<?php

namespace ruriazz\AutoFaucetMulti;

class OneXbitcoins
{
    private String $source = "https://www.1xbitcoins.com";
    private String $Currency = "1xbitcoins";
    private Ajax $Ajax;
    private Array $Headers;
    private String $Token;
    private int $Balance;

    function __construct(Ajax $ajax, String $Cookie, String $UserAgent)
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
        $balance = explode('id="tokenBalance"', $response)[1];
        $balance = explode('value="', $balance)[1];
        $balance = explode('"', $balance)[0];
        $this->Balance = (int) $balance;

        $text = Coloration::Text("Balance ~>", Coloration::WHITE);
        echo Coloration::Text($text, Coloration::BLOCK_GREY);
        echo Coloration::Text(" {$this->Balance} {$this->Currency} Tokens", Coloration::ORAGE);
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
        $balance = explode('id="tokenBalance"', $response)[1];
        $balance = explode('value="', $balance)[1];
        $balance = explode('"', $balance)[0];

        $text = Coloration::Text("Update balance ~>", Coloration::WHITE);
        echo Coloration::Text($text, Coloration::BLOCK_GREY);
        echo Coloration::Text(" $balance {$this->Currency}", Coloration::ORAGE);
        echo "\n";
    }
}