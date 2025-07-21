document.addEventListener('DOMContentLoaded', function () {
    $('#minhasSolicitacoes').DataTable();

    const formAvaliacao = document.getElementById('formAvaliacao');

    if (formAvaliacao) {
        formAvaliacao.addEventListener('submit', function (e) {
            e.preventDefault();

            const titulo = document.getElementById('tituloChamadoAvaliado').value;
            const nota = document.getElementById('nota').value;
            const comentario = document.getElementById('comentario').value;

            console.log('Enviando avaliação:', { titulo, nota, comentario });

            const formData = new FormData(this);

            fetch(baseUrl + '/avaliacoes/salvar', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) throw new Error('Erro na requisição');
                return res.json();
            })
            .then(data => {
                if (data.status === 'ok') {
                    // Fecha a modal (caso use Bootstrap 5)
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAvaliacao'));
                    modal.hide();

                    // Recarrega a página para atualizar status "Avaliado"
                    location.reload();
                } else {
                    alert(data.erro || 'Erro ao salvar avaliação.');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar avaliação:', error);
                alert('Erro ao salvar avaliação!');
            });
        });
    }
});

// Função para abrir o modal de avaliação
function abrirModalAvaliacao(titulo, solicitacaoId) {
    document.getElementById('tituloChamadoAvaliado').value = titulo;
    document.getElementById('solicitacaoIdAvaliado').value = solicitacaoId;
    document.getElementById('tituloChamadoExibido').value = titulo;
    document.getElementById('comentario').value = '';
    document.getElementById('nota').value = '5';

    const modal = new bootstrap.Modal(document.getElementById('modalAvaliacao'));
    modal.show();
}

// Função para abrir o modal de edição de solicitação
function editarSolicitacao(chamado) {
    document.getElementById('editChamadoId').value = chamado.id;
    document.getElementById('editTitulo').value = chamado.titulo;
    document.getElementById('editDescricao').value = chamado.descricao || '';
    document.getElementById('editPrioridade').value = chamado.prioridade;
    document.getElementById('editStatus').value = chamado.status;
    document.getElementById('editSetor').value = chamado.setor_id;
    document.getElementById('editUsuarioId').value = chamado.usuario_id;
    document.getElementById('editTipoServico').value = chamado.tipo_servico_id;

    const modal = new bootstrap.Modal(document.getElementById('modalEdicao'));
    modal.show();
}

// Função para abrir o modal de exclusão
function excluirSolicitacao(titulo, id) {
    document.getElementById('excluirChamadoId').value = id;
    document.getElementById('excluirChamadoTitulo').innerText = titulo;
    const modalExclusao = new bootstrap.Modal(document.getElementById('modalExclusao'));
    modalExclusao.show();
}
