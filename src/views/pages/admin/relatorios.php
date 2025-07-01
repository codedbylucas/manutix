<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 p-5">
                <div class="card mb-4 shadow">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Relatórios de Chamados
                    </div>
                    <div class="card-body">

                        <!-- Filtros -->
                        <form id="formFiltros" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="dataInicio" class="form-label">Data Início</label>
                                <input type="date" class="form-control" id="dataInicio" name="dataInicio">
                            </div>
                            <div class="col-md-3">
                                <label for="dataFim" class="form-label">Data Fim</label>
                                <input type="date" class="form-control" id="dataFim" name="dataFim">
                            </div>
                            <div class="col-md-2">
                                <label for="tipoServico" class="form-label">Tipo</label>
                                <select class="form-select" id="tipoServico">
                                    <option value="">Todos</option>
                                    <option>Elétrica</option>
                                    <option>Mecânica</option>
                                    <option>Hidráulica</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="setor" class="form-label">Setor</label>
                                <select class="form-select" id="setor">
                                    <option value="">Todos</option>
                                    <option>Administração</option>
                                    <option>Produção</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="tecnico" class="form-label">Técnico</label>
                                <select class="form-select" id="tecnico">
                                    <option value="">Todos</option>
                                    <option>João</option>
                                    <option>Maria</option>
                                </select>
                            </div>
                        </form>

                        <!-- Botões -->
                        <div class="mb-4">
                            <button class="btn btn-primary me-2" onclick="aplicarFiltros()">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                            <button class="btn btn-danger me-2" onclick="exportarPDF()">
                                <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                            </button>
                            <button class="btn btn-success" onclick="exportarExcel()">
                                <i class="fas fa-file-excel me-1"></i> Exportar Excel
                            </button>
                        </div>

                        <!-- Gráficos -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-header text-center">Chamados por Tipo</div>
                                    <div class="card-body">
                                        <canvas id="graficoTipos"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-header text-center">Chamados por Status</div>
                                    <div class="card-body">
                                        <canvas id="graficoStatus"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabela -->
                        <div class="table-responsive">
                            <table id="tabelaRelatorio" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Setor</th>
                                        <th>Técnico</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    const dadosChamados = [
        {
            data: '2025-06-20',
            titulo: 'Trocar luminária',
            tipo: 'Elétrica',
            setor: 'Produção',
            tecnico: 'João',
            status: 'Concluído'
        },
        {
            data: '2025-06-21',
            titulo: 'Consertar torneira',
            tipo: 'Hidráulica',
            setor: 'Administração',
            tecnico: 'Maria',
            status: 'Em andamento'
        }
    ];

    let tabela;

    document.addEventListener('DOMContentLoaded', () => {
        tabela = $('#tabelaRelatorio').DataTable({
            data: dadosChamados,
            columns: [
                { data: 'data' },
                { data: 'titulo' },
                { data: 'tipo' },
                { data: 'setor' },
                { data: 'tecnico' },
                { data: 'status' }
            ]
        });

        renderizarGraficos(dadosChamados);
    });

    function aplicarFiltros() {
        const tipo = document.getElementById('tipoServico').value;
        const setor = document.getElementById('setor').value;
        const tecnico = document.getElementById('tecnico').value;

        const filtrado = dadosChamados.filter(item => {
            return (!tipo || item.tipo === tipo) &&
                (!setor || item.setor === setor) &&
                (!tecnico || item.tecnico === tecnico);
        });

        tabela.clear().rows.add(filtrado).draw();
        renderizarGraficos(filtrado);
    }

    function renderizarGraficos(data) {
        const porTipo = {};
        const porStatus = {};

        data.forEach(item => {
            porTipo[item.tipo] = (porTipo[item.tipo] || 0) + 1;
            porStatus[item.status] = (porStatus[item.status] || 0) + 1;
        });

        // Gráfico de Tipos
        new Chart(document.getElementById('graficoTipos'), {
            type: 'pie',
            data: {
                labels: Object.keys(porTipo),
                datasets: [{ data: Object.values(porTipo), backgroundColor: ['#007bff', '#28a745', '#ffc107'] }]
            }
        });

        // Gráfico de Status
        new Chart(document.getElementById('graficoStatus'), {
            type: 'bar',
            data: {
                labels: Object.keys(porStatus),
                datasets: [{ label: 'Status', data: Object.values(porStatus), backgroundColor: '#6c757d' }]
            }
        });
    }

    function exportarPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Relatório de Chamados", 10, 10);
        doc.save("relatorio.pdf");
    }

    function exportarExcel() {
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.json_to_sheet(dadosChamados);
        XLSX.utils.book_append_sheet(wb, ws, "Relatório");
        XLSX.writeFile(wb, "relatorio.xlsx");
    }
    
</script>