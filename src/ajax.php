<?php

namespace ruriazz\AutoFaucetMulti;

class Ajax
{
    private $method;
    private $url;
    private $headers;
    private $postdata;
    private $results;

    private function exec()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->Headers);
        curl_setopt($ch, $this->Method, 1);
        if ($this->Method == CURLOPT_HTTPGET) {
            curl_setopt($ch, CURLOPT_ENCODING, "");
        } else if ($this->Method == CURLOPT_POST) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->PostData);
            curl_setopt($ch, CURLOPT_COOKIEJAR, "");
            curl_setopt($ch, CURLOPT_COOKIEFILE, "");
        }

        $this->Response = curl_exec($ch);
        $this->Response = trim(preg_replace('/\s+/', '', $this->Response));
        curl_close($ch);
    }

    public function GET($url, $headers, $pattern = null)
    {
        $this->url = $url;
        $this->Method = CURLOPT_HTTPGET;
        $this->Headers = $headers;
        $this->exec();

        return $this->Response;
    }

    public function POST($url, $headers, $postdata, $pattern = null)
    {
        $this->url = $url;
        $this->Method = CURLOPT_POST;
        $this->Headers = $headers;
        $this->PostData = $postdata;
        $this->exec();

        return $this->Response;
    }
}
