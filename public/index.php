<?php

namespace Home;

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config\Database;

$conn = new Database();
$conn::getConnection();
