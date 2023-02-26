<?php
require_once './controllers/back/JWT.controller.php';



$autoloadPath = realpath(__DIR__ . '/../../vendor/autoload.php');
require $autoloadPath;
use Dotenv\Dotenv;

class LoginManager extends Model
{
    public $secret;
    
    public function __construct()
    {
        // Load variables environement fot .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
        $this->secret = $_ENV['SECRET'];
    }
    
    public function loginUser(string $email, string $password)
    {
        $jwt = new JWT();
        $user = $this->getUserByEmail($email);
        
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Utilisateur introuvable'
            ];
        }
        if (!password_verify($password, $user['password'])) {
            return [
                'status' => 'error',
                'message' => 'Mot de passe incorrect'
            ];
        }
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
        $payload = [
            'email' => $user['email'],
            'username' => $user['username']
        ];
        $token = $jwt->generate($header, $payload, $this->secret);
        return [
            'status' => 'success',
            'message' => 'Connexion réussie',
            'data' => [
                'token' => $token
                ]
            ];
        }
        
        private function getUserByEmail($email)
        {
        $req = "SELECT * FROM clients WHERE email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user;
    }    
}
