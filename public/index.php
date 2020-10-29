<?php

use Src\Model\Login;
use Symfony\Component\Config\Definition\Exception\Exception;

require_once __DIR__ . '/../src/Config/Config.php';
//require_once __DIR__ . '/../src/View/login.php';


$login = new Login([
    'email' => 'admin@cod3r.com.br',
    'password' => 'a'
]);

try {
    $login->checkLogin();
    echo 'Deu certo o login';
} catch (Exception $e) {
    echo 'Problema no login :p';
}
