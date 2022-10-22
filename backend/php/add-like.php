<?php

set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php'; // On inclut le fichier autoconnect.php
require_once 'tools/tools.php'; // On inclut le fichier tools.php
$db = getDB(); // On récupère la base de données

if (isset($_GET['article']) && isset($_SESSION['id'])) { // Si l'article et l'utilisateur sont définis
    $id = SQLpurify($_GET['article']); // On récupère l'id de l'article
    $sql = "SELECT * FROM likes WHERE aid = " . $id . " AND uid = " . $_SESSION['id']; // On prépare la requête
    mysqli_query($db, $sql); // On exécute la requête

    if (mysqli_affected_rows($db) == 0) { // Si l'utilisateur n'a pas encore liké l'article
        $sql = "INSERT INTO likes (aid, uid) VALUES (" . $id . ", " . $_SESSION['id'] . ")"; // On prépare la requête
        mysqli_query($db, $sql); // On exécute la requête
        $sql = "UPDATE articles SET likes = likes + 1 WHERE id = " . $id; // On prépare la requête
        mysqli_query($db, $sql); // On exécute la requête
    } else { // Si l'utilisateur a déjà liké l'article
        $sql = "DELETE FROM likes WHERE aid = " . $id . " AND uid = " . $_SESSION['id'];  // On prépare la requête
        mysqli_query($db, $sql); // On exécute la requête
        $sql = "UPDATE articles SET likes = likes - 1 WHERE id = " . $id; // On prépare la requête
        mysqli_query($db, $sql); // On exécute la requête
    }
}