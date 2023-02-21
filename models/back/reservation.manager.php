<?php

require_once 'models/Model.php';

class ReservationsManager extends Model
{
    public function reservation($date, $time, $number_of_people, $comment)
    {

            $pdo = $this->getBdd();
            $req = $pdo->prepare("INSERT INTO reservations (date, time, number_of_people, comments 
            VALUES (:date, :time, :number_of_people, :comment)");
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":date", $date, PDO::PARAM_STR);
            $stmt->bindValue(":email", $time, PDO::PARAM_STR);
            $stmt->bindValue(":number_of_people", $number_of_people, PDO::PARAM_STR);
            $stmt->bindValue(":comments", $comment, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->getBdd()->lastInsertId();
        } else {
            throw new Exception("Une erreur est survenue lors de la création du client, veuillez réessayer plus tard.");
        }
    }
}
