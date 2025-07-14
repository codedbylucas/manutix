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
                                        <th>Ações</th>
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
                                           <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-sm btn-primary" 
                                                        onclick="editarSolicitacao({
                                                            id: '<?= $chamado['id'] ?>',
                                                            titulo: '<?= $chamado['titulo'] ?>',
                                                            descricao: '<?= $chamado['descricao'] ?>',
                                                            prioridade: '<?= $chamado['prioridade'] ?>',
                                                            status: '<?= $chamado['status'] ?>',
                                                            setor_id: '<?= $chamado['setor_id'] ?>',
                                                            tipo_servico_id: '<?= $chamado['tipo_servico_id'] ?>'
                                                        })">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" 
                                                        onclick="excluirSolicitacao('<?= htmlspecialchars($chamado['titulo']) ?>', '<?= $chamado['id'] ?>')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <?php if ($chamado['status'] === 'concluido'): ?>
                                                        <button class="btn btn-sm btn-warning" onclick="abrirModalAvaliacao('<?= addslashes($chamado['titulo']) ?>', '<?= $chamado['id'] ?>')">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
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

