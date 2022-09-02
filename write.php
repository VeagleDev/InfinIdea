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
require_once 'autoconnect.php';
require_once 'tools.php';

// si l'utilisateur est connecté
if(isset($_POST['title']) && isset($_POST['content']))
{
    echo "Publication de l'article...";
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['id'];
    echo "Article de " . getPseudo($author) . " : " . $title . " : " . $content;
}
else
{
    // si l'utilisateur a envoyé un article
    if (!isset($_SESSION['id'])) {
        echo "Il faut être connecté pour publier un article !";
        die();
    }
    ?>
    <h1>MyProject - Article</h1>
    <p>Bienvenue sur MyProject, <?=getPseudo($_SESSION['id'])?>  sur la page d'écriture !</p>
    <!-- formulaire avec champs pour le titre, et le contenu de l'article avec un bouton submit-->
    <form action="write.php" method="post">
        <input type="text" name="title" placeholder="Titre de l'article">
        <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenu de l'article"></textarea>
        <input type="submit" value="Publier">
    </form>
    <?php

}