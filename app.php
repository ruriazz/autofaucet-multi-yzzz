<?php

namespace ruriazz\AutoFaucetMulti;
require_once "./src/loader.php";

class App
{
    private $dogeHero;
    private $cryptoAffiliats;
    private $oneXbitcoins;
    private $btcBunch;
    private $freeShibaLimited;

    function __construct()
    {
        $Ajax = new Ajax();
        $config = $this->getConfig();
        $userAgent = $config['USER_AGENT'];

        try {
            system("clear");
        } catch(\Throwable $e) {
            system("cls");
        }

        $this->dogeHero = new Dogehero($Ajax, $config['COOKIES']["DOGEHERO"], $userAgent);
        $this->cryptoAffiliats = new CryptoAffiliates($Ajax, $config['COOKIES']["CRYPTO_AFFILIATES"], $userAgent);
        $this->oneXbitcoins = new OneXbitcoins($Ajax, $config['COOKIES']["ONE_XBITCOIN"], $userAgent);
        $this->btcBunch = new BtcBunch($Ajax, $config['COOKIES']["BTC_BUNCH"], $userAgent);
        $this->freeShibaLimited = new FreeShibaLimited($Ajax, $config['COOKIES']["FREE_SHIBA_LIMITED"], $userAgent);

        while (true) {
            $this->run();
        }
    }

    private function run()
    {
        $this->waiting(); //1
        $this->dogeHero->verify();
        $this->waiting(); //2
        $this->dogeHero->verify();
        $this->cryptoAffiliats->verify();
        $this->waiting(); //3
        $this->dogeHero->verify();
        $this->oneXbitcoins->verify();
        $this->waiting(); //4
        $this->dogeHero->verify();
        $this->cryptoAffiliats->verify();
        $this->waiting(); //5
        $this->dogeHero->verify();
        $this->btcBunch->verify();
        $this->waiting(); //6
        $this->dogeHero->verify();
        $this->cryptoAffiliats->verify();
        $this->oneXbitcoins->verify();
        $this->waiting(); //7
        $this->dogeHero->verify();
        $this->waiting(); //8
        $this->dogeHero->verify();
        $this->cryptoAffiliats->verify();
        $this->waiting(); //9
        $this->dogeHero->verify();
        $this->oneXbitcoins->verify();
        $this->waiting(); //10
        $this->dogeHero->verify();
        $this->cryptoAffiliats->verify();
        $this->btcBunch->verify();
        $this->waiting(); //11
        $this->dogeHero->verify();
        $this->waiting(); //12
        $this->dogeHero->verify();
        $this->cryptoAffiliats->verify();
        $this->oneXbitcoins->verify();
        $this->waiting(); //13
        $this->dogeHero->verify();
        $this->waiting(); //14
        $this->dogeHero->verify();
        $this->cryptoAffiliats->verify();
        $this->waiting(); //15
        $this->freeShibaLimited->verify();
        $this->dogeHero->verify();
    }

    private function getConfig() 
    {
        include "./config.php";
        return $config;
    }

    private function waiting(int $time = 60)
    {
        $ix = 0;
        for ($x = $time; $x > 0; $x--) {
            $ix++;
            switch ($ix) {
                case 1:
                    $sy = '←';
                    break;
                
                case 2:
                    $sy = "↖";
                    break;
    
                case 3:
                    $sy = "↑";
                    break;
                    
                case 4:
                    $sy = "↗";
                    break;
    
                case 5:
                    $sy = "→";
                    break;
    
                case 6:
                    $sy = "↘";
                    break;
    
                case 7:
                    $sy = "↓";
                    break;
    
                case 8:
                    $sy = "↙";
                    $ix = 0;
                    break;
    
                default:
                    break;
            }
            
            echo "\r   \r";
            echo $sy;
            sleep(1);
        }

        echo "\r   \r";
    }
}

new App();
