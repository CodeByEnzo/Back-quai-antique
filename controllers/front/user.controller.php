<?php

require_once "models/front/user.manager.php";
require_once "controllers/front/auth.controller.php";
require_once "controllers/front/JWT.controller.php";
require_once "controllers/front/TokenPW.php";

// **User signifies the users from React app, do not get confuse with "clients" that can be handle from back end interface**
// **So this code does response to requests from REACT**

// Handle users in REACT
class UserController
{
    private function sendErrorResponse($code, $message)
    {
        http_response_code($code);
        echo json_encode(['message' => $message]);
        exit;
    }

    public function getUserInfo()
    {
        require "./config/cors.php";

        //Get token's user from headers of query
        $headers = getallheaders();
        $token = $headers['Authorization'];

        // Verify if user is authenticated
        $authController = new AuthController();
        $authController->authenticate();

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

        // Verify if user id were successfully retrieved
        if (!$client_id) {
            $this->sendErrorResponse(401, 'Impossible de récupérer les informations de l\'utilisateur');
            exit;
        }
        $client_number = $userData['number'];

        // Merge user's data and reservation in array
        $userInfo = [
            'user' => $userData,
            'reservations' => $userReservations,
        ];

        // Return user's info
        echo json_encode($userInfo);
    }

    public function userUpdateInfo()
    {
        require "./config/cors.php";
        // Get Token from headers
        $headers = getallheaders();
        $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;

        // Check Token
        if (!isset($token) || !preg_match('/^Bearer\s(\S+)/', $token, $matches)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Token introuvable']);
        }

        // Check authentication
        $authController = new AuthController();
        $authController->authenticate();

        $data = json_decode(file_get_contents('php://input'), true);
        $client_id = $data['client_id'] ?? null;
        $email = $data['email'] ?? null;
        $number = $data['number'] ?? null;
        $password = $data['password'] ?? null;
        $username = $data['username'] ?? null;

        if (empty($client_id) || empty($email) || empty($number) || empty($password) || empty($username)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Données incorrectes']);
        }

        $userManager = new UserManager();
        $updateResult = $userManager->UpdateUser($username, $number, $email, $password, $client_id);

        if ($updateResult) {
            $response = [
                'status' => 'success',
                'message' => 'Mise à jour du profil réussie.',
                'client_id' => $client_id,
                'email' => $email,
                'number' => $number,
                'username' => $username
            ];
        } else {
            http_response_code(500);
            $response = ['status' => 'error', 'message' => 'La mise à jour du profil a échoué.'];
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }


    public function register()
    {
        require "./config/cors.php";

        $data = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new Exception('Erreur lors de la lecture des données JSON');
        }

        $username = $data['username'];
        $number = $data['number'];
        $email = $data['email'];
        $password = $data['password'];

        if (empty($username) || empty($number) || empty($email) || empty($password)) {
            throw new Exception('Tous les champs sont requis');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email est invalide');
        }

        $userManager = new UserManager();
        $result = $userManager->registerUser($username, $number, $email, $password);
        echo json_encode($result);
    }


    public function makeReservation()
    {
        require "./config/cors.php";
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
        require "./config/cors.php";

        $data = json_decode(file_get_contents('php://input'), true);
        $client_id = isset($data['client_id']) ? $data['client_id'] : null;
        $reservation_id = isset($data['reservation_id']) ? $data['reservation_id'] : null;

        $userManager = new UserManager();
        $result = $userManager->DeleteReservation($client_id, $reservation_id);
        echo json_encode($result);
    }
    public function UpdateReservation()
    {
        require "./config/cors.php";

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

    //*****************************************************************************
    //Send mail to user including link and token***********************************
    //Mail is going to spam, have to be fix ***************************************
    function forgotPW()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get user's email
            $jsonData = file_get_contents('php://input');
            $emailObject = json_decode($jsonData, true);
            $userEmail = $emailObject['email'];

            if ($userEmail) {
                $userManager = new UserManager();
                $isEmailValid = $userManager->isEmailValid($userEmail);

                if ($isEmailValid) {
                    // Create link with token
                    $TokenPW = new TokenPW;
                    $tokenData = $TokenPW->generateToken();
                    $resetLink = "http://localhost:3000/ResetPW?token=" . $tokenData['token'];

                    // Call function to send mail
                    $sujet = "Réinitialisation de votre mot de passe";
                    $message = "Bonjour,\n\n";
                    $message .= "Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le lien ci-dessous pour procéder à la réinitialisation :\n";
                    $message .= $resetLink . "\n\n";
                    $message .= "Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer ce message.\n\n";
                    $message .= "Cordialement,\nLe Quai Antique";

                    $headers = "From: Info@le-quai-antique.com";

                    // Use mail()
                    $envoiEmail = mail($userEmail, $sujet, $message, $headers);

                    // Check
                    if ($envoiEmail) {
                        echo "E-mail de réinitialisation envoyé avec succès à $userEmail.";
                    } else {
                        echo "Erreur lors de l'envoi de l'e-mail de réinitialisation. Veuillez vérifier les paramètres de configuration du serveur.";
                    }
                } else {
                    echo "L'adresse e-mail n'est pas valide.";
                }
            } else {
                echo "Adresse e-mail invalide.";
            }
        }
    }
}
