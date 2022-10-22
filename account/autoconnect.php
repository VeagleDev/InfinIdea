<?php
set_include_path('/var/www/blog'); // On définit le chemin d'accès aux fichiers
require_once 'tools/tools.php'; // On inclut les outils

$db = getDB(); // On récupère la base de données

function connectViaCookie(mysqli $db) // On définit la fonction qui sert à se connecter grâce aux cookies
{
    $token = htmlspecialchars($_COOKIE['token']); // On récupère le token
    $query = "SELECT id, user, expiration FROM tokens WHERE token = '$token'"; // On prépare la requête
    $result = mysqli_query($db, $query); // On exécute la requête
    if (!$result) {
        return false;
    }
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $ts = $row['expiration']; // On récupère la date d'expiration
        $user = $row['user']; // On récupère l'utilisateur
        logs('connexion automatique', 'utilisateur se connecte grâce au cookie', $user); // On log l'action
        updateUserIP($user); // On met à jour l'IP de l'utilisateur
        if ($ts > time()) // Si la date d'expiration est supérieure à la date actuelle
        {
            $_SESSION['id'] = $user;
            setcookie( // On actualise le cookie
                'token', // Le nom du cookie
                $token, // Son contenu
                [
                    'expires' => time() + 15 * 24 * 3600, // On dit qu'il expire dans 15 jours
                    'secure' => true, // On dit que le cookie est sécurisé
                    'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
                    'path' => '/',
                ]
            );
        }
    }
}

if (session_status() == PHP_SESSION_NONE) // Si la session n'est pas démarrée
{
    session_start(); // On la démarre
}

if(isset($_COOKIE['token'])) // Si on a un cookie et qu'on est pas connecté
{
    connectViaCookie($db); // On se connecte grâce au cookie
}

if(isset($_SESSION['id']))
{
    updateUserIP($_SESSION['id']);
}




