<?php

namespace src\controllers\chamados;

use src\models\Usuario;
use src\models\Chamado;
use \core\Controller;

class ChamadosController extends Controller
{
    public function __construct()
    {
        $this->protegerAcesso(['funcionario', 'admin']);
    }

    private function protegerAcesso(array $tiposPermitidos)
    {
        if (
            !isset($_SESSION['usuario_id']) ||
            !isset($_SESSION['usuario_tipo']) ||
            !in_array($_SESSION['usuario_tipo'], $tiposPermitidos)
        ) {
            $this->redirect('/login');
            exit;
        }
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            $prioridade = $_POST['prioridade'] ?? '';
            $status = $_POST['status'] ?? 'novo';
            $setor_id = $_POST['setor_id'] ?? '';
            $tipo_servico_id = $_POST['tipo_servico_id'] ?? '';
            $usuario_id = $_SESSION['usuario_id'] ?? '';
            $tecnico_id = !empty($_POST['tecnico_id']) ? $_POST['tecnico_id'] : null;

            $anexo = null;
            if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['anexo']['tmp_name'];
                $nome_original = $_FILES['anexo']['name'];
                $nome_arquivo = uniqid() . '-' . basename($nome_original);

                $destino = __DIR__ . '/../../public/uploads/' . $nome_arquivo;

                if (move_uploaded_file($tmp_name, $destino)) {
                    $anexo = $nome_arquivo;
                }
            }

            $dadosChamado = [
                'titulo' => $titulo,
                'descricao' => $descricao,
                'prioridade' => $prioridade,
                'status' => $status,
                'setor_id' => $setor_id,
                'tipo_servico_id' => $tipo_servico_id,
                'usuario_id' => $usuario_id,
                'tecnico_id' => $tecnico_id,
                'anexo' => $anexo
            ];

            $salvo = Chamado::criar($dadosChamado);

            if ($salvo) {
                $this->render('chamados/cadastro_chamados');
                exit;
            } else {
                echo "Erro ao cadastrar o chamado.";
            }
        } else {
            echo "Método inválido.";
        }
    }

    public function listar()
    {
        $usuarioId = $_SESSION['usuario_id'];
        $chamados = \src\models\Chamado::listarPorUsuario($usuarioId);
        $setores = \src\models\Setor::select(['id', 'nome'])->orderBy('nome')->get();

        $this->render('chamados/listar_chamados', [
            'chamados' => $chamados,
            'setores' => $setores
        ]);
    }

    public function novo() {
        $setores = \src\models\Setor::select(['id', 'nome'])->orderBy('nome')->get();
        $usuarios = \src\models\Usuario::select(['id', 'nome'])->orderBy('nome')->get();

        $this->render('chamados/cadastro_chamados', [
            'setores' => $setores,
            'usuarios' => $usuarios
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

                $this->redirect('/chamados');
            } else {
                echo "Chamado não encontrado.";
            }
        } else {
            echo "Dados inválidos.";
        }
    }


    public function excluir()
    {
        $id = filter_input(INPUT_POST, 'id');

        if ($id) {
            // Buscar o chamado para verificar o tecnico_id
            $chamado = \src\models\Chamado::select()->where('id', $id)->one();

            // Só excluir se tecnico_id for NULL
            if ($chamado && $chamado['tecnico_id'] === null) {
                \src\models\Chamado::delete()->where('id', $id)->execute();
            }
        }

        $usuarioId = $_SESSION['usuario_id'];
        $chamados = \src\models\Chamado::listarPorUsuario($usuarioId);
        $setores = \src\models\Setor::select(['id', 'nome'])->orderBy('nome')->get();

        $this->render('chamados/listar_chamados', [
            'chamados' => $chamados,
            'setores' => $setores
        ]);
    }

}
