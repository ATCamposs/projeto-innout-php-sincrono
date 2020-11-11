<?php

use Src\Config\Session;
use Src\Controller\DayRecordsController;
use Src\Controller\InNOut;
use Src\Controller\LoginController;
use Src\Controller\MonthlyReportController;

require_once __DIR__ . '/../src/Config/Config.php';

$uri = 'http://innout.localhost:8080';
if (isset($_SERVER['REQUEST_URI'])) {
    $uri =  urldecode(
        (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );
}
if ($uri === '/' || $uri === '' || $uri === '/login.php' || $uri === '/index.php') {
    $url = new LoginController();
    $url->index();
}

if ($uri === '/day_records.php') {
    $url = new DayRecordsController();
    $url->index();
}

if ($uri === '/logout.php') {
    $url = new Session();
    $url->sessionLogout();
}

if ($uri === '/registrar_ponto.php') {
    $url = new InNOut();
    $url->register();
}

if ($uri === '/registro_forcado.php') {
    $url = new InNOut();
    $url->forcedRegister();
}

if ($uri === '/monthly_report.php') {
    $url = new MonthlyReportController();
    $url->index();
}
