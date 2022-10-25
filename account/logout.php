<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';

if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}


if(session_status() == PHP_SESSION_ACTIVE)
{
    logs('L\'utilisateur se déconnecte');
    session_destroy(); // On détruit la session
    session_unset(); // On détruit les variables de session
    $_SESSION = []; // On détruit les variables de session
}

setcookie( // On supprime le cookie
    'token',
    'NONE',
    [
        'expires' => time() + 15 * 24 * 3600, // On dit qu'il expire dans 15 jours
        'secure' => true, // On dit que le cookie est sécurisé
        'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
        'path' => '/',
    ]
);

header('Location: /'); // On redirige l'utilisateur vers la page d'accueil