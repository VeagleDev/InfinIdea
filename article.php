<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';
require_once 'vendor/autoload.php';
$db = getDB();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinIdea : Bienvenue</title>
    <script src="backend/js/fontawesome.js"></script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/article.css">




</head>
<body>
    <section class="top-page">
        <header>
            <nav class="top-nav">
                <img src="images/logo_veagle_white.png" alt="MysteriousDevelopers creation" class="logo-top">
                <ul class="main-list">
                    <li class="first-child"><a href="index.php"><p><i class="fa-solid fa-house nav-icon"></i> Accueil</p></a></li>
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
        </header>
    </section>








    <section class="contents-page">

        <?php
            if(isset($_GET['id']))
            {
                $aid = HTMLpurify($_GET['id']);
                if(articleExists($aid))
                {
                    $sql = "SELECT * FROM articles WHERE id = '$aid'";
                    $result = mysqli_query($db, $sql);
                    if(mysqli_affected_rows($db) == 1)
                    {
                        $row = mysqli_fetch_assoc($result);
                        $title = $row['name'];
                        $desc = $row['description'];
                        $body = $row['content'];
                        $author = getPseudo($row['creator']);
                        $created = correctTimestamp($row['created']);
                        $tags = $row['tags'];

                        $blocked = $row['blocked'];

                        if($blocked == 1)
                        {
                            echo('<p color="red">L\'article que vous avez sélectionné est bloqué !</p>');
                        }
                    }
                    else
                    {
                        echo('<p color="blue">L\'article que vous avez sélectionné n\'est pas valide !</p>');
                    }
                }
                else
                {
                    echo('<p color="blue">L\'article que vous avez sélectionné n\'existe pas.</p>');
                }
            }
            else
            {
                echo('<p color="blue">Pas d\'article sélectionné</p>');
                die();
            }

        ?>

        <div class="article-container">
            <div class="article">

                <div class="img-nav">
                    <?php
                            $sql = 'SELECT path FROM images WHERE aid = ' . $aid;
                            $result = mysqli_query($db, $sql);
                            if(mysqli_affected_rows($db) > 0)
                            {
                                $row = mysqli_fetch_assoc($result);
                                $firstPath = $row['path'];
                            }
                            else
                            {
                                $firstPath = 'https://infinidea.veagle.fr/images/Logo_InfinIdea.png';
                            }
                    ?>
                    <div class="displayed-img">
                        <img src="<?php echo $firstPath; ?>" alt="Image de l'article" id="displayed-img">
                    </div>
                    <nav class="nav">
                        <ul class="preview-container">
                            <li class="li-img"><button class="li-img"><img src="<?php echo $firstPath; ?>" alt="Bouton de prévisualisation" class="preview"></button></li>
                            <?php
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $path = $row['path']; ?>
                                    <li class="li-img"><button class="li-img"><img src="<?php echo $path; ?>" alt="Bouton de prévisualisation" class="preview"></button></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>

                <div class="txt-container">

                    <h3 class="title"><?php echo $title; ?></h3>
                    <p class="description"><?php echo $desc; ?></p>
                    <div class="interaction-nav">
                        <nav class="nav">
                            <ul class="interaction-container">
                                <li><button><i class="fa-regular fa-user interaction"></i></button></li>
                                <?php
                                if(isset($_SESSION['id']))
                                {
                                    $sql = 'SELECT * FROM likes WHERE aid = ' . $aid . ' AND uid = ' . $_SESSION['id'];

                                    $result = mysqli_query($db, $sql);
                                    if(mysqli_affected_rows($db) == 1)
                                    {
                                        echo("<li><button onclick='performLike(" . $aid . ")'><i class=\"fa-heart interaction like fa-solid\"></i></button></li>");
                                    }
                                    else
                                    {
                                        echo("<li><button onclick='performLike(" . $aid . ")'><i class=\"fa-regular fa-heart interaction like\"></i></button></li>");
                                    }
                                }
                                else
                                {
                                    echo('<li><button><i class="fa-regular fa-heart interaction like"></i></button></li>');
                                }
                                ?>
                                <li><button class="open-comment"><i class="fa-regular fa-comment interaction"></i></button></li>

                            </ul>
                        </nav>
                    </div>

                </div>

            </div>

            <br />
            <br />
            <br />
            <br />

            <div class="content-txt" style="width: 100%; height: auto;"><?php echo $body; ?></div>
        </div>

        <div class="comment-section">
            <button class="close"><i class="fa-solid fa-xmark "></i></button>
            <nav>
                <ul>

                    <?php
                        $sql = 'SELECT * FROM comments WHERE aid = ' . $aid . ' ORDER BY time DESC';
                        $result = mysqli_query($db, $sql);
                        if(mysqli_affected_rows($db) > 0)
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $pseudo = getPseudo($row['uid']);
                                $message = $row['message'];
                                ?>
                                <li class="comment">
                                    <h1 class="username"><?php echo $pseudo; ?></h1>
                                    <p class="comment-content"><?php echo $message; ?></p>
                                    <ul class="comment-user-interaction">
                                        <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                                        <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                                    </ul>
                                </li>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <li class="comment">
                                <h1 class="username"></h1>
                                <p class="comment-content">Il n'y a pas encore de commentaires !</p>
                                <ul class="comment-user-interaction">
                                    <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                                    <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                                </ul>
                            </li>
                            <?php
                        }
                    ?>

                </ul>
            </nav>
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
                        <li><a href="https://veagle.fr" target="_blank"><p>Instagram</p></a></li>
                    </ul>
                </nav>
                <nav>
                    <ul>
                        <li><p class="nav-title">Rejoignez-nous</p></li>
                        <li><a href="https://veagle.fr" target="_blank"><p>veagle.fr</p></a></li>
                        <li><a href="https://discord.gg/Vahr76XmpU" target="_blank"><p>Discord</p></a></li>
                        <li><a href="https://veagle.fr" target="_blank"><p>Instagram</p></a></li>
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
                        <li><a href="https://www.instagram.com/nicolas_fsn_/"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="https://github.com/Mysterious-Developers"><i class="fa-brands fa-github"></i></a></li>
                        <li><a href="https://veagle.fr" target="_blank"><i class="fa-solid fa-window-restore"></i></a></li>
                    </ul>
                </nav>
            </div>
        </footer>

    </section>


    <script src="backend/js/img-explorer.js"></script>
    <script src="backend/js/article-interaction.js"></script>
    <script src="backend/js/like.js"></script>
    <script defer src="backend/js/check-ratio.js"></script>




</body>
</html>
