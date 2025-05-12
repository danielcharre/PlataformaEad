<?php 

    namespace App;

use PDOException;

    class Connection {

        public static function getDB() {
            try {
                
                $conn = new \PDO(
                    "mysql:host=localhost;dbname=ead;charset=utf8",
                    "root",
                    ""
                );

                return $conn;

            } catch (\PDOException $e) {
                echo "ERRO: Falha na conexao com banco de dados" .$e->getMessage(); 
            }
        }
    }
?>