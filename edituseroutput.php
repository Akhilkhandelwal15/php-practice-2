<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    $id = $_GET['id'];
    include('connection.php');
    $firstname = $_REQUEST['fname'];
    $lastname = $_REQUEST['lname'];
    $username = $_REQUEST['uname'];
    $email = $_REQUEST['email'];
    $mobno = $_REQUEST['mobno'];
    $id = $_GET['id'];
    $selectuser = $_REQUEST["user"];
    $country = $_REQUEST["country"];
    $state = $_REQUEST["state"];
    $city = $_REQUEST['city'];
    $sql2 = "update user set firstname='$firstname', lastname='$lastname', username='$username', email='$email', mobile_number='$mobno', type='$selectuser', country='$country', state='$state', city='$city' where id='$id'";

    if($conn->query($sql2))
    {
        echo "Data updated successfully";
        header("Location: adminedit.php?id=$id&msg=updatesuccess");
    }
    else
    {
        echo "error";
    }
?>