<?php

namespace ruriazz\AutoFaucetMulti;

class Loger {
    public static function write($string)
    {
        $log = Loger::getLog();
        $log = explode("\n", $log);
        foreach ($log as $key => $value) {
            if($value == "")
                unset($log[$key]);
        }

        $string = date("d/m/Y H:i:s") . " $string";
        array_push($log, $string);

        $log = implode("\n", $log);
        file_put_contents("./status.log", $log);
    }

    private static function getLog()
    {
        if(!file_exists("./status.log"))
            file_put_contents("./status.log", "");

        return file_get_contents("./status.log");
    }
}