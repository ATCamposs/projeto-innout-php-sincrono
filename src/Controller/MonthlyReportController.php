<?php

namespace Src\Controller;

use DateTime;
use Src\Config\Loader;
use Src\Config\Session;
use Src\Model\User;
use Src\Model\WorkingHours;

class MonthlyReportController
{
    public function index(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $currentDate = new DateTime();

        $users = null;
        $selectedUserId = $_SESSION['user']->id;
        $user = $_SESSION['user'];

        if ($user->is_admin) {
            $users = User::get('');
            $selectedUserId = $_POST['user'] ?? $user->id;
        }

        $selectedPeriod = $_POST['period'] ?? $currentDate->format('Y-m');
        $selectedPeriod = new DateTime($selectedPeriod);
        $periods = [];

        for ($yearDiff = 0; $yearDiff <= 2; $yearDiff++) {
            $year = date('Y') - $yearDiff;
            for ($month = 12; $month >= 1; $month--) {
                $date = new DateTime("{$year}-{$month}-1");
                $periods[$date->format('Y-m')] = strftime('%B de %Y', $date->getTimestamp());
            }
        }

        $registries = WorkingHours::getMonthlyReport($selectedUserId, $selectedPeriod);
        $report = [];
        $workDay = 0;
        $sumOfWorkedTime = 0;
        $lastDay = \getLastDayOfMonth($selectedPeriod)->format('d');

        for ($day = 2; $day <= $lastDay; $day++) {
            $date = $selectedPeriod->format('Y-m') . '-' . sprintf('%02d', $day);
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
        $selectedPeriod = $selectedPeriod->format('Y-m');
        (new Loader())->loadTemplateView('monthly_report', $_POST + [
            'exception' => $exception,
            'report' => $report,
            'sumOfWorkedTime' => \getTimeStringFromSeconds($sumOfWorkedTime),
            'selectedPeriod' => $selectedPeriod,
            'balance' => "{$sign}{$balance}",
            'periods' => $periods,
            'users' => $users,
            'user' => $user,
            'selectedUserId' => $selectedUserId
        ]);
    }
}
