<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';

if (isset($_POST['payload'])) {
    $json = json_decode(HTMLpurify(['payload']));
    // get result of the git pull command
    $result = shell_exec('git pull');
    // add result to the json
    // create new array with the result string, the result code and the date
    $json['result'] = [
        'date' => date('Y-m-d H:i:s'),
        'code' => $result
    ];

    $file = fopen('webhook.json', 'w');
    fwrite($file, json_encode($json));
    fclose($file);


} else {
    if (file_exists('webhook.json')) {
        $json = file_get_contents('webhook.json');
        header('Content-Type: application/json');
        echo $json;

    } else {
        echo "No webhook.json file";
        die();
    }
}


