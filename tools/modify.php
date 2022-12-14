<?php

// Page à refaire
set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';


echo '<p style="color:blue;">Cette page n\'est malheureusement pas encore disponible ...</p>';
die();

// si l'utilisateur est connecté
if(!isset($_SESSION['id']))
{
    echo "<p style=\"color:red;\">Il faut être connecté pour modifier un article !</p>";
    die();
}


if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['content']) && isset($_POST['tags']))
{
    $id = SQLpurify($_POST['id']);
    $title = SQLpurify($_POST['title']);
    $desc = SQLpurify($_POST['desc']);
    $content = SQLpurify($_POST['content']);
    $tags = SQLpurify($_POST['tags']);

    $db = getDB();
    $sql = "SELECT * FROM articles WHERE id = $id";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            if ($row['creator'] != $_SESSION['id']) {
                echo "<p style=\"color:red;\">Vous n'avez pas le droit de modifier cet article !</p>";
                die();
            }
        }
        else {
            echo "<p style=\"color:red;\">Cet article n'existe pas !</p>";
            die();
        }
    }
    else {
        echo "<p style=\"color:red;\">Erreur lors de la modification de l'article !</p>";
        die();
    }

    $sql = "UPDATE articles SET name = '$title', description = '$desc', content = '$content', tags = '$tags' WHERE id = $id";
    $result = mysqli_query($db, $sql);
    if($result)
    {
        echo "Article modifié";
    }
    else
    {
        echo "Erreur lors de la modification de l'article";
        die();
    }


}
elseif(isset($_GET['article']))
{
    $db = getDB();
    $id = SQLpurify($_GET['article']);
    $sql = "SELECT * FROM articles WHERE id = $id";
    $result = mysqli_query($db, $sql);
    // if result found
    if( $result )
    {
        $row = mysqli_fetch_assoc($result);

        if($row['creator'] != $_SESSION['id'])
        {
            echo "<p style=\"color:red;\">Vous n'avez pas le droit de modifier cet article !</p>";
            die();
        }
        else
        {
            ?>
            <h1>MyProject - Modifier un article</h1>
            <form action="modify.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="<?php echo $row['name']; ?>">
                <label for="desc">Description</label>
                <input type="text" name="desc" id="desc" value="<?php echo $row['description']; ?>">
                <label for="content">Contenu</label>
                <textarea name="content" id="content" cols="30" rows="10"><?php echo $row['content']; ?></textarea>
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" value="<?php echo $row['tags']; ?>">
                <input type="submit" value="Modifier">
            </form>
            <!-- nice style for the form and the textarea -->
            <style>
                form {
                    display: flex;
                    flex-direction: column;
                    width: 50%;
                    margin: 0 auto;
                }
                form label {

                    margin-top: 10px;
                }
                form input, form textarea {
                    padding: 5px;
                    border: 1px solid #000;
                }
                form textarea {
                    resize: none;
                }
            <?php
        }
    }
}
else {
    echo "<p style=\"color:red;\">Il faut spécifier un article à modifier !</p>";
    die();
}