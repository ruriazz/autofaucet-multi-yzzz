<?php

namespace ruriazz\AutoFaucetMulti;

class OneXbitcoins
{
    private $source = "https://www.1xbitcoins.com";
    private $Currency = "1xbitcoins";
    private $Ajax;
    private $Headers;
    private $Token;
    private $Balance;

    const Delimiters = array(
        "balance" => array(
            '</div><divclass="balance"><p>',
            'tokens</p></div></div></div></div><divclass="'
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
            "cookie: {$config['cookies']['1xbitcoin']}"
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
        echo Coloration::Text(" {$this->Balance} {$this->Currency} Tokens", Coloration::ORAGE);
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
        echo Coloration::Text(" $balance {$this->Currency}", Coloration::ORAGE);
        echo "\n";
    }

    private function exploder($index, $response) {
        $delimiter = OneXbitcoins::Delimiters[$index];
        try {
            $result = explode($delimiter[0], $response)[1];
            $result = explode($delimiter[1], $result)[0];
    
            return $result;
        } catch (\Throwable $th) {}
    }
}
