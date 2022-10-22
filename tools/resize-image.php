<?php

function process_image(string $path, string $id)
{
    list($width, $height, $type) = getimagesize($path); // On récupère les dimensions de l'image

    $hd_path = "/var/www/blog/images/uploads/hd/" . $id . ".jpg"; // On définit le chemin de l'image HD
    $sd_path = "/var/www/blog/images/uploads/sd/" . $id . ".jpg"; // On définit le chemin de l'image SD
    $thumb_path = "/var/www/blog/images/uploads/thumb/" . $id . ".jpg"; // On définit le chemin de l'image Thumb

    $hd_size = ($width > $height ? array(1440, round($height * 1440 / $width)) : array(round($width * 1440 / $height), 1440)); // On définit la taille de l'image HD
    $sd_size = ($width > $height ? array(720, round($height * 720 / $width)) : array(round($width * 720 / $height), 720)); // On définit la taille de l'image SD
    $thumb_size = ($width > $height ? array(360, round($height * 360 / $width)) : array(round($width * 360 / $height), 360)); // On définit la taille de l'image Thumb

    $hd_image = imagecreatetruecolor($hd_size[0], $hd_size[1]); // On crée une image HD
    $sd_image = imagecreatetruecolor($sd_size[0], $sd_size[1]); // On crée une image SD
    $thumb_image = imagecreatetruecolor($thumb_size[0], $thumb_size[1]); // On crée une image Thumb

    // get source image which is png or jpg
    if ($type == IMAGETYPE_JPEG) { // Si l'image est au format JPEG
        $source = imagecreatefromjpeg($path); // On crée une image à partir du fichier
    } else if ($type == IMAGETYPE_PNG) { // Si l'image est au format PNG
        $source = imagecreatefrompng($path);    // On crée une image à partir du fichier
    } else {
        echo "Error while processing the image";
        die();
    }

    imagecopyresized($hd_image, $source, 0, 0, 0, 0, $hd_size[0], $hd_size[1], $width, $height); // On redimensionne l'image HD
    imagecopyresized($sd_image, $source, 0, 0, 0, 0, $sd_size[0], $sd_size[1], $width, $height); // On redimensionne l'image SD
    imagecopyresized($thumb_image, $source, 0, 0, 0, 0, $thumb_size[0], $thumb_size[1], $width, $height); // On redimensionne l'image Thumb

    imagejpeg($hd_image, $hd_path); // On enregistre l'image HD
    imagejpeg($sd_image, $sd_path); // On enregistre l'image SD
    imagejpeg($thumb_image, $thumb_path); // On enregistre l'image Thumb

    unlink($path); // On supprime l'image originale

    return array('images/uploads/hd/' . $id . '.jpg',
        'images/uploads/sd/' . $id . '.jpg',
        'images/uploads/thumb/' . $id . '.jpg');
    // On retourne les chemins des images
}

