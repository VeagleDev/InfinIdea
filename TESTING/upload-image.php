<?php

if(isset($_POST['base64']))
{
    $img = $_POST['base64'];
    $base_to_php = explode(',', $img);
    $data = base64_decode($base_to_php[1]);
    file_put_contents("test-image.jpg",$data);
    echo("Image uploaded : test-image.jpg");
}
else
{
    echo("No image");
}