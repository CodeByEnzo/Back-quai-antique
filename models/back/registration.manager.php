<?php

require_once 'models/Model.php';

class RegistrationManager extends Model
{
    public function registerUser($username, $email, $password)
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
            $stmt = $pdo->prepare('INSERT INTO clients (username, email, password) VALUES (:username, :email, :password)');
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $passwordHash]);
            return ['status' => 'success'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
            print_r($e);
        }
    }
}
