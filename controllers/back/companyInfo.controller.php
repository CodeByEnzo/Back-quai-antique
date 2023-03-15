<?php

require_once "controllers/back/Security.class.php";

require_once "models/back/companyInfo.manager.php";
require_once "controllers/back/utile.php";

class companyInfoController
{
    private $companyInfoManager;

    public function __construct()
    {
        $this->companyInfoManager = new companyInfoManager();
    }
    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $companyInfo = $this->companyInfoManager->getCompanyInfo();
            // print_r($companyInfos);
            require_once "views/companyInfoVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (
            isset($_POST['id']) &&
            isset($_POST['name']) &&
            isset($_POST['adress']) &&
            isset($_POST['phone']) &&
            isset($_POST['email'])
        ) {
            $id = intval($_POST['id']);
            $name = filter_var($_POST['name']);
            $adress = filter_var($_POST['adress']);
            $phone = filter_var($_POST['phone']);
            $email = filter_var($_POST['email']);


            if (!$id) {
                throw new Exception("Les données envoyées sont incorrectes : id doit être un entier valide.");
            } else {
                $this->companyInfoManager->updateCompanyInfo($id, $name, $adress, $phone, $email);
                $_SESSION['alert'] = [
                    "message" => "les données de l'entreprise ont été modifié.",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/companyInfo/visualisation");
            }
        } else {
            throw new Exception("Les données envoyées sont incorrectes");
        }
    }
}
