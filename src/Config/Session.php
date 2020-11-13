<?php

namespace Src\Config;

class Session
{
    public function requireValidSession(bool $requireIsAdmin = false): void
    {
        $user = $_SESSION['user'];
        if ($requireIsAdmin && !$user->is_admin) {
            \addErrorMsg('Acesso negado');
            header('Location: day_records.php');
            exit();
        }
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
