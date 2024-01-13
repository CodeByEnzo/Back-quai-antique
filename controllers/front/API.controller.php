<?php

require_once "models/front/API.manager.php";
require_once "models/Model.php";
require_once "controllers/front/TokenPW.php";

class APIController
{

    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new APIManager();
    }

    //*************************************************************
    //API controller to show restaurant's menu*********************
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
    // API controller to display pictures on home page*******************
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
    //API controller to show open hours of restaurant*************************
    public function getHours()
    {
        require "./config/cors.php";

        $hours = $this->apiManager->getDBHours();
        Model::sendJSON($this->formatDataHoursLine($hours));
    }
    private function formatDataHoursLine($lines)
    {
        require "./config/cors.php";
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

    //************************************************************************
    //API controller to show infos about restaurant***************************
    public function getCompanyInfo()
    {
        require "./config/cors.php";

        $companyInfo = $this->apiManager->getDBCompanyInfo();
        Model::sendJSON($this->formatDataCompanyInfoLine($companyInfo));
    }
    private function formatDataCompanyInfoLine($lines)
    {
        $tab = [];
        foreach ($lines as $line) {
            if (!array_key_exists($line['id'], $tab)) {
                $tab[$line['id']] = [
                    "id" => $line['id'],
                    "name" => html_entity_decode($line['name']),
                    "adress" => html_entity_decode($line['adress']),
                    "phone" => html_entity_decode($line['phone']),
                    "email" => html_entity_decode($line['email'])
                ];
            }
        }
        return $tab;
    }

    //*****************************************************************************
    //To get messages from contact page********************************************
    //Mail is going to spam, have to be fix ***************************************
    public function sendMessage()
    {
        require "./config/cors.php";
        $obj = json_decode(file_get_contents('php://input'));
        $message = $obj->message ?? $obj->content ?? '';
        if (!empty($message)) {
            $to = "webmaster@ec-bootstrap.com";
            $subject = "Message du site Le Quai Antique de : " . $obj->name;
            $headers = "From: webmaster@ec-bootstrap.com\r\n";
            $headers .= "Reply-To: " . $obj->email . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $html_message = sprintf(
                "<html>
                <body>
                <h2>Nouveau message de formulaire de contact</h2>
                <p><strong>Nom :</strong> %s</p>
                <p><strong>Email :</strong> %s</p>
                <p><strong>Message :</strong></p>
                <p>%s</p>
                </body>
                </html>",
                htmlspecialchars($obj->name),
                htmlspecialchars($obj->email),
                nl2br(htmlspecialchars($message))
            );

            // Vérifier si l'envoi de l'email a réussi
            if (mail($to, $subject, $html_message, $headers)) {
                $messageReturn = [
                    'from' => $obj->email,
                    'to' => "webmaster@ec-bootstrap.com"
                ];

                // Envoyer un retour de succès
                echo json_encode($messageReturn);
            } else {
                // Erreur lors de l'envoi de l'email
                echo json_encode(['error' => 'Erreur lors de l\'envoi de l\'email']);
            }
        } else {
            // Message vide
            echo json_encode(['error' => 'Message vide']);
        }
    }
}
