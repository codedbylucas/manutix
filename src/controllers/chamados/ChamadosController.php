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

    public function index()
    {
        $this->render('chamados/cadastro_chamados');
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
            $usuario_id = $_POST['usuario_id'] ?? '';
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
        // Receber dados do formulário
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
        $prioridade = filter_input(INPUT_POST, 'prioridade', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
        $setor_id = filter_input(INPUT_POST, 'setor_id', FILTER_VALIDATE_INT);
        $tipo_servico_id = filter_input(INPUT_POST, 'tipo_servico_id', FILTER_VALIDATE_INT);
        $usuario_id = filter_input(INPUT_POST, 'usuario_id', FILTER_VALIDATE_INT);
        $tecnico_id = filter_input(INPUT_POST, 'tecnico_id', FILTER_VALIDATE_INT);

        if ($id && $titulo && $descricao && $prioridade && $status && $setor_id && $tipo_servico_id && $usuario_id) {
            // Verifica se o chamado existe
            $chamado = \src\models\Chamado::select()->where('id', $id)->one();

            if ($chamado) {
                // Atualiza os dados no banco
                \src\models\Chamado::update()
                    ->set('titulo', $titulo)
                    ->set('descricao', $descricao)
                    ->set('prioridade', $prioridade)
                    ->set('status', $status)
                    ->set('setor_id', $setor_id)
                    ->set('tipo_servico_id', $tipo_servico_id)
                    ->set('usuario_id', $usuario_id)
                    ->set('tecnico_id', $tecnico_id)
                    ->where('id', $id)
                    ->execute();

                // Redireciona para a listagem com sucesso
                $this->redirect('/chamados/listar');
            } else {
                echo "Chamado não encontrado.";
            }
        } else {
            echo "Dados inválidos para atualização.";
        }
    }

    public function excluir()
    {
        $id = filter_input(INPUT_POST, 'id');

        if ($id) {
            \src\models\Chamado::delete()->where('id', $id)->execute();
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
