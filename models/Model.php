<?php

// Permet de faire la connection à la BDD
// Classe abstraite qui n'est pas instanciable, on peut seulement l'étendre
abstract class Model
{
    private static $pdo;
    //Fonction static qui fait la connection à la BD
    private static function setBdd()
    {
        self::$pdo = new PDO("mysql:host=localhost;dbname=db_quai;charset=utf8", "root", "8!+B4j{wZuR7");


        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    // appelle la fonction setBdd pour recupérer la connection
    protected function getBdd()
    {
        //Pour se connecter une seule fois à la BDD
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
