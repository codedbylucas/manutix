<?php $render('header') ?>

<body class="sb-nav-fixed">
    <div id="layoutAuthentication">
        <?php $render('sideBar'); ?>
        <div id="layoutAuthentication_content">
            <main>
                <div class="container p-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Criar uma conta</h3>
                                </div>
                                <div class="card-body">
                                    <form action="<?= $base ?>./admin/usuarios/novo" method="POST">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" name="nome" type="text" placeholder="Nome" required />
                                                    <label for="inputFirstName">Nome</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" name="sobrenome" type="text" placeholder="Sobrenome" />
                                                    <label for="inputLastName">Sobrenome</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" name="senha" type="password" placeholder="Senha" required />
                                                    <label for="inputPassword">Senha</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" name="confirmar_senha" type="password" placeholder="Confirme a senha" required />
                                                    <label for="inputPasswordConfirm">Confirmar Senha</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" name="tipo" required>
                                                        <option value="">Selecione o tipo</option>
                                                        <option value="funcionario">Funcionário</option>
                                                        <option value="tecnico">Técnico</option>
                                                        <option value="admin">Administrador</option>
                                                    </select>
                                                    <label>Tipo de Usuário</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" name="setor_id" required>
                                                        <option value="">Selecione o setor</option>
                                                        <option value="1">RH</option>
                                                        <option value="2">TI</option>
                                                        <option value="3">FINANCEIRO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" class="btn btn-primary btn-block" value="Criar Conta">
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