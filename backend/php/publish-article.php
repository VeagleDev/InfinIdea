<?php
set_include_path('/var/www/blog');

if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once 'account/autoconnect.php';
require_once 'tools/tools.php';

$db = getDB();

logs('Débute la publication d\'\'un article');

if (
    isset($_POST['title']) &&
    isset($_POST['description']) &&
    isset($_POST['content']) &&
    isset($_POST['tags'])
) {
    $title = SQLpurify($_POST['title']);
    $description = SQLpurify($_POST['description']);
    $content = SQLpurify($_POST['content']);
    $tags = SQLpurify($_POST['tags']);


    $author = $_SESSION['id'];


    $sql = "SELECT * INTO articles WHERE creator = " . $author . " AND visibility = 'not-written' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($db, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $aid = $row['id'];
        $sql = "UPDATE articles SET 
                    name = '$title', 
                    description = '$description', 
                    content = '$content', 
                    visibility = 'public',
                    modified = NOW() 
                WHERE id = $aid";
        $result = mysqli_query($db, $sql);
        if ($result) {
            logs('Article publié avec succès');
            echo "0";
        } else {
            logs('Erreur lors de la publication de l\'article');
            echo "2";
        }
    } else {
        echo "3";
    }
} else {
    logs('Erreur : Tous les champs ne sont pas remplis');
    echo "1";
    die();
}



