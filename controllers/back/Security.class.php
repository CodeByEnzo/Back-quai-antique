<?php
// permet de verifier le formulaire et de verifier que l'utilisateur dispose des accés administrateur pour accéder aux différentes page
class security
{
    public static function secureHTML($string)
    {
        return htmlentities($string);
    }
    public static function verifAccessSession()
    {
        return (!empty($_SESSION['access']) && $_SESSION['access'] === "admin");
    }
}
