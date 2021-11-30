<?php

namespace ruriazz\AutoFaucetMulti;

class FreeShibaLimited
{
    private $source = "https://free.shiba.limited";
    private $Currency = "Free Shiba Binance Tokens";
    private $Ajax;
    private $Headers;
    private $Token;
    private $Balance;

    const Delimiters = array(
        "balance" => array(
            '<pclass="text-mutedfont-weight-medium">Balance</p><h4class="mb-0">',
            'tokens</h4></div><divclass="mini-stat'
        ),
        "token" => array(
            '<inputtype="hidden"name="token"value="',
            '"></form>'
        )
    );

    function __construct($ajax, $config)
    {
        $this->Ajax = $ajax;
        $this->Headers = array(
            "user-agent: {$config['user-agent']}",
            "cookie: {$config['cookies']['free.shiba.limited']}"
        );

        if($config['enable_log'])
            $this->Log = true;

        $this->init();
    }

    public function init()
    {
        $response = $this->Ajax->GET("{$this->source}/dashboard", $this->Headers);
        $balance = $this->exploder('balance', $response);
        $this->Balance = $balance;

        if(property_exists($this, 'Log') && $this->Log)
            Loger::write("Balance ~> {$this->Balance} {$this->Currency} Tokens");

        $text = Coloration::Text("Balance ~>", Coloration::WHITE);
        echo Coloration::Text($text, Coloration::BLOCK_GREY);
        echo Coloration::Text(" {$this->Balance} {$this->Currency}", Coloration::BLUE);
        echo "\n";
        $this->claim();
    }

    public function claim()
    {
        $response = $this->Ajax->GET("{$this->source}/auto", $this->Headers);
        $this->Token = $this->exploder('token', $response);
    }

    public function verify()
    {
        $this->Ajax->POST("{$this->source}/auto/verify", $this->Headers, "token={$this->Token}");
        $this->Ajax->GET("{$this->source}/auto", $this->Headers);
        $this->getUpdate();
        $this->claim();
    }

    public function getUpdate()
    {
        $response = $this->Ajax->GET("{$this->source}/dashboard", $this->Headers);
        $balance = $this->exploder('balance', $response);

        if(property_exists($this, 'Log') && $this->Log)
            Loger::write("Update balance ~> {$balance} {$this->Currency} Tokens");

        $text = Coloration::Text("Update balance ~>", Coloration::WHITE);
        echo Coloration::Text($text, Coloration::BLOCK_GREY);
        echo Coloration::Text(" $balance {$this->Currency}", Coloration::BLUE);
        echo "\n";
    }

    private function exploder($index, $response) {
        $delimiter = FreeShibaLimited::Delimiters[$index];
        try {
            $result = explode($delimiter[0], $response)[1];
            $result = explode($delimiter[1], $result)[0];
    
            return $result;
        } catch (\Throwable $th) {}
    }
}
