<?php

use Src\View\Template\Messages;

if (isset($exception) && method_exists($exception, 'get')) {
    $email_exception = !empty($exception->get('email')) ? $exception->get('email') : null;
    $password_exception = !empty($exception->get('password')) ? $exception->get('password') : null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/comum.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>In 'n Out</title>
</head>

<body>
    <form class="form-login" action="#" method="post">
        <div class="login-card card">
            <div class="card-header">
                <i class="icofont-travelling mr-2"></i>
                <span class="font-weight-light">In</span>
                <span class="font-weight-bold mx-2">N'</span>
                <span class="font-weight-light">Out</span>
                <i class="icofont-runner-alt-1 ml-2"></i>
            </div>
            <div class="card-body">
                <?php if (!empty($exception)) {
                    (new Messages())->errorMessage($exception);
                }
                ?>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control <?= !empty($email_exception) ? 'is-invalid' : '' ?>" value="<?= !empty($email) ? $email : '' ?>" placeholder="Informe o e-mail" autofocus>
                    <div class="invalid-feedback">
                        <?= !empty($email_exception) ? $email_exception : '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control <?= !empty($password_exception) ? 'is-invalid' : '' ?>" placeholder="Informe a senha">
                    <div class="invalid-feedback">
                        <?= !empty($password_exception) ? $password_exception : '' ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-lg btn-primary">Entrar</button>
            </div>
        </div>
    </form>
</body>

</html>