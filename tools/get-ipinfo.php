<?php
set_include_path('/var/www/blog');

require_once 'tools/tools.php';
require_once 'vendor/autoload.php';

use ipinfo\ipinfo\IPinfo;

$db = getDB();

/*
 * On récupère toutes les IP différentes dans la table logs
 * On les stocke dans un tableau
 * On regarde si l'IP est déjà dans la table ip
 * Si oui, on ne fait rien
 * Sinon, on récupère les infos de l'IP grâce à l'API ipinfo
 * Puis on les stocke dans la table ip
 *
 */

$query = "SELECT DISTINCT ip FROM logs";
$result = mysqli_query($db, $query);
$ips = [];
while ($row = mysqli_fetch_assoc($result)) {
    $ips[] = $row['ip'];
}

echo "Nombre d'IPs différentes : " . count($ips) . "<br />";
$count = 0;
foreach ($ips as $ip) {
    $query = "SELECT * FROM ip WHERE ip = '$ip'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 0) {
        $ipinfo = new IPinfo("653547ee5378c1");
        $details = $ipinfo->getDetails($ip);
        $city = $details->city;
        $region = $details->region;
        $country = $details->country;
        $loc = $details->loc;
        $org = $details->org;
        $query = "INSERT INTO ip (ip, city, region, country, loc, fai) VALUES ('$ip', '$city', '$region', '$country', '$loc', '$org')";
        mysqli_query($db, $query);
        $count++;
    }
}
echo "Nombre d'IPs ajoutées : " . $count;