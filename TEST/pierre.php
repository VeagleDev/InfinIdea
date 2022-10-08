<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';

$db = getDB();

$sql = "SELECT * FROM articles";
$result = mysqli_query($db, $sql);
echo mysqli_num_rows($result);
while($row = mysqli_fetch_assoc($result))
{
    $aid = $row['id'];
    $uid = uniqid();
    $sql = "UPDATE articles SET uid = '" . $uid . "'";
    $result2 = mysqli_query($db, $sql);
    if($result2)
    {
        echo '<p style="color:black">Le UID de l\'article n°' . $aid . ' à été mis à ' . $uid;
        sleep(0.25);
    }
    else
    {
        echo '<p style="color:red;">Erreur lors du changement de l\'UID de ' . $aid . ' : ' . mysqli_error($db);
    }
    sleep(0.1);
}
