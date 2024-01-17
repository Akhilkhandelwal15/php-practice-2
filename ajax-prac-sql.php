<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
    include('connection.php');
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];

    $sql = "insert into test(Firstname, Lastname) values ('$fname', '$lname')";
    // echo $sql;
    if($conn->query($sql))
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
?>