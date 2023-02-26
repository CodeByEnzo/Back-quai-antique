<?php
require_once "./models/Model.php";

class AdminManager extends Model
{
    private function getPasswordUser($login)
    {
        $req =  'SELECT * FROM users WHERE login = :login';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $admin['password'];
    }
    public function isConnectionValid($login, $password)
    {
        $passwordBD = $this->getPasswordUser($login);
        return password_verify($password, $passwordBD);
    }
}
