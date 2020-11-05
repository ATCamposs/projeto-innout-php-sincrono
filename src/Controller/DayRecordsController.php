<?php

namespace Src\Controller;

use Src\Config\Loader;
use Src\Config\Session;

class DayRecordsController
{
    public function index(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $exception = '';
        (new Loader())->loadTemplateView('day_records', $_POST + ['exception' => $exception]);
    }
}
