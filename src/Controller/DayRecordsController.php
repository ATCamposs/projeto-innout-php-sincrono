<?php

namespace Src\Controller;

use DateTime;
use Src\Config\Loader;
use Src\Config\Session;

class DayRecordsController
{
    public function index(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $date = (new DateTime())->getTimestamp();
        $today = strftime('%d de %B de %Y', $date);
        $exception = '';
        (new Loader())->loadTemplateView('day_records', $_POST + ['exception' => $exception] + ['today' => $today]);
    }
}
