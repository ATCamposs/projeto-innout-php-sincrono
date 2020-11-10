<?php

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

function sumIntervals(DateInterval $interval1, DateInterval $interval2): DateInterval
{
    $date = new DateTime('00:00:00');
    $date->add($interval1);
    $date->add($interval2);
    return (new DateTime('00:00:00'))->diff($date);
}

function substracIntervals(DateInterval $interval1, DateInterval $interval2): DateInterval
{
    $date = new DateTime('00:00:00');
    $date->add($interval1);
    $date->sub($interval2);
    return (new DateTime('00:00:00'))->diff($date);
}

function getDateFromInterval(DateInterval $interval): DateTime
{
    return new DateTime($interval->format('%H:%i:%s'));
}

/** @return DateTime|false */
function getDateFromString(string $str)
{
    return date_create_from_format('H:i:s', $str);
}