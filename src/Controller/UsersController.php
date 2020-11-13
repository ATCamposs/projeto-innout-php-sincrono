<?php

namespace Src\Controller;

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
        }
        (new Loader())->loadTemplateView('users');
    }
}
