<?php

set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once 'tools/tools.php';

$val = array(
    "_POST['pseudo']",
    "_POST['prenom']",
    "_POST['mail']",
    "_POST['password']"
);

if (
    isset($_POST['pseudo']) &&
    isset($_POST['prenom']) &&
    isset ($_POST['mail']) &&
    isset($_POST['password'])
) {
    $pseudo = SQLpurify($_POST['pseudo']);
    $surname = SQLpurify($_POST['prenom']);
    $email = SQLpurify($_POST['mail']);
    $password = SQLpurify($_POST['password']);

    // check regex

    $password = hash('sha512', $password);

    $sql = "SELECT * FROM users WHERE pseudo = '$pseudo' OR email = '$email'";
    $db = getDB();
    $result = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['email'] == $email) {
            echo '2';
            die();
        }
        if ($row['pseudo'] == $pseudo) {
            echo '3';
            die();
        } else {
            echo '4';
            die();
        }
    }
    $ip = getIP();
    $sql = "INSERT INTO users(pseudo, prenom, email, accessor, password, ip) 
            VALUES ('$pseudo', '$surname', '$email', 'veagleconnect', '$password', '$ip')";
    $result = mysqli_query($db, $sql);
    if ($result) {
        $_SESSION['id'] = mysqli_insert_id($db);
        echo '0';
        $wannaStayConnected = false;
        if ($wannaStayConnected) {
            // set cookie
        }

    } else {
        echo '1';
    }


}