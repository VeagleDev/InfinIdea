<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';
$db = getDB();


if(isset($_POST['image']) && isset($_POST['article']))
{
    $img = htmlspecialchars($_POST['image']);
    $article = htmlspecialchars($_POST['article']);

    if(articleExists($article))
    {
        $sql = "SELECT id FROM articles WHERE id = " . $article . " AND creator = " . $_SESSION['id'];
        $result = mysqli_query($db, $sql);
        // On vérifie que l'article existe bien et qu'il appartient bien à l'utilisateur
        if(mysqli_num_rows($result) == 1) {
            // create an unique id for the image
            $id = uniqid();
            $sql = "INSERT INTO images(uid, aid) VALUES(" . $id . ", " . $article . ")";
            $result = mysqli_query($db, $sql);
            if($result)
            {
                $path = 'images/uploads/body/' . $id . '.jpg';
                $base_to_php = explode(',', $img);
                $data = base64_decode($base_to_php[1]);
                file_put_contents($path, $data);
                $absolute_path = 'https://infinidea.veagle.fr/' . $path;
                $sql = "UPDATE images SET path = '" . $absolute_path . "' WHERE uid = " . $id;
                $result = mysqli_query($db, $sql);
                $markdown = '![](' . $absolute_path . ')';
                echo($markdown);
            }
            else
            {
                echo("Error while inserting the image in the database");
            }

        }
        else
        {
            echo("You don't have the right to add an image to this article");
        }
    }
    else
    {
        echo "Article doesn't exist";
    }

}