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

                    <!-- Gráfico de Barras: Chamados por Técnico -->
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
    <script>
        const baseUrl = "<?= $base ?>";
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Configurações globais Chart.js
        Chart.defaults.font.family = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.color = '#292b2c';

        // Gráfico de Pizza - Status dos Chamados
        fetch(baseUrl + '/grafico/status')
            .then(r => {
                if (!r.ok) throw new Error('Resposta não OK');
                return r.json();
            })
            .then(data => {
                const labels = data.map(item => item.status);
                const values = data.map(item => item.total);
                const colors = ['#007bff', '#dc3545', '#ffc107', '#28a745', '#6610f2', '#6c757d'];

                const ctx = document.getElementById("myPieChart");
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: colors.slice(0, values.length),
                        }],
                    },
                });
            })
            .catch(error => {
                console.error('Erro ao carregar dados do gráfico:', error);
            });


        // Gráfico de Barras - Chamados por Técnico
        fetch(baseUrl + '/grafico/tecnico')
            .then(r => {
                if (!r.ok) throw new Error('Resposta não OK');
                return r.json();
            })
            .then(data => {
                const labels = data.map(item => item.tecnico);
                const values = data.map(item => item.total);

                const ctx = document.getElementById("myBarChart");
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Chamados',
                            data: values,
                            backgroundColor: '#0d6efd',  // Azul Bootstrap
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: context => context.parsed.y + ' chamados'
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: { display: true, text: 'Técnico' }
                            },
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Quantidade de chamados' },
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Erro ao carregar dados do gráfico:', error);
            });
    </script>


