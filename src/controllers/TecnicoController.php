<?php

namespace src\controllers;

use \core\Controller;

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
    public function index()
    {
        $this->render('tecnico/chamados_atribuidos');
    }
}
