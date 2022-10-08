<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';

$db = getDB();

$sql = "SELECT id FROM articles";
$result = mysqli_query($db, $sql);
$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach($articles as $article)
{
    $aid = $article['id'];
    $uid = uniqid();
    $sql = "UPDATE articles SET uid = '" . $uid . "'";
    $result = mysqli_query($db, $sql);
    if($result)
    {
        echo '<p style="color:black">Le UID de l\'article n°' . $aid . ' à été mis à ' . $uid;
        sleep(0.25);
    }
    else
    {
        echo '<p style="color:red;">Erreur lors du changement de l\'UID de ' . $aid . ' : ' . mysqli_error($db);
    }
}
