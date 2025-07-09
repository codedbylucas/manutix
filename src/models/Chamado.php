<?php

namespace src\models;

use \core\Model;
use core\Database;
use \PDO;

class Chamado extends Model {
    public static string $table = 'solicitacoes';
    public static function criar($dados)
    {
        $pdo = Database::getInstance();

        $sql = "INSERT INTO solicitacoes 
            (titulo, descricao, prioridade, status, setor_id, tipo_servico_id, usuario_id, tecnico_id, anexo)
            VALUES 
            (:titulo, :descricao, :prioridade, :status, :setor_id, :tipo_servico_id, :usuario_id, :tecnico_id, :anexo)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $dados['titulo']);
        $stmt->bindValue(':descricao', $dados['descricao']);
        $stmt->bindValue(':prioridade', $dados['prioridade']);
        $stmt->bindValue(':status', $dados['status']);
        $stmt->bindValue(':setor_id', $dados['setor_id'], PDO::PARAM_INT);
        $stmt->bindValue(':tipo_servico_id', $dados['tipo_servico_id'], PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $dados['usuario_id'], PDO::PARAM_INT);
        $stmt->bindValue(':tecnico_id', $dados['tecnico_id'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':anexo', $dados['anexo']);

        return $stmt->execute();
    }

    public static function listarPorUsuario($usuarioId)
    {
        $pdo = Database::getInstance();
        $sql = "
            SELECT 
                s.id,
                s.titulo,
                s.status,
                s.prioridade,
                s.tipo_servico_id,
                s.setor_id,
                s.descricao,
                ts.nome AS tipo_servico
            FROM solicitacoes s
            LEFT JOIN tipos_servico ts ON ts.id = s.tipo_servico_id
            ORDER BY s.id DESC
        ";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}