<?php

namespace src\models;

use \core\Model;
use core\Database;
use \PDO;

class Setor extends Model
{
    protected static string $table = 'setores';
    public static function buscarSetor($nome)
    {
        $pdo = Database::getInstance();

        $sql = "SELECT * FROM setores WHERE nome = :nome LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public static function salvar($dados)
    {
        $pdo = Database::getInstance();

        $sql = "INSERT INTO setores (nome) VALUES (:nome)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome']);
        $stmt->execute();

        return $pdo->lastInsertId(); // retorna o ID do setor inserido, se quiser usar depois
    }
}
