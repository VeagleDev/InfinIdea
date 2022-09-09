<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->

<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';

$db = getDB();

function connectViaCookie(mysqli $db)
{
    $token = htmlspecialchars($_COOKIE['token']);
    $query = "SELECT id, user, expiration FROM tokens WHERE token = '$token'";
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        return false;
    }
    $row = mysqli_fetch_assoc($result);
    if($row)
    {
        $ts = $row['expiration'];
        $user = $row['user'];
        logs('connexion automatique', 'utilisateur se connecte grâce au cookie', $user);
        updateUserIP($user);
        if($ts > time())
        {
            $_SESSION['id'] = $user;
            setcookie( // On actualise le cookie
                'token', // Le nom du cookie
                $token, // Son contenu
                [
                    'expires' => time() + 15*24*3600, // On dit qu'il expire dans 15 jours
                    'secure' => true, // On dit que le cookie est sécurisé
                    'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
                    'path' => '/',
                ]
            );
        }
    }
}

if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}


if(isset($_COOKIE['token']) && !isset($_SESSION['id'])) // Si on a un cookie et qu'on est pas connecté
{
    connectViaCookie($db);
}
elseif(isset($_SESSION['id']))
{
    updateUserIP($_SESSION['id']);
}




