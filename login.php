
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    label.error {
      color: red;
    }
    label.valid {
      color: green;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>  


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>  
<script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
  $(document).ready(function(){
    $("#form2").validate(
      {
      rules:{
        uname: {required: true},
        pswd: {required: true}
      },
      messages:{
        uname:"This field is required",
        pswd:"This field is required"
      },
      errorClass: "error",
      validClass: "valid",
      submitHandler: function(form) {  
        form.submit();  
      }  
  });
  });
</script>
<body>
<div class="container mt-3">
  <h2>Login Form</h2>
  <form action="authentication.php" method="post" id="form2">
    <div class="mb-3 mt-3">
      <label for="username">Enter Username:</label>
      <input type="text" class="form-control" id="uname" placeholder="Enter User name" name="uname">
      <div class="uname text-danger"></div>
    </div>
    <div class="mb-3">
      <label for="pwd">Enter Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
      <div class="pwd text-danger"></div>
    </div>
    
    <button type="submit" class="btn btn-primary" value="Login">Login</button>


  <!-- Register buttons -->
  <div class="text-center">
    <p>Not a member? <a href="index.php">Register</a></p>
  </div>
  </form>
</div>

</body>
</html>

<?php
  $msg=$_GET['message'];
  if($msg=='success')
  {
    echo "password updated successfully";
  }
?>