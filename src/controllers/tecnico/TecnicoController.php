<?php

namespace src\controllers\tecnico;

use \core\Controller;
use src\models\Chamado;

class TecnicoController extends Controller
{

    public function __construct()
    {
        $this->protegerAcesso(['admin', 'tecnico']);
    }

    private function protegerAcesso(array $tipoNecessario)
    {
        if (
            !isset($_SESSION['usuario_id']) ||
            !isset($_SESSION['usuario_tipo']) ||
            !in_array($_SESSION['usuario_tipo'], $tipoNecessario)
        ) {
            $this->redirect('/login');
            exit;
        }
    }

    public function listar()
    {
        $usuarioId = $_SESSION['usuario_id'];
        $chamados = \src\models\Chamado::listarPorTecnico($usuarioId);
        $setores = \src\models\Setor::select(['id', 'nome'])->orderBy('nome')->get();

        $this->render('tecnico/chamados_atribuidos', [
            'chamados' => $chamados,
            'setores' => $setores
        ]);
    }

    public function editar()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $titulo = filter_input(INPUT_POST, 'titulo');
        $descricao = filter_input(INPUT_POST, 'descricao');
        $prioridade = filter_input(INPUT_POST, 'prioridade');
        $status = filter_input(INPUT_POST, 'status');
        $setor_id = filter_input(INPUT_POST, 'setor_id', FILTER_VALIDATE_INT);
        $tipo_servico_id = filter_input(INPUT_POST, 'tipo_servico_id', FILTER_VALIDATE_INT);

        if ($id && $titulo && $descricao && $prioridade && $status && $setor_id && $tipo_servico_id) {
            $chamado = Chamado::select()->where('id', $id)->one();

            if ($chamado) {
                $usuario_id = $chamado['usuario_id']; // ← Pegando do banco

                // Verifica se foi enviado um novo anexo
                if (!empty($_FILES['anexo']['name'])) {
                    $anexo = $_FILES['anexo'];
                    $nomeArquivo = uniqid() . '_' . $anexo['name'];
                    $caminhoDestino = 'uploads/chamados/' . $nomeArquivo;

                    if (move_uploaded_file($anexo['tmp_name'], $caminhoDestino)) {
                        Chamado::update()
                            ->set([
                                'titulo' => $titulo,
                                'descricao' => $descricao,
                                'prioridade' => $prioridade,
                                'status' => $status,
                                'setor_id' => $setor_id,
                                'tipo_servico_id' => $tipo_servico_id,
                                'usuario_id' => $usuario_id,
                                'anexo' => $nomeArquivo
                            ])
                            ->where('id', $id)
                            ->execute();
                    } else {
                        echo "Erro ao fazer upload do anexo.";
                        return;
                    }
                } else {
                    // Atualiza sem alterar o anexo
                    Chamado::update()
                        ->set([
                            'titulo' => $titulo,
                            'descricao' => $descricao,
                            'prioridade' => $prioridade,
                            'status' => $status,
                            'setor_id' => $setor_id,
                            'tipo_servico_id' => $tipo_servico_id,
                            'usuario_id' => $usuario_id
                        ])
                        ->where('id', $id)
                        ->execute();
                }

                $this->redirect('/tecnico/chamados');
            } else {
                echo "Chamado não encontrado.";
            }
        } else {
            echo "Dados inválidos.";
        }
    }
}
