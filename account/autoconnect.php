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
    echo '<p style="color: red;">Token : ' . $token . '</p>';
    $query = "SELECT id, user, expiration FROM tokens WHERE token = '$token'";
    echo '<p style="color: blue;">' . $query . '</p>';
    $result = mysqli_query($db, $query);
    if(!$result)
    {
        echo '<p style="color: red;">' . mysqli_error($db) . '</p>';
        return false;
    }
    $row = mysqli_fetch_assoc($result);
    if($row)
    {
        echo '<p style="color: green;">ID du token : ' . $row['id'] . '</p>';
        $ts = $row['expiration'];
        $user = $row['user'];
        logs('connexion automatique', 'utilisateur se connecte grâce au cookie', $user);
        updateUserIP($user);
        if($ts > time())
        {
            echo '<p style="color: green;">Token valide</p>';
            $_SESSION['id'] = $user;
            setcookie( // On actualise le cookie
                'token', // Le nom du cookie
                $token, // Son contenu
                [
                    'expires' => time() + 15*24*3600, // On dit qu'il expire dans 15 jours
                    'secure' => true, // On dit que le cookie est sécurisé
                    'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
                ]
            );
        }
    }
}

if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}


if(isset($_COOKIE['token']))
{
    echo "<p>Connexion automatique par le cookie</p>";
    connectViaCookie($db);
}
elseif(isset($_SESSION['id']))
{
    echo "<p>Connexion automatique par la session</p>";
    if($_SESSION['id'] == 0)
    {
        if(isset($_COOKIE['token']))
        {
            connectViaCookie($db);
        }
        else
        {
            logout();
        }
    }
    updateUserIP($_SESSION['id']);
}
else
{
    $cookie = isset($_COOKIE['token']);
    echo "<p>Connexion automatique : " . ($cookie ? "oui" : "non") . "</p>";
    echo "<p>Connexion automatique impossible " . isset($_COOKIE['token']) . "</p>";
}



