<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php'); 
    exit();
}
$adminid =$_GET['adminid'];
$order = $_GET['order'];
$column = $_GET['column'];
// die;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Pannel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
</head>
<body>
<script>
    $(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('showModal')) {
        // If the parameter is present, show the modal
        $('#myModal').modal('show');
    }
});
</script>

<?php
    include('connection.php');
    $id = $_GET['id'];
    $showModal = $_GET['showModal'];
    echo $id;

    $sql = "delete from user where id = '$id'";

    if($conn->query($sql))
    {
        echo "User deleted Successfully";
        header("Location: adminedit.php?id=" . $adminid. "&column=".$column. "&order=".$order . "&dltmsg=deletesuccess");
    }
    else
    {
        echo "error";
    }

    // session_unset();
    // session_destroy();
    // <a href=deleteuser.php?id=" .$row['id']." class='btn btn-danger' data-toggle='modal' data-target='#myModal'>Delete</a>
?>
