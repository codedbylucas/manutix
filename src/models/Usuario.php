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
}
