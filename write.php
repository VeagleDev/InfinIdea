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
session_start() ;
$db = getDB();

if(isset($_SESSION['id']))
{

}
