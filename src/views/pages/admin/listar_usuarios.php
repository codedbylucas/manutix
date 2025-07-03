<?php $render('header') ?>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container p-5">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-users me-1"></i>
                            Lista de Usuários
                        </div>
                        <div class="card-body">
                            <table id="tabelaUsuarios" class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Tipo</th>
                                        <th>Setor</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Modal de Alteração de Senha -->
    <div class="modal fade" id="modalSenha" tabindex="-1" aria-labelledby="modalSenhaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form id="formSenha">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSenhaLabel">Alterar Senha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="emailUsuario" />
                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" id="novaSenha" required />
                            <label for="novaSenha">Nova Senha</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar Senha</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const usuarios = [
            {
                nome: 'Maria Silva',
                email: 'maria.silva@example.com',
                tipo: 'admin',
                setor: 'TI'
            },
            {
                nome: 'João Souza',
                email: 'joao.souza@example.com',
                tipo: 'tecnico',
                setor: 'Manutenção'
            },
            {
                nome: 'Ana Costa',
                email: 'ana.costa@example.com',
                tipo: 'funcionario',
                setor: 'RH'
            }
        ];

        $('#tabelaUsuarios').DataTable({
                data: usuarios,
                columns: [
                    { data: 'nome' },
                    { data: 'email' },
                    { data: 'tipo' },
                    { data: 'setor' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning" onclick="abrirModalSenha('${row.email}')">
                                    <i class="fas fa-key"></i> Alterar Senha
                                </button>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        function abrirModalSenha(email) {
            document.getElementById('emailUsuario').value = email;
            document.getElementById('novaSenha').value = '';
            const modal = new bootstrap.Modal(document.getElementById('modalSenha'));
            modal.show();
        }

        document.getElementById('formSenha').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('emailUsuario').value;
            const novaSenha = document.getElementById('novaSenha').value;

            console.log('Senha atualizada para:', { email, novaSenha });

            alert(`Senha do usuário ${email} alterada com sucesso!`);
            bootstrap.Modal.getInstance(document.getElementById('modalSenha')).hide();
        });

    </script>
</body>
<?php $render('footer'); ?>