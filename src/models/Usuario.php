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
}
