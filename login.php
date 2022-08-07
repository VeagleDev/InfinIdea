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
    if(isset($_POST['pseudo']) && isset($_POST['password']))
    {
        $user = mysqli_real_escape_string($db, htmlspecialchars($_POST['pseudo']));
        $pass = hash("sha512", mysqli_real_escape_string($db, htmlspecialchars($_POST['password'])));
        $real = getPasswordbyUser($user);
        echo "<p>Le vrai mot de passe est : $real</p>";
        echo "<p>Le mot de passe que tu as entré est : $pass</p>";

        if($real == $pass)
        {
            $_SESSION['user'] = $user;
            $_SESSION['password'] = $pass;
            $_SESSION['id'] = getIdbyUser($user);
            echo "<p style='color: green'>Connexion réussie !</p>";
        }
        else
        {
            echo "<p style='color: red'>Connexion échouée !</p>";
        }
    }
    else if(isset($_SESSION['user']))
    {
        echo '<p>Vous êtes déjà connecté en tant que ' . $_SESSION['user'] . '</p>';
    }
    else
    {
        echo login_form();
    }

    ?>
