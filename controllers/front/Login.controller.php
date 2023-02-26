<?php
require 'models/front/Login.manager.php';

class LoginController
{
    public function login()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        header('Access-Control-Max-Age: 86400');
        // Get data sent by user
        $data = json_decode(file_get_contents('php://input'), true);

        // Verify validity of data sent
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
