<?php

namespace Mattbit\MysqlCompat;

use PDO;

class ConnectionFactory
{
    /**
     * Create a new Connection from PDO.
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     *
     * @return Connection
     */
    public function createConnection($dsn, $username, $password, $options)
    {
        return new Connection(new PDO($dsn, $username, $password, $options));
    }
}
