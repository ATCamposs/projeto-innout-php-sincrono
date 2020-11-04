<?php

use Src\Controller\LoginController;

require_once __DIR__ . '/../src/Config/Config.php';

$teste = new LoginController();
$teste->index();
