<?php

namespace Src\Config;

class Session
{
    public function requireValidSession(): void
    {
        $user = $_SESSION['user'];
        if (!isset($user)) {
            header('Location: login.php');
            exit();
        }
    }

    public function sessionLogout(): void
    {
        session_destroy();
        header('Location: login.php');
    }
}
