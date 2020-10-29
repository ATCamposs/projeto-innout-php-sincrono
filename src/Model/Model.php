<?php

namespace Src\Model;

use Src\Config\Database;
use PDOStatement;

class Model
{
    /**
     * @var string $tableName
     */
    protected static $tableName;

    /**
     * @var array{int, string} $columns
     */
    protected static $columns;

    /**
     * @var array{string, string} $values
     */
    protected $values;

    /**
     * @param array<string, string> $arr
     */
    public function __construct($arr)
    {
        $this->loadFromArray($arr);
    }

    /**
     * @param array<string, string> $arr
     */
    public function loadFromArray($arr): void
    {
        if (!empty($arr)) {
            foreach ($arr as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     *
     * @return (string|null)
     */
    public function __get(string $key)
    {
        return $this->values[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     */
    public function __set($key, $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * @param mixed $filters
     * @return mixed
     */
    public static function getResultSetFromSelect($filters, string $columns = '*')
    {
        $sql = "SELECT ${columns} FROM " .
            static::$tableName .
            static::getFilters($filters);
        return Database::getResultFromQuery($sql);
    }

    /**
     * @param array{int, string} $filters
     */
    private static function getFilters($filters): string
    {
        print_r($filters);
        $sql = '';
        if (!empty($filters)) {
            $sql .= " WHERE 1 = 1";
            foreach ($filters as $column => $value) {
                $sql .= " AND ${column} = " . static::getFormatedValue($value);
            }
        }
        return $sql;
    }

    /**
     * @param (int|string) $value
     * @return (int|string)
     */
    private static function getFormatedValue($value)
    {
        if (empty($value)) {
            return "null";
        }
        if (gettype($value) === 'string') {
            return "'${value}'";
        }

        return $value;
    }

    /**
     * @param mixed $filters
     * @return iterable<int, mixed>
     */
    public static function get($filters, string $columns = '*')
    {
        $objects = [];
        $results = static::getResultSetFromSelect($filters, $columns);
        $class = get_called_class();
        while ($row = $results->fetchObject()) {
            array_push($objects, new $class($row));
        }
        return $objects;
    }

    /**
     * @param mixed $filters
     * @return mixed
     */
    public static function getOne($filters, string $columns = '*')
    {
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);
        return $result ? new $class($result->fetchObject()) : null;
    }
}
