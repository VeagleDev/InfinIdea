<!-- DERNIER TRUC A FAIRE !! -->
<?php session_start();
        require_once 'tools.php'?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProject : Compte</title>
</head>
<body>
<?php if(isset($_SESSION['id'])) : ?>
    <h1>MyProject - Compte</h1>
    <p>Bienvenue, <?=getPseudo($_SESSION['id'])?>  sur votre page personelle !</p>
    <a href="logout.php">Se déconnecter</a>
<?php else : ?>
    <h1>MyProject - Accueil</h1>
    <p>Bienvenue, vous n'êtes pas connecté !</p>
    <a href="login.php">Se connecter</a>
    <a href="register.php">S'inscrire</a>
<?php endif; ?>
</body>