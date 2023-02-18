<?php
require_once "models/Model.php";

class UserManager extends Model
{
    public function getUserByEmail($email)
    {
        $db = $this->getBdd();
        $req = $db->prepare('SELECT * FROM clients WHERE email = ?');
        $req->execute(array($email));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        $userData = [
            'id' => $data['client_id'],
            'email' => $data['email'],
            'username' => $data['username'],
            'created_at' => $data['created_at'],
        ];

        return $userData;
    }


}
