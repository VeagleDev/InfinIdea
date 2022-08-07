<?php session_start();
require_once 'tools.php';
require_once 'strings.php';
$db = getDB();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Connexion</h1>

    <!-- JE TE LAISSE FAIRE UN BEAU FORMULAIRE DE CONNEXION AVEC TOUT CE DONT TU AS BESOIN, JE M'ADAPTERAIS
    A CE QUE TU FERA, IL FAUT JUSTE PSEUDO/MDP + RESTER CONNECTÉ -->


    <!-- Pour information, pour que je puisse récupérer des informations, il faut faire un
    formulaire de ce type :
        <form action="login.php" method="post">
        <p>
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo">
        </p>
        <p>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <input type="checkbox" name="stay_connected" id="stay_connected">
            <label for="stay_connected">Rester connecté</label>
        </p>
        <p>
            <input type="submit" value="Se connecter">
        </p>
    </form>
    -->


<?php
    if(isset($_POST['pseudo']) && isset($_POST['password'])) // Si les champs pseudo et password sont remplis
    {
        $user = mysqli_real_escape_string($db, htmlspecialchars($_POST['pseudo'])); // On récupère le pseudo
        $pass = hash("sha512", mysqli_real_escape_string($db, htmlspecialchars($_POST['password']))); // On récupère le mot de passe
        $userID = getID($user); // On récupère l'id de l'utilisateur
        $real = getPassword($userID); // On récupère le mot de passe de l'utilisateur
        echo "Test : " . $real . " - " . $pass;
        if($real == $pass) // Si les mots de passe sont identiques
        {
            // On enregistre ses informations dans la session pour qu'il soit connecté
            $_SESSION['id'] = $userID;
            echo "Session enregistrée";
            $token = createAuthToken($userID); // On crée un jeton d'authentification
            echo "On créé le token";

            echo "Token : " . $token;

            if(isset($_POST['stay_connected'])) // Si l'utilisateur a coché la case "Rester connecté"
            {
                echo "test";

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

            echo "<p style='color: green'>Connexion réussie !</p>"; // On affiche un message de succès
            if(isset($_GET['redirect'])) // Si on a demandé une redirection
            {
                header("Location: ".$_GET['redirect']);
            }
            else
            {
                header("Location: index.php");
            }
        }
        else
        {
            echo login_form();
            echo "<p style='color: red'>Mauvais identifiants !</p>";
        }
    }
    else if(isset($_SESSION['user']))
    {
        echo '<p>Vous êtes déjà connecté en tant que ' . $_SESSION['user'] . '. <a href="logout.php">Se déconnecter</a></p>';
    }
    else
    {
        echo login_form();
    }

    ?>
