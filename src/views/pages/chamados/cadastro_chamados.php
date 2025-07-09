<?php $render('header'); ?>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Nova Solicitação</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Cadastro de Chamado</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="<?=$base?>/chamados/novo" method="POST" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="titulo" type="text" placeholder="Título da solicitação" required />
                                    <label for="titulo">Título</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="descricao" placeholder="Descreva a solicitação" style="height: 120px" required></textarea>
                                    <label for="descricao">Descrição</label>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-control" name="prioridade" required>
                                                <option value="">Selecione</option>
                                                <option value="baixa">Baixa</option>
                                                <option value="media">Média</option>
                                                <option value="alta">Alta</option>
                                            </select>
                                            <label>Prioridade</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-control" name="status" required>
                                                <option value="">Selecione</option>
                                                <option value="novo">Novo</option>
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
                                            <select class="form-control" name="setor_id" required>
                                                <option value="">Selecione o Setor</option>
                                                <?php foreach ($setores as $setor): ?>
                                                    <option value="<?= $setor['id'] ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Setor</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-control" name="tipo_servico_id" required>
                                                <option value="">Selecione o Tipo de Serviço</option>
                                                <option value="1">Manutenção</option>
                                                <option value="2">Suporte Técnico</option>
                                                <option value="3">Infraestrutura</option>
                                            </select>
                                            <label>Tipo de Serviço</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-control" name="usuario_id" required>
                                                <option value="">Selecione o Usuário</option>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nome']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Usuário</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" type="file" name="anexo" />
                                    <label for="anexo">Anexo (opcional)</label>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Cadastrar Solicitação</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            <?php $render('footer'); ?>
        </div>
    </div>