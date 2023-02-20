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

        if (is_array($data)) {
            $userData = [
                'id' => $data['client_id'],
                'email' => $data['email'],
                'username' => $data['username'],
                'created_at' => $data['created_at'],
            ];
            return $userData;
        } else {
            return null;
        }
    }

    public function getUserReservations($userId)
    {
        $db = $this->getBdd();
        $req = $db->prepare('SELECT * FROM reservations WHERE client_id = ?');
        $req->execute(array($userId));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data ? $data : [];
    }
}
