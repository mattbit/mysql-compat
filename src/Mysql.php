<?php

declare (strict_types = 1);

namespace Mattbit\MysqlCompat;

class Mysql
{
    private static $handler;

    public static function __callStatic($method, $args)
    {
        if (self::$handler === null) {
            self::$handler = new Handler();
        }

        return call_user_func_array([self::$handler, $method], $args);
    }
}
