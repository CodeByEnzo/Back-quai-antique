<?php
require_once "models/Model.php";


class reservationsManager extends Model
{
    public function getReservations()
    {
        $req = "SELECT * from reservations";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $reservations;
    }
    
    public function deleteDBReservation($reservation_id)
    {
        $req = "DELETE FROM reservations WHERE reservation_id= :reservation_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function updateReservation($reservation_id, $client_id, $date, $time, $comments)
    {
        try {
            $req = "SELECT * FROM reservations WHERE reservation_id = :reservation_id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
            $stmt->execute();
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            $req = "UPDATE reservations 
                SET reservation_id = :reservation_id, client_id = :client_id, date = :date, comments = :comments
                WHERE reservation_id= :reservation_id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
            $stmt->bindValue(":client_id", $client_id, PDO::PARAM_STR);
            $stmt->bindValue(":date", $date, PDO::PARAM_INT);
            $stmt->bindValue(":time", $time, PDO::PARAM_STR);
            $stmt->bindValue(":comments", $comments, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            echo $e->getMessage();
        }
    }

    public function createReservation($client_id, $date, $time, $number_of_people, $comments)
    {
        $this->getBdd()->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4");
        $req = "INSERT INTO reservations (client_id, date, time, number_of_people, comments)
        VALUES (:client_id, :date, :time, :number_of_people, :comment)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":client_id", $client_id, PDO::PARAM_STR);
        $stmt->bindValue(":date", $date, PDO::PARAM_STR);
        $stmt->bindValue(":time", $time, PDO::PARAM_STR);
        $stmt->bindValue(":number_of_people", $number_of_people, PDO::PARAM_INT);
        $stmt->bindValue(":comment", $comments, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
}
