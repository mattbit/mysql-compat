<?php declare(strict_types=1);

namespace Mattbit\MysqlCompat;

use PDO;

class Result
{
    const FETCH_ASSOC = 1;
    const FETCH_NUM = 2;
    const FETCH_BOTH = 3;
    const FETCH_OBJ = PDO::FETCH_OBJ;

    protected $statement;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
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
        $row = $this->statement->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_FIRST, $row);
        
        return $row[$column];
    }

    public function fetch(int $style = Result::FETCH_BOTH)
    {
        return $this->statement->fetch($this->convertFetchStyle($style));
    }

    public function fetchObject(string $class = null, array $parameters = [])
    {
        if ($class === null) {
            return $this->fetch(static::FETCH_OBJ);
        }

        $result = $this->fetch(static::FETCH_ASSOC);
        $object = new $class($parameters);

        foreach ($result as $key => $value) {
            $object->{$key} = $value;
        }

        return $object;
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

            default:
                return $style;
        }
    }
}