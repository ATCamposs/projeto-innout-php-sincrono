<?php

use Src\Controller\DayRecordsController;
use Src\Controller\LoginController;

require_once __DIR__ . '/../src/Config/Config.php';


$uri =  urldecode(
    (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri === '/' || $uri === '' || $uri === '/login.php' || $uri === '/index.php') {
    $url = new LoginController();
    $url->index();
}

if ($uri === '/day_records.php') {
    $url = new DayRecordsController();
    $url->index();
}
