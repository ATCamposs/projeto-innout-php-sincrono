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
    public function __construct($arr, bool $sanitize = true)
    {
        $this->loadFromArray($arr, $sanitize);
    }

    /**
     * @param array<string, string> $arr
     */
    public function loadFromArray($arr, bool $sanitize = true): void
    {
        if (empty($arr)) {
            return;
        }
        foreach ($arr as $key => $value) {
            $cleanValue = $value;
            if ($sanitize && $cleanValue) {
                $cleanValue = strip_tags(trim($cleanValue));
                $cleanValue = \htmlentities($cleanValue, \ENT_NOQUOTES);
                $this->$key = $cleanValue;
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
