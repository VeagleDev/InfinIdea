<?php

if(isset($_POST['image']))
{
    $img = $_POST['image'];
    $base_to_php = explode(',', $img);
    $data = base64_decode($base_to_php[1]);
    file_put_contents("test-image.jpg",$data);
    $path = 'https://infinidea.veagle.fr/TESTING/test-image.jpg';
    echo $path;
}
else
{
    echo("No image sended");
}