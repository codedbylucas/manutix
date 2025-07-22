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
                                <tbody>
                                <?php foreach ($avaliacoes as $av): ?>
                                    <tr>
                                        <td><?= $av['id'] ?></td>
                                        <td><?= htmlspecialchars($av['titulo']) ?></td>
                                        <td data-nota="<?= $av['nota'] ?>">
                                            <?= str_repeat('⭐', (int)$av['nota']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($av['comentario']) ?></td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
<script>
    const baseUrl = "<?=$base?>";
</script>
<script src="<?=$base?>/assets/js/avaliacoes.js"></script>