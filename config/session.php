<?php
session_start();

// Les paramètres de durée de vie de la session et de l'emplacement du stockage des données de session
$session_lifetime = 3600; // Durée de vie de la session en secondes
ini_set('session.gc_maxlifetime', $session_lifetime);
session_set_cookie_params($session_lifetime);

// L'emplacement de stockage des données de session
session_save_path(__DIR__ . '/sessions');
