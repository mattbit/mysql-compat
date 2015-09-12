<?php declare(strict_types=1);

namespace Mattbit\MysqlCompat;

class Handler
{
    protected $connections = [];

    protected $lastError;

    public function connect(string $server, string $username = null, string $password = null): Connection
    {
        $connectionId = "{$username}@{$server}";

        // If the same connection is present, do not open a new one
        if ($connection = $this->getConnection($connectionId)) {
            return $connection;
        }

        // Otherwise create a new connection
        $connection = new Connection("mysql:host={$server};", $username, $password);
        $this->connections[$connectionId] = $connection;

        return $connection;
    }

    public function disconnect(Connection $connection = null): bool
    {
        if ($connection === null) {
            $connection = $this->getLastConnection();
        }

        $connection->close();
        $connectionId = array_search($connection, $this->connections);
        unset($this->connections[$connectionId]);

        return true;
    }

    public function getConnection(string $id)
    {
        if (array_key_exists($id, $this->connections)) {
            return $this->connections[$id];
        }
    }

    public function useDatabase(string $databaseName, Connection $connection = null): bool
    {
        if ($connection === null) {
            $connection = $this->getLastConnection();
        }

        $connection->useDatabase($databaseName);
        
        return true;
    }

    public function query(string $query, Connection $connection = null): Result
    {
        if ($connection === null) {
            $connection = $this->getLastConnection();
        }

        return $connection->query($query);
    }

    public function quote(string $string, Connection $connection = null): string
    {
        if ($connection === null) {
            $connection = $this->getLastConnection();
        }

        return $connection->quote($string);
    }

    public function getLastConnection(): Connection
    {
        $connection = end($this->connections);

        if (!$connection) {
            throw new ConnectionException("There is no open connection!");
        }

        return $connection;
    }
}