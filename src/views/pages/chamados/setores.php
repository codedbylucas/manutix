        <?php $render('header'); ?>

        <body class="sb-nav-fixed">
            <div id="layoutSidenav">
                <?php $render('sideBar'); ?>
                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                            <div>
                                <h1 class="mt-4">Chamados</h1>
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
                        <form action="cadastrar_setor.php" method="POST">
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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const setores = [{
                            nome: 'Financeiro'
                        },
                        {
                            nome: 'TI'
                        },
                        {
                            nome: 'RH'
                        },
                    ];

                    $('#tabelaSetores').DataTable({
                        data: setores,
                        columns: [{
                                data: 'nome'
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `
                                <button class="btn btn-sm btn-primary me-1" onclick="editarSetor('${row.nome}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="excluirSetor('${row.nome}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            `;
                                },
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });
                });

                function editarSetor(nome) {
                    alert('Editar setor: ' + nome);
                }

                function excluirSetor(nome) {
                    if (confirm(`Deseja excluir o setor "${nome}"?`)) {
                        alert('Setor excluído: ' + nome);
                    }
                }
            </script>