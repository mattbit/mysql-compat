<?php

namespace Mattbit\MysqlCompat;

use PDO;
use PDOStatement;

class Result
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var PDOStatement
     */
    protected $statement;

    /**
     * The last fetched row.
     *
     * @var mixed
     */
    protected $lastFetch;

    /**
     * Create a Result instance.
     *
     * @param PDOStatement $statement
     * @param Connection $connection
     */
    public function __construct(PDOStatement $statement, Connection $connection)
    {
        $this->statement = $statement;
        $this->connection = $connection;
    }

    /**
     * Get the PDO statement.
     *
     * @return PDOStatement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    public function toArray()
    {
        return $this->statement->fetchAll();
    }

    public function count()
    {
        return $this->statement->rowCount();
    }

    public function column($column, $row)
    {
        $rows = $this->statement->fetchAll(PDO::FETCH_BOTH);

        return $rows[$row][$column];
    }

    public function fetch($fetchMode = PDO::FETCH_BOTH, $orientation = PDO::FETCH_ORI_NEXT, $offset = 0)
    {
        $result = $this->statement->fetch($fetchMode, $orientation, $offset);
        $this->lastFetch = is_object($result) ? clone($result) : $result;

        return $result;
    }

    public function fetchObject($class = 'stdClass', array $params = [])
    {
        $this->statement->setFetchMode(PDO::FETCH_CLASS, $class, $params);

        return $this->fetch(PDO::FETCH_CLASS);
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }

    public function free()
    {
        return $this->statement->closeCursor();
    }

    public function setCursor($rowNumber)
    {
        $this->cursor = $rowNumber;
    }

    public function getColumnMeta($columnNumber)
    {
        return $this->statement->getColumnMeta($columnNumber);
    }

    public function getColumnCount()
    {
        return $this->statement->columnCount();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getLastFetch()
    {
        return $this->lastFetch;
    }
}
