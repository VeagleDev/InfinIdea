<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->

<!-- IL FAUT FAIRE LA PAGE POUR ECRIRE DES ARTICLES, TU PEUX CHERCHER
UN EDITEUR SUR GITHUB, POUR QUE JE PUISSE RECUPERER LE TEXTE,
IL FAUT QUE TU FASSES UN CHAMP INPUT CACHÉ QUI CONTIENT L'ARTICLE TRANSFORME EN HTML,
LE CHAMP RESSEMBLERA A CA : input type="hidden" name="article" value="<p>Mon article</p>">
ET IL FAUT QUE CA L'ENVOIE AVEC POST VERS LA PAGE write.php comme ça :

<form action="write.php" method="post">
            <input type="hidden" name="article" value="<p>Mon article</p>">
            <input type="submit" value="Publier">
</form>

ET TU CHANGERAS LA VALEUR DE article AVEC LA FONCTION QUI SERA SUREMENT EN JavaScript.
-->

<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools.php';

// si l'utilisateur est connecté
if(isset($_POST['title']) && isset($_POST['content']))
{
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    if(isset($_POST['desc']))
    {
        $desc = htmlspecialchars($_POST['desc']);
    }
    else
    {
        $desc = '';
    }
    if(isset($_POST['tags']))
    {
        $tags = htmlspecialchars($_POST['tags']);
    }
    else
    {
        $tags = '';
    }
    $author = $_SESSION['id'];





    $db = getDB();
    $sql = "INSERT INTO articles ( name, description, content, creator, tags) 
            VALUES ('$title', '$desc', '$content', $author, '$tags')";
    $result = mysqli_query($db, $sql);
    if($result)
    {

        echo "Article publié";
        // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
        if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0)
        {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['screenshot']['size'] <= 8000000)
            {
                // Testons si l'extension est autorisée
                $fileInfo = pathinfo($_FILES['screenshot']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions))
                {
                    // On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($_FILES['screenshot']['tmp_name'], 'uploads/' . mysqli_insert_id($db) . '.' . $extension);
                    echo "L'envoi a bien été effectué !";
                }
            }
        }


    }
    else
    {
        echo "Rien n'a été publié";
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
    <p>Bienvenue sur MyProject, <?=getPseudo($_SESSION['id'])?>  sur la page d'écriture !</p>
    <!-- formulaire avec champs pour le titre, et le contenu de l'article avec un bouton submit-->
    <form action="write.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre de l'article">
        <input type="text" name="desc" placeholder="Description de l'article">
        <input type="text" name="tags" placeholder="Tags de l'article">

        <div class="mb-3">
            <label for="screenshot" class="form-label">Votre capture d'écran</label>
            <input type="file" class="form-control" id="screenshot" name="screenshot" />
        </div>

        <!-- Nice text area -->
        <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenu de l'article"></textarea>
        <input type="submit" value="Publier">
    </form>


    <!-- stylesheet for the form -->
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input {
            margin: 10px;

        }
        textarea {
            width: 100%;
            height: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            resize: none;
        }
        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <?php

}