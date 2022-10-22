<?php
set_include_path('/var/www/blog'); // On définit le chemin d'accès aux fichiers
if (session_status() == PHP_SESSION_NONE)
    session_start(); // On démarre la session AVANT toute chose

if (isset($_SESSION['id'])) { // Si l'utilisateur est connecté
    echo '<p style="color:red;">Vous ne pouvez pas créer de compte en étant connecté !</p><p><a href="/">Retourner à l\'accueil</a></p>';
    die();
}

// Pour voir le processus d'inscription, voir le fichier veagle-register.php et register.js

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinIdea : S'inscrire</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/register.css">
    <script src="../backend/js/fontawesome.js"></script>
    <script src="../backend/library/jquery-3.6.1.min.js"></script>
    <script defer src="../backend/js/register.js"></script>
</head>
<body>
<section class="page-content">
    <div class="steps">
        <div class="step step-one">
            <p class="type-effect">Bienvenue dans la création de votre compte Infinidea avec VeagleConnect</p>
            <p class="type-effect before-append-input">Pour commencer, veuillez renseignez votre pseudo;</p>
            <div class="input-container">
                <input type="text" class="pseudo-value">
                <button class="submit-pseudo">Soumettre</button>
            </div>
            <p class="error">Ce pseudo est déjà utilisé ou est incorrect.</p>
        </div>

        <div class="step step-two">
            <p class="type-effect before-append-input">Maintenant, votre prénom;</p>
            <div class="input-container">
                <input type="text" class="name-value">
                <button class="submit-name">Soumettre</button>
            </div>
            <p class="error">Votre nom fait vraiment moins de 3 caractères ? Vérifiez ce que vous avez renseignez !</p>
        </div>

        <div class="step step-three">
            <p class="type-effect before-append-input">Bien ! Veuillez désormais inscrire votre E-mail;</p>
            <div class="input-container">
                <input type="text" class="email-value">
                <button class="submit-email">Soumettre</button>
            </div>
            <p class="error">L'E-mail renseignée est incorrecte.</p>
        </div>

        <div class="step step-four">
            <p class="type-effect before-append-input">Pour finir, la sécurité ! Renseignez votre mot de passe et
                confirmez-le. Prennez-en un sécurisé, c'est le plus important;</p>
            <div class="input-container">
                <input type="text" class="password-value">
                <button class="submit-password">Soumettre</button>
            </div>
            <p class="error">Votre mot de passe doit contenir au moins 8 caractères.</p>
        </div>

        <div class="step step-five">
            <p class="type-effect before-append-input">Confirmez votre mot de passe;</p>
            <div class="input-container">
                <input type="text" class="confirm-password-value">
                <button class="confirm-password">Valider</button>
            </div>
            <p class="error">Le mot de passe renseigné n'est pas le même !</p>
        </div>

        <div class="other-interaction">
            <p>Déjà un compte VeagleConnect ? <a href="/login">Connectez-vous</a>, c'est plus simple !</p>
        </div>
    </div>
</section>

<section class="bottom-page">
    <footer>
        <div class="site-nav">
            <nav>
                <ul>
                    <li><p class="nav-title">Soutien</p></li>
                    <li><a href=""><p>Nous contacter</p></a></li>
                    <li><a href=""><p>A propos</p></a></li>
                </ul>
            </nav>
            <nav>
                <ul>
                    <li><p class="nav-title">Contactez-nous</p></li>
                    <li><a href="https://discord.gg/Vahr76XmpU" target="_blank"><p>Discord</p></a></li>
                    <li><a href=""><p>Mail</p></a></li>
                    <li><a href="https://www.instagram.com/nicolas_fsn_/" target="_blank"><p>Instagram</p></a></li>
                </ul>
            </nav>
            <nav>
                <ul>
                    <li><p class="nav-title">Rejoignez-nous</p></li>
                    <li><a href="https://veagle.fr" target="_blank"><p>veagle.fr</p></a></li>
                    <li><a href="https://discord.gg/Vahr76XmpU" target="_blank"><p>Discord</p></a></li>
                    <li><a href="https://www.instagram.com/nicolas_fsn_/" target="_blank"><p>Instagram</p></a></li>
                </ul>
            </nav>
        </div>
        <div class="copyright-infos-nav">
            <nav>
                <ul>
                    <li><p>© 2022 InfinIdea, by VEagle</p></li>
                    <li><a href="">Politique de confidentialité</a></li>
                </ul>
            </nav>
            <nav class="social-media">
                <ul>
                    <li><a href="https://discord.gg/Vahr76XmpU" target="_blank"><i class="fa-brands fa-discord"></i></a>
                    </li>
                    <li><a href="https://www.instagram.com/nicolas_fsn_/" target="_blank"><i
                                    class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="https://github.com/Mysterious-Developers" target="_blank"><i
                                    class="fa-brands fa-github"></i></a></li>
                    <li><a href="https://veagle.fr" target="_blank"><i class="fa-solid fa-window-restore"></i></a></li>
                </ul>
            </nav>
        </div>
    </footer>
</section>
</body>
</html>