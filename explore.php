<!--
GNU General Public License version 3 or later.
Mysterious Developers 2022
All rights reserved.

Authors :
- pierrbt
- nicolasfasa

Last update : 2022/08/08

-->


<!-- PAGE PRINCIPALE, JE TE LAISSE FAIRE TOUT LE FRONT-END -->
<?php
session_start();
require_once 'tools.php';
require_once 'autoconnect.php';
$db = getDB();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProject : Explorer</title>
</head>
<body>
    <h1>MyProject - Explorer</h1>
    <p>Bienvenue, <?=getPseudo($_SESSION['id'])?>  sur la page de découverte !</p>
</body>


</html>