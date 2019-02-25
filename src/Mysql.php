<?php

namespace Mattbit\MysqlCompat;

/**
 * Class Mysql
 * Provides a facade to access the Mysql functions using a Manager singleton.
 */
class Mysql
{
    /**
     * The database manager service.
     *
     * @var Manager
     */
    private static $manager;

    /**
     * The bridge service.
     *
     * @var Bridge
     */
    private static $bridge;

    /**
     * Forward static calls to the bridge singleton.
     *
     * @param  $method
     * @param  $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (self::$bridge === null) {
            $manager = self::getManager();
            self::$bridge = new Bridge($manager);
        }

        return call_user_func_array([self::$bridge, $method], $args);
    }

    /**
     * Get the database manager.
     *
     * @return Manager
     */
    public static function getManager()
    {
        if (self::$manager === null) {
            self::$manager = new Manager(new ConnectionFactory());
        }

        return self::$manager;
    }

    /**
     * Defines the old global functions and constants.
     *
     * @return void
     */
    public static function defineGlobals()
    {
        require_once __DIR__ . '/globals.php';
    }
}
