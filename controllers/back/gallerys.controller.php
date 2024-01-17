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
            // print_r($gallerys);
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
        if (
            isset($_POST['gallery_id']) &&
            isset($_POST['gallery_title']) &&
            isset($_POST['gallery_content']) &&
            isset($_FILES['gallery_img'])
        ) {
            $gallery_id = filter_var($_POST['gallery_id'], FILTER_VALIDATE_INT);
            $gallery_title = htmlspecialchars($_POST['gallery_title'], ENT_QUOTES, 'UTF-8');
            $gallery_content = htmlspecialchars($_POST['gallery_content'], ENT_QUOTES, 'UTF-8');
            $gallery_img = $_FILES['gallery_img'];

            if (!$gallery_id) {
                throw new Exception("Les données envoyées sont incorrectes : gallery_id doit être un entier valide.");
            } else if (!$gallery_title || !$gallery_content) {
                throw new Exception("Les données envoyées sont incorrectes : title, content ne peuvent pas être vides.");
            } else {
                $this->gallerysManager->updateGallery($gallery_id, $gallery_title, $gallery_content, $gallery_img);
                $_SESSION['alert'] = [
                    "message" => "Le plat à été modifié",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/gallerys/visualisation");
            }
        } else {
            throw new Exception("Les données envoyées sont incorrectes : gallery_id, gallery_title, gallery_content, gallery_img doivent être définis.");
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
