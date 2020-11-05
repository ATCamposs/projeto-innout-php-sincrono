<?php

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

print_r(getDayTemplateByOdds(34, 33, 33));
