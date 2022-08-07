<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProject : Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>MyProject - Accueil</h1>
    <?php
    if(isset($_SESSION['user']))
    {
        echo '<p>Bienvenue ' . $_SESSION['user']['firstname'] . '</p>';
        echo '<p><a href="logout.php">Se déconnecter</a></p>';
    }
    else
    {
        echo '<p><a href="login.php">Se connecter</a></p>';
        echo '<p><a href="register.php">S\'inscrire</a></p>';
    }
    ?>
</body>
