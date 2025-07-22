document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formSolicitacao");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // impede o envio até a validação passar

        const titulo = form.titulo.value.trim();
        const descricao = form.descricao.value.trim();
        const prioridade = form.prioridade.value;
        const tipoServico = form.tipo_servico_id.value;
        const setor = form.setor_id.value;

        if (!titulo || !descricao || !prioridade || !tipoServico || !setor) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos obrigatórios',
                text: 'Por favor, preencha todos os campos marcados com *',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Se passou na validação
        Swal.fire({
            title: 'Confirmar envio?',
            text: "Deseja realmente cadastrar essa solicitação?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, cadastrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // envia o formulário
            }
        });
    });
});
