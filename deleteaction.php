<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    session_start();
    $uname = $_SESSION['uname'];
    include('connection.php');

    $deletesql = "delete from user where username='$uname'";

    if($conn->query($deletesql)===TRUE)
    {
        echo "Data deleted Successfully";
    }
    else
    {
        echo "error";
    }
?>