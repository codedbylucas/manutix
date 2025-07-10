<?= $render('header') ?>

<body class="sb-nav-fixed">
    <div id="layoutAuthentication">
        <?= $render('sideBar'); ?>
        <div id="layoutAuthentication_content">
            <main>
                <div class="container p-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Editar usuario</h3>
                                </div>
                                <div class="card-body">
                                    <form action="<?= $base ?>./admin/usuarios/atualizar" method="POST">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($usuarios['id'] ?? '') ?>">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="nome" type="text" placeholder="Nome" required value="<?= $usuarios['nome'] ?>" />
                                                    <label for="inputFirstName">Nome</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" name="sobrenome" type="text" placeholder="Sobrenome" value="<?= $usuarios['sobrenome'] ?>" />
                                                    <label for="inputLastName">Sobrenome</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="email" type="email" placeholder="name@example.com" required value="<?= $usuarios['email'] ?>" />
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" name="senha" type="password" placeholder="Nova senha (deixe em branco para manter)" />
                                                    <label for="inputPassword">Senha</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="confirmar_senha" type="password" placeholder="Nova senha (deixe em branco para manter)" />
                                                    <label for="inputPasswordConfirm">Confirmar Senha</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" name="tipo" required>
                                                        <option value="">Selecione o tipo</option>
                                                        <option value="funcionario" <?= ($usuarios['tipo'] === 'funcionario' ? 'selected' : ''); ?>>Funcionário</option>
                                                        <option value="tecnico" <?= ($usuarios['tipo'] === 'tecnico' ? 'selected' : ''); ?>>Técnico</option>
                                                        <option value="admin" <?= ($usuarios['tipo'] === 'admin' ? 'selected' : ''); ?>>Administrador</option>
                                                    </select>
                                                    <label>Tipo de Usuário</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" name="setor_id" required>
                                                        <option value="">Selecione o setor</option>
                                                        <option value="1" <?= ($usuarios['setor_id'] === 1 ? 'selected' : ''); ?>>RH</option>
                                                        <option value="2" <?= ($usuarios['setor_id'] === 2 ? 'selected' : ''); ?>>TI</option>
                                                        <option value="3" <?= ($usuarios['setor_id'] === 3 ? 'selected' : ''); ?>>FINANCEIRO</option>
                                                    </select>
                                                    <label>Setor</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" class="btn btn-primary btn-block" value="Salvar Alterações">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php $render('footer'); ?>