<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once '../account/autoconnect.php';
require_once 'tools.php';

if(!isset($_SESSION['id']))
{
    echo "<p style=\"color:red;\">Il faut être connecté pour liker un article !</p>";
    die();
}

if(isset($_GET['article']))
{
    $article = htmlspecialchars($_GET['article']);

    $db = getDB();
    $sql = "SELECT * FROM articles WHERE id = $article";
    $result = mysqli_query($db, $sql);

    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if($row)
        {
            $likes = $row['likes'];

            $sql = "SELECT COUNT(*) FROM views WHE";
            $likes++;
            $sql = "UPDATE articles SET likes = $likes WHERE id = $article";
            $result = mysqli_query($db, $sql);
            header("Location: explore.php?article=$article");
        }
        else
        {
            echo "Cet article n'existe pas";
            die();
        }
    }
    else
    {
        echo "Erreur lors du like de l'article";
        die();
    }
}
else
{
    echo "Erreur lors du like de l'article";
    die();
}