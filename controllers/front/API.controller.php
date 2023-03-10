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

    //************************************************************************
    //API controller pour afficher les horraires du restaurant*********************
    public function getHours()
    {
        $hours = $this->apiManager->getDBHours();
        Model::sendJSON($this->formatDataHoursLine($hours));
    }
    private function formatDataHoursLine($lines)
    {
        $tab = [];
        foreach ($lines as $line) {
            if (!array_key_exists($line['id'], $tab)) {
                $tab[$line['id']] = [
                    "id" => $line['id'],
                    "day_of_week" => html_entity_decode($line['day_of_week']),
                    "lunch_opening_time" => html_entity_decode($line['lunch_opening_time']),
                    "lunch_closing_time" => html_entity_decode($line['lunch_closing_time']),
                    "dinner_opening_time" => html_entity_decode($line['dinner_opening_time']),
                    "dinner_closing_time" => html_entity_decode($line['dinner_closing_time']),
                ];
            }
        }
        return $tab;
    }

    //*****************************************************************************
    //Permet de recevoir les messages de la page de contact************************
    //Le Mail arrive dans les spams, test ?? r??aliser avec une adresse du domaine **
    public function sendMessage()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
        header("Content-Type: application/json");

        //decodage de l'information qui est r??cup??r?? de la partie front
        //decodage de l'information qui est r??cup??r?? de la partie front
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

            //Send success return
            echo json_encode($messageReturn);
        } else {
            // Message empty
            echo json_encode(['error' => 'Message vide']);
        }
    }


    
}
