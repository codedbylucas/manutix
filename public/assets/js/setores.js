    document.addEventListener('DOMContentLoaded', function () {
            fetch(baseUrl + '/admin/setores/listar')
                .then(response => response.json())
                .then(setores => {
                    $('#tabelaSetores').DataTable({
                        data: setores,
                        columns: [
                            { data: 'nome' },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `
                                        <button class="btn btn-sm btn-primary me-1" onclick="editarSetor('${row.nome}', '${row.id}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="excluirSetor('${row.nome}', '${row.id}')">
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

        function excluirSetor(nome, id) {
            document.getElementById('excluirIdSetor').value = id;
            document.getElementById('excluirNomeSetor').innerText = nome;
            const modal = new bootstrap.Modal(document.getElementById('modalExcluirSetor'));
            modal.show();
        }

        function confirmarExclusaoSetor() {
            const id = document.getElementById('excluirIdSetor').value;

            fetch(baseUrl + '/admin/setores/excluir', {
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
                    location.reload(); // Ou atualizar a tabela
                } else {
                    alert(data.mensagem);
                }
            })
            .catch(error => {
                console.error('Erro na exclusão:', error);
                alert('Erro ao excluir o setor.');
            });
        }


        function editarSetor(nome, id) {
            document.getElementById('editarIdSetor').value = id;
            document.getElementById('editarNomeSetor').value = nome;
            const modal = new bootstrap.Modal(document.getElementById('modalEditarSetor'));
            modal.show();
        }
