<?php

use Src\Config\Loader;
use Src\View\Template\Messages;

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
                <span class="record">Entrada 1: ----</span>
                <span class="record">Saída 1: ----</span>
            </div>
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 2: ----</span>
                <span class="record">Saída 2: -----</span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-around">
            <a href="???" class="btn btn-success btn-lg">
                <i class="icofont-check mr-1"></i>
                Bater o Ponto
            </a>
        </div>
    </div>
</main>