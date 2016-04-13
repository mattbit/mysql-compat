<?php

class FunctionalTestCase extends PHPUnit_Framework_TestCase
{
    protected $config;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->config = [
            'dbhost' => getenv('MYSQL_COMPAT_DBHOST'),
            'dbuser' => getenv('MYSQL_COMPAT_DBUSER'),
            'dbname' => getenv('MYSQL_COMPAT_DBNAME'),
            'dbpass' => getenv('MYSQL_COMPAT_DBPASS'),
        ];
    }
}
