<?php

namespace Src\Model;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use PDO;
use Src\Exceptions\AppException;
use Src\Model\Model;

class WorkingHours extends Model
{
    protected static $tableName = 'working_hours';

    /** @var string $time1 */
    public $time1;

    /** @var string $time2 */
    public $time2;

    /** @var string $time3 */
    public $time3;

    /** @var string $time4 */
    public $time4;

    /** @var int $worked_time */
    public $worked_time;

    /** @var string $work_date */
    public $work_date;

    /**
     * @var array{string, string} $columns
     */
    protected static $columns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time'
    ];

    public static function loadFromUserAndDate(string $userId, string $workDate): WorkingHours
    {
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);
        if (empty($registry->values)) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => "0"
            ]);
        }

        return  $registry;
    }

    public function getNextTime(): ?string
    {
        if (!$this->time1) {
            return 'time1';
        }
        if (!$this->time2) {
            return 'time2';
        }
        if (!$this->time3) {
            return 'time3';
        }
        if (!$this->time4) {
            return 'time4';
        }
        return null;
    }

    public function getActiveClock(): ?string
    {
        $nextTime = $this->getNextTime();
        if ($nextTime == 'time1' || $nextTime == 'time3') {
            return 'exitTime';
        }
        if ($nextTime == 'time2' || $nextTime == 'time4') {
            return 'workedInterval';
        }
        return null;
    }

    public function innout(string $time): void
    {
        $timeColumn = $this->getNextTime();
        if (empty($timeColumn)) {
            throw new AppException("Você já fez os 4 batimentos do dia!");
        }

        $this->$timeColumn = $time;
        $id = $this->id;
        $this->worked_time = \getSecondsFromDateInterval($this->getWorkedInterval());
        if (!empty($id)) {
            $this->update();
        }
        if (empty($id)) {
            $this->insert();
        }
    }

    public function getWorkedInterval(): DateInterval
    {
        [$t1, $t2, $t3, $t4] = $this->getTimes();
        $part1 = new DateInterval('PT0S');
        $part2 = new DateInterval('PT0S');

        if ($t1) {
            $part1 = $t1->diff(new DateTime());
        }
        if ($t2 && $t1 instanceof DateTime) {
            $part1 = $t1->diff($t2);
        }
        if ($t3) {
            $part2 = $t3->diff(new DateTime());
        }
        if ($t4 && $t3 instanceof DateTime) {
            $part2 = $t3->diff($t4);
        }

        return sumIntervals($part1, $part2);
    }

    /** @return DateInterval|false */
    public function getLunchInterval()
    {
        [, $t2, $t3,] = $this->getTimes();
        $breakInterval = new DateInterval('PT0S');

        if ($t2 && $t2 instanceof DateTime) {
            $breakInterval = $t2->diff(new DateTime());
        }
        if ($t3 && $t3 instanceof DateTime && $t2 instanceof DateTime) {
            $breakInterval = $t2->diff($t3);
        }
        return $breakInterval;
    }

    public function getExitTime(): DateTime
    {
        [$t1,,, $t4] = $this->getTimes();
        $workday = date_interval_create_from_date_string('8 hours');
        $defaultBreakInterval = date_interval_create_from_date_string('1 hour + 30 minutes');
        if (!$t1) {
            $totalTime =  (new DateTime())->add($workday);
            $totalTime->add($defaultBreakInterval);
            return $totalTime;
        }
        if ($t4) {
            return $t4;
        }
        $lunchInterval = $this->getLunchInterval();
        if ($lunchInterval instanceof DateInterval) {
            $totalInterval = substracIntervals($defaultBreakInterval, $lunchInterval);
            $total = sumIntervals($workday, $totalInterval);
            return $t1->add($total);
        }
        return new DateTime();
    }

    public function getBalance(): string
    {
        if (
            $this->time1 && !isPastWorkday($this->work_date) ||
            $this->worked_time == 60 * 60 * 8
        ) {
            return '-';
        }
        $balance = $this->worked_time - 60 * 60 * 8;
        $balanceString = \getTimeStringFromSeconds(abs($balance));
        $sign = $this->worked_time >= 60 * 60 * 8 ? '+ ' : '- ';
        return "{$sign}{$balanceString}";
    }

    /** @return array<int|string, WorkingHours> */
    public static function getMonthlyReport(int $userId, DateTime $date)
    {
        $registries = [];
        $startDate = \getFirstDayOfMonth($date)->format('Y-m-d');
        $endDate = \getLastDayOfMonth($date)->format('Y-m-d');

        $result = static::getResultSetFromSelect([
            'user_id' => $userId,
            'raw' => "work_date between '{$startDate}' AND '{$endDate}'"
        ]);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $registries[$row['work_date']] = new WorkingHours($row);
            }
        }
        return $registries;
    }

    /** @return array<int, Datetime|false|null> */
    private function getTimes()
    {
        $times = [];

        $this->time1 ? array_push($times, getDateFromString($this->time1)) : array_push($times, null);
        $this->time2 ? array_push($times, getDateFromString($this->time2)) : array_push($times, null);
        $this->time3 ? array_push($times, getDateFromString($this->time3)) : array_push($times, null);
        $this->time4 ? array_push($times, getDateFromString($this->time4)) : array_push($times, null);
        return $times;
    }
}
