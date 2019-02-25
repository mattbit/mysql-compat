<?php

namespace Mattbit\MysqlCompat\BridgeComponents;

use Mattbit\MysqlCompat\Connection;
use Mattbit\MysqlCompat\Exception\QueryException;

trait ExecuteQueries
{
    public function affectedRows(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getRowCount();
    }

    public function query($query, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        try {
            $result = $connection->query($query);
        } catch (QueryException $e) {
            return false;
        }

        return $result;
    }

    public function selectDb($databaseName, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return (bool) $connection->useDatabase($databaseName);
    }

    public function createDb($databaseName, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->parametrizedQuery(
            'CREATE DATABASE :databaseName',
            [':databaseName' => $databaseName]
        );
    }

    public function listTables($database, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->parametrizedQuery(
            'SHOW TABLES FROM :database',
            [':database' => $database]
        );
    }

    public function insertId(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return (int) $connection->getLastInsertId();
    }

    public function listDbs()
    {
        // @todo
    }

    public function dbName()
    {
        // @todo
    }

    public function dbQuery($database, $query, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);
        $connection->useDatabase($database);

        return $connection->query($query);
    }

    public function dropDb()
    {
        // @todo
    }

    public function listFields()
    {
        // @todo
    }

    public function listProcesses()
    {
        // @todo
    }

    public function tablename()
    {
        // @todo
    }

    public function unbufferedQuery()
    {
        // @todo
    }
}
