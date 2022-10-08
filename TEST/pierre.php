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
    echo "<p style='color:blue;'>" . $aid . "</p>";
}
