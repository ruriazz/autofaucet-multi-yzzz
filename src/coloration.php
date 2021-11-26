<?php

namespace ruriazz\AutoFaucetMulti;

class Coloration
{

    const BLUE = "\e[1;34m";
    const GREEN = "\e[1;32m";
    const RED = "\e[1;31m";
    const WHITE = "\33[37;1m";
    const YELLOW = "\e[1;33m";
    const CYAN = "\e[1;36m";
    const PURPLE = "\e[1;35m";
    const GREY = "\e[1;30m";
    const ORAGE = "\033[38;5;202m";

    const BLOCK_GLOW = "\033[102m";
    const BLOCK_BLUE = "\033[104m";
    const BLOCK_RED = "\033[101m";
    const BLOCK_PINK = "\033[105m";
    const BLOCK_WHITE = "\033[107m";
    const BLOCK_YELLOW = "\033[103m";
    const BLOCK_CYAN = "\033[106m";
    const BLOCK_GREY = "\033[100m";

    public static function Text($string, $color)
    {
        return "$color$string\033[0m";
    }
}
