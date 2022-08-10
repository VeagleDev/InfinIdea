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
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
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
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <!-- TU PEUX FAIRE COMME LE FORMULAIRE DE LOGIN MAIS AVEC PLUS DE CHAMPS -->


<?php
    if( isset($_POST['pseudo']) &&
        isset($_POST['firstname']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['password_confirm']) &&
        isset($_POST['age']) &&
        isset($_POST['avatar']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_confirm = htmlspecialchars($_POST['password_confirm']);
        $age = htmlspecialchars($_POST['age']);
        $avatar = htmlspecialchars($_POST['avatar']);
        if($password != $password_confirm)
        {
            echo register_form($pseudo, $firstname, $email, $password, $password_confirm, $age, $avatar);
            echo '<p style="color:red">Les mots de passe ne correspondent pas</p>';
        }
        else
        {
            $stayConnected = isset($_POST['stayConnected']);
            if(strlen($pseudo) > 24 || strlen($pseudo) < 3)
            {
                echo register_form($pseudo, $firstname, $email, $password, $password_confirm, $age, $avatar);
                echo '<p style="color:red;">Le pseudo doit contenir entre 3 et 24 caractères !</p>';
            }
            else if(strlen($firstname) > 30 || strlen($firstname) < 3)
            {
                echo register_form($pseudo, $firstname, $email, $password, $password_confirm, $age, $avatar);
                echo '<p style="color:red;">Le prénom doit contenir entre 3 et 30 caractères !</p>';
            }
            else if(strlen($email) > 100 || strlen($email) < 4 || !filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                echo register_form($pseudo, $firstname, $email, $password, $password_confirm, $age, $avatar);
                echo '<p style="color:red;">L\'email doit être correcte et contenir entre 3 et 100 caractères !</p>';
            }
            else if(strlen($age) > 2 || strlen($age) < 1)
            {
                echo register_form($pseudo, $firstname, $email, $password, $password_confirm, $age, $avatar);
                echo '<p style="color:red;">L\'age doit contenir entre 1 et 2 caractères !</p>';
            }
            else if(strlen($avatar) > 200 || strlen($avatar) < 3)
            {
                echo register_form($pseudo, $firstname, $email, $password, $password_confirm, $age, $avatar);
                echo '<p style="color:red;">L\'avatar doit contenir entre 3 et 200 caractères !</p>';
            }
            else
            {
                list($ok, $error) = verifyPasswordStrongness($password);
                if(!$ok)
                {
                    echo register_form($pseudo, $firstname, $email, $password, $password_confirm, $age, $avatar);
                    echo '<p style="color:red;">'.$error.'</p>';
                }
                $ret = register($pseudo, $firstname, $email, $password, $age, $avatar);
                echo $ret;

                if($ret = '<p style="color:green">Inscription réussie</p>')
                {
                    $userID = mysqli_insert_id($db);
                    $_SESSION['id'] = $userID;
                    if(isset($_POST['stay_csonnected']))
                    {
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
                    }
                }

            }
        }
    }
    else
    {
        echo register_form();
    }
    ?>
</body>
</html>
