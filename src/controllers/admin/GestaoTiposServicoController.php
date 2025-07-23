<?php
namespace src\controllers\admin;

use \core\Controller;
use src\models\TipoServico;

class GestaoTiposServicoController extends Controller
{
    public function __construct()
    {
        $this->protegerAcesso('admin');
    }

    private function protegerAcesso($tipoNecessario)
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== $tipoNecessario) {
            $this->redirect('/login');
            exit;
        }
    }

    public function tipos()
    {
        $this->render('admin/tipos_servico');
    }

    public function listar()
    {
        $tipos = TipoServico::listarTipos();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tipos, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => trim(ucwords($_POST['nome']) ?? '')
            ];

            foreach ($dados as $valor) {
                if (empty($valor)) {
                    $this->redirect('/admin/tipos_servico', ['erro' => 'Preencha todos os campos!']);
                    return;
                }
            }

            if (TipoServico::buscarTipo($dados['nome'])) {
                $this->redirect('/admin/tipos_servico', ['erro' => 'Tipo já cadastrado!']);
                return;
            }

            TipoServico::salvar($dados);
            $this->redirect('/admin/tipos_servico', ['success' => 'Tipo de serviço cadastrado com sucesso!']);
        }
    }

    public function editar()
    {
        $id = filter_input(INPUT_POST, 'id');
        $nome = filter_input(INPUT_POST, 'nome');

        if ($id && $nome) {
            $tipo = TipoServico::select()->where('id', $id)->one();

            if ($tipo) {
                TipoServico::update()->set('nome', $nome)->where('id', $id)->execute();
                $this->redirect('/admin/tipos_servico');
            } else {
                echo "Tipo não encontrado.";
            }
        } else {
            echo "Dados inválidos.";
        }
    }

    public function excluir()
    {
        $id = filter_input(INPUT_POST, 'id');

        if ($id) {
            $tipo = TipoServico::select()->where('id', $id)->one();

            if ($tipo) {
                TipoServico::delete()->where('id', $id)->execute();
                echo json_encode(['success' => true, 'mensagem' => 'Tipo excluído com sucesso!']);
            } else {
                echo json_encode(['success' => false, 'mensagem' => 'Tipo não encontrado.']);
            }
        } else {
            echo json_encode(['success' => false, 'mensagem' => 'ID inválido.']);
        }
    }
}
