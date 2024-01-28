<?php

require_once "./controllers/back/Security.class.php";
require_once "./models/back/gallerys.manager.php";
require_once "./controllers/back/utile.php";

class gallerysController
{
    private $gallerysManager;

    public function __construct()
    {
        $this->gallerysManager = new gallerysManager();
    }
    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $gallerys = $this->gallerysManager->getGallerys();
            require_once "views/gallerysVisualisation.view.php";
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

            $this->gallerysManager->deleteDBgallery((int) security::secureHTML($_POST['gallery_id']));
            header('Location: ' . URL . 'back/gallerys/visualisation');
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (security::verifAccessSession()) {
            $gallery_id = security::secureHTML($_POST['gallery_id']);
            $gallery_title = security::secureHTML($_POST['gallery_title']);
            $gallery_content = security::secureHTML($_POST['gallery_content']);
            $gallery_img = $_FILES['gallery_img'];

            if (!$gallery_id) {
                throw new Exception("Les données envoyées sont incorrectes");
            } else if (!$gallery_title || !$gallery_content) {
                throw new Exception("Les données envoyées sont incorrectes");
            } else {
                $this->gallerysManager->updateGallery($gallery_id, $gallery_title, $gallery_content, $gallery_img);
                $_SESSION['alert'] = [
                    "message" => "Le plat à été modifié",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/gallerys/visualisation");
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
            $gallery_title = security::secureHTML($_POST['gallery_title']);
            $gallery_content = security::secureHTML($_POST['gallery_content']);
            $gallery_img = "";
            if ($_FILES['gallery_img']['size'] > 0) {
                $folder = "public/images/";
                $gallery_img = addPic($_FILES['gallery_img'], $folder);
            }
            $gallery_id =  $this->gallerysManager->createGallery($gallery_title, $gallery_content, $gallery_img);

            $_SESSION['alert'] = [
                "message" => "Le plat à été créé avec l'identifiant :" . $gallery_id,
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/gallerys/visualisation");
            // var_dump($_POST);
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
}
