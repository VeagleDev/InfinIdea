<?php
require_once 'tools/tools.php';


if(isset($_GET['info']))
{
    $param = htmlspecialchars($_GET['info']);
    if($param == 'likes')
    {
        $db = getDB();
        $sql = "SELECT likes FROM articles WHERE id = " . $_GET['article'];
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
}