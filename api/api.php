<?php

set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';
$db = getDB();

if(isset($_POST['comment']) && isset($_POST['article']) && isset($_SESSION['id']) && isset($_GET['action']))
{
    $comment = SQLpurify($_POST['comment']);
    $article = SQLpurify($_POST['article']);
    $action = HTMLPurify($_GET['action']);

    if($action == 'comment')
    {
        $sql = "INSERT INTO comments (aid, uid, message) VALUES ($article, " . $_SESSION['id'] . ", '$comment')";
        mysqli_query($db, $sql);
        die();
    }
}

if((isset($_POST['article']) || isset($_GET['article'])) && isset($_GET['action']))
{
    $action = HTMLPurify($_GET['action']);
    if($action == 'likes')
    {
        $article = SQLpurify(isset($_POST['article']) ? $_POST['article'] : $_GET['article']);
        $sql = "SELECT likes FROM articles WHERE id = $article";
        $result = mysqli_query($db, $sql);
        $likes = mysqli_fetch_assoc($result)['likes'];
        echo $likes;
        die();
    }
    elseif($action == 'comments')
    {
        $article = SQLpurify(isset($_POST['article']) ? $_POST['article'] : $_GET['article']);
        $sql = "SELECT * FROM comments WHERE aid = $article";
        $result = mysqli_query($db, $sql);
        // make json array of username, message, date
        $comments = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $comment = array();
            $comment['username'] = getPseudo($row['uid']);
            $comment['message'] = $row['message'];
            $comment['date'] = correctTimestamp($row['time']);
            $comments[] = $comment;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($comments);
        die();
    }
    elseif($action == 'views')
    {
        $article = SQLpurify(isset($_POST['article']) ? $_POST['article'] : $_GET['article']);
        $sql = "SELECT views FROM articles WHERE id = $article";
        $result = mysqli_query($db, $sql);
        $views = mysqli_fetch_assoc($result)['views'];
        echo $views;
        die();
    }
    elseif($action == 'article')
    {
        $article = SQLpurify(isset($_POST['article']) ? $_POST['article'] : $_GET['article']);
        $sql = "SELECT * FROM articles WHERE id = $article";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row['blocked'] == 1 || $row['visibility'] != 'public')
        {
            echo json_encode(array());
            die();
        }

        $infos = array();
        $infos['title'] = $row['name'];
        $infos['description'] = $row['description'];
        $infos['content'] = $row['content'];
        $infos['author'] = getPseudo($row['creator']);
        $infos['date'] = correctTimestamp($row['created']);
        $infos['likes'] = $row['likes'];
        $infos['views'] = $row['views'];
        $infos['tags'] = explode(',', $row['tags']);
        foreach($infos['tags'] as $key => $tag)
        {
            $infos['tags'][$key] = trim($tag);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($infos);
        die();
    }

}

