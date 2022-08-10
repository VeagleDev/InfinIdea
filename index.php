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
require_once 'autoconnect.php';
require_once 'tools.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProject : Accueil</title>
</head>
<body>
    <h1>MyProject - Accueil</h1>
    <!-- PAGE D'ACCUEIL, JE TE LAISSE FAIRE -->
    <?php if(isset($_SESSION['id'])) : ?> <!-- Si l'utilisateur est connecté, on affiche son compte -->
        <p>Bienvenue <?=getPseudo($_SESSION['id'])?> !</p>
        <a href="account.php">Mon compte</a>
        <a href="write.php">Ecrire un article</a>
        <a href="logout.php">Se déconnecter</a>
    <?php
        $db = getDB();
        logs('ouverture de la page accueil', 'utilisateur connecté se connecte sur la page d\'accueil', $_SESSION['id'], $db);
        mysqli_close($db);
    ?>
    <?php else : ?> <!-- Sinon, on lui demande de se connecter ou de s'inscrire -->
        <p>Bienvenue sur MyProject, vous n'êtes pas encore connecté !</p>
        <a href="login.php">Se connecter</a>
        <a href="register.php">S'inscrire</a>
    <?php
        $db = getDB();
        logs('ouverture de la page accueil', 'utilisateur déconnecté se connecte sur la page d\'accueil', $db);
        mysqli_close($db);
        ?>
    <?php endif; ?>

    <!-- css -->
<style>
    h1 {
        text-align: center;
    }
    a {
        display: block;
        margin: 0 auto;
        text-align: center;
    }
</style>
</body>
</html>