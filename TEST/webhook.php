<?php
require_once 'tools/tools.php';

if (isset($_POST['payload'])) {
    $json = HTMLpurify($_POST['payload']);
    $file = fopen('webhook.json', 'w');
    fwrite($file, $json);
    fclose($file);
} else {
    if (file_exists('webhook.json')) {
        $json = file_get_contents('webhook.json');
        echo $json;
        header('Content-Type: application/json');
    } else {
        echo "No webhook.json file";
        die();
    }
}


