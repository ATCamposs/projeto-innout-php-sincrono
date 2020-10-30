<?php

use Src\Controller\LoginController;
use Src\Config\Loader;

require_once __DIR__ . '/../src/Config/Config.php';

$teste = new LoginController();
$teste->index();
