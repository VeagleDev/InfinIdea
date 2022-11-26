<?php

function getTrendArticles($limit = 10): array
{
    set_include_path('/var/www/blog/');
    require_once 'tools/tools.php';

    $db = getDB();

    $sql = "SELECT * FROM articles WHERE visibility = 'public' AND blocked = 0 LIMIT 10000";
    $query = $db->query($sql);
    $result = mysqli_query($db, $sql);
    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($articles as $key => $article) {

        $sql = "SELECT id FROM views WHERE aid = " . $article['id'];
        $result = mysqli_query($db, $sql);
        $articles[$key]['views'] = mysqli_num_rows($result);


        $sql = "SELECT id FROM likes WHERE aid = " . $article['id'];
        $result = mysqli_query($db, $sql);
        $articles[$key]['likes'] = mysqli_num_rows($result);

        $sql = "SELECT id FROM comments WHERE aid = " . $article['id'];
        $result = mysqli_query($db, $sql);
        $articles[$key]['comments'] = mysqli_num_rows($result);
    }

    foreach ($articles as $key => $article) {
        $score = $article['views'] * 1 + $article['likes'] * 3 + $article['comments'] * 2;
        $recent = time() - strtotime($article['created']);
        if ($recent < 43200) {
            $score = $score * 2;
        } elseif ($recent < 86400) {
            $score = $score * 1.5;
        } elseif ($recent < 172800) {
            $score = $score * 1.2;
        }
        $articles[$key]['score'] = $score;

    }

    usort($articles, function ($a, $b) {
        return $b['score'] - $a['score'];
    });

    return array_slice($articles, 0, $limit);
}


