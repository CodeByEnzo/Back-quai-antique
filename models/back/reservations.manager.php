<?php
require_once "models/Model.php";


class reservationsManager extends Model
{
    public function getreservations()
    {
        $req = "SELECT * from reservations";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $reservations;
    }
    public function deleteDBreservation($reservation_id)
    {
        $req = "DELETE FROM reservations WHERE reservation_id= :reservation_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function updatereservation($reservation_id, $client_id, $date, $time, $comments)
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
            // Enregistrer des informations sur l'erreur
            error_log($e->getMessage());

            // Notifier les utilisateurs
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            // ou avec un message d'erreur personnalisé
            echo $e->getMessage();
        }
    }

    public function createreservation($reservation_id, $client_id, $date, $time, $comments)
    {
        $this->getBdd()->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4");
        $req = "INSERT INTO reservations (reservation_title, reservation_content, reservation_img)
        VALUES (:reservation_title, :reservation_content, :reservation_img)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
        $stmt->bindValue(":client_id", $client_id, PDO::PARAM_STR);
        $stmt->bindValue(":date", $date, PDO::PARAM_INT);
        $stmt->bindValue(":time", $time, PDO::PARAM_INT);
        $stmt->bindValue(":comments", $comments, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
}
