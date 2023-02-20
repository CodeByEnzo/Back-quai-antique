<?php

require_once "./models/back/user.manager.php";
require_once "./controllers/back/auth.controller.php";
require_once "./controllers/back/JWT.controller.php";


class UserController
{

    public function getUserInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
            header("Access-Control-Allow-Credentials: true");
            header("Content-Type: application/json");
            header('Access-Control-Max-Age: 86400');
            http_response_code(200);
            exit();
        }

        // Vérifier que l'utilisateur est authentifié
        $authController = new AuthController();
        $authController->authenticate();

        // Récupérer le token de l'utilisateur depuis les en-têtes de la requête
        $headers = getallheaders();
        $token = $headers['Authorization'];

        // Décoder le token pour obtenir le payload et extraire l'email de l'utilisateur
        $jwt = new JWT();
        $payload = $jwt->getPayload($token);
        $email = $payload['email'];

        // Récupérer les informations utilisateur correspondantes à l'email
        $userManager = new UserManager();
        $userData = $userManager->getUserByEmail($email);

        // Récupérer les réservations de l'utilisateur correspondant à son ID
        $userId = $userData['id'];
        $userReservations = $userManager->getUserReservations($userId);

        // Combiner les données utilisateur et les réservations dans un tableau
        $userInfo = [
            'user' => $userData,
            'reservations' => $userReservations
        ];

        echo json_encode($userInfo);
    }
}
