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

    function __construct($ajax, $Cookie, $UserAgent)
    {
        $this->Ajax = $ajax;
        $this->Headers = array(
            "user-agent: $UserAgent",
            "cookie: $Cookie"
        );

        $this->init();
    }

    public function init()
    {

        $response = $this->Ajax->GET("{$this->source}/dashboard", $this->Headers);
        $balance = explode(">Balance<", $response)[1];
        $balance = explode('">', $balance)[1];
        $balance = explode("tokens", $balance)[0];
        $this->Balance = (int) $balance;

        $text = Coloration::Text("Balance ~>", Coloration::WHITE);
        echo Coloration::Text($text, Coloration::BLOCK_GREY);
        echo Coloration::Text(" {$this->Balance} {$this->Currency} Tokens", Coloration::CYAN);
        echo "\n";
        $this->claim();
    }

    public function claim()
    {
        $response = $this->Ajax->GET("{$this->source}/auto", $this->Headers);
        $token = explode('name="token" value="', $response);
        $token = explode('">', $token[1]);
        $this->Token = "$token[0]";
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
        $balance = explode(">Balance<", $response)[1];
        $balance = explode('">', $balance)[1];
        $balance = explode("tokens", $balance)[0];

        $text = Coloration::Text("Update balance ~>", Coloration::WHITE);
        echo Coloration::Text($text, Coloration::BLOCK_GREY);
        echo Coloration::Text(" $balance {$this->Currency}", Coloration::CYAN);
        echo "\n";
    }
}
