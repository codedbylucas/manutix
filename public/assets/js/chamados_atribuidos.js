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
                alert('Avaliação salva com sucesso!');
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalAvaliacao'));
                modal.hide();
                this.reset();
            })
            .catch(error => {
                console.error('Erro ao salvar avaliação:', error);
                alert('Erro ao salvar avaliação!');
            });
        });
    }
});

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

function abrirModalFinalizacao(id, titulo) {
    document.getElementById('finalizarChamadoId').value = id;
    document.getElementById('finalizarChamadoTitulo').innerText = titulo;
    new bootstrap.Modal(document.getElementById('modalFinalizacao')).show();
}