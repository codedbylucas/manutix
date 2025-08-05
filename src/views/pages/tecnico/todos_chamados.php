<?php $render('header'); ?>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 p-5">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            <h4>Todas as Solicitações</h4>
                        </div>
                        <div class="card-body">
                            <table id="minhasSolicitacoes" class="table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Título</th>
                                        <th>Tipo de Serviço</th>
                                        <th>Prioridade</th>
                                        <th>Data de Abertura</th>
                                        <th>Técnico</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($chamados as $chamado): ?>
                                        <tr>
                                            <td>
                                               <?php
                                                    switch ($chamado['status']) {
                                                        case 'novo':
                                                            echo '<span class="badge bg-primary text-white">Novo</span>';
                                                            break;
                                                        case 'andamento':
                                                            echo '<span class="badge bg-warning text-dark">Em Andamento</span>';
                                                            break;
                                                        case 'aguardando_material':
                                                            echo '<span class="badge bg-info text-dark">Aguardando Material</span>';
                                                            break;
                                                        case 'concluido':
                                                            echo '<span class="badge bg-success text-white">Concluído</span>';
                                                            break;
                                                        case 'cancelado':
                                                            echo '<span class="badge bg-danger text-white">Cancelado</span>';
                                                            break;
                                                        default:
                                                            $nomeStatus = str_replace('_', ' ', $chamado['status']);
                                                            echo '<span class="badge bg-secondary text-white">' . ucwords($nomeStatus) . '</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($chamado['titulo']) ?></td>
                                            <td><?= htmlspecialchars($chamado['tipo_servico']) ?></td>
                                            <td><?= strtoupper(htmlspecialchars($chamado['prioridade']) )?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($chamado['data_abertura'])) ?></td>
                                            <td>
                                                <?php if (!empty($chamado['nome_tecnico'])): ?>
                                                    <?= htmlspecialchars($chamado['nome_tecnico']) ?>
                                                <?php else: ?>
                                                    <form action="<?= $base ?>/chamados/assumir" method="POST" style="display:inline;">
                                                        <input type="hidden" name="chamado_id" value="<?= $chamado['id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-user-check"></i> Assumir
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const baseUrl = "<?=$base?>";
    </script>
    <script src="<?=$base?>/assets/js/listar_chamados.js"></script>
