<?php

namespace Mattbit\MysqlCompat;

use PDO;
use PDOStatement;
use Mattbit\MysqlCompat\Exception\QueryException;

class Connection
{
    /**
     * The status of the connection.
     *
     * @var bool
     */
    protected $open = false;

    /**
     * The PDO instance which represents the actual connection.
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * The last executed query.
     *
     * @var PDOStatement
     */
    protected $lastQuery;

    /**
     * Create a new Connection instance.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->open = true;
    }

    public function query($query)
    {
        $statement = $this->pdo->query($query);

        if ($statement === false) {
            throw new QueryException("Error executing the query.");
        }

        $this->lastQuery = $statement;

        if ($statement === null) {
            return;
        }

        return new Result($statement, $this);
    }

    public function quote($string)
    {
        $escaped = $this->pdo->quote($string);

        return $escaped;
    }

    public function useDatabase($database)
    {
        return $this->query("USE {$database}");
    }

    public function getServerInfo()
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function close()
    {
        $this->pdo = null;
        $this->open = false;

        return true;
    }

    public function isOpen()
    {
        return $this->open;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function getRowCount()
    {
        if ($this->lastQuery) {
            return $this->lastQuery->rowCount();
        }

        return 0;
    }
    
    public function getCharset()
    {
        $statement = $this->pdo->query("SELECT COLLATION('c')");

        return $statement->fetch(PDO::FETCH_NUM)[0];
    }
    
    public function getErrorInfo()
    {
        return $this->pdo->errorInfo();
    }

    public function getAttribute($attribute)
    {
        return $this->pdo->getAttribute($attribute);
    }

    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @param $query
     * @param array $params
     * @return bool|Result
     */
    public function parametrizedQuery($query, array $params = [])
    {
        $statement = $this->pdo->prepare($query);

        $success = $statement->execute($params);
        if ($success === false) {
            return false;
        }

        return new Result($statement, $this);
    }
}
