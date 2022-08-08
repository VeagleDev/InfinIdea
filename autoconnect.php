<?php
session_start();
echo "Salut !";
if(isset($_COOKIE['token']))
{
    require_once 'tools.php';
    $db = getDB();
    $token = mysqli_escape_string(htmlspecialchars(['token']));
    $req = $db->prepare("SELECT * FROM tokens WHERE type = 'auth' AND token = '$token'");
    echo $req;
    // get result from mysqli request
    $req->execute();
    $result = $req->get_result();
    $row = $result->fetch_assoc();
    if($row)
    {
        $ts = $row['expiration'];
        $user = $row['user'];
        if (int($ts) > time())
        {
            $_SESSION['id'] = $user;
        }
    }
}


