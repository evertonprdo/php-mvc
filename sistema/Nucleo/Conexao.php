<?php 

namespace sistema\Nucleo;

use PDO;
use PDOException;

class Conexao 
{
    private static $instancia;

    /**
     * Instancia do Banco de Dados Banco dbname
     */
    public static function getInstancia(): PDO
    {
        if(empty(self::$instancia)) {
            try {
                self::$instancia = new PDO('mysql:host='. DB_HOST .';port='. DB_PORTA .';dbname='.DB_NOME, DB_USER, DB_SENHA, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL
                ]);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$instancia;
    }

    protected function __construct() {      }

    private function __clone(): void {      }
}


?>