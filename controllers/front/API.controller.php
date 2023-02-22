<?php

require_once "models/front/API.manager.php";
require_once "models/Model.php";


class APIController
{
    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new APIManager();
    }

    //************************************************************************
    //API controller pour afficher la carte du restaurant*********************
    public function getProducts()
    {
        $products = $this->apiManager->getDBproducts();
        Model::sendJSON($this->formatDataProductLine($products));
    }
    private function formatDataProductLine($lines)
    {
        $tab = [];
        foreach ($lines as $line) {
            if (!array_key_exists($line['product_id'], $tab)) {
                $tab[$line['product_id']] = [
                    "id" => $line['product_id'],
                    "title" => html_entity_decode($line['title']),
                    "content" => html_entity_decode($line['content']),
                    "category_id" => $line['category_id'],
                    "prix" => $line['prix'],
                    "product_image" => URL . "public/images/" . $line['product_image']
                ];
            }
        }
        return $tab;
    }

    //*******************************************************************
    // API controller pour afficher les photos en page d'accueil*********
    public function getGallerys()
    {
        $gallerys = $this->apiManager->getDBGallery();
        Model::sendJSON($this->formatDataGalleryLine($gallerys));
    }
    private function formatDataGalleryLine($lines)
    {
        $tab = [];
        foreach ($lines as $line) {
            if (!array_key_exists($line['gallery_id'], $tab)) {
                $tab[$line['gallery_id']] = [
                    "gallery_id" => $line['gallery_id'],
                    "gallery_title" => html_entity_decode($line['gallery_title']),
                    "gallery_content" => html_entity_decode($line['gallery_content']),


                    "gallery_img" => URL . "public/images/" . $line['gallery_img']
                ];
            }
        }
        return $tab;
    }

    //***********************************************************
    // API controller pour afficher les clients******************
    public function getClients()
    {
        $clients = $this->apiManager->getDBClient();
        Model::sendJSON($this->formatDataClientsLine($clients));
    }
    private function formatDataClientsLine($lines)
    {
        $tab = [];
        foreach ($lines as $line) {
            if (!array_key_exists($line['client_id'], $tab)) {
                $tab[$line['client_id']] = [
                    "client_id" => $line['client_id'],
                    "username" => html_entity_decode($line['username']),
                    "email" => html_entity_decode($line['email']),
                    "password" => html_entity_decode($line['password'])
                ];
            }
        }
        return $tab;
    }


    //*****************************************************************************
    //Permet de recevoir les messages de la page de contact************************
    //Le Mail arrive dans les spams, test à réaliser avec une adresse du domaine **
    public function sendMessage()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
        header("Content-Type: application/json");

        //decodage de l'information qui est récupéré de la partie front
        //decodage de l'information qui est récupéré de la partie front
        $obj = json_decode(file_get_contents('php://input'));

        $message = isset($obj->message) ? $obj->message : (isset($obj->content) ? $obj->content : '');
        if (!empty($message)) {
            $to = "enzocapi@hotmail.com";
            $subject = "Message du site Le Quai Antique de : " . $obj->name;
            $headers = "From : " . $obj->email;
            mail($to, $subject, $message, $headers);

            $messageReturn = [
                'from' => $obj->email,
                'to' => "enzocapi@hotmail.com"
            ];

            //envoie du retour pour indiqué que c'est traité
            echo json_encode($messageReturn);
        } else {
            // Message vide
            echo json_encode(['error' => 'Message vide']);
        }
    }


    
}
