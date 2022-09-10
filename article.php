<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';

$db = getDB();

?>

<!DOCTYPE html>
<html lang="fr">
<!-- make a header and a container for the article -->
<head>
    <meta charset="UTF-8">
    <title>Article</title>
    <script src="tools/like.js"></script>
</head>
<body>
    <h1>MyProject - Article</h1>

<?php



if(isset($_GET['id'])) {

    $id = htmlspecialchars($_GET['id']);

    $sql = "SELECT COUNT(*) FROM articles WHERE id = $id";
    $result = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) == 0) {
        echo '<p style="color:red;">Cet article n\'existe pas</p>';
        die();
    }

    if (isset($_GET['action']) && isset($_SESSION['id'])) {
        $param = htmlspecialchars($_GET['action']);
        if ($_GET['action'] == 'like') {
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

    }

    $sql = "SELECT * 
            FROM views 
            WHERE             
            aid = " . $id . " 
            AND date > DATE_SUB(NOW(), INTERVAL 10 MINUTE)
            AND (" . (isset($_SESSION['id']) ? "uid = " . $_SESSION['id'] . " OR " : "") . "ip = '" . getIP() . "')";

    echo $sql;

    $result = mysqli_query($db, $sql);

    $do = mysqli_affected_rows($db) == 0;


    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['uid'] == 0) {
            if ($row['ip'] == getIP()) {
                $do = false;
            } else {
                $do = true;
            }
        }
    }

    if ($do) {
        $sql = "INSERT INTO views (ip, aid, uid) VALUES ('" . getIP() . "', $id, " . (isset($_SESSION['id']) ? $_SESSION['id'] : "0") . ")";
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
    echo "<p><span id='likeCounter'>" . $row['likes'] . "</span> likes</p>";
    echo "<p>Créé : " . correctTimestamp($row['created']) . "</p>";
    echo "<p>Modifié : " . correctTimestamp($row['modified']) . "</p>";
    echo "<p>Écrit par : " . $row['creator'] . "</p>";
    echo "<br />";

    if (isset($_SESSION['id'])) {
        $sql = "SELECT * FROM likes WHERE aid = $id AND uid = " . $_SESSION['id'];
        $result = mysqli_query($db, $sql);
        if (mysqli_affected_rows($db) == 0) {
            echo "<button onclick='performLike(" . $id . ")'><span id='likeButton'>Like</span></button>";
        } else {
            echo "<button onclick='performLike(" . $id . ")'><span id='likeButton'>Unlike</span></button>";
        }
    }
}

?>


</body>
</html>
