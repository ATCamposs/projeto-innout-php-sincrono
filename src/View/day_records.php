<?php

use Src\Config\Loader;
use Src\View\Template\Messages;

$records = !empty($records) ? $records : (object) [];
?>

<main class="content">
    <?php

    (new Loader())->loadTitle(
        'Registrar Ponto',
        'Mantenha seu ponto consistente !',
        'icofont-check-alt'
    );
    if (!empty($exception)) {
        (new Messages())->errorMessage($exception);
    }
    ?>
    <div class="card">
        <div class="card-header">
            <h3> <?= isset($today) ? $today : null ?></h3>
            <p class="mb-0">Os batimentos efetuados hoje </p>
        </div>
        <div class="card-body">
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 1: <?= $records->time1 ?? '---' ?></span>
                <span class="record">Saída 1: <?= $records->time2 ?? '---' ?></span>
            </div>
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 2: <?= $records->time3 ?? '---' ?></span>
                <span class="record">Saída 2: <?= $records->time4 ?? '---' ?></span>
            </div>
        </div>
        <?php if (empty($records->time4) || $records->time4 == '00:00:00') : ?>
            <div class="card-footer d-flex justify-content-around">
                <a href="registrar_ponto.php" class="btn btn-success btn-lg">
                    <i class="icofont-check mr-1"></i>
                    Bater o Ponto
                </a>
            </div>
        <?php endif; ?>
        <?php if (!empty($records->time4)) : ?>
            <div class="card-footer d-flex justify-content-around">
                <p class="mb-0">Você já registrou seus pontos hoje !</p>
            </div>
        <?php endif; ?>
    </div>

    <form class="mt-5" action="registro_forcado.php" method="post">
        <div class="input-group no-border">
            <input type="text" name="forcedTime" class="form-control" 
            placeholder="Informe a hora para simular o batimento">
            <button class="btn btn-danger ml-3">
                Simular Ponto
            </button>
        </div>
    </form>
</main>