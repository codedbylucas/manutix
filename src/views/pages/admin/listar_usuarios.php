<?php $render('header') ?>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container p-3">
                    <div>
                        <h1 class="mt-4">Usuários</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Listar Usuários</li>
                        </ol>
                    </div>
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
                                <tbody>
                                    <?php if (!empty($usuarios)): ?>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                                <td><?= htmlspecialchars($usuario['tipo']) ?></td>
                                                <td><?= htmlspecialchars($usuario['setor'] ?? 'Sem setor') ?></td>
                                                <td>
                                                    <!-- Coloque aqui botões de editar, excluir, etc -->
                                                    <a href="<?= $base ?>/admin/usuarios/editar<?= $usuario['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                                    <a href="<?= $base ?>/admin/usuarios/excluir/<?= $usuario['id'] ?>" class="btn btn-sm btn-danger">Excluir</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
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
</body>
<?php $render('footer'); ?>