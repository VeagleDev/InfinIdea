<?php

function load_image($filename, $type)
{
    $new = 'new34.jpeg';
    if ($type == IMAGETYPE_JPEG) {
        $image = imagecreatefromjpeg($filename);
        imagejpeg($image, $new);

    } elseif ($type == IMAGETYPE_PNG) {
        $image = imagecreatefrompng($filename);
        imagepng($image, $new);
    } elseif ($type == IMAGETYPE_GIF) {
        $image = imagecreatefromgif($filename);
        imagejpeg($image, $new);
    }
    return $new;
}

function process_image(string $path, string $id)
{
    list($width, $height, $type) = getimagesize($path);
    $image = load_image($path, $type);
    $hd_path = "/var/www/blog/images/uploads/hd/" . $id . ".jpg";
    $sd_path = "/var/www/blog/images/uploads/sd/" . $id . ".jpg";
    $thumb_path = "/var/www/blog/images/uploads/thumb/" . $id . ".jpg";

    $hd_size = ($width > $height ? array(1440, $height * 1440 / $width) : array($width * 1440 / $height, 1440));
    $sd_size = ($width > $height ? array(720, $height * 720 / $width) : array($width * 720 / $height, 720));
    $thumb_size = ($width > $height ? array(360, $height * 360 / $width) : array($width * 360 / $height, 360));

    echo "hd_size: " . $hd_size[0] . "x" . $hd_size[1];
    echo "sd_size: " . $sd_size[0] . "x" . $sd_size[1];
    echo "thumb_size: " . $thumb_size[0] . "x" . $thumb_size[1];
    echo "default_size: " . $width . "x" . $height;

}

process_image("/var/www/blog/images/uploads/1.jpg", "1");

/*$filename = "panda.jpeg";
list($width, $height, $type) = getimagesize($filename);
echo "Width:", $width, "\n";
echo "Height:", $height, "\n";
echo "Type:", $type, "\n";

$old_image = load_image($filename, $type);*/

