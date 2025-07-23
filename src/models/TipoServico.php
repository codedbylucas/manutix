<?php
namespace src\models;

use \core\Model;

class TipoServico extends Model
{
    public static string $table = 'tipo_servico';

    public static function listarTipos()
    {
        return self::select()->orderBy('nome')->get();
    }

    public static function buscarTipo($nome)
    {
        return self::select()->where('nome', $nome)->one();
    }

    public static function salvar($dados)
    {
        self::insert($dados)->execute();
    }
}
