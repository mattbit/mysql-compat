<?php

namespace Mattbit\MysqlCompat;

use Mattbit\MysqlCompat\Exception\NotSupportedException;
use PDO;
use Mattbit\MysqlCompat\Exception\QueryException;

class Bridge
{
    /**
     * MYSQL_CLIENT_COMPRESS
     */
    const CLIENT_COMPRESS = 32;

    /**
     * MYSQL_CLIENT_SSL
     */
    const CLIENT_SSL = 2048;

    /**
     * MYSQL_CLIENT_INTERACTIVE
     */
    const CLIENT_INTERACTIVE = 1024;


    /**
     * MYSQL_CLIENT_IGNORE_SPACE
     */
    const CLIENT_IGNORE_SPACE = 256;

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
        return $this->manager->disconnect($linkIdentifier);
    }

    public function connect($server = null, $username = null, $password = null, $newLink = false, $clientFlags = 0)
    {
        if ($server   === null) $server   = ini_get("mysql.default_host");
        if ($username === null) $username = ini_get("mysql.default_user");
        if ($password === null) $password = ini_get("mysql.default_password");

        $options = $this->parseClientFlags($clientFlags);

        return $this->manager->connect("mysql:host={$server};", $username, $password, $options, $newLink);
    }

    protected function parseClientFlags($clientFlags)
    {
        $options = [];

        if ($clientFlags & static::CLIENT_COMPRESS) {
            $options[PDO::MYSQL_ATTR_COMPRESS] = 1;
        }

        if ($clientFlags & static::CLIENT_IGNORE_SPACE) {
            $options[PDO::MYSQL_ATTR_IGNORE_SPACE] = 1;
        }

        if ($clientFlags & static::CLIENT_SSL) {
            throw new NotSupportedException("SSL is not supported. You must create the PDO instance manually.");
        }

        if ($clientFlags & static::CLIENT_INTERACTIVE) {
            throw new NotSupportedException("Interactive client is not supported by PDO.");
        }

        return $options;
    }

    public function createDb($databaseName, Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->parametrizedQuery(
            "CREATE DATABASE :databaseName",
            [':databaseName' => $databaseName]
        );
    }

    public function dataSeek()
    {
        throw new NotSupportedException("The mysql_data_seek function is not supported. You must refactor your code.");
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

    /**
     * Return the last error number. A value of 0 means no errors.
     *
     * @param Connection|null $linkIdentifier
     * @return int
     */
    public function errno(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return (int) $connection->getErrorInfo()[1];
    }

    /**
     * Return the last error text.
     *
     * @param Connection|null $linkIdentifier
     * @return string
     */
    public function error(Connection $linkIdentifier = null)
    {
        $connection = $this->manager->getOpenConnectionOrFail($linkIdentifier);

        return $connection->getErrorInfo()[2];
    }

    public function escapeString($unescapedString)
    {
        return $this->realEscapeString($unescapedString);
    }

    /**
     * Fetch the next row from the result as an array.
     *
     * @param Result $result
     * @param int $resultType
     * @return bool|array
     */
    public function fetchArray(Result $result, $resultType = Result::FETCH_BOTH)
    {
        return $result->fetch($resultType);
    }

    /**
     * Fetch the next row as an associative array.
     *
     * @param Result $result
     * @return bool|array
     */
    public function fetchAssoc(Result $result)
    {
        return $this->fetchArray($result, Result::FETCH_ASSOC);
    }

    /**
     * Fetch the metadata of a column.
     * USE WITH CARE! Accuracy of results is not guaranteed.
     *
     * @param Result $result
     * @param int $fieldOffset
     * @return bool|object
     * @deprecated
     */
    public function fetchField(Result $result, $fieldOffset = 0)
    {
        $meta = $result->getColumnMeta($fieldOffset);

        if ($meta === false) {
            return false;
        }

        $meta = (object) $meta;

        foreach ($meta->flags as $flag) {
            $meta->{$flag} = 1;
        }

        return $meta;
    }

    public function fetchLengths(Result $result)
    {
        if (!is_array($result->getLastFetch())) {
            return false;
        }

        return array_values(array_map('strlen', $result->getLastFetch()));
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

        return $connection->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function info()
    {
        // @todo
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
        $query = $result->getStatement()->queryString;
        $matches = 0;
        $count = preg_replace("~SELECT (.+) FROM~", "SELECT COUNT(*) FROM", $query, -1, $matches);

        if ($matches === 0) {
            return 0;
        }

        $countResult = $result->getConnection()->query($count);

        return (int) $countResult->fetch()[0];
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
