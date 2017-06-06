<?php
namespace Core\Helpers;

class Debug
{
    public static function dump($arg)
    {
        var_dump('<pre>', ...$arg);
    }
}