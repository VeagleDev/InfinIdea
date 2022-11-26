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
    $sql = "SELECT * FROM views WHERE aid = :article_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':article_id', $article['id']);
    $stmt->execute();
    $views = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $articles[$key]['views'] = count($views);

    $sql = "SELECT * FROM likes WHERE aid = :article_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':article_id', $article['id']);
    $stmt->execute();
    $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $articles[$key]['likes'] = count($likes);

    $sql = "SELECT * FROM comments WHERE aid = :article_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':article_id', $article['id']);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $articles[$key]['comments'] = count($comments);
}

// foreach article, calculate the score
// score = views * 0.2 + likes * 0.5 + comments * 0.3
foreach ($articles as $key => $article) {
    $articles[$key]['score'] = $article['views'] * 0.2 + $article['likes'] * 0.5 + $article['comments'] * 0.3;
}

// sort the articles by score
$articles = array_sort($articles, 'score', SORT_DESC);

// print the articles
foreach ($articles as $article) {
    echo $article['title'] . ' - ' . $article['score'] . '<br>';
}

