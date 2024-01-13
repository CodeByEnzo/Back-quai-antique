<?php
require_once "models/Model.php";

class UserManager extends Model
{

    public function getUserByEmail($email)
    {
        $db = $this->getBdd();
        $req = $db->prepare('SELECT * FROM clients WHERE email = ?');
        $req->execute(array($email));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        if (is_array($data)) {
            $userData = [
                'id' => $data['client_id'],
                'email' => $data['email'],
                'username' => $data['username'],
                'number' => $data['number'],
                'created_at' => $data['created_at'],
            ];
            return $userData;
        } else {
            return null;
        }
    }

    public function UpdateUser($username, $number, $email, $password, $client_id)
    {
        // Validation des données
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = ['status' => 'error', 'message' => 'Adresse email invalide'];
        } else {
            $db = $this->getBdd();
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Préparation de la requête
            $stmt = $db->prepare("UPDATE clients 
            SET username = :username, number = :number, email = :email, password = :password 
            WHERE client_id = :client_id");

            if ($stmt) {
                $stmt->bindValue(":username", $username, PDO::PARAM_STR);
                $stmt->bindValue(":number", $number, PDO::PARAM_STR);
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                $stmt->bindValue(":password", $passwordHash, PDO::PARAM_STR);
                $stmt->bindValue(":client_id", $client_id, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        // La mise à jour a réussi
                        return true;
                    } else {
                        // Aucun enregistrement mis à jour
                        return false;
                    }
                } else {
                    // La mise à jour a échoué
                    return false;
                }
            }
        }

        // Convertir la réponse en JSON
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function getUserReservations($client_id)
    {
        $db = $this->getBdd();
        $req = $db->prepare('SELECT * FROM reservations WHERE client_id = ?');
        $req->execute(array($client_id));
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data ? $data : [];
    }

    public function registerUser($username, $number, $email, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $pdo = $this->getBdd();
            $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            if ($user) {
                return ['status' => 'error', 'message' => "Cet utilisateur existe déjà"];
            }
            $stmt = $pdo->prepare('INSERT INTO clients (username, number, email, password) VALUES (:username, :number, :email, :password)');
            $stmt->execute(['username' => $username, 'email' => $email, 'number' => $number, 'password' => $passwordHash]);
            return ['status' => 'success'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
            print_r($e);
        }
    }

    public function reservation($date, $time, $number_of_people, $comment, $client_id)
    {
        $pdo = $this->getBdd();
        $req = $pdo->prepare("INSERT INTO reservations (date, time, number_of_people, comments, client_id) 
                          VALUES (:date, :time, :number_of_people, :comment, :client_id)");
        $req->bindValue(":date", $date, PDO::PARAM_STR);
        $req->bindValue(":time", $time, PDO::PARAM_STR);
        $req->bindValue(":number_of_people", $number_of_people, PDO::PARAM_INT);
        $req->bindValue(":comment", $comment, PDO::PARAM_STR);
        $req->bindValue(":client_id", $client_id, PDO::PARAM_INT);

        if ($req->execute()) {
            return ['status' => 'success'];
        } else {
            throw new Exception("Une erreur est survenue lors de la réservation, veuillez réessayer plus tard.");
        }
    }

    public function DeleteReservation($client_id, $reservation_id)
    {
        $req = "DELETE FROM reservations WHERE client_id= :client_id AND reservation_id = :reservation_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
        $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        if ($stmt->execute()) {
            return ['status' => 'success'];
        } else {
            throw new Exception("Une erreur est survenue lors de l'annulation de la réservation, veuillez réessayer plus tard.");
        }
    }

    public function UpdateReservation($client_id, $reservation_id, $date, $time, $number_of_people, $comments)
    {
        $req = "UPDATE reservations 
        SET date = :date, time = :time, number_of_people = :number_of_people, comments = :comments 
        WHERE reservation_id = :reservation_id 
        AND client_id = :client_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":reservation_id", $reservation_id, PDO::PARAM_INT);
        $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
        $stmt->bindValue(":date", $date, PDO::PARAM_STR);
        $stmt->bindValue(":time", $time, PDO::PARAM_STR);
        $stmt->bindValue(":number_of_people", $number_of_people, PDO::PARAM_INT);
        $stmt->bindValue(":comments", $comments, PDO::PARAM_STR);
        $stmt->execute();

        $stmt->closeCursor();

        if ($stmt->rowCount() > 0) {
            return ['status' => 'success'];
        } else {
            return ['error' => "Une erreur est survenue lors de la modification de la réservation, veuillez réessayer plus tard."];
        }
    }

    public function isEmailValid($email)
    {
        try {
            // Check email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            $req = "SELECT email FROM clients WHERE email = :email";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            $count = $stmt->fetchColumn();

            $stmt->closeCursor();

            return $count > 0;
        } catch (PDOException $e) {
            // Log ou gestion de l'erreur
            error_log("Erreur lors de la vérification de l'e-mail : " . $e->getMessage());
            return false;
        }
    }
    public function pushToken($email, $token)
    {
        try {
            $req = "UPDATE clients SET token = :token WHERE email = :email";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(':token', $token, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du token en base de données : " . $e->getMessage());
            return false;
        }
    }
    /**
     * Update user password
     *
     * @param string $email    user email
     * @param string $password   new password
     *
     * @return bool return bool
     */
    public function resetPWmanager($email, $password)
    {
        try {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $req = "UPDATE clients SET password = :password WHERE email = :email";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du mot de passe en base de données : " . $e->getMessage());
            return false;
        }
    }
}
