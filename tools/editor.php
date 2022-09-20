<?php
set_include_path('/var/www/blog');

if(isset($_POST['content']))
{
    require_once 'tools/Parsedown.php';
    $Parsedown = new Parsedown();
    $content = htmlspecialchars($_POST['content']);
    ?>
    <form method="post">
        <textarea name="content"><?php echo $content; ?></textarea>
        <input type="submit" value="Convertir">
    </form>
    <style>
        textarea {
            width: 100%;
            height: 500px;
        }
        input {
            width: 100%;
            height: 50px;
        }
        <!-- add colors and style here -->
    </style>
    <?php
    $Parsedown->setUrlsLinked(true);
    $mardown = $Parsedown->text($content);
    ?>
    <div>
        <pre><code>Résultat : </code></pre>
        <p>
            <?php echo $mardown; ?>
        </p>
    </div>
    <?php
}
else
{
    // faire un champ de texte pour écrire le markdown et un bouton pour le convertir en html
    ?>
    <form method="post">
        <textarea name="content"></textarea>
        <input type="submit" value="Convertir">
    </form>
    <style>
        textarea {
            width: 100%;
            height: 500px;
        }
        input {
            width: 100%;
            height: 50px;
        }
        <!-- add colors and style here -->
    </style>
    <?php
    die();

}