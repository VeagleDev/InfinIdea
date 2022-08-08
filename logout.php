<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->


<!-- Script de déconnexion -->
<?php
session_destroy();
setcookie( // On crée un cookie
    'token', // Le nom du cookie
    'NONE', // Son contenu
    [
        'expires' => time() + 15*24*3600, // On dit qu'il expire dans 15 jours
        'secure' => true, // On dit que le cookie est sécurisé
        'httponly' => true, // On dit que le cookie n'est accessible que via le protocole http
    ]
);
header("Location: index.php");