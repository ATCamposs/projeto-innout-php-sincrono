<?php

namespace Src\Model;

class User extends Model
{
    /**
     * @var string $name
     */
    public static $name;

    /**
     * @var string $tableName
     */
    protected static $tableName = 'users';

    /**
     * @var array{string, string} $columns
     */
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin'
    ];
}
