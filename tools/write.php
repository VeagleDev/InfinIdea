<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
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
    <link rel="stylesheet" href="../css/header.css">
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
        </header>
    </section>
    <?php
        if(!isset($_SESSION['id']))
        {?>
            <p class="unconnected">Vous devez être connecté pour accéder à cette page</p>
            <style>
                .unconnected
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                    align: center;
                }
            </style>
            <?php

        }
        elseif(isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['content']) && isset($_POST['tags']) && $_POST['article'])
        {
            $title = htmlspecialchars($_POST['title']);
            $desc = htmlspecialchars($_POST['desc']);
            $content = htmlspecialchars($_POST['content']);
            $tags = htmlspecialchars($_POST['tags']);
            $article = htmlspecialchars($_POST['article']);
            $author = $_SESSION['id'];

            $sql = "INSERT INTO articles (name, description, content, creator, tags) 
            VALUES ('$title', '$desc', '$content', $author, '$tags')";
            $result = mysqli_query($db, $sql);

            ?>

                <form action="write.php" method="post">
                    <input type="text" name="title" placeholder="Titre" value="<?php echo $title; ?>">
                    <input type="text" name="desc" placeholder="Description" value="<?php echo $desc; ?>">
                    <input type="text" name="content" placeholder="Contenu" value="<?php echo $content; ?>">
                    <input type="hidden" name="article" value="<?php echo $article; ?>">
                    <!-- add disabled button -->

                    <input type="text" name="tags" placeholder="Tags" value="<?php echo $tags; ?>">
                <input type="submit" value="Envoyer"<?php if($result) echo " disabled"; ?>>
                </form>
                <style>
                .form
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                    align: center;

                }
                .input
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                    align: center;
                    color: white;
                    background-color: black;
                    border: none;
                    border-radius: 3px;
                }
                input[type="submit"]
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                    align: center;
                    color: white;
                    background-color: #1e1e1e;
                    border: none;
                    border-radius: 5px;
                    padding: 0.5em;

                }
                </style
            <?php
            if($result) {
                echo "<p style='color: green;'>Votre article a bien été publié !</p>";
            }
            else
            {
                echo "<p style='color: red;'>Une erreur est survenue lors de la publication de votre article.</p>";
            }
        }
        else
        {
            $sql = "INSERT INTO articles (creator, visibility) VALUES ('" . $_SESSION['id'] . "', 'not-written')";
            $result = mysqli_query($db, $sql);
            if(!$result)
            {
                echo '<p style="color:red;">Erreur lors de la création de l\'article';
            }
            else
            {
                $aid = mysqli_insert_id($db);

        ?>

            <form action="write.php" method="post">
                <input type="text" name="title" placeholder="Titre">
                <input type="text" name="desc" placeholder="Description">
                <input type="text" name="content" placeholder="Contenu">
                <input type="text" name="tags" placeholder="Tags">
                <input type="hidden" name="article" value="<?php echo $aid; ?>">
                <input type="submit" value="Envoyer">
            </form>
            <style>
                <!-- make beautiful css for the form -->
                .form
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                    align: center;

                }
                .input
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                    align: center;
                    color: white;
                    background-color: black;
                    border: none;
                    border-radius: 3px;
                }
                input[type="submit"]
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                    align: center;
                    color: white;
                    background-color: #1e1e1e;
                    border: none;
                    border-radius: 5px;
                    padding: 0.5em;

                }
            </style>
            <?php
            }
        }
        ?>
</body>
</html>

