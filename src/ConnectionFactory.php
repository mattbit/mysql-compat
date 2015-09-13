<?php

namespace Mattbit\MysqlCompat;

class ConnectionFactory
{
    public function createConnection($dsn, $username, $password)
    {
        return new Connection(new \PDO($dsn, $username, $password));
    }
}
