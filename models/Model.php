<?php

abstract class Model
{
    private static $pdo;
    private static function setBdd()
    {
        self::$pdo = new PDO("mysql:host=localhost;dbname=db_quai;charset=utf8", "root", "8!+B4j{wZuR7");
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
