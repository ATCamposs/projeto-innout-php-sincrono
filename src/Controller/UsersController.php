<?php

namespace Src\Controller;

use DateTime;
use Src\Config\Loader;
use Src\Config\Session;
use Src\Model\User;

class UsersController
{
    public function index(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $users = User::get('');
        foreach ($users as $user) {
            $user->start_date = (new DateTime($user->start_date))->format('d/m/y');
            if($user->end_date) {
                $user->end_date = (new DateTime($user->end_date))->format('d/m/y');
            }
        }
        (new Loader())->loadTemplateView('users', [
            'users' => $users
        ]);
    }
}
