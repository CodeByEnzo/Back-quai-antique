<?php
require_once "models/Model.php";


class hoursManager extends Model
{
    public function getHours()
    {
        $req = "SELECT * from opening_hours";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $hours = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $hours;
    }


    public function updateHours($id, $day_of_week, $lunch_opening_time, $lunch_closing_time, $dinner_opening_time, $dinner_closing_time)
    {
        try {
            $req = "SELECT * FROM open_hours WHERE id = :id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $hour = $stmt->fetch(PDO::FETCH_ASSOC);

            $req = "UPDATE opening_hours 
                SET id = :id, 
                day_of_week = :day_of_week, 
                lunch_opening_time = :lunch_opening_time, 
                lunch_closing_time = :lunch_closing_time, 
                dinner_opening_time = :dinner_opening_time, 
                dinner_closing_time = :dinner_closing_time
                WHERE id= :id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":day_of_week", $day_of_week, PDO::PARAM_STR);
            $stmt->bindValue(":lunch_opening_time", $lunch_opening_time, PDO::PARAM_STR);
            $stmt->bindValue(":lunch_closing_time", $lunch_closing_time, PDO::PARAM_STR);
            $stmt->bindValue(":dinner_opening_time", $dinner_opening_time, PDO::PARAM_STR);
            $stmt->bindValue(":dinner_closing_time", $dinner_closing_time, PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            echo $e->getMessage();
        }
    }
}
