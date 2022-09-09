<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->


<!-- PAGE PRINCIPALE, JE TE LAISSE FAIRE TOUT LE FRONT-END -->
<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'tools.php';
require_once 'autoconnect.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProject : Explorer</title>
</head>
<body>
    <h1>MyProject - Explorer</h1>

    <?php
    $db = getDB();
    if(isset($_GET['article']))
    {
        $sql = "SELECT name, description, content, creator, created, modified, tags, views, likes FROM articles WHERE id = " . $_GET['article'] . " AND visibility = 'public';";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $sql = "UPDATE articles SET views = views + 1 WHERE id = " . $_GET['article'] . ";";
        mysqli_query($db, $sql);
        echo '<h2>' . $row['name'] . '</h2>';
        echo '<p>' . $row['description'] . '</p>';
        echo '<p>' . $row['content'] . '</p>';
        echo '<p>Créé par ' . getPseudo($row['creator']) . '</p>';
        echo '<p>Publié : ' . correctTimestamp(strtotime($row['created'])) . '</p>';
        echo '<p>Tags : ' . $row['tags'] . '</p>';
        echo '<p>Vues : ' . $row['views'] . '</p>';
        echo '<p>Likes : ' . $row['likes'] . '</p>';
        // make a modify button if the user is the creator
        if(isset($_SESSION['id']) && $_SESSION['id'] == $row['creator'])
        {
            echo '<a href="modify.php?article=' . $_GET['article'] . '">Modifier</a>';
        }
        // add a like button if the user is connected
        if(isset($_SESSION['id']))
        {
            echo '<a href="like.php?article=' . $_GET['article'] . '">Like</a>';
        }


    }
    else
    {
        $sql = "SELECT id, name, description, content, creator, created, tags, views FROM articles WHERE visibility = 'public' ORDER BY created DESC";
        $result = mysqli_query($db, $sql);
        if($result)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                // create a card for each article
                echo '<a href="explore.php?article='.$row['id'].'">';
                echo '<div class="card">';
                echo '<h2>'.$row['name'].'</h2>';
                echo '<p>'.$row['description'].'</p>';
                echo '<p>Écrit par '. getPseudo($row['creator']) . ' le ' . $row['created'] . '</p>';
                echo '<p>'.$row['tags'].'</p>';
                echo '<p>'.$row['views'].' vues</p>';
                echo '</div>';
                echo '</a>';

            }

        }
        else
        {
            echo 'Erreur : '.mysqli_error($db);
        }

    }
    ?>

    <!-- create nice style for the cards -->
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
        }
        .card {
            background-color: #ffffff;
            color: #000000;
            padding: 10px;
            margin: 10px;
            border-radius: 10px;

        }
    </style>



</body>

<?php
logs('explorer', 'utilisateur se rend sur la page d\'exploration', (isset($_SESSION['id']) ? $_SESSION['id'] : 0));
?>



</html>