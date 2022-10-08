<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'autoconnect.php';
require_once 'tools/tools.php';
?> <!-- On appelle le fichier tools.php -->


<!-- DERNIER TRUC A FAIRE !! -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProject : Compte</title>
</head>
<body>

<?php
if(!isset($_SESSION['id']))
{
    echo '<p>Vous n\'êtes pas connecté</p>';
    echo '<a href="login.php">Se connecter</a>';
    echo '<a href="register.php">S\'inscrire</a>';
}
else
{
    echo '<p>Bonjour ' . getPseudo($_SESSION['id']) . '</p>';
    echo '<a href="logout.php">Se déconnecter</a>';
}
?>


</body>
