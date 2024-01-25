<?php
//This file is the model of users from back office*****
//*****************************************************
require_once "models/Model.php";
class clientsManager extends Model
{
    public function getClients()
    {
        $req = "SELECT * from clients";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $clients;
    }

    public function deleteDBclient($client_id)
    {
        $req = "DELETE FROM clients WHERE client_id= :client_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function updateClient($client_id, $username, $number, $email)
    {
        try {
            $req = "SELECT * FROM clients WHERE client_id = :client_id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
            $stmt->execute();

            // Vérify if client id exist
            if ($stmt->rowCount() === 0) {
                throw new Exception("Aucun client trouvé avec cet ID");
            }


            $req = "UPDATE clients SET username = :username, number = :number, email = :email
            WHERE client_id= :client_id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":client_id", $client_id, PDO::PARAM_INT);
            $stmt->bindValue(":username", $username, PDO::PARAM_STR);
            $stmt->bindValue(":number", $number, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $e) {
            // save info about error
            error_log($e->getMessage());

            // Notify client
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            // or with custom message
            echo $e->getMessage();
        }
    }


    public function createClient($username, $number, $email, $password)
    {
        if (strlen($password) < 8) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
        }

        if (!preg_match("#[A-Z]+#", $password)) {
            throw new Exception("Le mot de passe doit contenir au moins une majuscule");
        }

        if (!preg_match("#\W+#", $password)) {
            throw new Exception("Le mot de passe doit contenir au moins un caractère spécial");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $req = "INSERT INTO clients (username, number, email, password)
            VALUES (:username, :number, :email, :password)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":number", $number, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $hashedPassword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->getBdd()->lastInsertId();
        } else {
            throw new Exception("Une erreur est survenue lors de la création du client, veuillez réessayer plus tard.");
        }
    }
}
