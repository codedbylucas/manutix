<?php

namespace src\controllers\admin;

use \core\Controller;
use src\models\Setor;

class GestaoSetoresController extends Controller
{
    public function __construct()
    {
        $this->protegerAcesso('admin');
    }

    private function protegerAcesso($tipoNecessario)
    {
        if (
            !isset($_SESSION['usuario_id']) ||
            !isset($_SESSION['usuario_tipo']) ||
            $_SESSION['usuario_tipo'] !== $tipoNecessario
        ) {
            $this->redirect('/login');
            exit;
        }
    }

    public function setores() {
        $this->render('admin/setores');
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => trim(ucwords($_POST['nome']) ?? ''),
            ];
        }

        foreach ($dados as $chave => $valor) {
            if (empty($valor)) {
                $this->redirect('/admin/usuarios/novo', ['erro' => 'Preencha todos os campos!']);
                exit;
            }
        }
        if (Setor::buscarSetor($dados['nome'])) {
            $this->redirect('/admin/setores', ['erro' => 'Setor ja cadastrado!']);
            exit;
        } else {
            Setor::salvar($dados);
            $this->redirect('/admin/setores', ['success' => 'Usuario cadastrado com sucesso!']);
            exit;
        }
    }

    public function index()
    {
        $setores = \src\models\Setor::listarSetores();
        $this->render('admin/setores', ['setores' => $setores]);
    }

    public function listar()
    {
        $setores = Setor::listarSetores();          // array associativo
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($setores, JSON_UNESCAPED_UNICODE);
        exit;                                       // garante que nada mais será enviado
    }

     public function editar()
    {
        $id = filter_input(INPUT_POST, 'id');
        $nome = filter_input(INPUT_POST, 'nome');

        if ($id && $nome) {
            $setor = Setor::select()->where('id', $id)->one();
            
            if ($setor) {
                Setor::update()
                    ->set('nome', $nome)
                    ->where('id', $id)
                    ->execute();

                $this->redirect('/admin/setores');
            } else {
                echo "Setor não encontrado.";
            }
        } else {
            echo "Dados inválidos.";
        }
    }

    public function excluir()
    {
        $id = filter_input(INPUT_POST, 'id');

        if ($id) {
            $setor = Setor::select()->where('id', $id)->one();

            if ($setor) {
                Setor::delete()->where('id', $id)->execute();
                echo json_encode(['success' => true, 'mensagem' => 'Setor excluído com sucesso!']);
                
            } else {
                echo json_encode(['success' => false, 'mensagem' => 'Setor não encontrado.']);
            }
        } else {
            echo json_encode(['success' => false, 'mensagem' => 'ID inválido.']);
        }
    }

}
