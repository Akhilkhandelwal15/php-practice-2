<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);


    $id = $_GET['id'];
    // echo $id;

    include('connection.php');
    $sql3 = "select * from user where (id='$id')";
    $result = $conn->query($sql3);
    print_r($result);
    if($result->num_rows>0)
    {
        $row = $result->fetch_assoc();
        $oldpasswordhash  = $row['password'];
        $enteredpassword = $_REQUEST['pswd'];
        $newpassword = $_REQUEST['newpswd'];
        $confirmpassword = $_REQUEST['cnfpswd'];

        $verifyoldpassword = password_verify($enteredpassword, $oldpasswordhash); 
        $newpasswordhash = password_hash($newpassword, PASSWORD_DEFAULT); 

        $verifyconfirmpassword = password_verify($confirmpassword, $newpasswordhash); 
        // echo $verifyoldpassword;
        if($verifyoldpassword)
        {
            if($verifyconfirmpassword)
            {
                $sql2 = "update user set password='$newpasswordhash' where (id='$id')";
                if($conn->query($sql2)===TRUE)
                {
                    echo "Old Password updated successfully";
                    header("Location: login.php?message=success");
                }
                else
                {
                    echo "error";
                }
            }
            else
            {
                echo "newpassword and ConfirmPassword not matched";
            }
        }
        else
        {
            echo "Old Password is incorrect";
            header("Location: changePassword.php?message=fail");
        }
    }
    // else
    // {
    //     echo "error";
    // }
?>