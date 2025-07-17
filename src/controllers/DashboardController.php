<?php

namespace src\controllers;

use \core\Controller;
use src\models\Chamado;

class DashBoardController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect('/login');
            exit;
        }

        $this->render('dashboard');
    }

     public function dadosGraficoStatus()
    {
        $usuarioId = $_SESSION['usuario_id'];

        $resultados = Chamado::totaisStatusPorUsuario($usuarioId);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resultados, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        exit;
    }

    public function dadosGraficoTecnico(): void
    {
        $dados = Chamado::totaisPorTecnico();

        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($dados);
        exit;
    }
}
