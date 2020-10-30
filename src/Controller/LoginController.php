<?php

namespace Src\Controller;

use Src\Config\Loader;
use Src\Model\Login;
use Symfony\Component\Config\Definition\Exception\Exception;

class LoginController
{

    public function index(): void
    {
        if (count($_POST) > 0) {
            $login = new Login($_POST);
            try {
                $user = $login->checkLogin();
                echo "Usuário {$user->name} logado";
            } catch (Exception $e) {
                echo 'Falha no login';
            }
        }
        (new Loader())->loadView('Login', $_POST);
    }
}
