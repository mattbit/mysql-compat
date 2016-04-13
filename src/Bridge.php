<?php

namespace Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\QueryException;

class Bridge
{
    /**
     * The database manager instance.
     *
     * @var Manager
     */
    protected $manager;

    /**
     * Create a new bridge.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function affectedRows(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getRowCount();
    }

    public function clientEncoding(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getCharset();
    }

    public function close(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->close();
    }

    public function connect($server = null, $username = null, $password = null, $newLink = false, $clientFlags = 0)
    {
        if ($server   === null) $server   = ini_get("mysql.default_host");
        if ($username === null) $username = ini_get("mysql.default_user");
        if ($password === null) $password = ini_get("mysql.default_password");

        // @todo: implement $newLInk and $clientFlags

        $this->manager->connect("mysql:host={$server};", $username, $password);
    }

    public function createDb($databaseName, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->parametrizedQuery(
            "CREATE DATABASE :databaseName",
            [':databaseName' => $databaseName]
        );
    }

    public function dataSeek(Result $result, $rowNumber = 0)
    {
        $result->setCursor($rowNumber);

        return true;
    }

    public function dbName(Result $result, $row, $field = null)
    {
        // @todo: implement this
    }

    public function dbQuery($database, $query, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);
        $connection->useDatabase($database);

        return $connection->query($query);
    }

    public function dropDb()
    {
        // @todo: implement dropDb
    }

    public function errno(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getErrorCode();
    }

    public function error(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getErrorInfo()[2];
    }

    public function escapeString($unescapedString)
    {
        // @todo: this should warn the user
        return $this->realEscapeString($unescapedString);
    }

    public function fetchArray(Result $result, $resultType = Result::FETCH_BOTH)
    {
        return $result->fetch($resultType);
    }

    public function fetchAssoc(Result $result)
    {
        return $this->fetchArray($result, Result::FETCH_ASSOC);
    }

    public function fetchField(Result $result, $fieldOffset = 0)
    {
        // @todo: handle non-numeric offset
        $meta = $result->getColumnMeta($fieldOffset);

        if ($meta === false) {
            return false;
        }

        // @todo: check that attributes correspond

        return (object) $meta;
    }

    public function fetchLengths()
    {
        // @todo
    }

    public function fetchObject(Result $result, $className = 'stdClass', array $params = [])
    {
        return $result->fetchObject($className, $params);
    }

    public function fetchRow(Result $result)
    {
        return $result->fetch(Result::FETCH_NUM);
    }

    public function fieldfFlags()
    {
        // @todo
    }

    public function fieldLen()
    {
        // @todo
    }

    public function fieldName()
    {
        // @todo
    }

    public function fieldSeek()
    {
        // @todo
    }

    public function fieldTable()
    {
        // @todo
    }

    public function fieldType()
    {
        // @todo
    }

    public function freeResult()
    {
        // @todo
    }

    public function getClientInfo()
    {
        // @todo
    }

    public function getHostInfo()
    {
        // @todo
    }

    public function getProtoInfo()
    {
        // @todo
    }

    public function getServerInfo(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getAttribute(PDO::ATTR_SERVER_INFO);
    }

    public function info()
    {
        // @todo
    }

    public function insertId(Connection $linkIdentifier)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getLastInsertId();
    }

    public function listDbs()
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

    public function listTables($database, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->parametrizedQuery(
            "SHOW TABLES FROM :database",
            [':database' => $database]
        );
    }

    public function numFields(Result $result)
    {
        return $result->getColumnCount();
    }

    public function numRows(Result $result)
    {
        return count($result->fetchAll());
    }

    public function pconnect()
    {
        // @todo
    }

    public function ping()
    {
        // @todo
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

    public function realEscapeString($unescapedString, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        $escaped = $connection->quote($unescapedString);
        // Hack!
        if ($escaped[0] === "'" && $escaped[strlen($escaped)-1] === "'") {
            return substr($escaped, 1, -1);
        }

        throw new \Exception("Cannot escape string");
    }

    public function result(Result $result, $row, $field = 0)
    {
        $row = $result->fetch(Result::FETCH_BOTH, \PDO::FETCH_ORI_ABS, $row);

        return $row[$field];
    }

    public function selectDb($databaseName, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return (bool) $connection->useDatabase($databaseName);
    }

    public function setCharset()
    {
        // @todo
    }

    public function stat()
    {
        // @todo
    }

    public function tablename()
    {
        // @todo
    }

    public function threadId()
    {
        // @todo
    }

    public function unbufferedQuery()
    {
        // @todo
    }
}
