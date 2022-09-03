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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinIdea : Bienvenue</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<section class="top-page">
    <header>
        <a href="https://mysteriousdev.fr"><img src="images/logo.png" alt="MysteriousDevelopers creation" class="logo-top"></a>
        <nav class="user-connection-interaction-nav">
            <ul>
                <a href="register.php"><li><h4>S'inscrire</h4></li></a>
                <a href="login.php"><li><h4>Se connecter</h4></li></a>
            </ul>
        </nav>
        <div class="main-title-container">
            <img src="images/Logo_InfinIdea.png" alt="Logo_InfinIdea" class="logo title">
            <h1 class="catchword">Créer est la découverte</h1>
        </div>
        <a href="" id="discover-interaction"><h4>Découvrir</h4></a>
    </header>
</section>

<section class="contents-page">
    <div class="welcom-display">
        <header class="code-header">
            <div class="file-display"><p><>infinidea.cdd</p></div>
            <div class="file-display"><p><>main.cdd</p></div>
        </header>
        <div class="line-display"><p>01</p></div>

        <div class="site-usefullness line">
            <p class="o">Bienvenue
                <?php
                if(isset($_SESSION['id']))
                    echo(', ' . getPseudo($_SESSION['id']))
            ?>
            () {</p>
        </div>

        <div class="line-display"><p>02</p></div>

        <div class="following-text">
            <p class="o">sur InfinIdea;</p>
        </div>

        <div class="line-display"><p>03</p></div>

        <div class="site-usefullness-bottom">
            <p class="o">}</p>
        </div>

        <div class="line-display"><p>04</p></div>

        <div class="site-usefullness">
            <p class="o">Decouvrir() {</p>
        </div>

        <div class="line-display"><p>05</p></div>

        <div class="following-text">
            <p class="o">Un clique, un nouveau projet vous est présenté !
                Vous l'aimez ? Likez, et suivez son
                avancement;</p>
        </div>

        <div class="line-display"><p>06</p></div>

        <div class="site-usefullness-bottom">
            <p class="o">}</p>
        </div>

        <div class="line-display"><p>07</p></div>

        <div class="site-usefullness">
            <p class="o">Créer() {</p>
        </div>

        <div class="line-display"><p>08</p></div>

        <div class="following-text">
            <p class="o">Créez les projets que vous voulez,
                à volonté. Une idée ? Un projet;</p>
        </div>

        <div class="line-display"><p>09</p></div>

        <div class="site-usefullness-bottom">
            <p class="o">}</p>
        </div>

        <div class="line-display"><p>10</p></div>

        <div class="site-usefullness">
            <p class="o">Discutter() {</p>
        </div>

        <div class="line-display"><p>11</p></div>

        <div class="following-text">
            <p class="o">Une question ? Posez-la, un passioné vous
                répondra;</p>
        </div>

        <div class="line-display"><p>12</p></div>

        <div class="site-usefullness-bottom">
            <p class="o">}</p>
        </div>
    </div>
</section>

<script src="main.js"></script>
</body>
</html>