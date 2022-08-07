
<!-- TOUCHE PAS NON PLUS A CE FICHIER CE SONT DES FONCTIONS QUI ME SERVENT
DANS LE BACK-END -->


<?php
require_once 'strings.php';
function getDB()
{
    $db = mysqli_connect('localhost', 'root', 'rta45tty1!_SL', 'blog');
    if(!$db)
    {
        die('Erreur de connexion (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    return $db;
}
function getID($pseudo) : int
{
    $db = getDB();
    $query = "SELECT id FROM users WHERE pseudo = '$pseudo'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['id'];
}
function getPseudo($id) : string
{
    $db = getDB();
    $query = "SELECT pseudo FROM users WHERE id = '$id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['pseudo'];
}
function getMail($id) : string
{
    $db = getDB();
    $query = "SELECT email FROM users WHERE id = $id";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['email'];
}
function getMailbyUser($user) : string
{
    $db = getDB();
    $query = "SELECT email FROM users WHERE pseudo = '$user'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['email'];
}
function getPassword($id) : string
{
    $db = getDB();
    $query = "SELECT password FROM users WHERE id = $id";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['password'];
}
function getPasswordbyUser($user) : string
{
    $db = getDB();
    $query = "SELECT password FROM users WHERE pseudo = '$user'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['password'];
}
function getAge($id) : int
{
    $db = getDB();
    $query = "SELECT age FROM users WHERE id = $id";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['age'];
}
function getAvatar($id) : string
{
    $db = getDB();
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['avatar'];
}
function getAvatarbyUser($user) : string
{
    $db = getDB();
    $query = "SELECT avatar FROM users WHERE pseudo = '$user'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['avatar'];
}
function register($pseudo, $firstname, $email, $password, $age, $avatar) : string
{
    $db = getDB();
    $query = "SELECT pseudo FROM users WHERE pseudo = '$pseudo'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0)
    {
        return '<p style="color:red">Le pseudo " . $pseudo . " est déjà utilisé</p>';
    }
    $query = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0)
    {
        return '<p style="color:red">L\'email " . $email . " est déjà utilisée</p>';
    }
    $password = hash("sha512", $password);
    $query = "INSERT INTO users (pseudo, prenom, email, age, password, avatar) VALUES ('$pseudo', '$firstname', '$email', '$age', '$password', '$avatar')";
    $result = mysqli_query($db, $query);
    if($result)
    {
        return '<p style="color:green">Inscription réussie</p>';
    }
    else
    {
        return '<p style="color:red">Inscription échouée</p>';
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
    echo $query;
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
function connectByCookie($token)
{
    $db = getDB();
    $query = "SELECT user, expiration FROM tokens WHERE type = 'auth' AND token = '$token'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    // if we have a row, the token is valid
    if(mysqli_num_rows($result) > 0)
    {
        // if the token is not expired
        if($row['expiration'] > time())
        {
            // we return the user id
            return $row['user'];
        }
        else
        {
            // the token is expired, we delete it
            $query = "DELETE FROM tokens WHERE type = 'auth' AND token = '$token'";
            $result = mysqli_query($db, $query);
            return 'NONE';
        }
    }
    else
    {
        return 'NONE';
    }
}