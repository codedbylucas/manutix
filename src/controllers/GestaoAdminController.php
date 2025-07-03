<?php

namespace src\controllers;

use \core\Controller;
use src\models\Usuario;

class GestaoAdminController extends Controller
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

    public function index()
    {
        $this->render('admin/cadastro_usuarios');
    }

    public function setores()
    {
        $this->render('admin/setores');
    }

    public function listar()
    {
        $this->render('admin/listar_usuarios');
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dados = [
                'nome' => trim(ucwords($_POST['nome']) ?? ''),
                'sobrenome' => trim(ucwords($_POST['sobrenome']) ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'senha' => $_POST['senha'] ?? '',
                'confirmar_senha' => $_POST['confirmar_senha'] ?? '',
                'tipo' => $_POST['tipo'] ?? '',
                'setor_id' => $_POST['setor_id'] ?? ''
            ];

            foreach ($dados as $chave => $valor) {
                if (empty($valor)) {
                    $this->redirect('/admin/usuarios/novo', ['erro' => 'Preencha todos os campos!']);
                    exit;
                }
            }

            if ($dados['senha'] !== $dados['confirmar_senha']) {
                $this->redirect('/admin/usuarios/novo', ['erro' => 'As senhas não coincidem!']);
                exit;
            }

            $dados['nome'] = $dados['nome'] . ' ' . $dados['sobrenome'];
            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
            unset($dados['confirmar_senha']);

            if (Usuario::buscarPorEmail($dados['email'])) {
                $this->redirect('/admin/usuarios/novo', ['erro' => 'Email ja cadastrado!']);
                exit;
            } else {
                Usuario::salvar($dados);
                $this->redirect('/admin/usuarios/novo', ['success' => 'Usuario cadastrado com sucesso!']);
                exit;
            }
        }
    }
}
