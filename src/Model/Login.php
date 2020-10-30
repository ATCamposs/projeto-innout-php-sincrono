<?php

namespace Src\Model;

use Src\Exceptions\AppException;

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
}
