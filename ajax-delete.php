<?php
include('connection.php');
$id = $_POST['id'];
$sql = "delete from test where id='$id'";
if($conn->query($sql))
{
    echo 1;
}
else
{
    echo 0;
}
?>