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
                            <h4>Chamados Atribuidos</h4>
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
                                                    <button class="btn btn-sm btn-success" onclick="abrirModalFinalizacao('<?= $chamado['id'] ?>', '<?= addslashes($chamado['titulo']) ?>')">
                                                        <i class="fas fa-check"></i> Finalizar
                                                    </button>
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
                                    <select class="form-control" name="status" id="editStatus" required>
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
                                        <option value="1">Manutenção</option>
                                        <option value="2">Suporte Técnico</option>
                                        <option value="3">Infraestrutura</option>
                                    </select>
                                    <label>Tipo de Serviço</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" type="file" name="anexo" />
                            <label for="anexo">Anexo (opcional)</label>
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
    <!-- Modal de Finalização -->
    <div class="modal fade" id="modalFinalizacao" tabindex="-1" aria-labelledby="modalFinalizacaoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form action="<?=$base?>/chamados/finalizar" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFinalizacaoLabel">Finalizar Chamado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="finalizarChamadoId">
                        <p>Deseja finalizar o chamado: <strong id="finalizarChamadoTitulo"></strong>?</p>
                        <div class="form-floating">
                            <select class="form-control" name="motivo_finalizacao" required>
                                <option value="">Selecione o motivo</option>
                                <option value="resolvido">Resolvido</option>
                                <option value="encaminhado_errado">Encaminhado Errado</option>
                                <option value="falta_de_informacao">Falta de Informação</option>
                            </select>
                            <label>Motivo da Finalização</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Finalizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const baseUrl = "<?=$base?>";
    </script>
    <script src="<?=$base?>/assets/js/chamados_atribuidos.js"></script>

