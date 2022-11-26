<?php

function getTrendArticles($limit = 10)
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

// foreach article, calculate the score
// score = views * 0.2 + likes * 0.5 + comments * 0.3
    foreach ($articles as $key => $article) {
        // add up to 100% of the score if the article is recenntly published
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

// sort the articles by score
    usort($articles, function ($a, $b) {
        return $b['score'] - $a['score'];
    });


// print the articles
    foreach ($articles as $article) {
        echo $article['name'] . ' --> ' . $article['score'] . ' | (' . $article['views'] . ' vues, ' . $article['likes'] . ' likes, ' . $article['comments'] . ' commentaires)' . '<br />';
    }
    return array_slice($articles, 0, $limit);
}


