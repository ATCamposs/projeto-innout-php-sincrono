<?php

use Src\Config\Loader;
use Src\View\Template\Messages;

echo '<main class="content">';
(new Loader())->loadTitle(
    'Cadastro de Usuário',
    'Crie e atualize o usuário',
    'icofont-user'
);
if (isset($exception) && method_exists($exception, 'get')) {
    $name_exception = $exception->get('name') ?? null;
    $email_exception = $exception->get('email') ?? null;
    $password_exception = $exception->get('password') ?? null;
    $confirm_password_exception = $exception->get('confirm_password') ?? null;
    $start_date_exception = $exception->get('start_date') ?? null;
    $end_date_exception = $exception->get('end_date') ?? null;
    $is_admin_exception = $exception->get('is_admin') ?? null;
}
    $id = $userData['id'] ?? null;
    $name = $userData['name'] ?? null;
    $email = $userData['email'] ?? null;
    $start_date = $userData['start_date'] ?? null;
    $end_date = $userData['end_date'] ?? null;
    $is_admin = $userData['is_admin'] ?? null;
if (!empty($exception)) {
    (new Messages())->errorMessage($exception);
}
?>

<form action="#" method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Nome</label>
            <input type="text" id="name" name="name" placeholder="Informe o nome" 
            class="form-control <?= !empty($name_exception) ? 'is-invalid' : '' ?>" value="<?= $name ?>">
            <div class="invalid-feedback">
                <?= $name_exception ?? null ?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Informe o email" 
            class="form-control <?= !empty($email_exception) ? 'is-invalid' : '' ?>" value="<?= $email ?>">
            <div class="invalid-feedback">
                <?= $email_exception ?? null ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" placeholder="Informe a senha" 
            class="form-control <?= !empty($password_exception) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback">
                <?= $password_exception ?? null ?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="confirm_password">Confirmação de Senha</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirme a senha" 
            class="form-control <?= !empty($confirm_password_exception) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback">
                <?= $confirm_password_exception ?? null ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="start_date">Data de Admissão</label>
            <input type="date" id="start_date" name="start_date" 
            class="form-control <?= !empty($start_date_exception) ? 'is-invalid' : '' ?>" value="<?= $start_date ?>">
            <div class="invalid-feedback">
                <?= $start_date_exception ?? null ?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="end_date">Data de Desligamento</label>
            <input type="date" id="end_date" name="end_date" 
            class="form-control <?= !empty($end_date_exception) ? 'is-invalid' : '' ?>" value="<?= $end_date ?>">
            <div class="invalid-feedback">
                <?= $end_date_exception ?? null ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="is_admin">Administrador?</label>
            <input type="checkbox" id="is_admin" name="is_admin" 
            class="form-control <?= !empty($is_admin_exception) ? 'is-invalid' : '' ?>" 
            <?= !empty($is_admin) ? 'checked' : '' ?>>
            <div class="invalid-feedback">
                <?= $is_admin_exception ?? null ?>
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-primary btn-lg">Salvar</button>
        <a href="/users.php" class="btn btn-secondary btn-lg">Cancelar</a>
    </div>
</form>
</main>