<?php

namespace Src\Model;

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
     * @var string $value
     */
    protected $value;

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

    public function __get(string $key): string
    {
        return $this->values[$key];
    }

    /**
     * @param mixed $key
     */
    public function __set($key, string $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * @param mixed $filters
     */
    public static function getSelect($filters, string $columns = '*'): string
    {
        $sql = "SELECT ${columns} FROM " .
            static::$tableName .
            static::getFilters($filters);
        return $sql;
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
}
