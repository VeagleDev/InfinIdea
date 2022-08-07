<?php

function register_form(string $pseudo = '', string $name = '', string $email = '', string $password = '', string $password_confirm = '', string $age = '', string $avatar = '') : string {
return '
<form action="register.php" method="post">
    <label for="pseudo">Pseudo</label>
    <input type="text" name="pseudo" id="pseudo" value="' . $pseudo . '">
    <label for="firstname">Prénom</label>
    <input type="text" name="firstname" id="firstname" value="' . $name . '">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="' . $email . '">
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" value="' . $password . '">
    <label for="password">Confirmation mot de passe</label>
    <input type="password" name="password_confirm" id="password_confirm" value="' . $password_confirm . '">
    <label for="age">Age</label>
    <input type="number" name="age" id="age" value="' . $age . '">
    <label for="avatar">Avatar</label>
    <input type="text" name="avatar" id="avatar" value="' . $avatar . '">
    <input type="checkbox" name="stay_connected" id="stay_connected">
    <label for="stay_connected">Rester connecté</label>
    <input type="submit" value="Inscription">
</form>
<style>
    body {
        background-color: #f2f2f2;
    }
    h1 {
        text-align: center;
        color: #000;
        font-size: 2rem;
        margin-top: 1rem;
    }
    form {
        width: 50%;
        margin: 0 auto;
        text-align: center;
    }
    label {
        display: block;
        margin-bottom: 0.5rem;
    }
    input {
        display: block;
        margin-bottom: 1rem;
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
    }
    input[type="submit"] {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 0.5rem;
        cursor: pointer;
    }
</style>';
}



function login_form() : string
{
    return '<h1>Connexion</h1>
    <form action="login.php" method="post">
        <p>
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo">
        </p>
        <p>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <input type="checkbox" name="stay_connected" id="stay_connected">
            <label for="stay_connected">Rester connecté</label>
        </p>
        <p>
            <input type="submit" value="Se connecter">
        </p>
    </form>
    <style>
        body {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            color: #000;
            font-size: 2rem;
            margin-top: 1rem;
        }
        form {
            width: 50%;
            margin: 0 auto;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input {
            display: block;
            margin-bottom: 1rem;
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
        }
</style>';
}


