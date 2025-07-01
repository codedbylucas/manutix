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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const solicitacoes = [{
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
                    columns: [{
                            data: 'status'
                        },
                        {
                            data: 'titulo'
                        },
                        {
                            data: 'tipo'
                        },
                        {
                            data: 'prioridade'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                <button class="btn btn-sm btn-primary me-1" onclick="editarSolicitacao('${row.titulo}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="excluirSolicitacao('${row.titulo}')">
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
        </script>