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

    public static function listarPorUsuario(int $usuarioId): array
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
                s.tecnico_id,                 -- ainda trazemos o ID
                s.descricao,
                ts.nome AS tipo_servico,
                u.nome AS nome_tecnico        -- aqui já vem o nome
            FROM solicitacoes s
            LEFT JOIN tipos_servico ts ON ts.id = s.tipo_servico_id
            LEFT JOIN usuarios      u  ON u.id  = s.tecnico_id   -- junta com usuários
            WHERE s.usuario_id = :usuarioId                       -- se o filtro fizer sentido
            ORDER BY s.id DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function listarPorTecnico(int $tecnicoId): array
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
                s.tecnico_id,
                s.descricao,
                ts.nome AS tipo_servico,
                u.nome AS nome_tecnico
            FROM solicitacoes s
            LEFT JOIN tipos_servico ts ON ts.id = s.tipo_servico_id
            LEFT JOIN usuarios      u  ON u.id  = s.tecnico_id
            WHERE s.tecnico_id = :tecnicoId          -- agora o filtro é aqui
            ORDER BY s.id DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':tecnicoId', $tecnicoId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodos(): array
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
                s.tecnico_id,
                s.descricao,
                ts.nome AS tipo_servico,
                u.nome  AS nome_tecnico,      -- nome do técnico (se houver)
                su.nome AS nome_solicitante   -- nome de quem abriu o chamado
            FROM solicitacoes s
            LEFT JOIN tipos_servico ts ON ts.id = s.tipo_servico_id
            LEFT JOIN usuarios      u  ON u.id  = s.tecnico_id       -- técnico
            LEFT JOIN usuarios      su ON su.id = s.usuario_id       -- solicitante
            ORDER BY s.id DESC
        ";

        $stmt = $pdo->query($sql);          // não precisa de prepare/bind
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function totaisStatusPorUsuario(int $usuarioId): array
    {
        $pdo = Database::getInstance();

        $sql = "
            SELECT status, COUNT(*) AS total
            FROM solicitacoes
            WHERE usuario_id = :id
            GROUP BY status
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public static function totaisPorTecnico(?string $statusOpcional = null): array
    {
        $pdo   = Database::getInstance();
        $table = self::$table;                // evita hard‑code

        $sql = "
            SELECT u.nome AS tecnico, COUNT(*) AS total
            FROM {$table} s
            JOIN usuarios u ON u.id = s.tecnico_id
            " . ($statusOpcional ? "WHERE s.status = :status" : "") . "
            GROUP BY u.nome
            ORDER BY total DESC
        ";

        $stmt = $pdo->prepare($sql);

        if ($statusOpcional) {
            $stmt->bindValue(':status', $statusOpcional, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}