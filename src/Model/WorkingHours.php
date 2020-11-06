<?php

namespace Src\Model;

use Src\Model\Model;

class WorkingHours extends Model
{
    protected static $tableName = 'working_hours';

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
}
