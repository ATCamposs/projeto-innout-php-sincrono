<?php

namespace Home;

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config\Database;

$sql = 'select * from users';
$result = Database::getResultFromQuery($sql);

if (!empty($result)) {
    while ($row = $result->fetch()) {
        print_r($row);
        echo '<br>';
    }
}
