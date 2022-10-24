<?php
// création de la session et chargement des outils complémentaires

set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
    session_start(); // On démarre la session AVANT toute chose
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';
$db = getDB();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinIdea : Bienvenue</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="backend/js/fontawesome.js"></script>
    <script defer src="backend/js/grid-check-ratio.js"></script>
</head>
<body>
<section class="top-page">
    <header>
        <nav class="top-nav">
            <img src="images/logo_veagle_white.png" alt="MysteriousDevelopers creation" class="logo-top">
            <ul class="main-list">
                <li class="first-child"><a href="#"><p><i class="fa-solid fa-house nav-icon"></i> Accueil</p></a></li>
                <li class="first-child"><a href="explore.php"><p><i class="fa-solid fa-shuffle nav-icon"></i>
                            Recommendations</p></a></li>
                <li class="first-child"><a href="explore.php"><p><i class="fa-regular fa-heart nav-icon"></i> Suivis</p>
                    </a></li>
                <li class="first-child"><a href="tools/write.php"><p><i class="fa-solid fa-question nav-icon"></i>Créer
                        </p></a></li>
            </ul>
        </nav>
        <nav class="user-connection-interaction-nav">
            <ul class="user-connection-interaction-list">
                <li class="user-menu">
                    <?php
                    if (isset($_SESSION['id'])) {
                        ?>
                        <a href="account/account.php">
                            <p>Bonjour, &nbsp;
                            <p class="unconnected"><?= getPseudo($_SESSION['id']) ?><i
                                        class="fa-solid fa-angle-down arrow"></i></p>
                            </p>
                        </a>
                        <ul class="user-connection-scrolling-menu">
                            <li><a href="account/account.php"><p>Mon compte</p></a></li>
                            <li><a href="tools/write.php"><p>Écrire</p></a></li>
                            <li><a href="account/logout.php"><p>Déconnexion</p></a></li>
                        </ul>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="account/login.php">
                            <p>Bonjour, &nbsp;
                            <p class="unconnected">connectez-vous</p>
                        </a>
                        <?php
                    }
                    ?>
                </li>

                <?php
                if (!isset($_SESSION['id'])) // Si il n'est pas connecté, on lui propose de se connecter
                {
                    echo('<a href="/register" class="sign-in unconnected"><li class="sign-in-sub-element"><p>S\'inscrire</p></li></a>');
                }
                ?>
            </ul>
        </nav>
        <div class="main-title-container">
            <img src="images/Logo_InfinIdea.png" alt="Logo_InfinIdea" class="logo title">
            <h1 class="catchword">Créer est la découverte</h1>
        </div>
        <a href="explore.php" id="discover-interaction"><h4>Explorer</h4></a>
        <div class="shadow"></div>
        <div class="shadow"></div>
        <div class="shadow"></div>
    </header>
</section>

<section class="contents-page">
    <div class="article-display">
        <h1 class="big-title">Découvrez</h1>
        <div class="gallery js-flickity"
             data-flickity-options='{ "wrapAround": true }'>

            <?php
            $sql = "SELECT * FROM articles WHERE visibility = 'public' ORDER BY views DESC LIMIT 20;"; // on charge les 50 articles les plus vus
            $result = mysqli_query($db, $sql); // on execute la requete
            while($row = mysqli_fetch_assoc($result)) // tant que on a un resultat
            {
                $articleid = $row['id'];
                $href = "article.php?id=" . $row['uid']; // on recupere l'id de l'article
                $sql = "SELECT * FROM images WHERE type = 'main' AND aid = " . $articleid . " LIMIT 1;"; // on charge l'image de l'article
                $result2 = mysqli_query($db, $sql); // on execute la requete
                if(mysqli_affected_rows($db) > 0) // si on a un resultat
                {
                    $row2 = mysqli_fetch_assoc($result2); // on recupere le resultat
                    $img = $row2['path']; // on recupere l'image
                }
                else
                {
                    $sql = "SELECT * FROM images WHERE aid = " . $articleid . " LIMIT 1;"; // on charge l'image par defaut
                    $result2 = mysqli_query($db, $sql); // on execute la requete
                    if(mysqli_affected_rows($db) > 0) // si on a un resultat
                    {
                        $row2 = mysqli_fetch_assoc($result2); // on recupere le resultat
                        $img = $row2['path']; // on recupere l'image
                    }
                    else
                    {
                        $img = "images/uploads/" . $articleid . ".jpg";
                        if(!file_exists($img))
                        {
                            $img = "images/Logo_InfinIdea.png"; // on charge l'image par defaut
                        }
                    }
                }
                ?>
                <a href="<?php echo $href; ?>" class="gallery-cell">
                    <div class="img-container">
                        <img src="<?php echo $img; ?>" alt="" class="img-article">
                    </div>
                    <div class="text">
                        <h1><?php echo($row['name']); ?></h1>
                        <p class="description"><?php echo($row['description']); ?></p>
                    </div>
                </a>
                <?php
            }

            ?>
        </div>

        <h1 class="big-title">Nouveaux</h1>
        <div class="gallery js-flickity"
             data-flickity-options='{ "wrapAround": true }'>

            <?php
            $sql = "SELECT * FROM articles WHERE visibility = 'public' ORDER BY created DESC LIMIT 50;"; // on charge les 50 articles les plus récents
            $result = mysqli_query($db, $sql); // on execute la requete
            while($row = mysqli_fetch_assoc($result)) // tant que on a un resultat
            {
                $articleid = $row['id'];
                $href = "article.php?id=" . $row['uid']; // on recupere l'id de l'article
                $sql = "SELECT * FROM images WHERE type = 'main' AND aid = " . $articleid . " LIMIT 1;"; // on charge l'image de l'article
                $result2 = mysqli_query($db, $sql); // on execute la requete
                if(mysqli_affected_rows($db) > 0) // si on a un resultat
                {
                    $row2 = mysqli_fetch_assoc($result2); // on recupere le resultat
                    $img = $row2['path']; // on recupere l'image
                }
                else
                {
                    $sql = "SELECT * FROM images WHERE aid = " . $articleid . " LIMIT 1;"; // on charge l'image par defaut
                    $result2 = mysqli_query($db, $sql); // on execute la requete
                    if(mysqli_affected_rows($db) > 0) // si on a un resultat
                    {
                        $row2 = mysqli_fetch_assoc($result2); // on recupere le resultat
                        $img = $row2['path']; // on recupere l'image
                    }
                    else
                    {
                        $img = "images/uploads/" . $articleid . ".jpg";
                        if(!file_exists($img))
                        {
                            $img = "images/Logo_InfinIdea.png"; // on charge l'image par defaut
                        }
                    }
                }
                ?>
                <a href="<?php echo $href; ?>" class="gallery-cell">
                    <div class="img-container">
                        <img src="<?php echo $img; ?>" alt="" class="img-article">
                    </div>
                    <div class="text">
                        <h1><?php echo($row['name']); ?></h1>
                        <p class="description"><?php echo($row['description']); ?></p>
                    </div>
                </a>
                <?php
            }

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
                    <li><a href="https://github.com/Mysterious-Developers" target="_blank"><p>GitHub</p></a></li>
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

<script src="backend/js/flickity.pkgd.min.js"></script>
</body>
</html>