<?php

namespace ruriazz\AutoFaucetMulti;
require_once "./src/loader.php";

class App
{
    private $DogeHero;
    private $CryptoAffiliates;
    private $OnexBitcoin;
    private $BtcBunch;
    private $FreeShibaLimited;

    function __construct()
    {
        $Ajax = new Ajax();
        $config = $this->getConfig();

        if($config["enable_log"])
            Loger::write("Starting bot");

        try {
            system("clear");
        } catch(\Throwable $e) {
            system("cls");
        }

        $this->DogeHero = new DogeHero($Ajax, $config);
        $this->CryptoAffiliates = new CryptoAffiliates($Ajax, $config);
        $this->OnexBitcoin = new OneXbitcoins($Ajax, $config);
        $this->BtcBunch = new BtcBunch($Ajax, $config);
        $this->FreeShibaLimited = new FreeShibaLimited($Ajax, $config);

        while (true) {
            $this->run();
        }
    }

    private function run()
    {
        $this->waiting(); //1
        $this->DogeHero->verify();
        $this->waiting(); //2
        $this->DogeHero->verify();
        $this->CryptoAffiliates->verify();
        $this->waiting(); //3
        $this->DogeHero->verify();
        $this->OnexBitcoin->verify();
        $this->waiting(); //4
        $this->DogeHero->verify();
        $this->CryptoAffiliates->verify();
        $this->waiting(); //5
        $this->DogeHero->verify();
        $this->BtcBunch->verify();
        $this->waiting(); //6
        $this->DogeHero->verify();
        $this->CryptoAffiliates->verify();
        $this->OnexBitcoin->verify();
        $this->waiting(); //7
        $this->DogeHero->verify();
        $this->waiting(); //8
        $this->DogeHero->verify();
        $this->CryptoAffiliates->verify();
        $this->waiting(); //9
        $this->DogeHero->verify();
        $this->OnexBitcoin->verify();
        $this->waiting(); //10
        $this->DogeHero->verify();
        $this->CryptoAffiliates->verify();
        $this->BtcBunch->verify();
        $this->waiting(); //11
        $this->DogeHero->verify();
        $this->waiting(); //12
        $this->DogeHero->verify();
        $this->CryptoAffiliates->verify();
        $this->OnexBitcoin->verify();
        $this->waiting(); //13
        $this->DogeHero->verify();
        $this->waiting(); //14
        $this->DogeHero->verify();
        $this->CryptoAffiliates->verify();
        $this->waiting(); //15
        $this->FreeShibaLimited->verify();
        $this->DogeHero->verify();
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
