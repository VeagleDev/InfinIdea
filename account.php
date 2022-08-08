<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->



<?php session_start(); // On démarre la session AVANT toute chose
require_once 'autoconnect.php';
require_once 'tools.php'?> <!-- On appelle le fichier tools.php -->

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
<?php if(isset($_SESSION['id'])) : ?> <!-- Si l'utilisateur est connecté, on affiche son compte -->
    <h1>MyProject - Compte</h1>
    <p>Bienvenue, <?=getPseudo($_SESSION['id'])?>  sur votre page personelle !</p>
    <a href="logout.php">Se déconnecter</a>
<?php else : ?> // Sinon, on lui demande de se connecter
    <h1>MyProject - Accueil</h1>
    <p>Bienvenue, vous n'êtes pas connecté !</p>
    <a href="login.php">Se connecter</a>&nbsp;
    <a href="register.php">S'inscrire</a>
<?php endif; ?>
</body>