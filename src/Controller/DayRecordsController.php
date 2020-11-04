<?php

namespace Src\Controller;

use Src\Config\Loader;

class DayRecordsController
{
    public function index(): void
    {
        $exception = '';
        (new Loader())->loadTemplateView('day_records', $_POST + ['exception' => $exception]);
    }
}
