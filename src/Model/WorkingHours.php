<?php

namespace Src\Model;

use DateTime;
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

    public function innout(string $time): void
    {
        $timeColumn = $this->getNextTime();
        if (empty($timeColumn)) {
            throw new AppException("Você já fez os 4 batimentos do dia!");
        }

        $this->$timeColumn = $time;
        $id = $this->id;

        if (!empty($id)) {
            $this->update();
        }
        if (empty($id)) {
            $this->insert();
        }
    }
}
