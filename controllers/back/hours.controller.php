<?php

require_once "controllers/back/Security.class.php";

require_once "models/back/hours.manager.php";
require_once "controllers/back/utile.php";

class hoursController
{
    private $hoursManager;

    public function __construct()
    {
        $this->hoursManager = new hoursManager();
    }
    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $hours = $this->hoursManager->getHours();
            // print_r($hours);
            require_once "views/hoursVisualisation.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (security::verifAccessSession()) {
            $id = security::secureHTML($_POST['id']);
            $day_of_week = security::secureHTML($_POST['day_of_week']);
            $lunch_opening_time = security::secureHTML($_POST['lunch_opening_time']);
            $lunch_closing_time = security::secureHTML($_POST['lunch_closing_time']);
            $dinner_opening_time = security::secureHTML($_POST['dinner_opening_time']);
            $dinner_closing_time = security::secureHTML($_POST['dinner_closing_time']);
            if (!$id) {
                throw new Exception("Les données envoyées sont incorrectes : id doit être un entier valide.");
            } else {
                $this->hoursManager->updateHours($id, $day_of_week, $lunch_opening_time, $lunch_closing_time, $dinner_opening_time, $dinner_closing_time);
                $_SESSION['alert'] = [
                    "message" => "L'horraire à été modifié",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/hours/visualisation");
            }
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
}
