<?php

require_once __DIR__ . '/../src/Config/Config.php';

use Src\Config\Database;
use Src\Model\User;

$user = new User(['name' => 'André', 'email' => 'andre.email@email.com']);
print_r($user->email);
$user->email = 'teste.com';
print_r($user->email);
echo 'Fim!';
echo '<br>';
echo $user->getSelect(['id' => 1, 'name' => 'andre']);
