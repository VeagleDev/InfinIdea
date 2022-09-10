<?php
set_include_path('/var/www/blog');
require_once 'tools/tools.php';


if(isset($_GET['like']))
{
    $param = htmlspecialchars($_GET['like']);

    $db = getDB();
    $sql = "SELECT likes FROM articles WHERE id = " . $_GET['like'];
    $result = mysqli_query($db, $sql);
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if($row)
        {
            echo $row['likes'];
        }
        else
        {
            echo "0";
        }
    }
    else
    {
        echo "0";
    }

}