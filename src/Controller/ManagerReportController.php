<?php

namespace Src\Controller;

use DateTime;
use Src\Config\Loader;
use Src\Config\Session;
use Src\Model\User;
use Src\Model\WorkingHours;

class ManagerReportController
{
    public function index(): void
    {
        session_start();
        (new Session())->requireValidSession(true);
        $activeUsersCount = User::getActiveUsersCount();
        $absentUsers = WorkingHours::getAbsentUsers();
        $yearAndMonth = (new DateTime())->format('Y-m');
        $seconds = WorkingHours::getWorkedTimeInMonth($yearAndMonth);
        $hoursInMonth = explode(':', \getTimeStringFromSeconds($seconds))[0];

        (new Loader())->loadTemplateView('manager_report', [
            'activeUsersCount' => $activeUsersCount,
            'absentUsers' => $absentUsers,
            'hoursInMonth' => $hoursInMonth
        ]);
    }
}
