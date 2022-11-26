<?php
set_include_path('/var/www/blog/');
require_once 'tools/tools.php';
require_once 'account/autoconnect.php';

$db = getDB();

$sql = "SELECT * FROM articles";
$query = $db->query($sql);
$result = mysqli_query($db, $sql);
$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($articles as $key => $article) {

    $sql = "SELECT id FROM comments WHERE aid = " . $article['id'];
    $result = mysqli_query($db, $sql);
    $articles[$key]['views'] = mysqli_num_rows($result);


    $sql = "SELECT id FROM likes WHERE aid = " . $article['id'];
    $result = mysqli_query($db, $sql);
    $articles[$key]['likes'] = mysqli_num_rows($result);

    $sql = "SELECT id FROM comments WHERE aid = " . $article['id'];
    $result = mysqli_query($db, $sql);
    $articles[$key]['comments'] = mysqli_num_rows($result);
}

// foreach article, calculate the score
// score = views * 0.2 + likes * 0.5 + comments * 0.3
foreach ($articles as $key => $article) {
    $articles[$key]['score'] = $article['views'] * 0.2 + $article['likes'] * 0.5 + $article['comments'] * 0.3;
}

// sort the articles by score
asort($articles);


// print the articles
foreach ($articles as $article) {
    echo $article['title'] . ' - ' . $article['score'] . ' | (' . $article['views'] . ' vues, ' . $article['likes'] . ' likes, ' . $article['comments'] . ' commentaires)' . '<br />';
}

