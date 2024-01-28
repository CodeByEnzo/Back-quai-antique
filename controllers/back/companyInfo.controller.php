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
            require_once "views/companyInfoVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (security::verifAccessSession()) {
            $id = security::secureHTML($_POST['id']);
            $name = security::secureHTML($_POST['name']);
            $adress = security::secureHTML($_POST['adress']);
            $phone = security::secureHTML($_POST['phone']);
            $email = security::secureHTML($_POST['email']);
            if (!$id) {
                throw new Exception("Les données envoyées sont incorrectes");
            } else {
                $this->companyInfoManager->updateCompanyInfo($id, $name, $adress, $phone, $email);
                $_SESSION['alert'] = [
                    "message" => "les données de l'entreprise ont été modifié.",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/companyInfo/visualisation");
            }
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
}
