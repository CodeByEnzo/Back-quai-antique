<?php

require_once "./models/back/user.manager.php";
require_once "./controllers/back/auth.controller.php";
require_once "./controllers/back/JWT.controller.php";

class UserController
{

    public function getUserInfo()
    {
        require_once './config/cors.php';

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
        $tokenData = $authController->authenticate();
        $userData = $userManager->getUserByEmail($email);
        $userData = array_merge($userData, $tokenData);

        // Retourner le token et les données utilisateur sous forme d'un unique objet JSON
        $response = array(
            'token' => $token,
            'user' => $userData
        );
        echo json_encode($response);
    }

}
