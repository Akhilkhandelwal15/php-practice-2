<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
    include('connection.php');
    $id = $_POST['id'];
    $userid = $_POST['userid'];
    // echo $userid;
    // print_r($_POST);
    if ($_POST['type'] == 'username') {
        $username = $_POST['uname'];
        if(!empty($userid))
        {
            $sql = "SELECT * FROM user WHERE username='$username' and id!=$userid";
        }
        else
        {
            $sql = "SELECT * FROM user WHERE username='$username' and id!=$id";
        }
       
    } 
    elseif ($_POST['type'] == 'email') {
        $email = $_POST['email'];
        if(!empty($userid))
        {
            $sql = "SELECT * FROM user WHERE username='$username' and id!=$userid";
        }
        else
        {
            $sql = "SELECT * FROM user WHERE username='$username' and id!=$id";
        }
    }
    
    $result = $conn->query($sql);
    
    
    // echo $result->num_rows ? 'Email already exist':''; die;
    $conn->close();
    if ($result->num_rows > 0) {
        echo 'false';   
    } else {
        echo 'true';
    }
    
    // echo "Hello";
?>