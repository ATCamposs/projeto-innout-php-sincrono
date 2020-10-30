<?php

namespace Src\Model;

use Symfony\Component\Config\Definition\Exception\Exception;

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

    public function checkLogin(): object
    {
        $user = User::getOne(['email' => $this->email]);
        if (!empty($user)) {
            if (password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        throw new Exception();
    }
}
