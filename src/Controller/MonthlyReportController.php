<?php

namespace Src\Controller;

use DateTime;
use Src\Config\Loader;
use Src\Config\Session;
use Src\Model\WorkingHours;

class MonthlyReportController
{
    public function index(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $currentDate = new DateTime();

        $user = $_SESSION['user'];

        $registries = WorkingHours::getMonthlyReport($user->id, $currentDate);
        $report = [];
        $workDay = 0;
        $sumOfWorkedTime = 0;
        $lastDay = \getLastDayOfMonth($currentDate)->format('d');

        for ($day = 2; $day <= $lastDay; $day++) {
            $date = $currentDate->format('Y-m') . '-' . sprintf('%02d', $day);
            $registry = $registries[$date] ?? null;
            isPastWorkday($date) ? $workDay++ : $workDay;

            if (!empty($registry) && \is_object($registry)) {
                $sumOfWorkedTime += $registry->worked_time;
                array_push($report, $registry);
            }

            if (empty($registry)) {
                array_push($report, new WorkingHours([
                    'work_date' => $date,
                    'worked_time' => '0'
                ]));
            }
        }
        $expectedTime = $workDay * 60 * 60 * 8;
        $balance = \getTimeStringFromSeconds(abs($sumOfWorkedTime - $expectedTime));
        $sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';
        $exception = '';
        (new Loader())->loadTemplateView('monthly_report', $_POST + [
            'exception' => $exception,
            'report' => $report,
            'sumOfWorkedTime' => $sumOfWorkedTime,
            'balance' => "{$sign}{$balance}"
        ]);
    }
}
