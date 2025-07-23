document.addEventListener('DOMContentLoaded', function () {
    fetch(baseUrl + '/admin/tipos_servico/listar')
        .then(response => response.json())
        .then(tipos => {
            $('#tabelaTiposServico').DataTable({
                data: tipos,
                columns: [
                    { data: 'nome' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-primary me-1" onclick="editarTipoServico('${row.nome}', '${row.id}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="excluirTipoServico('${row.nome}', '${row.id}')">
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
});

function editarTipoServico(nome, id) {
    document.getElementById('editarIdTipoServico').value = id;
    document.getElementById('editarNomeTipoServico').value = nome;
    const modal = new bootstrap.Modal(document.getElementById('modalEditarTipoServico'));
    modal.show();
}

function excluirTipoServico(nome, id) {
    document.getElementById('excluirIdTipoServico').value = id;
    document.getElementById('excluirNomeTipoServico').innerText = nome;
    const modal = new bootstrap.Modal(document.getElementById('modalExcluirTipoServico'));
    modal.show();
}

function confirmarExclusaoTipoServico() {
    const id = document.getElementById('excluirIdTipoServico').value;

    fetch(baseUrl + '/admin/tipos_servico/excluir', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.mensagem);
            location.reload();
        } else {
            alert(data.mensagem);
        }
    })
    .catch(error => {
        console.error('Erro na exclusão:', error);
        alert('Erro ao excluir o tipo de serviço.');
    });
}
