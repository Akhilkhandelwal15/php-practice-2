<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    session_start();
    $uname = $_SESSION['uname'];
    include('connection.php');

    $firstnamepost = $_REQUEST['fname'];
    $lastnamepost = $_REQUEST["lname"];
    $usernamepost = $_REQUEST["uname"];
    $passwordpost = $_REQUEST["pswd"];
    $emailpost = $_REQUEST["email"];
    $mobilenopost = $_REQUEST["mobno"];

    $updatesql = "update user set firstname='$firstnamepost', lastname='$lastnamepost', username='$usernamepost',
    password='$passwordpost', email='$emailpost', mobile_number='$mobilenopost' where username='$uname'";

    if($conn->query($updatesql)===TRUE)
    {
        echo "Data is updated";
    }
    else
    {
        echo "error";
    }
?>