<?php

namespace Src\Model;

class ModelConfig
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
        return isset($this->values[$key]) ? $this->values[$key] : null;
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
}
