<?php

namespace src\controllers;

use src\models\Usuario;
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
        // 1. Quem está logado?
        $usuarioId = $_SESSION['usuario_id'];

        // 2. Pede ao Model os dados agregados
        $resultados = Chamado::totaisStatusPorUsuario($usuarioId);

        // 3. Responde em JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($resultados, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        exit;
    }

    public function dadosGraficoTecnico(): void
    {
        // Se quiser filtrar por status: Chamado::totaisPorTecnico('Aberto');
        $dados = Chamado::totaisPorTecnico();

        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($dados);
        exit;
    }
}
