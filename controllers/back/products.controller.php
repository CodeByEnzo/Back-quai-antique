<?php

require_once "controllers/back/Security.class.php";
require_once "models/back/products.manager.php";
require_once "controllers/back/utile.php";

class productsController
{
    private $productsManager;

    public function __construct()
    {
        $this->productsManager = new productsManager();
    }
    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $products = $this->productsManager->getProducts();
            require_once "views/productsVisualisation.view.php";
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

            $this->productsManager->deleteDBproduct((int) security::secureHTML($_POST['product_id']));
            header('Location: ' . URL . 'back/products/visualisation');
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (
            isset($_POST['product_id']) && !empty($_POST['product_id']) &&
            isset($_POST['title']) && !empty($_POST['title']) &&
            isset($_POST['content']) && !empty($_POST['content']) &&
            isset($_POST['prix']) && !empty($_POST['prix']) &&
            isset($_POST['category_id']) && !empty($_POST['category_id'])
        ) {
            // var_dump($_POST);

            $product_id = intval($_POST['product_id']);
            $title = filter_var($_POST['title']);
            $content = filter_var($_POST['content']);
            $prix = intval($_POST['prix']);
            $category_id = intval($_POST['category_id']);

            $this->productsManager->updateProduct($product_id, $title, $content, $prix, $category_id);

            $_SESSION['alert'] = [
                "message" => "Le plat à été modifié",
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/products/visualisation");
        } else {
            throw new Exception("Les données envoyées sont incorrectes");
        }
    }
    public function creationTemplate()
    {
        if (security::verifAccessSession()) {
            require_once "views/productCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
    public function creationValidation()
    {
        if (security::verifAccessSession()) {
            $title = security::secureHTML($_POST['title']);
            $content = security::secureHTML($_POST['content']);
            $prix = security::secureHTML($_POST['prix']);
            $category_id = security::secureHTML($_POST['category_id']);

            $product_id =  $this->productsManager->createProduct($title, $content, $prix, $category_id);

            $_SESSION['alert'] = [
                "message" => "Le plat à été créé avec l'identifiant :" . $product_id,
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/products/visualisation");
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }
}
