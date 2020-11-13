<?php

namespace Src\Controller;

use DateTime;
use Exception;
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
            if ($user->end_date) {
                $user->end_date = (new DateTime($user->end_date))->format('d/m/y');
            }
        }
        (new Loader())->loadTemplateView('users', [
            'users' => $users
        ]);
    }

    public function saveUser(): void
    {
        session_start();
        (new Session())->requireValidSession();
        $exception = null;

        if (count($_POST) > 0) {
            $exception = $this->trySaveUser();
        }

        (new Loader())->loadTemplateView('save_user', ['exception' => $exception]);
    }

    /** @return Exception|null */
    private function trySaveUser()
    {
        try {
            !isset($_POST['is_admin']) ? $_POST['is_admin'] = "0" : $_POST['is_admin'] = "1";
            !isset($_POST['end_date']) ? $_POST['end_date'] = $_POST['end_date'] : $_POST['end_date'] = null;

            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $newUser = new User($_POST);
            $newUser->validate();
            $newUser->insert();
            \addSuccessMsg('Usuário cadastrado com sucesso');
            $_POST = [];
            return null;
        } catch (Exception $e) {
            return $e;
        }
    }
}
