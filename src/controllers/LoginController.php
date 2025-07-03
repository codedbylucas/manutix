<?php

namespace src\controllers;

use src\models\Login;
use \core\Controller;

class LoginController extends Controller
{

    public function index()
    {
        $this->render('login', ['erro' => '']);
    }

    public function autenticar()
    {

        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $senha = filter_input(INPUT_POST, 'senha');

        if ($email && $senha) {
            $usuario = Login::buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'];

                $this->redirect('/dashboard');
                exit;
            } else {
                $this->render('login', ['erro' => 'Usuário ou senha inválidos.']);
            }
        } else {
            $this->render('login', ['erro' => 'Preencha todos os campos.']);
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        $this->redirect('/login');
    }
}
