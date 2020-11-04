<?php

namespace Src\Controller;

use Src\Config\Loader;
use Src\Exceptions\AppException;
use Src\Model\Login;

class LoginController
{
    public function index(): void
    {
        $exception = '';
        if (count($_POST) > 0) {
            $exception = $this->tryLogin();
        }
        (new Loader())->loadView('Login', $_POST + ['exception' => $exception]);
    }

    private function tryLogin(): ?AppException
    {
        $login = new Login($_POST);
        try {
            $user = $login->checkLogin();
            return null;
        } catch (AppException $e) {
            $exception = $e;
            return $exception;
        }
    }
}
