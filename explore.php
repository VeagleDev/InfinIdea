<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
    require_once 'account/autoconnect.php';
    require_once 'tools/tools.php';
}

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
                <img src="images/logo.png" alt="MysteriousDevelopers creation" class="logo-top">
                <ul class="main-list">
                    <li class="first-child"><a href=""><p>Explorer &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                    <li class="first-child"><a href=""><p>Recommendations &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                    <li class="first-child"><a href=""><p>Lus récemmment &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                    <li class="first-child"><a href=""><p>A propos &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                </ul>
            </nav>
            <nav class="user-connection-interaction-nav">
                <ul class="user-connection-interaction-list">
                    <li class="user-menu">
                        <a href="">
                            <p>
                                <?php if(!isset($_SESSION['id']))
                                {
                                    echo('Bonjour, &nbsp;<p class="unconnected">connectez-vous &nbsp;<i class="fa-solid fa-angle-down"></i></p>');
                                }    
                                else
                                {
                                    echo('Bonjour, &nbsp;<p class="unconnected">' . getPseudo($_SESSION['id']) . '&nbsp;<i class="fa-solid fa-angle-down"></i></p>');
                                }                               
                                    ?>
                                </p>
                            <ul class="user-connection-scrolling-menu">
                                <li><a href=""><p>Mon compte</p></a></li>
                                <li><a href=""><p>Comment se connecter ?</p></a></li>
                                <li><a href=""><p>A propos</p></a></li>
                                <li><a href=""><p>Mes projets</p></a></li>
                                <li><a href=""><p>Conditions d'utilisations</p></a></li>
                                <li><a href=""><p>Paramètres</p></a></li>
                            </ul>
                        </a>                       
                    </li>  
                    <a href="" class="sign-in unconnected"><li class="sign-in-sub-element"><p>S'inscrire</p></li></a>
                </ul>
            </nav>
        </header>
    </section>

    <section class="contents-page">
        <div class="card-container">

            <?php
                $db = getDB();
                $sql = "SELECT * FROM articles ORDER BY created DESC LIMIT 6;";
                $result = mysqli_query($db, $sql);
                while($row = mysqli_fetch_assoc($result))
                {
                    echo('

                        <a href="article.php?id=' . $row['id'] . '" class="card">
                        <img src="images/uploads/' . $row['id'] . '.jpg" class="presentation-photo">
                        <div class="text-container">
                            <h3>' . $row['name'] . '</h3>
                            <div class="statistics-container">
                                <p class="views-number">' . $row['views'] . ' vues</p>
                                <p class="date-upload">' . correctTimestamp($row['created']) . '</p>
                            </div>
                            <p class="description">' . $row['description'] . '</p>
                        </div>            
                    </a>

                    ');
                }

            ?>
        </div>
    </section>
</body>
</html>