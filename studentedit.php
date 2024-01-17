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
    $uname = $_SESSION['uname'];
    include('connection.php');
    $checksql = "select * from user where (username = '$uname')";
    $result = $conn->query($checksql);
    if($result->num_rows>0)
    {
        $row = $result->fetch_assoc();
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $username = $row['username'];
        $password = $row['password'];
        $email = $row['email'];
        $mobileno = $row['mobile_number'];  
    }

    // echo $firstname;
?>

<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['update'])) 
//     {
//         header("Location: updateaction.php");
//         exit();
//     } elseif (isset($_POST['delete'])) 
//     {
//         header("Location: deleteaction.php");
//         exit();
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registeration Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>  

<script>
  $(document).ready(function()
  {
    $("#form1").submit(function(e)
    {
      e.preventDefault();
      var firstname = $("#fname").val();
      var lastname = $("#lname").val();
      var username = $("#uname").val();
      var password = $("#pwd").val();
      var confirmpassword = $("#cnfpwd").val();
      var email = $("#email").val();
      var number = $("#number").val();
      var isValid = 1;
      console.log(firstname);
      $(".error").remove();
      // console.log(2);
      if(firstname.length<1)
      {
        // $("#fname").after('<span class="error"> This field is mandatory </span>');
        isValid = 0;
        $(".fname").text("This field is mandatory");
      }
      else
      {
        // $(".fname").attr('value', 'firstname');
        $(".fname").remove();
      }
      if(lastname.length<1)
      {
        isValid = 0;
        $(".lname").text("This field is mandatory");
      }
      else
      {
        $(".lname").remove();
      }
      if(username.length<1)
      {
        isValid = 0;
        $(".uname").text("This field is mandatory");
      }
      else if(username.length<5 || username.length>10)
      {
        isValid = 0;
        $(".uname").text("Username must be between 5 to 10 charecters");
      }
      else
      {
        $(".uname").remove();
      }
      // console.log(2);
      if(password.length<5 || password.length>8)
      {
        isValid = 0;
        $(".pwd").text("Password must be between 5 to 10 charecters");
      }
      else
      {
        $(".pwd").remove();
      }
      if(password != confirmpassword)
      {
        isValid = 0;
        $(".cnfpwd").text("password not matched");
      }
      else
      {
        $(".cnfpwd").remove();
      }
      if(email.length<1)
      {
        isValid = 0;
        $(".email").text("This field is mandatory");
      }
      else 
      {  
        var regEx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
        var validEmail = regEx.test(email);  
        if (!validEmail) 
        {  
          isValid = 0;
          $(".email").text("Enter a valid email");
        } 
        else
      {
        $(".email").remove();
      }
      }
      if(number.length<1)
      {
        isValid = 0;
        $(".number").text("This field is mandatory");
      } 
      else
      {
        $(".number").remove();
      }
      if (isValid == 1) 
      {
          var buttonClicked = $(document.activeElement).attr('name'); 
          if (buttonClicked == 'update') 
          {
            formAction = 'updateaction.php'; 
          } 
          else if (buttonClicked == 'delete') 
          {
            formAction = 'deleteaction.php'; 
          }

          $(this).attr('action', formAction); 
          this.submit();
      } 
      else 
      {
        console.log("Form validation failed");
      }
           
    });
  });
</script>



<body>
<div class="container mt-3">
  <h2>Updation Form</h2>
  <form action="" method="post" id="form1">
    <div class="mb-3 mt-3">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $firstname;?>">
      <div class="fname text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="lname">Last Name:</label>
      <input type="text" class="form-control" id="lname" placeholder="Enter Last name" name="lname" value="<?php echo $lastname;?>">
      <div class="lname text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="uname" placeholder="Enter User name" name="uname" value="<?php echo $username;?>">
      <div class="uname text-danger"></div>
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" value="<?php echo $password;?>">
      <div class="pwd text-danger"></div>
    </div>" id="pwd" placeholder="Enter password" name="pswd" value="<?php echo $password;?>">
    <div class="mb-3">
      <label for="cnfpwd">Confirm Password:</label>
      <input type="password" class="form-control" id="cnfpwd" placeholder="Enter Confirmed password" name="cnfpswd">
      <div class="cnfpwd text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email;?>">
      <div class="email text-danger"></div>
    </div>
    <div class="mb-3">
      <label for="num">Mobile Number:</label>
      <input type="number" class="form-control" id="number" placeholder="Enter Mobile number" name="mobno"  pattern="[1-9]{1}[0-9]{9}" value="<?php echo $mobileno;?>">
      <div class="number text-danger"></div>
    </div>
    <button type="submit" class="btn btn-primary" name = 'update' value="Update">Update</button>
    <button type="submit" class="btn btn-danger" name = 'delete' value="delete">Delete</button>

  </form>
</div>

</body>
</html>
