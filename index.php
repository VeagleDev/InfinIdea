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
</head>
<body>
<section class="top-page">
    <header>
        <nav class="top-nav">
            <img src="images/logo_veagle_white.png" alt="MysteriousDevelopers creation" class="logo-top">
            <ul class="main-list">
                <li class="first-child"><a href="#"><p><i class="fa-solid fa-house nav-icon"></i> Accueil</p></a></li>
                <li class="first-child"><a href="explore.php?type=recommandations"><p><i class="fa-solid fa-shuffle nav-icon"></i> Recommendations</p></a></li>
                <li class="first-child"><a href="explore.php?type=recents"><p><i class="fa-regular fa-heart nav-icon"></i> Suivis</p></a></li>
                <li class="first-child"><a href=""><p><i class="fa-solid fa-question nav-icon"></i>Créer</p></a></li>
            </ul>
        </nav>
        <nav class="user-connection-interaction-nav">
            <ul class="user-connection-interaction-list">
                <li class="user-menu">
                    <a href="account/login.php">
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
                            <li><a href="account/account.php"><p>Mon compte</p></a></li>
                            <li><a href=""><p>A propos</p></a></li>
                            <li><a href=""><p>Mes projets</p></a></li>
                            <li><a href="account/account.php"><p>Paramètres</p></a></li>
                            <li><a href="account/logout.php"><p>Déconnexion</p></a></li>
                        </ul>
                    </a>
                </li>
                <?php
                if(!isset($_SESSION['id'])) // Si il n'est pas connecté, on lui propose de se connecter
                {
                    echo('<a href="account/register.php" class="sign-in unconnected"><li class="sign-in-sub-element"><p>S\'inscrire</p></li></a>');
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
    <div class="welcom-display">
        <header class="code-header">
            <div class="file-display"><p><>infinidea.cdd</p></div>
            <div class="file-display"><p><>main.cdd</p></div>
        </header>
        <div class="line-display"><p>01</p></div>

        <div class="site-usefullness line">
            <?php
            if(isset($_SESSION['id'])) // Si connecté, prenom
            {
                echo('<p class="o">Bienvenue(string pseudo = "' . getPseudo($_SESSION['id']) . '") {</p>');
            }
            else
            {
                echo('<p class="o">Bienvenue() {</p>');
            }
            ?>
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
            <p class="o">Discutez() {</p>
        </div>

        <div class="line-display"><p>11</p></div>

        <div class="following-text">
            <p class="o">Une question ? Posez-la, un passioné vous
                répondra;</p>
        </div>

        <div class="line-display"><p>12</p></div>

        <div class="site-usefullness-bottom">
            <p class="o last-txt">}</p>
        </div>

        <div class="line-display"><p>13</p></div>
    </div>

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
                $href = "article.php?id=" . $row['id']; // on recupere l'id de l'article
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
                        $img = "images/Logo_InfinIdea.png"; // on charge l'image par defaut
                    }
                }
                ?>
                <a href="<?php echo $href; ?>" class="gallery-cell">
                    <img src="<?php echo $img; ?>" alt="">
                    <div class="text">
                        <h1><?php echo($row['name']); ?></h1>
                        <p class="description"><?php echo($row['description']); ?></p>
                    </div>
                </a>
                <?php
            }

            ?>

            <!--
            <a href="" class="gallery-cell">
                <img src="images/uploads/1.jpg" alt="">
                <div class="text">
                    <h1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, quam.</h1>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit facilis itaque ipsum tenetur sed officia, sequi dignissimos illum doloribus veritatis voluptatibus dolore, rem, est dolorum iure nam quae fugiat vero et beatae eligendi unde iste? Ullam debitis consequuntur labore numquam enim nobis nostrum officiis tempore aliquam, expedita facere et perspiciatis?</p>
                </div>
            </a>
            -->


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
                $href = "article.php?id=" . $row['id']; // on recupere l'id de l'article
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
                        $img = "images/Logo_InfinIdea.png"; // on charge l'image par defaut
                    }
                }
                ?>
                <a href="<?php echo $href; ?>" class="gallery-cell">
                    <img src="<?php echo $img; ?>" alt="">
                    <div class="text">
                        <h1><?php echo($row['name']); ?></h1>
                        <p class="description"><?php echo($row['description']); ?></p>
                    </div>
                </a>
                <?php
            }

            ?>

            <!--
            <a href="" class="gallery-cell">
                <img src="images/uploads/1.jpg" alt="">
                <div class="text">
                    <h1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, quam.</h1>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit facilis itaque ipsum tenetur sed officia, sequi dignissimos illum doloribus veritatis voluptatibus dolore, rem, est dolorum iure nam quae fugiat vero et beatae eligendi unde iste? Ullam debitis consequuntur labore numquam enim nobis nostrum officiis tempore aliquam, expedita facere et perspiciatis?</p>
                </div>
            </a>
            -->

        </div>

        <!--
        <h1 class="big-title">Applications et jeux</h1>
        <div class="gallery js-flickity"
        data-flickity-options='{ "wrapAround": true }'>
            <a href="" class="gallery-cell">
                <img src="images/base.jpg" alt="">
                <div class="text">
                    <h1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, quam.</h1>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit facilis itaque ipsum tenetur sed officia, sequi dignissimos illum doloribus veritatis voluptatibus dolore, rem, est dolorum iure nam quae fugiat vero et beatae eligendi unde iste? Ullam debitis consequuntur labore numquam enim nobis nostrum officiis tempore aliquam, expedita facere et perspiciatis?</p>
                </div>
            </a>
        </div>
        <h1 class="big-title">Mécanismes et projets manuels</h1>
        <div class="gallery js-flickity"
        data-flickity-options='{ "wrapAround": true }'>
            <a href="" class="gallery-cell">
                <img src="images/base.jpg" alt="">
                <div class="text">
                    <h1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, quam.</h1>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit facilis itaque ipsum tenetur sed officia, sequi dignissimos illum doloribus veritatis voluptatibus dolore, rem, est dolorum iure nam quae fugiat vero et beatae eligendi unde iste? Ullam debitis consequuntur labore numquam enim nobis nostrum officiis tempore aliquam, expedita facere et perspiciatis?</p>
                </div>
            </a>
        </div>
        -->
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
                    <li><a href="https://www.instagram.com/nicolas_fsn_/"  target="_blank"><p>Instagram</p></a></li>
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

<script src="backend/js/main.js"></script>
<script src="backend/js/flickity.pkgd.min.js"></script>
</body>
</html>