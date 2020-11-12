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

function getLastDayOfMonth(DateTime $date): DateTime
{
    $time = getDateAsDateTime($date)->getTimestamp();
    return new DateTime(date('Y-m-t', $time));
}

function getFirstDayOfMonth(DateTime $date): DateTime
{
    $time = getDateAsDateTime($date)->getTimestamp();
    return new DateTime(date('Y-m-1', $time));
}

function getSecondsFromDateInterval(DateInterval $interval): int
{
    $d1 = new DateTimeImmutable();
    $d2 = $d1->add($interval);
    return $d2->getTimestamp() - $d1->getTimestamp();
}

function isPastWorkday(string $date): bool
{
    return !isWeekend($date) && isBefore($date, new DateTime());
}

function getTimeStringFromSeconds(int $seconds): string
{
    $hour = intdiv($seconds, 3600);
    $minute = intdiv($seconds % 3600, 60);
    $sec = $seconds - ($hour * 3600) - ($minute * 60);
    return sprintf('%02d:%02d:%02d', $hour, $minute, $sec);
}

function formatDateWithLocale(string $date, string $pattern): string
{
    $time = getDateAsDateTime($date)->getTimestamp();
    return strftime($pattern, $time);
}
