<?= $render('header') ?>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?= $render('sideBar') ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                   <div class="row">
                    <!-- Gráfico de Barras -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Chamados por Técnico
                            </div>
                            <div class="card-body">
                                <canvas id="myBarChart" style="max-width: 100%; max-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico de Pizza -->
                    <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Status dos Chamados
                                </div>
                                <div class="card-body">
                                    <canvas id="myPieChart" style="max-width: 100%; max-height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const baseUrl = "<?=$base?>";
    </script>
    <script src="<?=$base?>/assets/js/dashboard.js"></script>


