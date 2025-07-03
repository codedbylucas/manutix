<?php $render('header'); ?>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <?php $render('sideBar'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 p-5">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Minhas Solicitações
                        </div>
                        <div class="card-body">
                            <table id="minhasSolicitacoes" class="table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Título</th>
                                        <th>Tipo de Serviço</th>
                                        <th>Prioridade</th>
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

    <!-- Modal de Avaliação -->
    <div class="modal fade" id="modalAvaliacao" tabindex="-1" aria-labelledby="modalAvaliacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <form id="formAvaliacao">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAvaliacaoLabel">Avaliar Chamado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="titulo_chamado" id="tituloChamadoAvaliado" />

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" name="nota" id="nota" required>
                                        <option value="5">⭐⭐⭐⭐⭐</option>
                                        <option value="4">⭐⭐⭐⭐</option>
                                        <option value="3">⭐⭐⭐</option>
                                        <option value="2">⭐⭐</option>
                                        <option value="1">⭐</option>
                                    </select>
                                    <label for="nota">Nota da Avaliação</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="tituloChamadoExibido" disabled />
                                    <label for="tituloChamadoExibido">Título do Chamado</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="comentario" id="comentario" style="height: 120px;" required></textarea>
                            <label for="comentario">Comentário</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar Avaliação</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const solicitacoes = [
                {
                    status: '<span class="badge bg-warning text-dark">Em andamento</span>',
                    titulo: 'Soeleta e senarica',
                    tipo: 'Elétrica',
                    prioridade: ''
                },
                {
                    status: '<span class="badge bg-success text-white">Concluída</span>',
                    titulo: 'Mínimo solicitação',
                    tipo: 'Manutenção',
                    prioridade: '★★★'
                },
                {
                    status: '<span class="badge bg-secondary text-white">Aguardando análise</span>',
                    titulo: 'Aguardando análise',
                    tipo: 'Loja',
                    prioridade: ''
                }
            ];

            $('#minhasSolicitacoes').DataTable({
                data: solicitacoes,
                columns: [
                    { data: 'status' },
                    { data: 'titulo' },
                    { data: 'tipo' },
                    { data: 'prioridade' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-primary me-1" onclick="editarSolicitacao('${row.titulo}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger me-1" onclick="excluirSolicitacao('${row.titulo}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="abrirModalAvaliacao('${row.titulo}')">
                                    <i class="fas fa-star"></i>
                                </button>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        function editarSolicitacao(titulo) {
            alert('Editar: ' + titulo);
            // redirecionar ou abrir modal
        }

        function excluirSolicitacao(titulo) {
            if (confirm(`Deseja excluir a solicitação "${titulo}"?`)) {
                alert('Excluída: ' + titulo);
                // lógica de exclusão aqui
            }
        }

        function abrirModalAvaliacao(titulo) {
            document.getElementById('tituloChamadoAvaliado').value = titulo;
            document.getElementById('tituloChamadoExibido').value = titulo;
            document.getElementById('comentario').value = '';
            document.getElementById('nota').value = '5';
            const modal = new bootstrap.Modal(document.getElementById('modalAvaliacao'));
            modal.show();
        }

        document.getElementById('formAvaliacao').addEventListener('submit', function (e) {
            e.preventDefault();
            const titulo = document.getElementById('tituloChamadoAvaliado').value;
            const nota = document.getElementById('nota').value;
            const comentario = document.getElementById('comentario').value;

            // Aqui você pode substituir por chamada AJAX ou fetch para salvar
            console.log('Avaliação salva:', { titulo, nota, comentario });

            alert('Avaliação enviada com sucesso!');
            bootstrap.Modal.getInstance(document.getElementById('modalAvaliacao')).hide();
        });
    </script>
