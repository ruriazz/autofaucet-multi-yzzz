<?php

namespace ruriazz\AutoFaucetMulti;

class Ajax
{
    private int $method;
    private String $url;
    private array $headers;
    private String $postdata;
    private String $results;

    private function exec()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, $this->method, 1);
        if ($this->method == CURLOPT_HTTPGET) {
            curl_setopt($ch, CURLOPT_ENCODING, "");
        } else if ($this->method == CURLOPT_POST) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postdata);
            curl_setopt($ch, CURLOPT_COOKIEJAR, "");
            curl_setopt($ch, CURLOPT_COOKIEFILE, "");
        }

        $this->results = curl_exec($ch);
        curl_close($ch);
    }

    public function GET(String $url, array $headers, String $pattern = null)
    {
        $this->url = $url;
        $this->method = CURLOPT_HTTPGET;
        $this->headers = $headers;
        $this->exec();

        if (!$pattern)
            return $this->results;

        try {
            $return = explode($this->results, $pattern)[1];
            return $return;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function POST(String $url, Array $headers, String $postdata, String $pattern = null)
    {
        $this->url = $url;
        $this->method = CURLOPT_POST;
        $this->headers = $headers;
        $this->postdata = $postdata;
        $this->exec();

        if (!$pattern)
            return $this->results;

        try {
            $return = explode($this->results, $pattern)[1];
            return $return;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
