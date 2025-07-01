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
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Minhas Solicitações
                        </div>
                        <div class="card-body">
                            <table id="minhasSolicitacoes" class="table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Título</th>
                                        <th>Tipo de Serviço</th>
                                        <th>Prioridade</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?= $render('footer') ?>