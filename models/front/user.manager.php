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

    public function getUserReservations($client_id)
    {
        $db = $this->getBdd();
        $req = $db->prepare('SELECT * FROM reservations WHERE client_id = ?');
        $req->execute(array($client_id));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data ? $data : [];
    }

    public function registerUser($username, $email, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $pdo = $this->getBdd();
            $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if ($user) {
                return ['status' => 'error', 'message' => "Cet utilisateur existe déjà"];
            }
            $stmt = $pdo->prepare('INSERT INTO clients (username, email, password) VALUES (:username, :email, :password)');
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $passwordHash]);
            return ['status' => 'success'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
            print_r($e);
        }
    }

    public function reservation($date, $time, $number_of_people, $comment, $client_id)
    {
        $pdo = $this->getBdd();
        $req = $pdo->prepare("INSERT INTO reservations (date, time, number_of_people, comments, client_id) 
                          VALUES (:date, :time, :number_of_people, :comment, :client_id)");
        $req->bindValue(":date", $date, PDO::PARAM_STR);
        $req->bindValue(":time", $time, PDO::PARAM_STR);
        $req->bindValue(":number_of_people", $number_of_people, PDO::PARAM_INT);
        $req->bindValue(":comment", $comment, PDO::PARAM_STR);
        $req->bindValue(":client_id", $client_id, PDO::PARAM_INT);

        if ($req->execute()) {
            return ['status' => 'success'];
        } else {
            throw new Exception("Une erreur est survenue lors de la réservation, veuillez réessayer plus tard.");
        }
    }
    public function DeleteReservation($client_id, $reservation_id)
    {
        $req = "DELETE FROM reservations WHERE client_id= :client_id AND reservation_id = :reservation_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
        $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        if ($stmt->execute()) {
            return ['status' => 'success'];
        } else {
            throw new Exception("Une erreur est survenue lors de l'annulation de la réservation, veuillez réessayer plus tard.");
        }
    }
    public function UpdateReservation($client_id, $reservation_id, $date, $time, $number_of_people, $comments)
    {
        $req = "UPDATE reservations 
        SET date = :date, time = :time, number_of_people = :number_of_people, comments = :comments 
        WHERE reservation_id = :reservation_id 
        AND client_id = :client_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
        $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
        $stmt->bindValue(":date", $date, PDO::PARAM_STR);
        $stmt->bindValue(":time", $time, PDO::PARAM_STR);
        $stmt->bindValue(":number_of_people", $number_of_people, PDO::PARAM_INT);
        $stmt->bindValue(":comments", $comments, PDO::PARAM_STR);
        $stmt->execute();

        $stmt->closeCursor();

        if ($stmt->rowCount() > 0) {
            return ['status' => 'success'];
        } else {
            return ['error' => "Une erreur est survenue lors de la modification de la réservation, veuillez réessayer plus tard."];
        }
    }
}
