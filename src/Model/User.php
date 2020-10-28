<?php

namespace Src\Model;

class User extends Model
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $is_admin
     */
    public $is_admin;

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
