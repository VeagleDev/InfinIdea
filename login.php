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
    <?php
    if(isset($_POST['pseudo']) && isset($_POST['password']))
    {
        $user = mysqli_real_escape_string($db, htmlspecialchars($_POST['pseudo']));
        $pass = mysqli_real_escape_string($db, htmlspecialchars($_POST['password']));
        $real = getPasswordbyUser($user);
        if($real == $pass)
        {
            $_SESSION['user'] = $user;
            $_SESSION['password'] = $pass;
            echo '<p>Bienvenue ' . $_COOKIE['user'] . '</p>';
        }
        else
        {
            echo '<p>Mauvais identifiants</p>';
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
