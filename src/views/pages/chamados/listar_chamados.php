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
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="minDate">Data Inicial</label>
                                    <input type="date" id="minDate" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="maxDate">Data Final</label>
                                    <input type="date" id="maxDate" class="form-control">
                                </div>
                            </div>
                            <table id="minhasSolicitacoes" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Título</th>
                                        <th>Tipo de Serviço</th>
                                        <th>Prioridade</th>
                                        <th>Data de Abertura</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($chamados as $chamado): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($chamado['id']) ?></td>
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
                                                    <div class="d-flex gap-1">
                                                        <button class="btn btn-sm btn-primary" 
                                                            onclick="editarSolicitacao({
                                                                id: '<?= $chamado['id'] ?>',
                                                                titulo: '<?= $chamado['titulo'] ?>',
                                                                descricao: '<?= $chamado['descricao'] ?>',
                                                                prioridade: '<?= $chamado['prioridade'] ?>',
                                                                status: '<?= $chamado['status'] ?>',
                                                                setor_id: '<?= $chamado['setor_id'] ?>',
                                                                tipo_servico_id: '<?= $chamado['tipo_servico_id'] ?>',
                                                                usuario_id: '<?= $chamado['usuario_id'] ?>'
                                                            })">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" 
                                                            onclick="excluirSolicitacao('<?= htmlspecialchars($chamado['titulo']) ?>', '<?= $chamado['id'] ?>')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        <?php if ($chamado['status'] === 'concluido'): ?>
                                                            <?php if (!$chamado['avaliada']): ?>
                                                                <button 
                                                                    class="btn btn-sm btn-warning text-dark d-flex align-items-center gap-1 botao-avaliar" 
                                                                    onclick="abrirModalAvaliacao('<?= addslashes($chamado['titulo']) ?>', '<?= $chamado['id'] ?>')"
                                                                    title="Avaliar chamado"
                                                                >
                                                                    <i class="fas fa-star"></i>
                                                                    <span>Avaliar</span>
                                                                </button>
                                                            <?php else: ?>
                                                                <div class="d-flex align-items-center text-muted" title="Já avaliado">
                                                                    <i class="fas fa-star text-success me-1"></i>
                                                                    <small>Avaliado</small>
                                                                </div>
                                                            <?php endif; ?>
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

    <!-- Modal de Avaliação -->
    <div class="modal fade" id="modalAvaliacao" tabindex="-1" aria-labelledby="modalAvaliacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form id="formAvaliacao">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAvaliacaoLabel">Avaliar Chamado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="solicitacao_id" id="solicitacaoIdAvaliado" />
                        <input type="hidden" name="titulo_chamado" id="tituloChamadoAvaliado" />

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" name="nota" id="nota" required>
                                        <option value="5">⭐⭐⭐⭐⭐</option>
                                        <option value="4">⭐⭐⭐⭐</option>
                                        <option value="3">⭐⭐⭐</option>
                                        <option value="2">⭐⭐</option>
                                        <option value="1">⭐</option>
                                    </select>
                                    <label for="nota">Nota da Avaliação</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="tituloChamadoExibido" disabled />
                                    <label for="tituloChamadoExibido">Título do Chamado</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="comentario" id="comentario" style="height: 120px;" required></textarea>
                            <label for="comentario">Comentário</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar Avaliação</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal de Edição -->
    <div class="modal fade" id="modalEdicao" tabindex="-1" aria-labelledby="modalEdicaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form id="formEdicao" action="<?=$base?>/chamados/editar" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEdicaoLabel">Editar Chamado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editChamadoId" />
                        <input type="hidden" name="usuario_id" id="editUsuarioId" />
                        <div class="form-floating mb-3">
                            <input class="form-control" name="titulo" id="editTitulo" type="text" required />
                            <label for="editTitulo">Título</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="descricao" id="editDescricao" style="height: 120px;" required></textarea>
                            <label for="editDescricao">Descrição</label>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" name="prioridade" id="editPrioridade" required>
                                        <option value="baixa">Baixa</option>
                                        <option value="media">Média</option>
                                        <option value="alta">Alta</option>
                                    </select>
                                    <label>Prioridade</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" name="status" id="editStatus">
                                        <option value="novo">Novo</option>
                                        <option value="aguardando">Aguardando</option>
                                        <option value="andamento">Em Andamento</option>
                                        <option value="aguardando_material">Aguardando Material</option>
                                        <option value="concluido">Concluído</option>
                                        <option value="cancelado">Cancelado</option>
                                    </select>
                                    <label>Status</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" name="setor_id" id="editSetor" required>
                                        <?php foreach ($setores as $setor): ?>
                                            <option value="<?= $setor['id'] ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Setor</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" name="tipo_servico_id" id="editTipoServico" required>
                                        <?php foreach ($tiposServico as $tipo): ?>
                                            <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nome']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Tipo de Serviço</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="modalExclusao" tabindex="-1" aria-labelledby="modalExclusaoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form id="formExclusao" action="<?=$base?>/chamados/excluir" method="POST">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalExclusaoLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="excluirChamadoId">
                        <p>Tem certeza que deseja excluir o chamado <strong id="excluirChamadoTitulo"></strong>?</p>
                        <p class="text-danger mb-0">Essa ação não poderá ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Sim, excluir</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    const baseUrl = "<?=$base?>";
</script>
<script src="<?=$base?>/assets/js/listar_chamados.js"></script>
