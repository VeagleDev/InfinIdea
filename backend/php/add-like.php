<?php

set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';
$db = getDB();

if (isset($_GET['article']) && isset($_SESSION['id'])) {
    $id = SQLpurify($_GET['article']);
    $sql = "SELECT * FROM likes WHERE aid = " . $id . " AND uid = " . $_SESSION['id'];
    mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) == 0) {
        $sql = "INSERT INTO likes (aid, uid) VALUES (" . $id . ", " . $_SESSION['id'] . ")";
        mysqli_query($db, $sql);
        $sql = "UPDATE articles SET likes = likes + 1 WHERE id = " . $id;
        mysqli_query($db, $sql);
    } else {
        $sql = "DELETE FROM likes WHERE aid = " . $id . " AND uid = " . $_SESSION['id'];
        mysqli_query($db, $sql);
        $sql = "UPDATE articles SET likes = likes - 1 WHERE id = " . $id;
        mysqli_query($db, $sql);
    }
}
