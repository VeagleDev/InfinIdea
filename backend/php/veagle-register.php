<?php

set_include_path('/var/www/blog');
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
            echo 'Email identique';
            die();
        }
        if ($row['pseudo'] == $pseudo) {
            echo 'Pseudo identique';
            die();
        } else {
            echo 'Erreur inconnue';
            die();
        }
    }
    $ip = getIP();
    $sql = "INSERT INTO users(pseudo, prenom, email, accessor, password, ip) 
            VALUES ('$pseudo', '$surname', '$email', 'veagleconnect', '$password', '$ip')";
    $result = mysqli_query($db, $sql);
    if ($result) {
        echo 'Nouveau pseudo : ' . mysqli_insert_id($db);
    } else {
        echo 'Erreur : ' . mysqli_error($db);
    }


}