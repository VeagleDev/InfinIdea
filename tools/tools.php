<?php

// Fichier à trier
// Commandes à ajouter
set_include_path('/var/www/blog');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'tools/strings.php';
require_once 'vendor/autoload.php';

require_once('tools/creditentials.php');

function getDB()
{
    if (PHP_SESSION_ACTIVE) {
        global $creditentials;
        $_SESSION['db'] = mysqli_connect(
            $creditentials['host'],
            $creditentials['user'],
            $creditentials['password'],
            $creditentials['database']);
        return $_SESSION['db'];
    }
    else
    {
        echo "Ce site requiert l'activation des cookies";
        die();
    }

}
function getID($pseudo) : int
{
    $db = getDB();
    $query = "SELECT id FROM users WHERE pseudo = '$pseudo'";
    $result = mysqli_query($db, $query);
    // if we have a result, we can return the id
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if(!$row)
        {
            return -1;
        }
        else
        {
            return $row['id'];
        }
    }
    else
    {
        return -1;
    }
}
function getPseudo($id) : string
{
    $db = getDB();
    $query = "SELECT pseudo FROM users WHERE id = '$id'";
    $result = mysqli_query($db, $query);
    // if we have a result, we can return the id
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if(!$row)
        {
            return "Utilisateur inconnu ($id)";
        }
        else
        {
            return $row['pseudo'];
        }
    }
    else
    {
        return "Utilisateur inconnu ($id)";
    }
}
function createAuthToken($id) : string
{
    $db = getDB();
    // on créé un token aléatoire de 64 caractères
    $token = bin2hex(random_bytes(64));
    // on définit la date d'expiration du token
    $expiration = time() + 15*24*3600; // 15 jours
    $query = "INSERT INTO tokens (type, token, user, expiration) VALUES ('auth', '$token', " . $id . ", '$expiration');";
    $result = mysqli_query($db, $query);
    if($result)
    {
        return $token;
    }
    else
    {
        return 'NONE';
    }

}
function createPassForgotToken($id) : string
{
    $db = getDB();
    // on créé un token aléatoire de 26 caractères
    $token = bin2hex(random_bytes(26));
    // on définit la date d'expiration du token
    $expiration = time() + 24*3600; // 1 jours
    $query = "INSERT INTO tokens (type, token, user, expiration) VALUES ('pass', '$token', " . $id . ", '$expiration');";
    $result = mysqli_query($db, $query);
    if($result)
    {
        return $token;
    }
    else
    {
        return 'NONE';
    }

}
function verifyPasswordStrongness(string $password)
{
    $ok = true;
    $error = '';

    if(strlen($password) < 8)
    {
        $ok = false;
        $error .= 'Password is too short<br/>';
    }
    if(!preg_match('#[0-9]+#', $password))
    {
        $ok = false;
        $error = 'Password must include at least one number<br/>';
    }
    if(!preg_match('#[a-zA-Z]+#', $password))
    {
        $ok = false;
        $error = 'Password must include at least one letter<br/>';
    }
    return array($ok, $error);

}
function getIP() : string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function updateUserIP($user): void
{
    $db = getDB();
    $ip = getIP();
    $query = "UPDATE users SET ip = '$ip' WHERE id = '$user'";
    mysqli_query($db, $query);
}

function logs($action): void
{
    if (isset($_SESSION['db'])) {
        $db = $_SESSION['db'];
        $ip = getIP();
        $user = 0;
        $username = 'Guest';
        if (isset($_SESSION['id'])) {
            $user = $_SESSION['id'];
            $username = getPseudo($user);
        }
        $sql = "INSERT INTO logs (action, user, username, ip) VALUES ('$action', " . $user . ", '$username', '$ip')";
        mysqli_query($db, $sql);
    }
}


function correctTimestamp($timestamp) : string
{
    $date = new DateTime($timestamp);
    $date->setTimezone(new DateTimeZone('Europe/Paris'));
    $diff = time() - $date->getTimestamp();

    if($diff < 600)
    {
        return 'À l\'instant';
    }
    elseif($diff < 3600)
    {
        return "Il y a " . floor($diff / 60) . " minutes";
    }
    elseif($diff < 3600*24)
    {
        return "Il y a " . floor($diff / 3600) .  " heures";
    }
    elseif($diff < 3600*24*2)
    {
        return "Hier à " . $date->format('H') . "h";
    }
    elseif($diff < 3600*24*90)
    {
        return "Il y a " . floor($diff / (3600*24)) . " jours";
    }
    else
    {
        return "Il y a " . floor($diff / (3600*24*30)) . " mois";
    }
}

function getClientUID() : string
{
    $ip = getIP();
    $port = $_SERVER['REMOTE_PORT'];

    $key = $ip . $port;

    $hash = hash('sha1', $key);

    return $hash;
}

function articleExists($id) : bool
{
    $db = getDB();
    if(is_numeric($id))
    {
        $query = "SELECT id FROM articles WHERE id = " . $id . " OR uid = '$id'";
    }
    else
    {
        $query = "SELECT id FROM articles WHERE uid = '" . $id . "'";
    }
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function SQLpurify($string) : string
{
    $db = getDB();

    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);

    $string = $purifier->purify($string);
/*
    $string =  str_replace("'", "\\\'", $string);
    $string = str_replace('"', '\\\"', $string);
*/
    $string = mysqli_real_escape_string($db, $string);

    return $string;
}

function HTMLpurify($string): string
{
    $purifier = new HTMLPurifier();

    $string = $purifier->purify($string);

    return $string;
}

function updateLastSeen(): bool
{
    if (isset($_SESSION['id'])) {
        $db = getDB();
        $sql = "UPDATE users SET last_seen = NOW() WHERE id = " . $_SESSION['id'];
        $res = $db->query($sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}