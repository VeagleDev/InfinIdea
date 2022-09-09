<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->



<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}

require_once 'autoconnect.php';
require_once 'tools/tools.php';
require_once 'tools/strings.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

<?php
    $db = getDB();
    if(isset($_SESSION['id']))
    {
        logs('login', 'utilisateur connecte essaie de se login', $_SESSION['id']);
        if(isset($_GET['redirect'])) // Si on a demandé une redirection
        {
            header('Location: ' .$_GET['redirect']);
        }
        else
        {
            header('Location: /');
        }
    }
    elseif(isset($_POST['pseudo']) && isset($_POST['password'])) // Si les champs pseudo et password sont remplis
    {
        $user = mysqli_real_escape_string($db, htmlspecialchars($_POST['pseudo'])); // On récupère le pseudo
        $pass = hash('sha512', mysqli_real_escape_string($db, htmlspecialchars($_POST['password']))); // On récupère le mot de passe
        $userID = getID($user); // On récupère l'id de l'utilisateur
        if($userID == -1)
        {
            echo "<p style='color: red'>Utilisateur inconnu !</p>";
            logs('login', 'utilisateur essaye de se connecter avec un pseudo inconnu', 0);
        }
        else
        {
            $real = getPasswordbyUser($user); // On récupère le mot de passe de l'utilisateur
            if($real == $pass) // Si les mots de passe sont identiques
            {
                // On enregistre ses informations dans la session pour qu'il soit connecté
                $_SESSION['id'] = $userID;
                $token = createAuthToken($userID); // On crée un jeton d'authentification
                if(isset($_POST['stay_connected'])) // Si l'utilisateur a coché la case "Rester connecté"
                {
                    setcookie( // On crée un cookie
                        'token', // Le nom du cookie
                        $token, // Son contenu
                        [
                            'expires' => time() + 15*24*3600, // On dit qu'il expire dans 15 jours
                            'secure' => true, // On dit que le cookie est sécurisé
                            'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
                        ]
                    );
                }
                else // Sinon
                {
                    setcookie( // On crée un cookie
                        'token', // Le nom du cookie
                        'NONE', // Son contenu
                        [
                            'expires' => time() + 15*24*3600, // On dit qu'il expire dans 15 jours
                            'secure' => true, // On dit que le cookie est sécurisé
                            'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
                        ]
                    );
                }
                logs('login', 'utilisateur connecte', $userID);

                if(isset($_GET['redirect'])) // Si on a demandé une redirection
                {
                    header('Location: ' .$_GET['redirect']);
                }
                else
                {
                    header('Location: /');
                }
            }
            else
            {
                echo login_form();
                echo "<p style='color: red'>Mot de passe incorrect !</p>";
                logs('login', 'utilisateur essaye de se connecter avec un mdp incorrect', $userID);
            }
        }

    }
    else
    {
        echo login_form();

    }

    ?>
