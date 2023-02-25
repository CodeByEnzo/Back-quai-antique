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
        // Charge les variables d'environnement depuis le fichier .env
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
        // Accède à la variable d'environnement
        $this->secret = $_ENV['SECRET'];
        $this->userManager = new UserManager();
    }

    public function authenticate()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");

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

        // On extrait le token
        $token = str_replace('Bearer ', '', $token);

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

    }
}
