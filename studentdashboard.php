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
error_reporting(E_ALL);
ini_set("display_errors",1);
    include("index.php");
    $id = $_GET['id'];
    // echo $id;
    include("connection.php");
    $checksql = "select * from user where (id = '$id')";
    $result = $conn->query($checksql);
    if($result->num_rows>0)
    {
        $row = $result->fetch_assoc();
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $username = $row['username'];
        $email = $row['email'];
        $mobno = $row['mobile_number'];  
    }
?>

<script>
    $(document).ready(function(){
        $("#formcontainer > h2:first").text("Student Details");
        $("#radio-btn").hide();
        $(".pwd").hide();
        $(".cnfpwd").hide();
        $("#signinmsg").hide();
        $("#fname").attr('value','<?php echo $firstname; ?>');
        $("#lname").attr('value','<?php echo $lastname; ?>');
        $("#uname").attr('value','<?php echo $username; ?>');
        $("#email").attr('value','<?php echo $email; ?>');
        $("#number").attr('value',<?php echo $mobno;?>);
        $("#submitbtn1").hide();
        $("#country-dropdown").hide();

        $("input").prop('disabled', true);
        $("#editstudentbtn").prop('hidden', false);
        $("#editstudentbtn").on("click", function(){
            $("#editstudentbtn").prop('hidden', true);
            $("input").prop('disabled', false);
            $("#submitstudentbtn").prop('hidden', false);
        });
        $('#submitstudentbtn').on("click", function(){

            // console.log("working");
            $('.formaction').attr('action', 'editstudent.php?id=<?php echo $id;?>');
            $(".formaction").submit();
        });
        $("#submitstudentbtn").after("<a href='logout.php' type='button' class='btn btn-primary'>Logout</a>")
    });


</script>