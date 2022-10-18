<?php
set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'tools/tools.php';
require_once 'vendor/autoload.php';

$db = getDB();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = SQLpurify($_POST['email']);
    $password = SQLpurify($_POST['password']);
    $password = hash('sha512', $password);
    $sql = "SELECT id, pseudo, prenom, email, password FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            echo "0";
        } else {
            echo "1";
        }
    } else {
        echo "2";
    }
} else {
    echo "3";
}
