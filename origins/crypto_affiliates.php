<?php

namespace ruriazz\AutoFaucetMulti;

class CryptoAffiliates
{
    private $source = "https://cryptoaffiliates.store";
    private $Currency = "CryptoAffiliates";
    private $Ajax;
    private $Headers;
    private $Token;
    private $Balance;

    const Delimiters = array(
        "balance" => array(
            '"widget-stats-title">Balance</span><spanclass="widget-stats-amount">',
            'tokens</span><spanclass="widget'
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
            "cookie: {$config['cookies']['cryptoaffiliates']}"
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
        echo Coloration::Text(" {$this->Balance} {$this->Currency} Tokens", Coloration::CYAN);
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
        echo Coloration::Text(" $balance {$this->Currency}", Coloration::CYAN);
        echo "\n";
    }

    private function exploder($index, $response) {
        $delimiter = CryptoAffiliates::Delimiters[$index];
        try {
            $result = explode($delimiter[0], $response)[1];
            $result = explode($delimiter[1], $result)[0];
    
            return $result;
        } catch (\Throwable $th) {}
    }
}
