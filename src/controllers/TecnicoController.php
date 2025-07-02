<?php

namespace src\controllers;

use \core\Controller;

class TecnicoController extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
            $this->redirect('/login');
            exit;
        }

        $this->render('tecnico/chamados_atribuidos');
    }

}