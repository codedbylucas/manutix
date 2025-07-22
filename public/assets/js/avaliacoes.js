document.addEventListener('DOMContentLoaded', function () {
    const tabela = $('#tabelaAvaliacoes').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        initComplete: function () {
            // Criação do filtro de notas
            const filtroHtml = `
                <label style="margin-left: 10px;">
                    Filtrar por Nota:
                    <select id="filtroNota" class="form-select form-select-sm"
                        style="width: auto; display: inline-block; margin-left: 5px;">
                        <option value="">Todas</option>
                        <option value="⭐">⭐</option>
                        <option value="⭐⭐">⭐⭐</option>
                        <option value="⭐⭐⭐">⭐⭐⭐</option>
                        <option value="⭐⭐⭐⭐">⭐⭐⭐⭐</option>
                        <option value="⭐⭐⭐⭐⭐">⭐⭐⭐⭐⭐</option>
                    </select>
                </label>`;

            // Adiciona o filtro ao lado do campo de busca
            $('#tabelaAvaliacoes_filter').append(filtroHtml);

            // Evento de filtro por nota
            $('#filtroNota').on('change', function () {
                const valor = $(this).val().length; // Conta quantas estrelas foram escolhidas (1 a 5)
                if (valor === 0) {
                    tabela.column(2).search('').draw(); // Sem filtro
                } else {
                    tabela.rows().every(function () {
                        const nota = $(this.node()).find('td').eq(2).data('nota');
                        if (nota == valor) {
                            $(this.node()).show();
                        } else {
                            $(this.node()).hide();
                        }
                    });
                }
            });
        }
    });
});
