<?php
set_include_path('/var/www/blog'); // On définit le chemin d'accès aux fichiers
if (session_status() == PHP_SESSION_NONE) { // Si la session n'est pas démarrée
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'tools/tools.php'; // On inclut le fichier tools.php
require_once 'vendor/autoload.php'; // On inclut le fichier autoload.php


$db = getDB(); // On récupère la base de données

logs('Inconnu tente de se connecter'); // On log l'action

if (isset($_POST['email']) && isset($_POST['password'])) { // Si l'email et le mot de passe sont définis
    $email = SQLpurify($_POST['email']); // On récupère l'email
    $password = SQLpurify($_POST['password']); // On récupère le mot de passe
    $password = hash('sha512', $password); // On hash le mot de passe
    $sql = "SELECT id, pseudo, prenom, email, password FROM users WHERE email = '$email'"; // On prépare la requête
    $result = mysqli_query($db, $sql); // On exécute la requête
    if (mysqli_affected_rows($db) == 1) { // Si l'utilisateur existe
        $row = mysqli_fetch_assoc($result); // On récupère les données de l'utilisateur
        if ($password == $row['password']) { // Si le mot de passe est correct
            $_SESSION['id'] = $row['id']; // On stocke l'id de l'utilisateur dans la session
            echo "0"; // On renvoie 0
            logs('Utilisateur se connecte'); // On log l'action

            // Faire en sorte qu'on puisse choisir de rester connecté ou pas
            $token = createAuthToken($row['id'], $db); // On crée un jeton d'authentification
            if (isset($_POST['stay_connected']) or true) // Si l'utilisateur a coché la case "Rester connecté"
            {
                setcookie( // On crée un cookie
                    'token', // Le nom du cookie
                    $token, // Son contenu
                    [
                        'expires' => time() + 15 * 24 * 3600, // On dit qu'il expire dans 15 jours
                        'secure' => true, // On dit que le cookie est sécurisé
                        'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
                    ]
                );
            }


        } else { // Si le mot de passe est incorrect
            echo "1"; // On renvoie 1
        }
    } else { // Si l'utilisateur n'existe pas
        echo "2"; // On renvoie 2
    }
} else { // Si l'email ou le mot de passe n'est pas défini
    echo "3"; // On renvoie 3
}
