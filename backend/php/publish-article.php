<?php
set_include_path('/var/www/blog');

if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once 'account/autoconnect.php';
require_once 'tools/tools.php';
require_once 'vendor/autoload.php';

use League\CommonMark\CommonMarkConverter;

$db = getDB();

logs('Débute la publication d\'\'un article');

if (
    isset($_POST['title']) &&
    isset($_POST['description']) &&
    isset($_POST['content']) &&
    isset($_POST['tags'])
) {

    // wait a second
    sleep(1);

    $title = SQLpurify($_POST['title']);
    $description = SQLpurify($_POST['description']);
    $content = $_POST['content'];
    $tags = SQLpurify($_POST['tags']);

    $converter = new CommonMarkConverter([
        'html_input' => 'allow',
        'allow_unsafe_links' => true,
    ]);

    $content = $converter->convert($content);
    $content = SQLpurify($content);
    $author = $_SESSION['id'];

    $title_regex = '/^.{4,50}$/';
    $description_regex = '/^.{4,200}$/';
    $content_regex = '/^[\s\S]{30,10000}$/';
    $tags_regex = '/^.{0,1000}$/';

    if (!preg_match($title_regex, $title)) {
        logs('Le titre n\'\'est pas valide');
        echo "Le titre n'est pas valide";
        exit();
    }

    if (!preg_match($description_regex, $description)) {
        logs('La description n\'\'est pas valide');
        echo "La description n'est pas valide";
        exit();
    }

    if (!preg_match($content_regex, $content)) {
        logs('Le contenu n\'\'est pas valide');
        echo "Le contenu n'est pas valide";
        exit();
    }

    if (!preg_match($tags_regex, $tags)) {
        logs('Les tags ne sont pas valide');
        echo "Les tags ne sont pas valide";
        exit();
    }


    $sql = "SELECT * FROM articles WHERE name = '" . $title . "'";
    if (mysqli_num_rows(mysqli_query($db, $sql)) > 0) {
        logs('L\'\'article existe déjà');
        echo "4";
        exit();
    }

    $sql = "SELECT * FROM articles WHERE creator = " . $author . " AND visibility = 'not-written' ORDER BY id DESC LIMIT 1";
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
            echo "https://infinidea.veagle.fr/article.php?id=" . $row['uid'];
        } else {
            logs('Erreur lors de la publication de l\'\'article');
            echo "2";
        }
    } else {
        echo "3";
    }
} else {
    logs('Erreur publication : Tous les champs ne sont pas remplis');
    echo "1";
    die();
}



