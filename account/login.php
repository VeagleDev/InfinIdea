<?php
set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE)
    session_start(); // On démarre la session AVANT toute chose

if (isset($_SESSION['id'])) {
    header('Location: index.php');
    die();
}

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
        <script defer src="../backend/js/login.js"></script>
        <script src="../backend/library/jquery-3.6.1.min.js"></script>
    </head>
    <body>
    <section class="page-content">
        <div class="steps">
            <div class="step step-one">
                <p class="type-effect">Vous revoilà !</p>
                <p class="type-effect before-append-input">Veuillez renseigner votre e-mail</p>
                <div class="input-container">
                    <input type="text" class="email-value">
                    <button class="submit-email">Soumettre</button>
                </div>
                <p class="error">L'E-mail renseignée n'est pas correcte.</p>
            </div>

            <div class="step step-two">
                <p class="type-effect before-append-input">Veuillez renseigner votre mot de passe</p>
                <div class="input-container">
                    <input type="text" class="password-value">
                    <button class="submit-password">Soumettre</button>
                </div>
                <p class="error">Le mot de passe renseigné est incorrect.</p>
            </div>

            <div class="other-interaction">
                <p>Retourner à l'<a href="../index.php">accueil</a>.</p>
                <p>Vous n'avez pas encore de compte VeagleConnect ? <a href="../register.html">Inscrivez-vous</a>, ça
                    prend
                    1 minute !</p>
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
                        <li><a href="https://veagle.fr" target="_blank"><i class="fa-solid fa-window-restore"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </footer>
    </section>
    </body>
    </html>


<?php
