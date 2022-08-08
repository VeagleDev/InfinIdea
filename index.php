<?php session_start();
        require_once 'tools.php';
        require_once 'autoconnect.php';
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
    <?php if(isset($_SESSION['user'])) : ?> // Si l'utilisateur est connecté, on affiche son compte
        <p>Bienvenue <?=getPseudo($_SESSION['id'])?> !</p>
        <a href="account.php">Mon compte</a>
        <a href="logout.php">Se déconnecter</a>
    <?php else : ?> // Sinon, on lui demande de se connecter ou de s'inscrire
        <p>Bienvenue sur MyProject !</p>
        <a href="login.php">Se connecter</a>
        <a href="register.php">S'inscrire</a>
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