<?php

namespace App\Helpers;

class IdGenerator
{
    private static int $_counter = 1;

    public static function generate(): int
    {
        return self::$_counter++;
    }
}
