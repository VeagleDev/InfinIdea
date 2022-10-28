<?php
set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';

$db = getDB();

logs('Va chercher les articles');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinIdea : Bienvenue</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/explore.css">
    <script src="backend/js/fontawesome.js"></script>
</head>
<body>
<section class="top-page">
    <header>
        <nav class="top-nav">
            <img src="images/logo_veagle_white.png" alt="MysteriousDevelopers creation" class="logo-top">
            <ul class="main-list">
                <li class="first-child"><a href="index.php"><p><i class="fa-solid fa-house nav-icon"></i> Accueil</p>
                    </a></li>
                <li class="first-child"><a href="explore.php"><p><i class="fa-solid fa-shuffle nav-icon"></i>
                            Recommendations</p></a></li>
                <li class="first-child"><a href="explore.php"><p><i class="fa-regular fa-heart nav-icon"></i> Suivis</p>
                    </a></li>
                <li class="first-child"><a href=""><p><i class="fa-solid fa-question nav-icon"></i> A propos</p></a>
                </li>
            </ul>
        </nav>
        <nav class="user-connection-interaction-nav">
            <ul class="user-connection-interaction-list">
                <li class="user-menu">
                    <a href=/login">
                        <p>Bonjour, &nbsp;

                            <?php
                                if(isset($_SESSION['id'])) // Si l'utilisateur est connecté, on affiche son pseudo
                                {
                                    echo('<p class="unconnected">' . getPseudo($_SESSION['id']) . '<i class="fa-solid fa-angle-down arrow"></i></p>');
                                }
                                else // Sinon on affiche qu'il faut de connecter
                                {
                                    echo('<p class="unconnected">connectez-vous<i class="fa-solid fa-angle-down arrow"></i></p>');
                                }
                                ?>

                        </p>
                        <ul class="user-connection-scrolling-menu">
                            <li><a href="/account/account.php"><p>Mon compte</p></a></li>
                            <li><a href="/write"><p>Écrire</p></a></li>
                            <li><a href="/account/logout.php"><p>Déconnexion</p></a></li>
                        </ul>
                    </a>
                </li>
                <?php
                    if(!isset($_SESSION['id'])) // Si il n'est pas connecté, on lui propose de se connecter
                    {
                        echo('<a href="/register" class="sign-in unconnected"><li class="sign-in-sub-element"><p>S\'inscrire</p></li></a>');
                    }
                    ?>
                </ul>
            </nav>
        </header>
    </section>

    <section class="page-content">
        <div class="explorer-container">


            <div class="gallery js-flickity"
            data-flickity-options='{ "wrapAround": true }'>

                <?php
                    $sql = "SELECT * FROM articles WHERE visibility = 'public' ORDER BY views DESC LIMIT 20";
                    $result = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_assoc($result))
                    { ?>
                        <a href="article.php?id=<?php echo($row['uid']); ?>" class="gallery-cell">

                            <div class="img-container">
                                <?php
                                $filename = 'images/uploads/' . $row['id'] . '.jpg';
                                if(file_exists($filename))
                                {
                                    echo('<div><img class="img-article" src="images/uploads/'. $row['id'] .'.jpg" alt="Image" ></div>');
                                    $sql = "SELECT path FROM images WHERE aid = " . $row['id'] . " LIMIT 3";
                                }
                                else
                                {
                                    $sql = "SELECT path FROM images WHERE aid = " . $row['id'] . " LIMIT 4";
                                }
                                $result2 = mysqli_query($db, $sql);
                                while($row2 = mysqli_fetch_assoc($result2))
                                {
                                    echo('<div><img class="img-article" src="' . $row2['path'] . '" alt="Image" ></div>');
                                }

                                ?>
                            </div>

                            <div class="text">
                                <h1><?php echo($row['name']); ?></h1>
                                <p class="description"><?php echo($row['description']); ?></p>
                            </div>
                        </a>
                    <?php }

                ?>


            </div>
        </div>


    </section>

<section class="bottom-page">
    <footer>
        <div class="site-nav">
            <nav>
                <ul>
                    <li><p class="nav-title">Soutien</p></li>
                    <li><a href="mailto:contact@veagle.fr"><p>Nous contacter</p></a></li>
                    <li><a href=""><p>A propos</p></a></li>
                </ul>
            </nav>
            <nav>
                <ul>
                    <li><p class="nav-title">Contactez-nous</p></li>
                    <li><a href="https://discord.gg/Vahr76XmpU" target="_blank"><p>Discord</p></a></li>
                    <li><a href="mailto:contact@veagle.fr"><p>Mail</p></a></li>
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
                        <li><a href="https://discord.gg/Vahr76XmpU" target="_blank"><i class="fa-brands fa-discord"></i></a></li>
                        <li><a href="https://www.instagram.com/nicolas_fsn_/" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="https://github.com/Mysterious-Developers" target="_blank"><i class="fa-brands fa-github"></i></a></li>
                        <li><a href="https://veagle.fr" target="_blank"><i class="fa-solid fa-window-restore"></i></a></li>
                    </ul>
                </nav>
            </div>
        </footer>
    </section>

    <script src="backend/js/main.js"></script>
    <script src="backend/js/flickity.pkgd.min.js"></script>
    <script defer src="backend/js/grid-check-ratio.js"></script>
</body>
</html>