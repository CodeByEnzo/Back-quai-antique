<?php

require_once "models/front/user.manager.php";
require_once "controllers/front/auth.controller.php";
require_once "controllers/front/JWT.controller.php";

// Handle users in REACT
class UserController
{
    public function getUserInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
            header("Access-Control-Allow-Credentials: true");
            header("Content-Type: application/json");
            header('Access-Control-Max-Age: 86400');
            http_response_code(200);
            exit();
        }

        // Vérify if user is authenticated
        $authController = new AuthController();
        $authController->authenticate();

        //Get token's user from headers of query
        $headers = getallheaders();
        $token = $headers['Authorization'];

        //Decode token to get the payload and extract user's email
        $jwt = new JWT();
        $payload = $jwt->getPayload($token);
        $email = $payload['email'];

        // Get user's info matches the email
        $userManager = new UserManager();
        $userData = $userManager->getUserByEmail($email);

        // Get user's reservation matches the id
        $client_id = $userData['id'];
        $userReservations = $userManager->getUserReservations($client_id);

        // Merge user's data and reservation in array
        $userInfo = [
            'user' => $userData,
            'reservations' => $userReservations
        ];

        echo json_encode($userInfo);
    }

    public function register()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        header('Access-Control-Max-Age: 86400');


        //Recupère les données
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        if (empty($username) || empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => "Tous les champs sont requis"]);
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => "Email est invalide"]);
            exit;
        }
        if (strlen($password) < 8) {
            echo json_encode(['status' => 'error', 'message' => "Le mot de passe doit contenir au moins 8 caractères"]);
            exit;
        }

        $userManager = new UserManager();
        $result = $userManager->registerUser($username, $email, $password);
        echo json_encode($result);
    }

    public function makeReservation()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        header('Access-Control-Max-Age: 86400');

        $data = json_decode(file_get_contents('php://input'), true);
        $date = isset($data['date']) ? $data['date'] : null;
        $time = isset($data['time']) ? $data['time'] : null;
        $number_of_people = isset($data['number_of_people']) ? $data['number_of_people'] : null;
        $comment = isset($data['comment']) ? $data['comment'] : null;
        $client_id = isset($data['client_id']) ? $data['client_id'] : null;

        $userManager = new UserManager();
        $result = $userManager->reservation($date, $time, $number_of_people, $comment, $client_id);
        echo json_encode($result);
    }
    public function DeleteReservation()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        header('Access-Control-Max-Age: 86400');

        $data = json_decode(file_get_contents('php://input'), true);
        $client_id = isset($data['client_id']) ? $data['client_id'] : null;
        $reservation_id = isset($data['reservation_id']) ? $data['reservation_id'] : null;

        $userManager = new UserManager();
        $result = $userManager->DeleteReservation($client_id, $reservation_id);
        echo json_encode($result);
    }
    public function UpdateReservation()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        header('Access-Control-Max-Age: 86400');

        $data = json_decode(file_get_contents('php://input'), true);
        $client_id = isset($data['client_id']) ? $data['client_id'] : null;
        $reservation_id = isset($data['reservation_id']) ? $data['reservation_id'] : null;
        $date = isset($data['date']) ? $data['date'] : null;
        $time = isset($data['time']) ? $data['time'] : null;
        $number_of_people = isset($data['number_of_people']) ? $data['number_of_people'] : null;
        $comment = isset($data['comment']) ? $data['comment'] : null;

        $userManager = new UserManager();
        $result = $userManager->UpdateReservation($client_id, $reservation_id, $date, $time, $number_of_people, $comment);
        echo json_encode($result);
    }
}
