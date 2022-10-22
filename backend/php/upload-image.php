<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';
$db = getDB();


if (isset($_POST['image']) && isset($_POST['article'])) // Si l'image et l'article sont définis
{
    $img = htmlspecialchars($_POST['image']); // On récupère l'image
    $article = htmlspecialchars($_POST['article']); // On récupère l'article

    $base_to_php = explode(',', $img); // On sépare le type de l'image et le contenu
    $data = base64_decode($base_to_php[1]); // On décode le contenu

    if (articleExists($article)) // Si l'article existe
    {
        $sql = "SELECT id FROM articles WHERE id = " . $article . " AND creator = " . $_SESSION['id']; // On prépare la requête
        $result = mysqli_query($db, $sql); // On exécute la requête
        // On vérifie que l'article existe bien et qu'il appartient bien à l'utilisateur
        if (mysqli_num_rows($result) == 1) { // Si l'article existe et qu'il appartient bien à l'utilisateur
            $id = uniqid(); // On génère un id unique
            $sql = "INSERT INTO images(uid, aid) VALUES('" . $id . "', " . $article . ")"; // On prépare la requête
            $result = mysqli_query($db, $sql); // On exécute la requête
            if ($result) { // Si l'insertion s'est bien déroulée
                $path = '/var/www/blog/images/uploads/temp/' . $id . '.jpg'; // On définit le chemin de l'image
                file_put_contents($path, $data); // On écrit l'image dans le fichier temporaire
                require_once 'tools/resize-image.php'; // On inclut le fichier resize-image.php
                list($hd, $sd, $td) = process_image($path, $id); // On redimensionne l'image
                $sql = "UPDATE images SET hd = '$hd', sd = '$sd', td = '$td', path = '$sd' WHERE uid = '$id'"; // On prépare la requête
                $result = mysqli_query($db, $sql); // On exécute la requête
                $absolute_path = 'https://infinidea.veagle.fr/' . $hd; // On définit le chemin absolu de l'image
                $sql = "UPDATE images SET path = '" . $absolute_path . "' WHERE uid = '" . $id . "'"; // On prépare la requête
                $markdown = '![](' . $absolute_path . ')'; // On définit le markdown de l'image
                echo($markdown); // On affiche le markdown de l'image
            }
            else
            {
                echo("Erreur lors de l'insertion de l'image dans la base de données");
            }

        } else {
            echo("Vous n'avez pas le droit de modifier cet article");
        }
    } else {
        echo "Cet article n'existe pas";
    }

} else if (isset($_GET['path']) && isset($_GET['article'])) // Si l'id, le chemin et l'article sont définis
    $id = uniqid(); // On génère un id unique
$path = htmlspecialchars($_GET['path']);
$article = htmlspecialchars($_GET['article']);

$sql = "INSERT INTO images(uid, aid) VALUES('" . $id . "', " . $article . ")"; // On prépare la requête
$result = mysqli_query($db, $sql); // On exécute la requête

require_once 'tools/resize-image.php'; // On inclut le fichier resize-image.php
list($hd, $sd, $td) = process_image($path, $id); // On redimensionne l'image
$sql = "UPDATE images SET hd = '$hd', sd = '$sd', td = '$td', path = '$sd' WHERE uid = '$id'"; // On prépare la requête
$result = mysqli_query($db, $sql); // On exécute la requête
$absolute_path = 'https://infinidea.veagle.fr/' . $hd; // On définit le chemin absolu de l'image
$sql = "UPDATE images SET path = '" . $absolute_path . "' WHERE uid = '" . $id . "'"; // On prépare la requête
mysqli_query($db, $sql); // On exécute la requête
// on affiche les differents chemins de l'image en html
echo '<p>HD : ' . $hd . '</p>';
echo '<p>SD : ' . $sd . '</p>';
echo '<p>TD : ' . $td . '</p>';
echo '<p>Path : ' . $absolute_path . '</p>';


}