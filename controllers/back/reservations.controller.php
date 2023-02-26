<?php

require_once "controllers/back/Security.class.php";

require_once "models/back/reservations.manager.php";
require_once "controllers/back/utile.php";

class reservationsController
{
    private $reservationsManager;

    public function __construct()
    {
        $this->reservationsManager = new reservationsManager();
    }
    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $reservations = $this->reservationsManager->getreservations();
            // print_r($reservations);
            require_once "views/reservationsVisualisation.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
    public function delete()
    {
        if (security::verifAccessSession()) {
            $_SESSION['alert'] = [
                "message" => "Le plat est supprimé",
                "type" => "alert-success"
            ];

            $this->reservationsManager->deleteDBreservation((int) security::secureHTML($_POST['reservation_id']));
            header('Location: ' . URL . 'back/reservations/visualisation');
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (
            isset($_POST['reservation_id']) &&
            isset($_POST['client_id']) &&
            isset($_POST['date']) &&
            isset($_POST['time']) &&
            isset($_POST['comments'])
        ) {
            $reservation_id = intval($_POST['reservation_id']);
            $client_id = intval($_POST['client_id']);
            $date = filter_var($_POST['date']);
            $time = filter_var($_POST['time']);
            $comments = filter_var($_POST['comments']);


            if (!$reservation_id) {
                throw new Exception("Les données envoyées sont incorrectes : reservation_id doit être un entier valide.");
            } else if (!$reservation_id || !$client_id) {
                throw new Exception("Les données envoyées sont incorrectes : client_id ne peut pas être vide.");
            } else {
                $this->reservationsManager->updatereservation($reservation_id, $client_id, $date, $time, $comments);
                $_SESSION['alert'] = [
                    "message" => "La réservation à bien été modifiée",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/reservations/visualisation");
            }
        } else {
            throw new Exception("Les données envoyées sont incorrectes : reservation_id, client_id, date, time, comments doivent être définis.");
        }
    }

    public function creationTemplate()
    {
        if (security::verifAccessSession()) {
            require_once "views/reservationCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function creationValidation()
    {
        if (security::verifAccessSession()) {
            $reservation_id = security::secureHTML($_POST['reservation_title']);
            $client_id = security::secureHTML($_POST['client_id']);
            $date = "";
            $time = "";
            $comments = "";

            $reservation_id =  $this->reservationsManager->createReservation($reservation_id, $client_id, $date, $time, $comments);

            $_SESSION['alert'] = [
                "message" => "Le plat à été créé avec l'identifiant :" . $reservation_id,
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/reservations/visualisation");
            // var_dump($_POST);
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
}