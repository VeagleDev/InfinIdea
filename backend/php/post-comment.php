<?php

set_include_path('/var/www/blog/');
require_once 'tools/tools.php';
require_once 'account/autoconnect.php';

$db = getDB();

header('Content-Type: application/json');
$data = [];

if (isset($_POST['comment']) && isset($_POST['aid']) && isset($_SESSION['id'])) {

    $comment = SQLpurify($_POST['comment']);
    $aid = SQLpurify($_POST['aid']);
    $aid = getArticleIdFromUID($aid);

    if ($aid == 0) {
        $data['success'] = false;
        $data['message'] = "Article introuvable";
        goto end;
    }

    $uid = $_SESSION['id'];
    $data['pseudo'] = getPseudo($_SESSION['id']);


    $sql = "INSERT INTO comments (aid, uid, message) VALUES ('$aid', '$uid', '$comment')";
    $query = $db->query($sql);
    if ($query) {
        $data['success'] = true;
        $data['message'] = "Commentaire posté";
    } else {
        $data['success'] = false;
        $data['message'] = "Erreur lors de l'envoi du commentaire";
    }
} else {
    $data['success'] = false;
    $data['message'] = "Erreur lors de l'envoi du commentaire";
}

end:
echo json_encode($data);
