<?php

require "./controllers/back/Security.class.php";
require "./models/back/admin.manager.php";

class AdminController
{
    private $adminManager;

    public function __construct()
    {
        $this->adminManager = new AdminManager();
    }

    public function getPageLogin()
    {
        require_once "views/login.view.php";
    }
    public function connection()
    {
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $login = security::secureHTML($_POST['login']);
            $password = security::secureHTML($_POST['password']);
            if ($this->adminManager->isConnectionValid($login, $password)) {
                $_SESSION['access'] = "admin";
                header('Location: ' . URL . "back/admin");
            } else {
                header('Location:' . URL . "back/login");
            }
        }
    }
    public function getHomeAdmin()
    {
        if (security::verifAccessSession()) {
            require "views/homeAdmin.view.php";
        } else {
            header('Location:' . URL . "back/login");
        }
    }
    public function logout()
    {
        session_destroy();
        header('Location:' . URL . "back/login");
    }
}
