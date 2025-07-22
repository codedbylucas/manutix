<?php

namespace src\controllers\avaliacao;

use \core\Controller;
use core\Database;
use \Exception;

class AvaliacoesController extends Controller
{
    public function __construct()
    {
        $this->protegerAcesso(['admin', 'tecnico', 'funcionario']);
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
        $pdo = Database::getInstance();
        $stmt = $pdo->query("
            SELECT a.id, a.solicitacao_id, a.nota, a.comentario, s.titulo
            FROM avaliacoes a
            JOIN solicitacoes s ON s.id = a.solicitacao_id
            ORDER BY a.id DESC
        ");
        $avaliacoes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // passa $avaliacoes para o template
        $this->render('avaliacao/listar_avaliacoes', ['avaliacoes' => $avaliacoes]);
    }

    public function salvar()
    {
        try {
            $nota = $_POST['nota'] ?? null;
            $comentario = $_POST['comentario'] ?? null;
            $solicitacaoId = $_POST['solicitacao_id'] ?? null;

            if (!$nota || !$comentario || !$solicitacaoId) {
                http_response_code(400);
                echo json_encode(['erro' => 'Preencha todos os campos obrigatórios.']);
                return;
            }

            $pdo = Database::getInstance();

            $stmt = $pdo->prepare("INSERT INTO avaliacoes (solicitacao_id, nota, comentario) VALUES (:solicitacao_id, :nota, :comentario)");
            $stmt->bindValue(':solicitacao_id', $solicitacaoId);
            $stmt->bindValue(':nota', $nota);
            $stmt->bindValue(':comentario', $comentario);
            $stmt->execute();

            echo json_encode(['status' => 'ok']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro interno: ' . $e->getMessage()]);
        }
    }

    public function listar()
    {
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->query("
                SELECT a.id, a.solicitacao_id, a.nota, a.comentario, s.titulo
                FROM avaliacoes a
                JOIN solicitacoes s ON s.id = a.solicitacao_id
                ORDER BY a.id DESC
            ");
            $avaliacoes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($avaliacoes);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao listar avaliações: ' . $e->getMessage()]);
        }
    }
}
