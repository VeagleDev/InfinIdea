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
    // verify no user with same pseudo
    $query = "SELECT pseudo FROM users WHERE pseudo = '$pseudo'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0)
    {
        return '<p style="color:red">Le pseudo " . $pseudo . " est déjà utilisé</p>';
    }
    // verify no user with same email
    $query = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0)
    {
        return '<p style="color:red">L\'email " . $email . " est déjà utilisée</p>';
    }
    // insert user in database
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