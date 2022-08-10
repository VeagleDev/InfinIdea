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
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
if(isset($_COOKIE['token']) && !isset($_SESSION['id']))
{
    require_once 'tools.php';
    $db = getDB();
    $token = htmlspecialchars($_COOKIE['token']);
    $query = "SELECT id, expiration FROM tokens WHERE token = '$token'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    if($row)
    {
        $ts = $row['expiration'];
        $user = $row['id'];
        logs('connexion automatique', 'utilisateur se connecte grâce au cookie', $user, $db);
        updateUserIP($user);
        echo "<p style=\"color:grey\">Votre adresse IP est <code>" . getIP() . "</code></p>";
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
                ]
            );
        }
    }
    mysqli_close($db);
}
elseif(isset($_SESSION['id']))
{
    require_once('tools.php');
    updateUserIP($_SESSION['id'], getDB());
}



