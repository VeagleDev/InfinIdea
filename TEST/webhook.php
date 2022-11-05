<?php

// create a html string with header
$html = "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <title>Webhook</title>
</head>
<body>
    <h1>Webhook</h1>
    <p>Path: TEST\webhook.php</p>
    ";

$isEmpty = true;
// for each post variable, add a line to the html string
foreach ($_POST as $key => $value) {
    $html .= "<p>$key: $value</p>";
    $isEmpty = false;
}

// for each get variable, add a line to the html string
foreach ($_GET as $key => $value) {
    $html .= "<p>$key: $value</p>";
    $isEmpty = false;
}

// add the footer to the html string

$html .= "</body>
</html>";

if ($isEmpty) {
    // read the file
    if (file_exists("webhook.html")) {
        $html = file_get_contents("webhook.html");
    } else {
        $html = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset=\"utf-8\">
            <title>Webhook</title>
        </head>
        <body>
            <h1>Webhook</h1>
            <p>Path: TEST\webhook.php</p>
            <p>Empty</p>
        </body>
        </html>";
    }
} else {
    // write the html string to a file
    $file = fopen("webhook.html", "w");
    fwrite($file, $html);
    fclose($file);
}

