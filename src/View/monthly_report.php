<?php

use Src\Config\Loader;

echo '<main class="content">';
(new Loader())->loadTitle(
    'Relatório Mensal',
    'Acompanhe seu saldo de horas',
    'icofont-ui-calendar'
);
$user = isset($user) ? $user : (object) $user = [];
$users = isset($users) ? $users : (object) $users = [];
$selectedUserId = $selectedUserId ?? null;
$selectedPeriod = $selectedUserId ?? null;
$periods = isset($periods) ? $periods : (object) $periods = [];
$sumOfWorkedTime = $sumOfWorkedTime ?? null;
$balance = $balance ?? null;
?>
<div>
    <form class="mb-4" action="#" method="post">
        <div class="input-group">
            <?php if ($user->is_admin) : ?>
                <select name="user" class="form-control mr-2" placeholder="Selecione o usuário...">
                    <option value="">Selecione o usuário</option>
                    <?php
                    foreach ($users as $user) {
                        $selected = ($user->id == $selectedUserId) ? 'selected' : '';
                        echo "<option value='{$user->id}' {$selected}>{$user->name}</option>";
                    }
                    ?>
                </select>
            <?php endif ?>
            <select name="period" class="form-control" placeholder="Selecione o periodo...">
                <?php
                foreach ($periods as $key => $month) {
                    $selected = ($key == $selectedPeriod) ? 'selected' : '';
                    echo "<option value='{$key}' {$selected}>{$month}</option>";
                }
                ?>
            </select>
            <button class="btn btn-primary ml-2">
                <i class="icofont-search">

                </i>
            </button>
        </div>
    </form>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th>Dia</th>
            <th>Entrada 1</th>
            <th>Saída 1</th>
            <th>Entrada 2</th>
            <th>Saída 2</th>
            <th>Saldo</th>
        </thead>
        <tbody>
            <?php if (isset($report) && count($report) > 0) : ?>
                <?php foreach ($report as $registry) : ?>
                    <tr>
                        <td>
                            <?= formatDateWithLocale($registry->work_date, '%A, %d de %B de %Y') ?>
                        </td>
                        <td>
                            <?= $registry->time1 ?>
                        </td>
                        <td>
                            <?= $registry->time2 ?>
                        </td>
                        <td>
                            <?= $registry->time3 ?>
                        </td>
                        <td>
                            <?= $registry->time4 ?>
                        </td>
                        <td>
                            <?= $registry->getBalance(); ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <tr class="bg-primary text-white">
                    <td>Horas Trabalhadas</td>
                    <td colspan="3"><?= $sumOfWorkedTime ?></td>
                    <td>Saldo Mensal</td>
                    <td><?= $balance ?></td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>
</main>