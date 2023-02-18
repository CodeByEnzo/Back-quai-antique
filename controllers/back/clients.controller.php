<?php

require_once "./controllers/back/Security.class.php";
require_once "./models/back/clients.manager.php";
require_once "./controllers/back/utile.php";

class clientsController
{
    private $clientsManager;

    public function __construct()
    {
        $this->clientsManager = new clientsManager();
    }
    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $clients = $this->clientsManager->getclients();
            // print_r($clients);
            require_once "views/clientsVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
    public function delete()
    {
        if (security::verifAccessSession()) {
            $_SESSION['alert'] = [
                "message" => "Le client à été supprimé",
                "type" => "alert-success"
            ];

            $this->clientsManager->deleteDBclient((int) security::secureHTML($_POST['client_id']));
            header('Location: ' . URL . 'back/clients/visualisation');
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (
            isset($_POST['client_id']) && !empty($_POST['client_id']) &&
            isset($_POST['username']) && !empty($_POST['username']) &&
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password']) && !empty($_POST['password'])
        ) {
            // var_dump($_POST);

            $client_id = intval($_POST['client_id']);
            $username = filter_var($_POST['username']);
            $email = filter_var($_POST['email']);
            $password = filter_var($_POST['password']);

            $this->clientsManager->updateClient($client_id, $username, $email, $password);

            $_SESSION['alert'] = [
                "message" => "Le plat à été modifié",
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/clients/visualisation");
        } else {
            throw new Exception("Les données envoyées sont incorrectes");
        }
    }
    public function creationTemplate()
    {
        if (security::verifAccessSession()) {
            require_once "views/clientCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
    public function creationValidation()
    {
        if (security::verifAccessSession()) {
            $username = security::secureHTML($_POST['username']);
            $email = security::secureHTML($_POST['email']);
            $password = security::secureHTML($_POST['password']);

            $result =  $this->clientsManager->createClient($username, $email, $password);

            if ($result != 0) {
                $_SESSION['alert'] = [
                    "message" => "Le client a été créé avec l'identifiant : " . $result,
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/clients/visualisation");
            } else {
                $_SESSION['alert'] = [
                    "message" => $result,
                    "type" => "alert-danger"
                ];
                header("Location: " . URL . "back/clients/creation");
            }

        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

}
