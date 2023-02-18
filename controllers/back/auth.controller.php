<?php

require_once './models/back/user.manager.php';
$autoloadPath = realpath(__DIR__ . '/../../vendor/autoload.php');
require $autoloadPath;

use Dotenv\Dotenv;

class AuthController
{
    public $secret;
    public $userManager;

    

    public function __construct()
    {
        require_once './config/cors.php';
        // Charge les variables d'environnement depuis le fichier .env
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
        // Accède à la variable d'environnement
        $this->secret = $_ENV['SECRET'];
        $this->userManager = new UserManager();

    }

    public function authenticate()
    {

        require_once './config/cors.php';
        require_once './controllers/back/JWT.controller.php';

        

        $jwt = new JWT();

        // On vérifie la validité
        if (!$jwt->isValid($token)) {
            http_response_code(400);
            echo json_encode(['message' => 'Token invalide']);
            exit;
        }

        // On vérifie la signature
        if (!$jwt->check($token, $this->secret)) {
            http_response_code(403);
            echo json_encode(['message' => 'Le token est invalide']);
            exit;
        }

        // On vérifie l'expiration
        if ($jwt->isExpired($token)) {
            http_response_code(403);
            echo json_encode(['message' => 'Le token a expiré']);
            exit;
        }

        return json_encode($jwt->getPayload($token));
    }
}
