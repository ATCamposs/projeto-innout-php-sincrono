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
        (new Session())->requireValidSession(true);

        $exception = null;
        if (isset($_GET['delete'])) {
            $exception = $this->deleteUser();
        }
        $users = User::get('');
        foreach ($users as $user) {
            $user->start_date = (new DateTime($user->start_date))->format('d/m/y');
            if ($user->end_date) {
                $user->end_date = (new DateTime($user->end_date))->format('d/m/y');
            }
        }
        (new Loader())->loadTemplateView('users', [
            'exception' => $exception,
            'users' => $users
        ]);
    }

    public function deleteUser(): ?Exception
    {
        try {
            User::deleteById($_GET['delete']);
            \addSuccessMsg('Usuário excluido com sucesso.');
            return null;
        } catch (Exception $e) {
            \stripos($e->getMessage(), 'FOREIGN KEY') ? \addErrorMsg('Não foi possível excluir o usuário.') : null;
            return $e;
        }
    }

    public function saveUser(): void
    {
        session_start();
        (new Session())->requireValidSession(true);
        $exception = null;
        $userData = $_POST;

        if (count($_POST) == 0 && isset($_GET['update'])) {
            $user = User::getOne(['id' => $_GET['update']]);
            $userData = $user->getValues();
            $userData['password'] = null;
        }

        if (count($_POST) > 0) {
            $exception = $this->trySaveUser();
        }

        (new Loader())->loadTemplateView('save_user', ['exception' => $exception, 'userData' => $userData]);
    }

    /** @return Exception|null */
    private function trySaveUser()
    {
        try {
            !empty($_POST['is_admin']) ? $_POST['is_admin'] = "0" : $_POST['is_admin'] = "1";
            !empty($_POST['end_date']) ? $_POST['end_date'] = $_POST['end_date'] : $_POST['end_date'] = "null";
            $_POST['initial_pass'] = $_POST['password'];
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $_POST['confirm_password'] = password_hash($_POST['confirm_password'], PASSWORD_DEFAULT);
            $newUser = new User($_POST);
            if ($newUser->id) {
                $newUser->update();
            }
            $newUser->validate();
            $newUser->insert();
            return null;
        } catch (Exception $e) {
            return $e;
        }
    }
}
