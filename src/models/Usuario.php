<?php

namespace src\models;

use \core\Model;
use core\Database;
use \PDO;

class Usuario extends Model

{

    public static function buscarPorEmail($email)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public static function salvar($dados)
    {
        $pdo = Database::getInstance();

        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, setor_id) VALUES (:nome, :email, :senha, :tipo, :setor_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome']);
        $stmt->bindValue(':email', $dados['email']);
        $stmt->bindValue(':senha', $dados['senha']);
        $stmt->bindValue(':tipo', $dados['tipo']);
        $stmt->bindValue(':setor_id', $dados['setor_id']);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function listarUsuarios()
    {
        $pdo = Database::getInstance();

        $sql = "SELECT u.id, u.nome, u.email, u.tipo, s.nome as setor 
            FROM usuarios u
            LEFT JOIN setores s ON u.setor_id = s.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function excluir($id)
    {
        $pdo = Database::getInstance();

        $sql = 'DELETE FROM usuarios WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('id', $id);

        return $stmt->execute();
    }

    public static function editar($id)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1"; // <- * importante!
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // <- retorna array associativo completo
    }

    public static function atualizar($dados)
    {
        $pdo = Database::getInstance();

        $sql = 'UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo, setor_id = :setor_id';
        if (isset($dados['senha'])) {
            $sql .= ", senha = :senha";
        }
        $sql .= " WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome']);
        $stmt->bindValue(':email', $dados['email']);
        $stmt->bindValue(':tipo', $dados['tipo']);
        $stmt->bindValue(':setor_id', $dados['setor_id']);
        $stmt->bindValue(':id', $dados['id']);

        if (isset($dados['senha'])) {
            $stmt->bindValue(':senha', $dados['senha']);
        }

        return $stmt->execute();
    }
}
