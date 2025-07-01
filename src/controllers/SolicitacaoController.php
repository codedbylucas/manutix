<?php

namespace src\controllers;

use src\models\Usuario;
use \core\Controller;

class SolicitacaoController extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
            $this->redirect('/login');
            exit;
        }

        $this->render('chamados/cadastro');
    }

    public function listar()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
            $this->redirect('/login');
            exit;
        }
        
        $this->render('chamados/listar');
        
    }
}
