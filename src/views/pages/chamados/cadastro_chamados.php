<?php $render('header'); ?>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><i class="fas fa-plus-circle"></i> Nova Solicitação</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Cadastro de Chamado</li>
                    </ol>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-body p-4">
                            <form action="<?=$base?>/chamados/novo" method="POST" enctype="multipart/form-data">
                                
                                <fieldset class="border p-3 mb-4">
                                    <legend class="w-auto px-2">Informações da Solicitação</legend>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="titulo" type="text" placeholder="Título da solicitação" required />
                                        <label for="titulo">Título <span class="text-danger">*</span></label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="descricao" placeholder="Descreva a solicitação" style="height: 120px; resize: none;" required></textarea>
                                        <label for="descricao">Descrição <span class="text-danger">*</span></label>
                                    </div>
                                </fieldset>

                                <fieldset class="border p-3 mb-4">
                                    <legend class="w-auto px-2">Detalhes Técnicos</legend>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="prioridade" required>
                                                    <option value="">Selecione</option>
                                                    <option value="baixa">Baixa</option>
                                                    <option value="media">Média</option>
                                                    <option value="alta">Alta</option>
                                                </select>
                                                <label>Prioridade <span class="text-danger">*</span></label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="tipo_servico_id" required>
                                                    <option value="">Selecione o Tipo de Serviço</option>
                                                    <option value="1">Manutenção</option>
                                                    <option value="2">Suporte Técnico</option>
                                                    <option value="3">Infraestrutura</option>
                                                </select>
                                                <label>Tipo de Serviço <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="setor_id" required>
                                                    <option value="">Selecione o Setor</option>
                                                    <?php foreach ($setores as $setor): ?>
                                                        <option value="<?= $setor['id'] ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label>Setor <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Caso queira permitir upload futuramente:
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="file" name="anexo" />
                                    <label for="anexo">Anexo (opcional)</label>
                                </div> -->

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fas fa-eraser"></i> Limpar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane"></i> Cadastrar Solicitação
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            <?php $render('footer'); ?>
        </div>
    </div>
</body>
