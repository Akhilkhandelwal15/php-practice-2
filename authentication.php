<?php 
    session_start();
    include('connection.php');

    $username = trim($_REQUEST["uname"]);
    $password = trim($_REQUEST["pswd"]);
     

    $checksql = "select * from user where (username = '$username')";
    $result = $conn->query($checksql);
    if($result->num_rows>0)
    {
        $row = $result->fetch_assoc();
        $verify = password_verify($password, $row["password"]);
        $id = $row['id'];
        if($username==$row['username'] && $verify)
        {
            $_SESSION['logged_in'] = true;
            $_SESSION['login_id'] = $row['id'];
            echo "Login Successfull" ."<br>";
            // print_r($_REQUEST);
            if($row['type']=='student')
            {
                $_SESSION['uname'] = $username;
                $_SESSION['typeofuser'] = $row['type'];
                header("Location: studentdashboard.php?id=$id");
            }
            else
            {
                $_SESSION['typeofuser'] = $row['type'];
                header("Location: adminedit.php?id=$id");
            }
        }
        else
        {
            // echo "Invalid username or password". "<br>";
            echo "<script>alert('Invalid username or password'); window.location.href = 'login.php';</script>";
            // header("Location: login.php");
        }
    }
    else
    {
        // echo "Invalid username or poassword". "<br>";
        echo "<script>alert('Invalid username or password');window.location.href = 'login.php'</script>";
        // header("Location: login.php");


    }
?>