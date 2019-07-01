<?php

namespace Mattbit\MysqlCompat\BridgeComponents;

use PDO;
use Mattbit\MysqlCompat\Result;
use Mattbit\MysqlCompat\MysqlConstants;
use Mattbit\MysqlCompat\Exception\QueryException;
use Mattbit\MysqlCompat\Exception\NotSupportedException;

trait FetchResults
{
    /**
     * Fetch the next row from the result as an array.
     *
     * @param Result $result
     * @param int    $resultType
     *
     * @return bool|array
     */
    public function fetchArray(Result $result, $resultType = MysqlConstants::FETCH_BOTH)
    {
        $fetchMode = $this->convertFetchStyle($resultType);

        return $result->fetch($fetchMode);
    }

    /**
     * Fetch the next row as an associative array.
     *
     * @param Result $result
     *
     * @return bool|array
     */
    public function fetchAssoc(Result $result)
    {
        return $this->fetchArray($result, MysqlConstants::FETCH_ASSOC);
    }

    /**
     * Fetch the metadata of a column.
     * USE WITH CARE! Accuracy of results is not guaranteed.
     *
     * @param Result $result
     * @param int    $fieldOffset
     *
     * @return bool|object
     *
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
        return $result->fetch(PDO::FETCH_NUM);
    }

    public function result(Result $result, $row, $field = 0)
    {
        $row = $result->fetch(PDO::FETCH_BOTH, PDO::FETCH_ORI_ABS, $row);

        return $row[$field];
    }

    public function dataSeek()
    {
        throw new NotSupportedException('The mysql_data_seek function is not supported. You must refactor your code.');
    }

    public function numFields(Result $result)
    {
        return $result->getColumnCount();
    }

    public function numRows(Result $result)
    {
        $query = $result->getStatement()->queryString;

        try {
            $countResult = $result->getConnection()->query(
                'SELECT COUNT(*) FROM (' . $query . ') AS ' . uniqid('count_')
            );
        } catch (QueryException $e) {
            return false;
        }

        return (int) $countResult->fetch()[0];
    }

    protected function convertFetchStyle($style)
    {
        switch ($style) {
            case MysqlConstants::FETCH_ASSOC:
                return PDO::FETCH_ASSOC;

            case MysqlConstants::FETCH_NUM:
                return PDO::FETCH_NUM;

            case MysqlConstants::FETCH_BOTH:
                return PDO::FETCH_BOTH;

            case MysqlConstants::FETCH_OBJ:
                return PDO::FETCH_CLASS;

            default:
                return $style;
        }
    }
}
