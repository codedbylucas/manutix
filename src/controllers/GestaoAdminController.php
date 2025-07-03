<?php

namespace src\controllers;

use \core\Controller;

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
}
