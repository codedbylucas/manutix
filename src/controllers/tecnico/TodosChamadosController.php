<?php

namespace src\controllers\tecnico;

use \core\Controller;

class TodosChamadosController extends Controller
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
        $chamados = \src\models\Chamado::listarTodos($usuarioId);
        $setores = \src\models\Setor::select(['id', 'nome'])->orderBy('nome')->get();

        $this->render('tecnico/todos_chamados', [
            'chamados' => $chamados,
            'setores' => $setores
        ]);
    }

    public function assumir()
    {
        $usuarioId = $_SESSION['usuario_id'];
        $chamadoId = $_POST['chamado_id'] ?? null;

        if ($chamadoId) {
            \src\models\Chamado::update()
                ->set(['tecnico_id' => $usuarioId])
                ->where('id', $chamadoId)
                ->execute();
        }

        $this->redirect('/tecnico/todosChamados');
    }
}
