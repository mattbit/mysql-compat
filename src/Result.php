<?php

namespace Mattbit\MysqlCompat;

use PDO;

class Result
{
    const FETCH_ASSOC = 1;
    const FETCH_NUM = 2;
    const FETCH_BOTH = 3;
    const FETCH_OBJ = PDO::FETCH_OBJ;

    protected $statement;

    protected $cursor;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

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
        $row = $this->statement->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_ABS, $row);

        return $row[$column];
    }

    public function fetch($style = self::FETCH_BOTH, $orientation = PDO::FETCH_ORI_NEXT, $offset = 0)
    {
        $fetchMode = $this->convertFetchStyle($style);

        if ($this->cursor !== null) {
            $result = $this->statement->fetch($fetchMode, PDO::FETCH_ORI_ABS, $this->cursor);
            $this->cursor++;

            return $result;
        }

        return $this->statement->fetch($fetchMode, $orientation, $offset);
    }

    public function fetchObject($class = 'stdClass', array $params = [])
    {
        $this->statement->setFetchMode(PDO::FETCH_CLASS, $class, $params);

        return $this->fetch(static::FETCH_OBJ);
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }

    public function free()
    {
        return $this->statement->closeCursor();
    }

    public function convertFetchStyle($style)
    {
        switch ($style) {
            case static::FETCH_ASSOC:
                return PDO::FETCH_ASSOC;

            case static::FETCH_NUM:
                return PDO::FETCH_NUM;

            case static::FETCH_BOTH:
                return PDO::FETCH_BOTH;

            case static::FETCH_OBJ:
                return PDO::FETCH_CLASS;

            default:
                return $style;
        }
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
}
