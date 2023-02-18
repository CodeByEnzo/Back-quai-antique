<?php
require './models/back/Login.manager.php';

class LoginController
{
    public function login()
    {
        require_once './config/cors.php';
        // Récupération des données envoyées par le client
        $data = json_decode(file_get_contents('php://input'), true);

        // Vérification de la validité des données envoyées
        if (!isset($data['email']) || !isset($data['password'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Les données envoyées sont incorrectes'
            ]);
            exit;
        }

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Les champs email et mot de passe sont requis'
            ]);
            exit;
        }

        // Tentative de connexion de l'utilisateur
        $loginManager = new LoginManager();

        $result = $loginManager->loginUser($email, $password);

        // Envoi de la réponse au client
        echo json_encode($result);
    }
}
