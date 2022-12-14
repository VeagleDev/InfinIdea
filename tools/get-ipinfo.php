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
print_r($ips);
$count = 0;
foreach ($ips as $ip) {
    $query = "SELECT * FROM ip WHERE ip = '$ip'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 0) {
        $ipinfo = new IPinfo("653547ee5378c1");
        $details = $ipinfo->getDetails($ip);
        if (isset($details->city)) {
            $city = $details->city;
        } else {
            $city = "Unknown";
        }
        if (isset($details->region)) {
            $region = $details->region;
        } else {
            $region = "Unknown";
        }
        if (isset($details->country)) {
            $country = $details->country;
        } else {
            $country = "Unknown";
        }
        if (isset($details->loc)) {
            $loc = $details->loc;
        } else {
            $loc = "Unknown";
        }
        if (isset($details->org)) {
            $org = $details->org;
        } else {
            $org = "Unknown";
        }
        $usernames = [];
        // Try to find the user linked to this IP
        $query = "SELECT DISTINCT username FROM logs WHERE ip = '$ip'";
        $result = mysqli_query($db, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $username = $row['username'];
            if ($username != "Guest") {
                $usernames[] = $username;
            }
        }
        if (empty($usernames)) {
            $usernames = "Unknown";
        } else {
            $usernames = implode(", ", $usernames);
            $usernames = str_replace('"', '\\"', $usernames);
            $usernames = str_replace("'", "\\'", $usernames);

        }
        $query = "INSERT INTO ip (ip, city, region, country, loc, fai, username) VALUES ('$ip', '$city', '$region', '$country', '$loc', '$org', '$usernames')";
        echo $query . "<br />";
        mysqli_query($db, $query);
        $count++;
    }
}
echo "Nombre d'IPs ajoutées : " . $count;