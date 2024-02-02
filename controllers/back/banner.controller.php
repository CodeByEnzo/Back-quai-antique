<?php

require_once "./controllers/back/Security.class.php";
require_once "./models/back/banner.manager.php";
require_once "./controllers/back/utile.php";

class bannerController
{
    private $bannerManager;

    public function __construct()
    {
        $this->bannerManager = new bannerManager();
    }
    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $banner = $this->bannerManager->getBanner();
            require_once "views/bannerVisualisation.view.php";
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

            $this->bannerManager->deleteDBBanner((int) security::secureHTML($_POST['ID']));
            header('Location: ' . URL . 'back/banner/visualisation');
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (security::verifAccessSession()) {
            try {

                $ID = (int) security::secureHTML($_POST['ID']);
                $Name = security::secureHTML($_POST['Name']);
                $AltText = security::secureHTML($_POST['AltText']);
                $file = $_FILES['Image'];
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            if (!$ID) {
                throw new Exception("Les données envoyées sont incorrectes");
            } else if (!$Name || !$file || !$AltText) {
                throw new Exception("Les données envoyées sont incorrectes");
            } else {
                $this->bannerManager->updateBanner($ID, $Name, $AltText, $file);
              

                $_SESSION['alert'] = [
                    "message" => "La bannière a été modifiée avec succès",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/banner/visualisation");
            }
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function creationTemplate()
    {
        if (security::verifAccessSession()) {
            require_once "views/galleryCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function creationValidation()
    {
        if (security::verifAccessSession()) {
            $ID = security::secureHTML($_POST['ID']);
            $Name = security::secureHTML($_POST['Name']);
            $AltText = security::secureHTML($_POST['AltText']);

            if ($_FILES['Image']['size'] > 0) {
                $folder = "public/images/";
                $Image = addPic($_FILES['Image'], $folder);
            }
            $ID =  $this->bannerManager->createBanner($ID, $Name, $AltText, $Image);

            $_SESSION['alert'] = [
                "message" => "Le plat à été créé avec l'IDentifiant :" . $ID,
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/banner/visualisation");
            // var_dump($_POST);
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
}
