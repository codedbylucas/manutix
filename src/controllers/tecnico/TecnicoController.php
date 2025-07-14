<?php

namespace src\controllers\tecnico;

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

    public function listar()
    {
        $usuarioId = $_SESSION['usuario_id'];
        $chamados = \src\models\Chamado::listarPorUsuario($usuarioId);
        $setores = \src\models\Setor::select(['id', 'nome'])->orderBy('nome')->get();

        $this->render('tecnico/chamados_atribuidos', [
            'chamados' => $chamados,
            'setores' => $setores
        ]);
    }
}
