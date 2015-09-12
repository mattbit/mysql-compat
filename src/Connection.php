<?php

namespace Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\QueryException;
use PDO;

class Connection
{
    protected $pdo;

    public function __construct(string $dsn, string $username = null, string $password = null)
    {
        $this->pdo = new PDO($dsn, $username, $password);
    }

    public function query(string $query): Result
    {
        $statement = $this->pdo->query($query);

        if ($statement === false) {
            throw new QueryException("Error executing the query: {$query}");
        }

        return new Result($statement);
    }

    public function quote(string $string): string
    {
        // Hack!
        return trim(rtrim($this->pdo->quote($string), "'"), "'");
    }

    public function useDatabase($database)
    {
        return $this->pdo->query("use {$database}");
    }

    public function getServerInfo(): string
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function close()
    {
        $this->pdo = null;
    }
}
