<?php
//TEST 3

// Connect to database
// Classe abstraite qui n'est pas instanciable, on peut seulement l'étendre
abstract class Model
{
    private static $pdo;
    private static function setBdd()
    {
        self::$pdo = new PDO("mysql:host=localhost;dbname=db_quai;charset=utf8", "root", "8!+B4j{wZuR7");
        // self::$pdo = new PDO("mysql:host=n39rx.myd.infomaniak.com;dbname=n39rx_db_quai;charset=utf8", "n39rx_enzo4snow", "1Df0351694");

        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    // call function settBdd to get connexion
    protected function getBdd()
    {
        // To connect once to database
        if (self::$pdo === null) {
            self::setBdd();
        }
        return self::$pdo;
    }
    public static function sendJSON($info)
    {
        require './config/cors.php';
        echo json_encode($info);
    }
}
