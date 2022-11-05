<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';

if (isset($_POST['payload'])) {
    // get the received data and decode it to an array
    // the data is in JSON format
    // then run git pull to update the local repo
    // print the result of the git pull command
    // and write it to webhook.json
    $data = json_decode($_POST['payload']);
    $output = shell_exec('cd /var/www/blog && git pull');
    $output = $output . " " . date("Y-m-d H:i:s");

    // add the output to data
    $data->output = $output;

    // write the data to a file
    $fp = fopen('webhook.json', 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
    

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


