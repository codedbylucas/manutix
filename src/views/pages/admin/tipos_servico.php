<?php $render('header'); ?>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div>
                        <h1 class="mt-4">Gestão</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Tipos de Serviço</li>
                        </ol>
                        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalCadastrarTipoServico">
                            + Cadastrar Novo Tipo
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="tabelaTiposServico" class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Cadastrar -->
    <div class="modal fade" id="modalCadastrarTipoServico" tabindex="-1" aria-labelledby="modalCadastrarTipoServicoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?=$base?>/admin/tipos_servico/novo" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCadastrarTipoServicoLabel">Cadastrar Novo Tipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nome" id="nomeTipoServico" placeholder="Nome do Tipo de Serviço" required>
                            <label for="nomeTipoServico">Nome do Tipo de Serviço</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditarTipoServico" tabindex="-1" aria-labelledby="modalEditarTipoServicoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form id="formEditarTipoServico" method="POST" action="<?=$base?>/admin/tipos_servico/editar">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarTipoServicoLabel">Editar Tipo de Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editarIdTipoServico" />
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="nome" id="editarNomeTipoServico" required />
                            <label for="editarNomeTipoServico">Nome do Tipo de Serviço</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="modalExcluirTipoServico" tabindex="-1" aria-labelledby="modalExcluirTipoServicoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form id="formExcluirTipoServico" method="POST" action="<?=$base?>/admin/tipos_servico/excluir">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalExcluirTipoServicoLabel">Excluir Tipo de Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="excluirIdTipoServico" />
                        <p>Tem certeza que deseja excluir o tipo de serviço <strong id="excluirNomeTipoServico"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="confirmarExclusaoTipoServico()">Excluir</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = "<?=$base?>";
    </script>
    <script src="<?=$base?>/assets/js/tipos_servico.js"></script>
