<?php

namespace Src\Controller;

use DateTime;
use Src\Config\Loader;
use Src\Config\Session;
use Src\Model\WorkingHours;

class DayRecordsController
{
    public function index(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $date = (new DateTime())->getTimestamp();
        $today = strftime('%d de %B de %Y', $date);
        $exception = '';

        $user = $_SESSION['user'];
        $records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
        $workedInterval = $records->getWorkedInterval();
        $workedInterval = $workedInterval->format('%H:%I:%S');
        $exitTime = $records->getExitTime();
        $exitTime = $exitTime->format('H:i:s');

        (new Loader())->loadTemplateView('day_records', $_POST + [
            'exception' => $exception, 'today' => $today, 'records' => $records,
            'workedInterval' => $workedInterval, 'exitTime' => $exitTime,
            'activeClock' => $records->getActiveClock()
        ]);
    }
}
