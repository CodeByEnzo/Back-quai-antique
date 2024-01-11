<?php
require 'models/front/Login.manager.php';

class LoginController
{
    public function login()
    {
        require "./config/cors.php";

        // Get datas
        $data = json_decode(file_get_contents('php://input'), true);

        // Verify if data is sent
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

        // Try to connect user
        $loginManager = new LoginManager();

        $result = $loginManager->loginUser($email, $password);

        // Send response to user
        echo json_encode($result);
    }
}
