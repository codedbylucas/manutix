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

    public function listar() {
        $pdo = \core\Database::getInstance();
        $stmt = $pdo->prepare("SELECT id, nome FROM setores");
        $stmt->execute();
        $setores = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode($setores);
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

                // Redireciona de volta com sucesso
                $this->redirect('/admin/setores');
            } else {
                echo "Setor não encontrado.";
            }
        } else {
            echo "Dados inválidos.";
        }
    }

}
