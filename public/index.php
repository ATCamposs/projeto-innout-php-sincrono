<?php

require_once __DIR__ . '/../src/Config/Config.php';

use Src\Config\Database;
use Src\Model\User;

$user = new User(['name' => 'André', 'email' => 'andre.email@email.com']);
echo '<br>';
var_dump(User::getAll(['id' => 1], 'name, email'));
echo '<br>';
echo '<br>';
echo '<br>';
var_dump(User::getAll([], 'name'));
