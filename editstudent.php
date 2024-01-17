<?php
    session_start();
    if (!isset($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit();
    }
    $urlid = $_GET['id'];
    if($urlid!=$_SESSION['login_id'])
    {
    header('Location: login.php');
        exit();
    }
?>

<?php
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
    $city = $_REQUEST["city"];
    $sql2 = "update user set firstname='$firstname', lastname='$lastname', username='$username', email='$email', mobile_number='$mobno', type='$selectuser', country='$country', state='$state', city='$city'  where id='$id'";

    if($conn->query($sql2))
    {
        echo "Data updated successfully";
        
        header("Location: studentdashboard.php?id=$id");
        ?>
        <script>
            alert("Data updated successfully");
        </script>
        <?php
    }
    else
    {
        echo "error";
    }
?>