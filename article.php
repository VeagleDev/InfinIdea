<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once '/tools/autoconnect.php';
require_once '/tools/tools.php';

?>

<!DOCTYPE html>
<html lang="fr">
<!-- make a header and a container for the article -->
<head>
    <meta charset="UTF-8">
    <title>Article</title>
</head>
<body>
    <h1>MyProject - Article</h1>

<?php

if(isset($_GET['id']))
{
    $id = htmlspecialchars($_GET['id']);
    $db = getDB();
    $sql = "SELECT COUNT(*) FROM articles WHERE id = $id";
    $result = mysqli_query($db, $sql);
    if(mysqli_affected_rows($db) == 0)
    {
        echo '<p style="color:red;">Cet article n\'existe pas</p>';
        die();
    }
    $sql = "SELECT * FROM views WHERE ip = '" . getIP() . "'" . (isset($_SESSION['id']) ? " OR uid = " . $_SESSION['id'] : "") . " AND aid = $id";
    echo '<p style="color:blue">' . $sql . '</p>';
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    if(mysqli_affected_rows($db) == 0)
    {
        $sql = "INSERT INTO views (ip, aid, uid) VALUES ('" . getIP() . "', $id, " . (isset($_SESSION['id']) ? $_SESSION['id'] : "0") . ")";
        echo '<p style="color:blue">' . $sql . '</p>';
        $result = mysqli_query($db, $sql);
        $sql = "SELECT COUNT(*) FROM views WHERE aid = $id";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['COUNT(*)'];
        $sql = "UPDATE articles SET views = $count WHERE id = $id";
        $result = mysqli_query($db, $sql);
    }
    $sql = "SELECT * FROM articles WHERE id = $id";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    echo "<h2>" . $row['name'] . "</h2>";
    echo "<p>" . $row['content'] . "</p>";
    echo "<p>" . $row['views'] . " vues</p>";
    echo "<p>" . $row['likes'] . " likes</p>";
    echo "<p>Créé : " . correctTimestamp($row['created']) . "</p>";
    echo "<p>Modifié : " . correctTimestamp($row['modified']) . "</p>";
    echo "<p>Écrit par : " . $row['creator'] . "</p>";
    echo "<p><a href=\"explore.php\">Retour au menu</a></p>";
}
