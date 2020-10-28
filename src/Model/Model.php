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
}
