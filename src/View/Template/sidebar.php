<aside class="sidebar">
    <nav class="menu mt-3">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="day_records.php">
                    <i class="icofont-ui-check mr-2">
                        Registrar Ponto
                    </i>
                </a>
            </li>
            <li class="nav-item">
                <a href="monthly_report.php">
                    <i class="icofont-ui-calendar mr-2">
                        Relatório Mensal
                    </i>
                </a>
            </li>
            <li class="nav-item">
                <a href="manager_report.php">
                    <i class="icofont-chart-histogram mr-2">
                        Relatório Gerencial
                    </i>
                </a>
            </li>
            <li class="nav-item">
                <a href="users.php">
                    <i class="icofont-users mr-2">
                        Usuários
                    </i>
                </a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-widgets">
        <div class="sidebar-widget">
            <i class="icon icofont-hour-glass text-primary"></i>
            <div class="info">
                <span class="main text-primary" <?= (isset($activeClock) && $activeClock === 'workedInterval') ? 'active-clock' : '' ?>>
                    <?= isset($workedInterval) ? $workedInterval : null ?>
                </span>
                <span class="label text-muted">Horas Trabalhadas</span>
            </div>
        </div>
        <div class="division my-3"></div>
        <div class="sidebar-widget">
            <i class="icon icofont-ui-alarm text-danger"></i>
            <div class="info">
                <span class="main text-danger" <?= (isset($activeClock) && $activeClock === 'exitTime') ? 'active-clock' : '' ?>>
                    <?= isset($exitTime) ? $exitTime : null ?>
                </span>
                <span class="label text-muted">Hora de Saída</span>
            </div>
        </div>
    </div>
</aside>