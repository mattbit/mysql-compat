<?php

namespace Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\QueryException;
use PDO;

class Connection
{
    /**
     * The status of the connection.
     *
     * @var bool
     */
    protected $open = false;

    /**
     * The PDO instance which represent the actual connection.
     *
     * @var PDO
     */
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->open = true;
    }

    public function query(string $query): Result
    {
        $statement = $this->pdo->query($query);

        if ($statement === false) {
            throw new QueryException("Error executing the query.");
        }

        return new Result($statement);
    }

    public function escape($string): string
    {
        $escaped = $this->pdo->quote($string);

        // Hack!
        if ($escaped[0] === "'" && $escaped[strlen($escaped)-1] === "'") {
            return substr($escaped, 1, -1);
        }

        return $escaped;
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
        $this->open = false;
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
