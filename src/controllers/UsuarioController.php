<?php

namespace src\controllers;

use \core\Controller;

class UsuarioController extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
            $this->redirect('/login');
            exit;
        }

        $this->render('usuarios/register');
    }

    public function listar()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
            $this->redirect('/login');
            exit;
        }
        
        $this->render('usuarios/reset_password');
        
    }

}