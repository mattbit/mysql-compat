<?php

namespace Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\NoConnectionException;
use Mattbit\MysqlCompat\Exception\ClosedConnectionException;

class Manager
{
    /**
     * The array of open connections.
     *
     * @var array
     */
    protected $connections = [];

    /**
     * @var ConnectionFactory
     */
    protected $connectionFactory;

    /**
     * Create a Manager instance.
     *
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * Return a connection to the database, creating a new one if needed.
     *
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array  $options
     * @param bool   $forceNew
     *
     * @return Connection
     */
    public function connect($dsn, $username = '', $password = '', array $options = [], $forceNew = false)
    {
        $connectionId = "{$username}@{$dsn}";

        // If the same connection is present, do not open a new one
        if (!$forceNew && $connection = $this->getConnection($connectionId)) {
            $this->setLastConnection($connectionId);

            return $connection;
        }

        // Otherwise create a new connection
        $connection = $this->connectionFactory->createConnection($dsn, $username, $password, $options);
        $this->addConnection($connectionId, $connection);

        return $connection;
    }

    /**
     * Close the connection. If no connection is passed, it closes the last.
     *
     * @param Connection|null $connection
     *
     * @return bool
     *
     * @throws NoConnectionException
     */
    public function disconnect(Connection $connection = null)
    {
        if ($connection === null) {
            $connection = $this->getLastConnection();
        }

        $connection->close();
        $connectionId = array_search($connection, $this->connections);
        unset($this->connections[$connectionId]);

        return true;
    }

    /**
     * Get a connection.
     *
     * @param string $id
     *
     * @return Connection
     */
    public function getConnection($id)
    {
        if (array_key_exists($id, $this->connections)) {
            return $this->connections[$id];
        }
    }

    /**
     * Select the database to use. If the connection is omitted, the last one is used.
     *
     * @param $databaseName
     * @param Connection|null $connection
     *
     * @return bool
     */
    public function useDatabase($databaseName, Connection $connection = null)
    {
        $connection = $this->getOpenConnectionOrFail($connection);
        $connection->useDatabase($databaseName);

        return true;
    }

    /**
     * Execute a query. If the connection is omitted, the last one is used.
     *
     * @param $query
     * @param Connection|null $connection
     *
     * @return mixed
     */
    public function query($query, Connection $connection = null)
    {
        $connection = $this->getOpenConnectionOrFail($connection);

        return $connection->query($query);
    }

    /**
     * Return the last used connection.
     *
     * @return Connection
     *
     * @throws NoConnectionException
     */
    public function getLastConnection()
    {
        $connection = end($this->connections);

        if (!$connection) {
            throw new NoConnectionException('There is no open connection.');
        }

        return $connection;
    }

    public function getOpenConnectionOrFail(Connection $connection = null)
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

        throw new ClosedConnectionException('Cannot use a closed connection.');
    }

    public function getConnections()
    {
        return $this->connections;
    }

    public function setLastConnection($id)
    {
        uksort($this->connections, function ($a, $b) use ($id) {
            if ($a === $id) {
                return 1;
            }
            if ($b === $id) {
                return -1;
            }

            return 0;
        });
    }

    public function addConnection($id, Connection $connection)
    {
        if (isset($this->connections[$id])) {
            $this->addConnection('_'.$id, $connection);

            return;
        }

        $this->connections[$id] = $connection;
    }
}
