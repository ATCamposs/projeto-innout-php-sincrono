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
