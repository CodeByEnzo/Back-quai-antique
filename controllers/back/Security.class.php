<?php
// Verify form and if user has administrator access to let him access of rest application
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
