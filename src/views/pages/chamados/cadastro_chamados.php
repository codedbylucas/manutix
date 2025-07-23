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
                            <form id="formSolicitacao" action="<?=$base?>/chamados/novo" method="POST" enctype="multipart/form-data">
                                
                                <fieldset class="border p-3 mb-4">
                                    <legend class="w-auto px-2">Informações da Solicitação</legend>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="titulo" type="text" placeholder="Título da solicitação" />
                                        <label for="titulo">Título <span class="text-danger">*</span></label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="descricao" placeholder="Descreva a solicitação" style="height: 120px; resize: none;"></textarea>
                                        <label for="descricao">Descrição <span class="text-danger">*</span></label>
                                    </div>
                                </fieldset>

                                <fieldset class="border p-3 mb-4">
                                    <legend class="w-auto px-2">Detalhes Técnicos</legend>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="prioridade" >
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
                                                <select class="form-select" name="tipo_servico_id">
                                                    <option value="">Selecione o Tipo de Serviço</option>
                                                    <?php foreach ($tiposServico as $tipo): ?>
                                                        <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nome']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label>Tipo de Serviço <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <select class="form-select" name="setor_id" >
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
    <?php if (!empty($_SESSION['sucesso_cadastro'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '<?= $_SESSION['sucesso_cadastro'] ?>',
                confirmButtonColor: '#28a745'
            });
        </script>
        <?php unset($_SESSION['sucesso_cadastro']); // limpa a sessão para não mostrar de novo ?>
    <?php endif; ?>
</body>

<script>
    const baseUrl = "<?=$base?>";
</script>
<script src="<?=$base?>/assets/js/cadastro_chamados.js"></script>
