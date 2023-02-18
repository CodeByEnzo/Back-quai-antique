<?php

require_once "./models/back/user.manager.php";
require_once "./controllers/back/auth.controller.php";

class UserController
{
    
    public function getUserInfo()
    {

        require_once './config/cors.php';
        // On interdit toute méthode qui n'est pas POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['message' => 'Méthode non autorisée']);
            exit;
        }

        // On vérifie si on reçoit un token
        if (isset($_SERVER['Authorization'])) {
            $token = trim($_SERVER['Authorization']);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $token = trim($_SERVER['HTTP_AUTHORIZATION']);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            if (isset($requestHeaders['Authorization'])) {
                $token = trim($requestHeaders['Authorization']);
            }
        }

        // On vérifie si la chaine commence par "Bearer "
        if (!isset($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            http_response_code(400);
            echo json_encode(['message' => 'Token introuvable']);
            exit;
        }

        // Récupérer le token envoyé depuis le front-end (React)
        $token = $_POST['token'];

        // Instancier un objet de la classe AuthController
        $authController = new AuthController();

        // Appeler la fonction authenticate avec le token en argument
        $userData = $authController->authenticate($token);

        // Récupérer l'e-mail de l'utilisateur
        $email = $userData['email'];

        // Instancier un nouvel objet UserManager
        $userManager = new UserManager();

        // Récupérer les informations de l'utilisateur à partir de son e-mail
        $userInfo = $userManager->getUserByEmail($email);

        // Retourner les informations de l'utilisateur sous forme de tableau
        echo $userInfo;
    }
}
