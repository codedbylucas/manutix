        <?php $render('header'); ?>
        <body class="sb-nav-fixed">
            <div id="layoutSidenav">
                <?php $render('sideBar'); ?>
                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                            <div>
                                <h1 class="mt-4">Usuários</h1>
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item active">Setores</li>
                                </ol>
                                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalCadastrarSetor">
                                    + Cadastrar Novo Setor
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="tabelaSetores" class="table">
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
            <!-- Modal Cadastrar-->
            <div class="modal fade" id="modalCadastrarSetor" tabindex="-1" aria-labelledby="modalCadastrarSetorLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?=$base?>./admin/setores/novo" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCadastrarSetorLabel">Cadastrar Novo Setor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="nome" id="nomeSetor" placeholder="Nome do Setor" required>
                                    <label for="nomeSetor">Nome do Setor</label>
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
            <!-- Modal Editar Setor -->
            <div class="modal fade" id="modalEditarSetor" tabindex="-1" aria-labelledby="modalEditarSetorLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content shadow-lg border-0 rounded-lg">
                        <form id="formEditarSetor" method="POST" action="<?=$base?>/admin/setores/editar">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditarSetorLabel">Editar Setor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="editarIdSetor" />
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="text" name="nome" id="editarNomeSetor" required />
                                    <label for="editarNomeSetor">Nome do Setor</label>
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
            <!-- Modal Excluir Setor -->
            <div class="modal fade" id="modalExcluirSetor" tabindex="-1" aria-labelledby="modalExcluirSetorLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content shadow-lg border-0 rounded-lg">
                        <form id="formExcluirSetor" method="POST" action="<?=$base?>/admin/setores/excluir">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalExcluirSetorLabel">Excluir Setor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="excluirIdSetor" />
                                <p>Tem certeza que deseja excluir o setor <strong id="excluirNomeSetor"></strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Excluir</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    const baseUrl = "<?=$base?>";
                </script>
                <script src="<?=$base?>/assets/js/setores.js"></script>
            </div>