<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->

<!-- PAGE POUR REINITIALISER LE MOT DE PASE -->
<!-- TU FAIS UNE PAGE AVEC DEDANS TOUTES LES ETAPES,
DEMANDE D'EMAIL
DEMANDE DE MOT DE PASSE
CONFIRMATION DE CHANGEMENT DE MOT DE PASSE
-->
<?php
session_start();
require_once 'tools.php';
require_once 'autoconnect.php';
$db = getDB();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProject : Réinitialiser le mot de passe</title>
</head>
<body>
    <h1>MyProject - Réinitialiser le mot de passe</h1>
    <?php
    if(isset($_POST['token']) && isset($_POST['pass']) && isset($_POST['pass2']))
    {
        $token = htmlspecialchars($_POST['token']);
        $pass = htmlspecialchars($_POST['pass']);
        $pass2 = htmlspecialchars($_POST['pass2']);
        if($pass == $pass2)
        {
            $password = hash("sha512", $pass);
            $sql = "SELECT user, expiration FROM tokens WHERE type='pass' AND token='" . $token . "'";
            $result = mysqli_query($db, $sql);
            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_assoc($result);
                $user = $row['user'];
                $expiration = $row['expiration'];
                if($expiration > time())
                {
                    $sql = "UPDATE users SET password='" . $password . "' WHERE id='" . $user . "'";
                    $result = mysqli_query($db, $sql);
                    if($result)
                    {
                        echo "<p style='color: green;'>Votre mot de passe a bien été modifié !</p>";
                    }
                    else
                    {
                        echo "<p style='color: red;'>Une erreur est survenue lors de la modification de votre mot de passe !</p>";
                    }
                }
                else
                {
                    echo "<p style=\"color:red\">Le lien est expiré</p>";
                }
            }
            else
            {
                echo "<p style=\"color:red\">Le lien n'est pas valide</p>";
            }

        }
        else
        {
            echo '<p style="color:red;">Les mots de passe ne correspondent pas !</p>';
        }
    }
    else if(isset($_GET['token']))
    {
        $token = htmlspecialchars($_GET['token']);
        $sql = "SELECT user, expiration FROM tokens WHERE type='pass' AND token='" . $token . "'";
        $result = mysqli_query($db, $sql);
        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_assoc($result);
            $user = $row['user'];
            $expiration = $row['expiration'];
            if($expiration > time())
            {
                ?>
                <form action="forgot.php" method="post">
                    <input type="hidden" name="token" value="<?=$token?>">
                    <input type="password" name="pass" placeholder="Nouveau mot de passe">
                    <input type="password" name="pass2" placeholder="Confirmer le mot de passe">
                    <input type="submit" value="Changer le mot de passe">
                </form>
                <?php
            }
            else
            {
                echo "<p style=\"color:red\">Le lien est expiré</p>";
            }
        }
        else
        {
            echo "<p style=\"color:red\">Le lien n'est pas valide</p>";
        }
    }
    else if(isset($_SESSION['id']))
    {
        echo '<p>Bienvenue ' . getPseudo($_SESSION['id']) . ' sur la page de réinitialisation de votre mot de passe !</p>
        <p style="color:red">Attention, vous êtes connecté, veuillez vous <a href="logout.php">déconnecter</a> pour pouvoir réinitialiser votre mot de passe.</p>';
    }
    else if(isset($_POST['email']))
    {
        $email = htmlspecialchars($_POST['email']);
        // verification de l'email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            echo "<p style='color:red'>L'adresse email n'est pas valide !</p>";
            exit;
        }
        $sql = "SELECT prenom, id FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        if(!$row)
        {
            echo passwordForgotten();
            echo "<p style='color:red'>L'email est inconnue !</p>";
            exit;
        }
        $token = createPassForgotToken($row['id']);
        $to = $email;
        $subject = 'Réinitialisation de votre mot de passe MyProject';
        $message = "Bonjour " . $row['prenom'] . ",\r\n
        Une demande de <i>réinitialisation de mot de passe</i> a été faite sur <b>MyProject</b>.<br />
        Pour <u>réinitialiser votre mot de passe</u>, veuillez cliquer sur le lien suivant :<br />
        https://myproject.mysteriousdev.fr/forgot.php?token=" . $token . " <br />
        Si vous rencontrez un problème, <a href=\"mailto:contact@mysteriousdev.fr\">contactez nous sur notre email</a> <br /> <br />
        Cordialement, <br />
        L'équipe MysteriousDev de MyProject";
        $headers = array();
        $headers[] = 'Content-Type: text/html; charset="UTF-8"';
        $headers[] = 'X-Mailer: PHP/'. phpversion();
        $headers[] = 'From: MyProject <contact@mysteriousdev.fr>';

        if(mail($to, $subject, $message, implode('\r\n', $headers)))
        {
            echo "<p>Un email vous a été envoyé à " . $to . " pour réinitialiser votre mot de passe !</p>
            <p>Si vous n'avez pas reçu d'email, veuillez vérifier dans les spams ou <a href=\"mailto:contact@mysteriousdev.fr\">contactez-nous</a>.</p>";
        }
        else
        {
            echo "<p style='color:red'>Une erreur est survenue lors de l'envoi de l'email !</p>";
        }
    }
    else
    {
        echo passwordForgotten();
    }

    ?>
</body>
</html>
