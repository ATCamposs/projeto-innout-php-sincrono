<?php

namespace Src\Model;

use PDO;
use Src\Config\Database;

class Model
{
    /**
     * @var string $id
     */
    protected static $id;

    /**
     * @var string $tableName
     */
    protected static $tableName;

    /**
     * @var mixed $columns
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

    public function __get(string $key): ?string
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
        while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
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

    public function save(): void
    {
        $sql = 'INSERT INTO ' . static::$tableName . '(' .
            implode(", ", static::$columns) . ") VALUES (";
        foreach (static::$columns as $col) {
            $sql .= static::getFormatedValue($this->$col) . ',';
        }
        $sql[strlen($sql) - 1] = ')';
        $id = Database::executeSQL($sql);
        $this->id = $id;
    }
}
