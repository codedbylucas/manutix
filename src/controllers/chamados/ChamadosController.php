<?php

namespace src\controllers\chamados;

use src\models\Usuario;
use \core\Controller;

class ChamadosController extends Controller
{

    public function __construct()
    {
        $this->protegerAcesso(['funcionario', 'admin']);
    }

    private function protegerAcesso(array $tiposPermitidos)
    {
        if (
            !isset($_SESSION['usuario_id']) ||
            !isset($_SESSION['usuario_tipo']) ||
            !in_array($_SESSION['usuario_tipo'], $tiposPermitidos)
        ) {
            $this->redirect('/login');
            exit;
        }
    }

    public function index()
    {
        $this->render('chamados/cadastro_chamados');
    }

    public function listar()
    {
        $this->render('chamados/listar_chamados');
    }

    
}
