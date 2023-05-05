<?php
require_once 'models/front/user.manager.php';
$autoloadPath = realpath(__DIR__ . '/../../vendor/autoload.php');
require $autoloadPath;

use Dotenv\Dotenv;

class AuthController
{
    public $secret;
    public $userManager;


    public function __construct()
    {
        // Load environment variable from .env folder
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
        // Accède à la variable d'environnement
        $this->secret = $_ENV['SECRET'];
        $this->userManager = new UserManager();
    }

    public function authenticate()
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
            header("Access-Control-Allow-Credentials: true");
            header("Content-Type: application/json");
            header('Access-Control-Max-Age: 86400');

            require_once "./config/cors.php";

            // Verify if token is in the request
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
            // Verify if string start with "Bearer "
            if (!isset($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches)) {
                return false;
            }
            // Extract token
            $token = str_replace('Bearer ', '', $token);
            require_once 'controllers/front/JWT.controller.php';
            $jwt = new JWT();
            // Verify validity
            if (!$jwt->isValid($token)) {
                http_response_code(400);
                echo json_encode(['message' => 'Token invalide']);
                exit;
            }
            // Verify signature
            if (!$jwt->check($token, $this->secret)) {
                http_response_code(403);
                echo json_encode(['message' => 'Le token est invalide']);
                exit;
            }
            // Verify if expired
            if ($jwt->isExpired($token)) {
                http_response_code(403);
                echo json_encode(['message' => 'Le token a expiré']);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Une erreur s\'est produite.']);
            exit;
        }
    }
}
