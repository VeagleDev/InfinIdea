<?php
function process_image(string $path, string $id)
{
    list($width, $height, $type) = getimagesize($path);

    $hd_path = "/var/www/blog/images/uploads/hd/" . $id . ".jpg";
    $sd_path = "/var/www/blog/images/uploads/sd/" . $id . ".jpg";
    $thumb_path = "/var/www/blog/images/uploads/thumb/" . $id . ".jpg";

    $hd_size = ($width > $height ? array(1440, round($height * 1440 / $width)) : array(round($width * 1440 / $height), 1440));
    $sd_size = ($width > $height ? array(720, round($height * 720 / $width)) : array(round($width * 720 / $height), 720));
    $thumb_size = ($width > $height ? array(360, round($height * 360 / $width)) : array(round($width * 360 / $height), 360));

    $hd_image = imagecreatetruecolor($hd_size[0], $hd_size[1]);
    $sd_image = imagecreatetruecolor($sd_size[0], $sd_size[1]);
    $thumb_image = imagecreatetruecolor($thumb_size[0], $thumb_size[1]);
    echo $path;
    $source = imagecreatefromjpeg($path);

    imagecopyresized($hd_image, $source, 0, 0, 0, 0, $hd_size[0], $hd_size[1], $width, $height);
    imagecopyresized($sd_image, $source, 0, 0, 0, 0, $sd_size[0], $sd_size[1], $width, $height);
    imagecopyresized($thumb_image, $source, 0, 0, 0, 0, $thumb_size[0], $thumb_size[1], $width, $height);

    imagejpeg($hd_image, $hd_path);
    imagejpeg($sd_image, $sd_path);
    imagejpeg($thumb_image, $thumb_path);

    unlink($path);

    return array('images/uploads/hd/' . $id . '.jpg', 'images/uploads/sd/' . $id . '.jpg', 'images/uploads/thumb/' . $id . '.jpg');
}

