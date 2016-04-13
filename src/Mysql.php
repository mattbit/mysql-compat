<?php

namespace Mattbit\MysqlCompat;

/**
 * Class Mysql
 * Provides a facade to access the Mysql functions using a Manager singleton.
 *
 * @package Mattbit\MysqlCompat
 */
class Mysql
{
    /**
     * The database manager service.
     *
     * @var Manager
     */
    private static $bridge;

    /**
     * Forward static calls to the manager singleton.
     *
     * @param  $method
     * @param  $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (self::$bridge === null) {
            $manager = new Manager(new ConnectionFactory());
            self::$bridge = new Bridge($manager);
        }

        return call_user_func_array([self::$bridge, $method], $args);
    }
}
