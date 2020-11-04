<?php

namespace Src\Model;

use Src\Exceptions\AppException;
use Src\Exceptions\ValidationException;

class Login extends Model
{
    /**
     * @var string $email
     */
    protected static $email;

    /**
     * @var string $password
     */
    protected static $password;

    public function checkLogin(): User
    {
        $user = User::getOne(['email' => $this->email]);
        $this->validate();
        if (!empty($user)) {
            if ($user->end_date) {
                throw new AppException('Usuário está desligado da empresa.');
            }
            if (password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        throw new AppException('Usuário/Senha inválidos.');
    }

    public function validate(): void
    {
        $email = $this->email;
        $pass = $this->password;
        $errors = [];
        if (empty($email)) {
            $errors['email'] = 'E-mail é um campo obrigatório.';
        }
        if (empty($pass)) {
            $errors['password'] = 'Por favor, informe a senha.';
        }
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
