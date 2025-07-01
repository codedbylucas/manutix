<!-- Filtro + Lista de Chamados Técnicos -->
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 p-5">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-tools me-1"></i> Chamados Atribuídos
                        </div>
                        <div class="d-flex gap-2">
                            <select id="filtroStatus" class="form-select">
                                <option value="">Todos os Status</option>
                                <option value="Em andamento">Em andamento</option>
                                <option value="Aguardando">Aguardando</option>
                                <option value="Concluído">Concluído</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="chamadosTecnico" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Título</th>
                                    <th>Tipo</th>
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
    const chamadosTecnico = [
        {
            status: 'Em andamento',
            titulo: 'Trocar luminária',
            tipo: 'Elétrica',
            prioridade: 'Alta'
        },
        {
            status: 'Aguardando',
            titulo: 'Revisar ar-condicionado',
            tipo: 'Climatização',
            prioridade: 'Média'
        },
        {
            status: 'Concluído',
            titulo: 'Conserto do portão',
            tipo: 'Mecânica',
            prioridade: 'Baixa'
        }
    ];

    let tabela;

    document.addEventListener('DOMContentLoaded', function () {
        tabela = $('#chamadosTecnico').DataTable({
            data: chamadosTecnico,
            columns: [
                {
                    data: 'status',
                    render: status => {
                        const badgeClass = {
                            'Em andamento': 'bg-warning text-dark',
                            'Aguardando': 'bg-secondary',
                            'Concluído': 'bg-success'
                        }[status] || 'bg-light';
                        return `<span class="badge ${badgeClass}">${status}</span>`;
                    }
                },
                { data: 'titulo' },
                { data: 'tipo' },
                { data: 'prioridade' },
                {
                    data: null,
                    render: function (row) {
                        return `
                            <button class="btn btn-sm btn-info me-1" onclick="atualizarStatus('${row.titulo}')">
                                <i class="fas fa-sync-alt"></i> Atualizar
                            </button>
                            <button class="btn btn-sm btn-success" onclick="concluirChamado('${row.titulo}')">
                                <i class="fas fa-check-circle"></i> Concluir
                            </button>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });

        document.getElementById('filtroStatus').addEventListener('change', function () {
            const statusSelecionado = this.value;
            tabela.clear().rows.add(
                statusSelecionado
                    ? chamadosTecnico.filter(ch => ch.status === statusSelecionado)
                    : chamadosTecnico
            ).draw();
        });
    });

    function atualizarStatus(titulo) {
        alert('Atualizar chamado: ' + titulo);
        // lógica de atualização aqui (ex: abrir modal ou fetch)
    }

    function concluirChamado(titulo) {
        if (confirm(`Deseja concluir o chamado "${titulo}"?`)) {
            const chamado = chamadosTecnico.find(c => c.titulo === titulo);
            if (chamado) {
                chamado.status = 'Concluído';
                tabela.clear().rows.add(chamadosTecnico).draw();
                alert('Chamado concluído!');
            }
        }
    }
</script>
