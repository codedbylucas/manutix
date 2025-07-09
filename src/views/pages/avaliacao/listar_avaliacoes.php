<?php $render('header'); ?>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 p-5">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-star me-1"></i> Avaliações Recebidas
                        </div>
                        <div class="card-body">
                            <table id="tabelaAvaliacoes" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título do Chamado</th>
                                        <th>Nota</th>
                                        <th>Comentário</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#tabelaAvaliacoes').DataTable({
            ajax: '/manutix/avaliacoes/listar',
            columns: [
                { data: 'id' },
                { data: 'titulo' },
                { 
                    data: 'nota',
                    render: nota => '⭐'.repeat(nota)
                },
                { data: 'comentario' }
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json'
            }
        });
    });
</script>
