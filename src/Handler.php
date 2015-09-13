<?php

namespace Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\ClosedConnectionException;
use Mattbit\MysqlCompat\Exception\ConnectionException;
use Mattbit\MysqlCompat\Exception\NoConnectionException;
use PDO;

class Handler
{
    /**
     * The array of open connections.
     *
     * @var array
     */
    protected $connections = [];

    protected $connectionFactory;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    public function connect(string $dsn, string $username = null, string $password = null): Connection
    {
        $connectionId = "{$username}@{$dsn}";

        // If the same connection is present, do not open a new one
        if ($connection = $this->getConnection($connectionId)) {
            $this->setLastConnection($connectionId);

            return $connection;
        }

        // Otherwise create a new connection
        $connection = $this->connectionFactory->createConnection($dsn, $username, $password);
        $this->addConnection($connectionId, $connection);

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
        $connection = $this->getOpenConnectionOrFail($connection);

        $connection->useDatabase($databaseName);
        
        return true;
    }

    public function query(string $query, Connection $connection = null): Result
    {
        $connection = $this->getOpenConnectionOrFail($connection);

        return $connection->query($query);
    }

    public function escape($string, Connection $connection = null): string
    {
        $connection = $this->getOpenConnectionOrFail($connection);

        return $connection->escape($string);
    }

    public function getLastConnection(): Connection
    {
        $connection = end($this->connections);

        if (!$connection) {
            throw new NoConnectionException("There is no open connection.");
        }

        return $connection;
    }

    public function getOpenConnectionOrFail(Connection $connection = null): Connection
    {
        if ($connection && $this->checkConnection($connection)) {
            return $connection;
        }

        return $this->getLastConnection();
    }

    public function checkConnection(Connection $connection)
    {
        if ($connection->isOpen()) {
            return true;
        }

        throw new ClosedConnectionException("Cannot use a closed connection.");
    }

    public function getConnections()
    {
        return $this->connections;
    }

    public function setLastConnection(string $id)
    {
        uksort($this->connections, function ($a, $b) use ($id) {
            if ($a === $id) return 1;
            if ($b === $id) return -1;
            return 0;
        });
    }

    public function addConnection($id, Connection $connection)
    {
        $this->connections[$id] = $connection;
    }
}
