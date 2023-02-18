<?php

require_once "./models/back/user.manager.php";
require_once "./controllers/back/auth.controller.php";

class UserController
{

    public function getUserInfo()
    {
        require_once './config/cors.php';

        // Vérifier si l'utilisateur est authentifié
        $auth_controller = new AuthController();
        $user_id = $auth_controller->authenticate();

        if ($user_id !== false) {
            // Si l'utilisateur est authentifié, récupérer ses informations
            $user_manager = new UserManager();
            $user_info = $user_manager->getUserByEmail($user_id);

            // Retourner les informations de l'utilisateur en JSON
            header('Content-Type: application/json');
            echo json_encode($user_info);
        } else {
            // Si l'utilisateur n'est pas authentifié, retourner une erreur 401 Unauthorized
            header('HTTP/1.0 401 Unauthorized');
            echo 'Unauthorized';
        }
    }
}
