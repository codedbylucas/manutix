    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
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
                    { data: 'prioridade' }
                ]
            });
        });
    </script>
