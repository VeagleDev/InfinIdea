<?php
set_include_path('/var/www/blog'); // On définit le chemin d'accès aux fichiers
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'tools/tools.php'; // On inclut les outils
require_once 'autoconnect.php'; // On connecte l'utilisateur automatiquement
$db = getDB(); // On récupère la base de données
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
    if(isset($_POST['token']) && isset($_POST['pass']) && isset($_POST['pass2'])) // Si on a les informations pour changer le mdp
    {
        // On récupère les informations
        $token = htmlspecialchars($_POST['token']);
        $pass = htmlspecialchars($_POST['pass']);
        $pass2 = htmlspecialchars($_POST['pass2']);
        logs('reinit', 'utilisateur réinitialise son mot de passe avec : ' . $token, 0);
        list($ok, $error) = verifyPasswordStrongness($pass); // On vérifie la force du mot de passe
        if (!$ok) {
            logs('reinit', 'erreur réinitalisation de mot de passe (' . $error . ') avec le token ' . $token, 0);
            echo('<form action="forgot.php" method="post">
                <input type="hidden" name="token" value="' . $token . '">
                <input type="password" name="pass" placeholder="Nouveau mot de passe">
                <input type="password" name="pass2" placeholder="Confirmer le mot de passe">
                <input type="submit" value="Changer le mot de passe">
                </form>
                <p style="color:red">' . $error . '</p>');
            exit;
        }
        if ($pass == $pass2) // On vérifie si les mdp sont identiques
        {
            $password = hash('sha512', $pass); // On hash le mot de passe
            $sql = "SELECT user, expiration, used FROM tokens WHERE type='pass' AND token='" . $token . "'"; // On récupère les informations du token
            $result = mysqli_query($db, $sql); // On exécute la requête
            if (mysqli_num_rows($result) == 1) // Si on a un résultat
            {
                $row = mysqli_fetch_assoc($result);
                $user = $row['user'];
                $expiration = $row['expiration'];
                $used = $row['used'] == 1;
                if ($expiration > time() && !$used) // Si le token n'est pas expiré et n'a pas été utilisé
                {
                    $sql = "UPDATE users SET password='" . $password . "' WHERE id='" . $user . "'"; // On change le mot de passe
                    $result = mysqli_query($db, $sql); // On exécute la requête
                    if ($result) {
                        // on met used à 1 pour dire que le token est utilisé
                        $sql = "UPDATE tokens SET used=1 WHERE token='" . $token . "'";
                        $result = mysqli_query($db, $sql);

                        echo "<p style='color: green;'>Votre mot de passe a bien été modifié !</p>";
                        logs('reinit', 'utilisateur a réinitialisé son mot de passe avec le token ' . $token, $user);
                    } else
                    {
                        echo "<p style='color: red;'>Une erreur est survenue lors de la modification de votre mot de passe !</p>";
                        logs('reinit', 'erreur réinitialisation de mot de passe (sql erreur changement) avec le token ' . $token . ' pour l\'utilisateur ' . $user, $user);
                    }
                }
                else
                {
                    echo "<p style=\"color:red\">Le lien est expiré</p>";
                    logs('reinit', 'erreur réinitialisation de mot de passe (lien expiré) avec le token ' . $token . ' pour l\'utilisateur ' . $user, $user);
                }
            }
            else
            {
                echo "<p style=\"color:red\">Le lien n'est pas valide</p>";
                logs('reinit', 'erreur réinitialisation de mot de passe (lien invalide) avec le token ' . $token, 0);
            }

        }
        else
        {
            echo '<p style="color:red;">Les mots de passe ne correspondent pas !</p>';
            logs('reinit', 'erreur réinitialisation de mot de passe (mots de passe différents) avec le token ' . $token, 0);
        }
    } elseif (isset($_GET['token'])) // Si on a juste un token
    {
        // On le récupère
        $token = htmlspecialchars($_GET['token']);
        $sql = "SELECT user, expiration, used FROM tokens WHERE type='pass' AND token='" . $token . "'";
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $user = $row['user'];
            $expiration = $row['expiration'];
            $used = $row['used'] == 1;
            if($expiration > time() && !$used)
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
                logs('reinit', 'erreur réinitialisation de mot de passe (lien expiré) avec le token ' . $token . ' pour l\'utilisateur ' . $user, $user);
            }
        }
        else
        {
            echo "<p style=\"color:red\">Le lien n'est pas valide</p>";
            logs('reinit', 'erreur réinitialisation de mot de passe (lien invalide) avec le token ' . $token , 0);
        }
    }
    elseif(isset($_SESSION['id']))
    {
        echo '<p>Bienvenue ' . getPseudo($_SESSION['id']) . ' sur la page de réinitialisation de votre mot de passe !</p>
        <p style="color:red">Attention, vous êtes connecté, veuillez vous <a href="logout.php">déconnecter</a> pour pouvoir réinitialiser votre mot de passe.</p>';
        logs('reinit', 'utilisateur essaie de réinitialiser son mdp en étant connecté', $_SESSION['id']);
    }
    elseif(isset($_POST['email']))
    {
        $email = htmlspecialchars($_POST['email']);
        // verification de l'email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            echo "<p style='color:red'>L'adresse email n'est pas valide !</p>";
            logs('reinit', 'erreur réinitialisation de mot de passe (email invalide)', 0);
            exit;
        }
        $sql = "SELECT prenom, id FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        if(!$row)
        {
            echo passwordForgotten();
            echo "<p style='color:red'>L'email est inconnue !</p>";
            logs('reinit', 'erreur réinitialisation de mot de passe (email inconnu)', 0);
            exit;
        }
        $token = createPassForgotToken($row['id']);
        $to = $email;
        $subject = 'Reinitialisation de votre mot de passe InfinIdea';
        $message = 'Bonjour ' . $row['prenom'] . ",\r\n
        Une demande de <i>réinitialisation de mot de passe</i> a été faite sur <b>InfinIdea</b>.<br />
        Pour <u>réinitialiser votre mot de passe</u>, veuillez cliquer sur le lien suivant :<br />
        https:/infinidea.veagle.fr/account/forgot.php?token=" . $token . " <br />
        Si vous rencontrez un problème, <a href=\"mailto:contact@veagle.fr\">contactez nous sur notre email</a> <br /> <br />
        Cordialement, <br />
        L'équipe MysteriousDev de Veagle";

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
        $headers .= 'From:  ' . 'InfinIdea' . ' <' . 'contact@mysteriousdev.fr' . '>' . " \r\n" .
            'X-Mailer: PHP/' . phpversion();


        if(mail($to, $subject, $message, $headers))
        {
            echo '<p>Un email vous a été envoyé à <code>' . $to . "</code> pour réinitialiser votre mot de passe !</p>
            <p>Si vous n'avez pas reçu d'email, veuillez vérifier dans les spams ou <a href=\"mailto:contact@mysteriousdev.fr\">contactez-nous</a>.</p>";
            logs('reinit', 'email envoyé pour réinitialisation de mot de passe', $row['id']);
        }
        else
        {
            echo "<p style='color:red'>Une erreur est survenue lors de l'envoi de l'email !</p>";
            logs('reinit', 'erreur réinitialisation de mot de passe (envoi email)', $row['id']);
        }
    }
    else
    {
        echo passwordForgotten();
        logs('reinit', 'utilisateur charge le formulaire de réinitialisation de mot de passe', 0);
    }

    ?>
</body>
</html>
