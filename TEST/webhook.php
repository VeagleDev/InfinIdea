<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';

if (isset($_POST['payload'])) {
    $json = json_decode(HTMLpurify(['payload']), true);
    $result = shell_exec('git pull');
    // add result to the json
    // create new array with the result string, the result code and the date
    // add a new element to the json array

    // add new element to the json array withour overwriting the old one
    $json['result'] = str_replace("\n", " - ", $result);
    $json['date'] = date('Y-m-d H:i:s');


    $file = fopen('webhook.json', 'w');
    fwrite($file, json_encode($json));
    fclose($file);


} else {
    if (file_exists('webhook.json')) {
        $json = file_get_contents('webhook.json');
        header('Content-Type: application/json');
        header('Server: Wow such server');
        header('X-Powered-By: PHP');
        echo $json;

    } else {
        echo "No webhook.json file";
        die();
    }
}


