<?php

namespace Src\Model;

use DateTime;
use Src\Exceptions\ValidationException;

class User extends Model
{
    /** @var string $name */
    public static $name;

    /** @var string $email */
    public static $email;

    /** @var string $password */
    public static $password;

    /** @var string $confirm_password */
    public static $confirm_password;

    /** @var string $start_date */
    public static $start_date;

    /** @var string $end_date */
    public static $end_date;

    /** @var string $is_admin */
    public static $is_admin;

    /** @var string $tableName */
    protected static $tableName = 'users';

    /** @var array<int, string> $columns */
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin'
    ];

    public static function getActiveUsersCount(): int
    {
        return static::getCount(['raw' => 'end_date IS NULL']);
    }

    public function validate(): void
    {
        $name = $this->name;
        $email = $this->email;
        $password = $this->password;
        $confirm_password = $this->confirm_password;
        $start_date = $this->start_date;
        $end_date = $this->end_date;

        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'E-mail é um campo obrigatório.';
        }
        if (empty($email)) {
            $errors['email'] = 'Por favor, informe um email.';
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email inválido.';
        }
        if (empty($password)) {
            $errors['password'] = 'Por favor, informe a senha.';
        }
        if (empty($confirm_password)) {
            $errors['confirm_password'] = 'Por favor, informe a senha.';
        }
        if (!empty($password) && !empty($confirm_password) && $password != $confirm_password) {
            $errors['password'] = 'As duas senhas devem ser iguais.';
            $errors['confirm_password'] = 'As duas senhas devem ser iguais.';
        }
        if (empty($start_date)) {
            $errors['start_date'] = 'A data de Admissão é obrigatória.';
        }
        if (!empty($start_date) && !DateTime::createFromFormat('Y-m-d', $start_date)) {
            $errors['email'] = 'Email inválido.';
        }
        if (!empty($end_date) && !DateTime::createFromFormat('Y-m-d', $end_date)) {
            $errors['email'] = 'Email inválido.';
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
