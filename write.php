<?php
set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE)
    session_start();
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';

$db = getDB();

logs('Commence l\'\'écriture d\'\'un article');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Infinidea : Créer</title>
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/write.css" rel="stylesheet">
    <link href="/css/markdown.css" rel="stylesheet">
    <script src="/backend/library/jquery-3.6.1.min.js"></script>
    <script src="/backend/js/paste-image.js"></script>
    <script src="/backend/js/write.js" defer></script>
    <script src="/backend/js/fontawesome.js"></script>
</head>
<body>
<section class="top-page">
    <header>
        <nav class="top-nav">
            <img alt="Logo de Veagle" class="logo-top" src="../images/logo_veagle_white.png">
            <ul class="main-list">
                <li class="first-child"><a href="/"><p><i class="fa-solid fa-house nav-icon"></i> Accueil</p></a></li>
                <li class="first-child"><a href="/explore"><p><i
                                    class="fa-solid fa-shuffle nav-icon"></i> Recommendations</p></a></li>
                <li class="first-child"><a href="/explore"><p><i
                                    class="fa-regular fa-heart nav-icon"></i> Suivis</p></a></li>
                <li class="first-child"><a href=""><p><i class="fa-solid fa-question nav-icon"></i>Créer</p></a></li>
            </ul>
        </nav>
        <nav class="user-connection-interaction-nav">
            <ul class="user-connection-interaction-list">
                <li class="user-menu">
                    <?php
                    if (isset($_SESSION['id'])) {
                        ?>
                        <a href="/account/account.php">
                            <p>Bonjour, &nbsp;
                            <p class="unconnected"><?= getPseudo($_SESSION['id']) ?><i
                                        class="fa-solid fa-angle-down arrow"></i></p>
                            </p>
                        </a>
                        <ul class="user-connection-scrolling-menu">
                            <li><a href="/account/account.php"><p>Mon compte</p></a></li>
                            <li><a href="/write"><p>Écrire</p></a></li>
                            <li><a href="/account/logout.php"><p>Déconnexion</p></a></li>
                        </ul>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="/login">
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
    </header>
</section>

<section class="page-content">

    <?php
    if (!isset($_SESSION['id'])) {
        echo('<div class="error-message">Vous devez être connecté pour écrire un article</div>');
    } else {
        $sql = "SELECT id FROM articles WHERE creator = " . $_SESSION['id'] . " AND visibility = 'not-written'";
        $result = $db->query($sql);
        if ($result->num_rows == 0) {
            $uuid = uniqid();
            $sql = "INSERT INTO articles (uid, creator, visibility) VALUES ('" . $uuid . "', '" . $_SESSION['id'] . "', 'not-written')";
            $result = mysqli_query($db, $sql);
        }
        ?>
        <div class="editor">
            <br/>

            <input class="title" id="title" name="title" placeholder="Titre de l'article" type="text">
            <p class="title-error">Le titre doit faire entre 4 et 50 caractères</p>

            <br/>

            <input class="description" id="description" name="description" placeholder="Description de l'article"
                   type="text">

            <p class="description-error">La description doit faire entre 4 et 200 caractères</p>

            <br/>

            <textarea class="content" id="content" name="content" placeholder="Contenu de l'article"></textarea>


            <div>
                <img src="/images/markdown-logo.svg" class="markdown-logo" alt="Logo Markdown">
                <a href="https://www.ionos.fr/digitalguide/sites-internet/developpement-web/markdown/"
                   alt="Guide Markdown" target="_blank">
                    <p class="markdown-explane">Le contenu supporte le langage <b>Markdown</b> pour mettre en forme
                        votre
                        article.
                        Cliquez pour comprendre comment ça fonctionne.</p>
                </a>
            </div>


            <p class="content-error">Le contenu doit faire entre 30 et 10000 caractères</p>

            <br/>

            <input class="tags" id="tags" name="tags" placeholder="Tags de l'article" type="text">
            <p class="tags-error">Les tags doivent faire entre 0 et 1000 caractères</p>

            <br/>

            <input class="image" id="image" name="image" placeholder="Image de l'article" type="file">
            <br/>

            <button class="submit" id="submit" type="submit">Publier</button>
            <br/>
            <p class="success" id="sucess">L'article a bien été publié, allez le voir <a href="" class="link-article"
                                                                                         id="link-article">ici</a></p>
        </div>

        <?php
    }
    ?>

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
                    <li><a href=""><p>Discord</p></a></li>
                    <li><a href=""><p>Mail</p></a></li>
                    <li><a href=""><p>Instagram</p></a></li>
                </ul>
            </nav>
            <nav>
                <ul>
                    <li><p class="nav-title">Rejoignez-nous</p></li>
                    <li><a href=""><p>veagle.fr</p></a></li>
                    <li><a href=""><p>Discord</p></a></li>
                    <li><a href=""><p>Instagram</p></a></li>
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
                    <li><a href="https://www.instagram.com/nicolas_fsn_/"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                    <li><a href="https://github.com/Mysterious-Developers"><i class="fa-brands fa-github"></i></a></li>
                    <li><a href="https://mysteriousdev.fr" target="_blank"><i
                                    class="fa-solid fa-window-restore"></i></a></li>
                </ul>
            </nav>
        </div>
    </footer>

</section>
</body>
</html>