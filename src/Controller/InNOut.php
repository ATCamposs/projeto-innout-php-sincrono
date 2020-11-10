<?php

namespace Src\Controller;

use Src\Config\Session;
use Src\Exceptions\AppException;
use Src\Model\WorkingHours;

class InNOut
{
    public function register(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $user = $_SESSION['user'];
        $records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
        try {
            $currentTime = strftime('%H:%M:%S', time());
            $records->innout($currentTime);
            addSuccessMsg('Ponto inserido com sucesso !');
        } catch (AppException $e) {
            addErrorMsg($e->getMessage());
        }
        header('Location: day_records.php');
    }

    public function forcedRegister(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $user = $_SESSION['user'];
        $records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
        try {
            $currentTime = strftime('%H:%M:%S', time());
            if (!empty($_POST['forcedTime'])) {
                $currentTime = $_POST['forcedTime'];
            }
            $records->innout($currentTime);
            addSuccessMsg('Ponto inserido com sucesso !');
        } catch (AppException $e) {
            addErrorMsg($e->getMessage());
        }
        header('Location: day_records.php');
    }
}
