<?php

namespace Src\Config;

require_once __DIR__ . '/../Config/Config.php';

use DateTime;
use Src\Config\Loader;
use Src\Config\Database;
use Src\Model\WorkingHours;

(new Loader())->loadModel('WorkingHours');

Database::executeSQL('DELETE FROM working_hours');
Database::executeSQL('DELETE FROM users WHERE id > 5');

/** @param (string|DateTime) $date */
function getDateAsDateTime($date): DateTime
{
    return is_string($date) ? new DateTime($date) : $date;
}

/** @param (string|DateTime) $date */
function isWeekend($date): bool
{
    $inputDate = getDateAsDateTime($date);
    return $inputDate->format('N') >= 6;
}

/** @param (string|DateTime) $date1
 *  @param (string|DateTime) $date2
 */
function isBefore($date1, $date2): bool
{
    $inputDate1 = getDateAsDateTime($date1);
    $inputDate2 = getDateAsDateTime($date2);
    return $inputDate1 <= $inputDate2;
}

/** @param (string|DateTime) $date */
function getNextDay($date): DateTime
{
    $inputDate = getDateAsDateTime($date);
    $inputDate->modify('+1 day');
    return $inputDate;
}


/** @return mixed */
function getDayTemplateByOdds(int $regularRate, int $extraRate, int $lazyRate)
{
    $regularDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => 60 * 60 * 8
    ];

    $extraHourDayTemplate = [
        'time1' => '08:00:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '18:00:00',
        'worked_time' => (60 * 60 * 8) + 3600
    ];

    $lazyDayTemplate = [
        'time1' => '08:30:00',
        'time2' => '12:00:00',
        'time3' => '13:00:00',
        'time4' => '17:00:00',
        'worked_time' => (60 * 60 * 8) - 1800
    ];

    $value = rand(0, 100);
    if ($value <= $regularRate) {
        return $regularDayTemplate;
    }
    if (($value > $regularRate) && $value <= $regularRate + $extraRate) {
        return $extraHourDayTemplate;
    }
    if ($value > $regularRate + $lazyRate) {
        return $lazyDayTemplate;
    }
}

function populateWorkingHours($userId, $initialDate, $regularRate, $extraRate, $lazyRate)
{
    $currentDate = $initialDate;
    $today = new DateTime();
    $columns = ['user_id' => $userId, 'work_date' => $currentDate];

    while (isBefore($currentDate, $today)) {
        if (!isWeekend($currentDate)) {
            $template = getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);
            $columns = array_merge($columns, $template);
            $workingHours = new WorkingHours($columns);
            $workingHours->save();
        }
        $currentDate = getNextDay($currentDate)->format('Y-m-d');
        $columns['work_date'] = $currentDate;
    }
}

$lastMonth = \strtotime('first day of last month');
populateWorkingHours(1, date('Y-m-d', $lastMonth), 70, 20, 10);
populateWorkingHours(3, date('Y-m-d', $lastMonth), 20, 75, 5);
populateWorkingHours(4, date('Y-m-d', $lastMonth), 50, 50, 50);

echo "Tudo certo";
