<?php
if(isset($_POST['image']))
{
    $image = $_POST['image'];
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $data = base64_decode($image);
    $file = 'images/uploads/' . uniqid() . '.png';
    $success = file_put_contents($file, $data);
    print $success ? $file : 'Unable to save the file.';
    echo 'Voici le lien de votre image : ' . $file;
    echo 'Voici le base64 de votre image : ' . $image;
}
else
{
    echo 'Aucune image reçue';
}