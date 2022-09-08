<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'autoconnect.php';
require_once 'tools.php';


// si l'utilisateur est connecté
if(!isset($_SESSION['id']))
{
    echo "<p style=\"color:red;\">Il faut être connecté pour modifier un article !</p>";
    die();
}

if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['content']) && isset($_POST['tags']))
{
    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $desc = htmlspecialchars($_POST['desc']);
    $content = htmlspecialchars($_POST['content']);
    $tags = htmlspecialchars($_POST['tags']);

    $author = $_SESSION['id'];

    if($id == $author)
    {
        $db = getDB();
        $sql = "UPDATE articles SET name = '$title', description = '$desc', content = '$content', tags = '$tags' WHERE id = $id";
        $result = mysqli_query($db, $sql);
        if($result)
        {
            echo "Article modifié";
        }
        else
        {
            echo "Erreur lors de la modification de l'article";
        }
    }
    else
    {
        echo "<p style=\"color:red;\">Vous n'avez pas le droit de modifier cet article</p>";
    }

}
else
{
    // si l'utilisateur a envoyé un article
    if (!isset($_SESSION['id'])) {
        echo "<p style=\"color:red;\">Il faut être connecté pour publier un article !</p>";
        die();
    }
    ?>
    <h1>MyProject - Article</h1>
    <form action="modify.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" value="<?php echo $_GET['title']; ?>">
        <label for="desc">Description</label>
        <input type="text" name="desc" id="desc" value="<?php echo $_GET['desc']; ?>">
        <label for="content">Contenu</label>
        <textarea name="content" id="content" cols="30" rows="10"><?php echo $_GET['content']; ?></textarea>
        <label for="tags">Tags</label>
        <input type="text" name="tags" id="tags" value="<?php echo $_GET['tags']; ?>">
        <input type="submit" value="Modifier">
    </form>
    <?php
}
if(isset($_GET['article']))
{
    $db = getDB();
    $id = $_GET['article'];
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
            <?php
        }
    }
}
else
{
    echo "<p style=\"color:red;\">Il faut spécifier un article à modifier !</p>";
    die();
}