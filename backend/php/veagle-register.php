<?php

set_include_path('/var/www/blog'); // On définit le chemin d'accès aux fichiers
if (session_status() == PHP_SESSION_NONE) { // Si la session n'est pas démarrée
    session_start(); // On démarre la session AVANT toute chose

    require_once 'tools/tools.php'; // On inclut le fichier tools.php
    logs('Tente de se créer un compte'); // On log l'action

    if (
        isset($_POST['pseudo']) && // Si le pseudo est défini
        isset($_POST['prenom']) && // Si le prénom est défini
        isset ($_POST['mail']) && // Si l'email est défini
        isset($_POST['password']) // Si le mot de passe est défini
    ) {
        $pseudo = SQLpurify($_POST['pseudo']); // On récupère le pseudo
        $surname = SQLpurify($_POST['prenom']); // On récupère le prénom
        $email = SQLpurify($_POST['mail']); // On récupère l'email
        $password = SQLpurify($_POST['password']); // On récupère le mot de passe

        // Faudra vérifier le Regex

        $password = hash('sha512', $password); // On hash le mot de passe avec sha512

        $sql = "SELECT * FROM users WHERE pseudo = '$pseudo' OR email = '$email'"; // On prépare la requête
        $db = getDB(); // On récupère la base de données
        $result = mysqli_query($db, $sql); // On exécute la requête
        if (mysqli_affected_rows($db) > 0) { // Si l'utilisateur existe
            $row = mysqli_fetch_assoc($result); // On récupère les données de l'utilisateur
            if ($row['email'] == $email) { // Si l'email est déjà utilisé
                echo '2'; // On renvoie 2
                die(); // On arrête le script
            }
            if ($row['pseudo'] == $pseudo) { // Si le pseudo est déjà utilisé
                echo '3'; // On renvoie 3
                die(); // On arrête le script
            } else { // Si l'email et le pseudo sont déjà utilisés
                echo '4'; // On renvoie 4
                die(); // On arrête le script
            }
        }
        $ip = getIP(); // On récupère l'adresse IP de l'utilisateur
        $sql = "INSERT INTO users(pseudo, prenom, email, accessor, password, ip)  
            VALUES ('$pseudo', '$surname', '$email', 'veagleconnect', '$password', '$ip')"; // On prépare la requête
        $result = mysqli_query($db, $sql); // On exécute la requête
        if ($result) { // Si la requête s'est bien exécutée
            $_SESSION['id'] = mysqli_insert_id($db); // On stocke l'id de l'utilisateur dans la session
            logs('Utilisateur créé'); // On log l'action
            echo '0'; // On renvoie 0

            // Ajouter un bouton pour savoir si il veut rester connecté ou pas
            // Pour l'instant on le fait tt le temps

            $token = createAuthToken($_SESSION['id'], $db); // On crée un jeton d'authentification
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


        } else {
            echo '1';
        }


    }
}