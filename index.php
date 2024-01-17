<?php 
error_reporting(E_ALL);
ini_set("display_errors",1);

if(!empty($_GET['id']))
{
  $id = $_GET['id'];
  if(!empty($_GET['userid']))
  {
    $userid = $_GET['userid'];
  }
  else
  {
    $userid = 0;
  }
  if(isset($_GET['order']))
  {
      $order = $_GET['order'];
  }
  else
  {
      $order = "asc";
  }
  if(isset($_GET['column']))
  {
      $column = $_GET['column'];

  }
  else
  {
      $column = "firstname";
  }
?>

  <!DOCTYPE html>
<html lang="en">
<head>
  <title id="title">Registration Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
<script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
  $(document).ready(function()
  {
      $("#submitbtn1").click(function()
      {
        console.log("Working");
      });
      $("#backButton").hide();

    $('form[id="form1"]').validate(
      {
        rules:
        {
          fname:{required: true},
          lname:{required:true},
          uname:{
            required:true,
            minlength: 5,
            maxlength: 8,
            remote:{
              url:'checkAvailability.php',
              method:'POST',
              data:{
                type:'username',
                id: <?php echo $id; ?>,
                userid: <?php echo $userid; ?>,
              }
            }
          },
          pswd:{
            required:true,
            minlength: 5,
            maxlength: 8,
          },
          cnfpswd:{
            required: true,
            equalTo : "#pwd",
	        },
          email:{
            required: true,
            email: true,
            remote:{
              url:'checkAvailability.php',
              method:'POST',
              data:{
                type:'email',
                id: <?php echo $id; ?>,
                userid: <?php echo $userid; ?>,
              }
            }
          },
          mobno:{
            required:true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          country:{
            required: true,
          },
          state:{
            required:true,
          },
          city:{
            required: true,
          }
        },
        messages:
        {
          fname:'This field is required',
          lname:'This field is required',
          uname:{
            required: 'This field is required',
            minlength: 'length must be between 5 to 8 characters',
            maxlength: 'length must be between 5 to 8 characters',
            remote: 'Username already exists',
          },
          pswd:{
            required: 'This field is required',
            minlength: 'length must be between 5 to 8 characters',
            maxlength: 'length must be between 5 to 8 characters',
          },
          cnfpswd:{
			   		required : 'Confirm Password is required',
			   		equalTo : 'Password not matching',
			   	},
          email:{
            required: 'This field is required',
            minlength: 'Enter a valid email',
            remote: 'Email already exists',
          },
          mobno:{
            required: "This field is required",
            number: "Please enter a valid numeric mobile number",
            minlength: "Mobile number must be 10 digits",
            maxlength: "Mobile number must be 10 digits",
          },
          country:{
            required:"This field is required",
          },
          state:{
            required:"This field is required",
          },
          city:{
            required:"This field is required",
          }
        },
        errorClass: "error",
        validClass: "valid",
        submitHandler: function(form) {  
          form.submit();  
        }  
        
      });
  });
</script>

<!-- script for dropdowns -->
<script>
  $(document).ready(function(){
    $("#state-dropdown").hide();
    $("#city-dropdown").hide();
    $("#country-dropdown").on("change", function(){
      var countryid = $(this).val();
      $.ajax({
        url:'states-by-country.php',
        type: 'post',
        data:{country_id : countryid},
        success: function(result){
          $("#state-dropdown").show();
          $("#state-dropdown").html(result);
          $("#city-dropdown").html('<option value="">Select State First</option>');
        }

      });
    });

    $("#state-dropdown").on("change", function(){
      var stateid = $(this).val();
      $.ajax({
        url:'city-by-states.php',
        type: 'post',
        data:{state_id : stateid},
        success: function(result){
          $("#city-dropdown").show();
          $("#city-dropdown").html(result);
        }
      });
    });
  });
</script> 
<body>
<div class="container mt-3" id='formcontainer'>
  <h2>Registration Form</h2>
  <form class='formaction' action="indexoutput.php?id=<?php echo $id; ?>&column=<?php echo $column ?>&order=<?php echo $order ?>" method="post" id="form1">
    <input type="hidden" id="usrid" value="0">
  <div class="mb-3 mt-3" id="radio-btn">
      <div class="form-check hidetype">
        <input class="form-check-input" type="radio" name="user" id="student" value="student" checked>
        <label class="form-check-label" id='reguser' for="flexRadioDefault1">
          Register User
        </label>
      </div>
      <div class="form-check hidetype">
        <input class="form-check-input" type="radio" name="user" id="admin" value="admin">
        <label class="form-check-label" id='regadmin' for="flexRadioDefault2">
          Register Admin
        </label>
      </div>
    </div>
    <div class="mb-3 mt-3">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" id="fname" placeholder="Enter First name" name="fname">
      <div class="fname text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="lname">Last Name:</label>
      <input type="text" class="form-control" id="lname" placeholder="Enter Last name" name="lname">
      <div class="lname text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="uname" placeholder="Enter User name" name="uname">
      <span id="usernameAvailability"></span>
      <div class="uname text-danger"></div>
    </div>
    <div class="mb-3 pwdhide pwd">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
      <div class="pwd text-danger"></div>
    </div>
    <div class="mb-3 pwdhide cnfpwd">
      <label for="cnfpwd">Confirm Password:</label>
      <input type="password" class="form-control" id="cnfpwd" placeholder="Enter Confirmed password" name="cnfpswd">
      <div class="cnfpwd text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
      <span id="emailAvailability"></span>
      <div class="email text-danger"></div>
    </div>
    <div class="mb-3">
      <label for="num">Mobile Number:</label>
      <input type="number" class="form-control" id="number" placeholder="Enter Mobile number" name="mobno"  pattern="[1-9]{1}[0-9]{9}">
      <div class="number text-danger"></div>
    </div>
    <div class="mb-3">
      <select class="form-select" id="country-dropdown" aria-label="Default select example" name="country">
        <option value="">Select Country</option>
        <?php
          include_once("connection.php");
          $sql = "select * from countries";
          $result = $conn->query($sql);
          if($result->num_rows>0)
          {
            while($row = $result->fetch_assoc())
            {
          ?>
            <option value="<?php echo $row['id'];?>"><?php echo $row["name"];?></option>
          <?php
            }
          }
          ?>
      </select>
    </div>
    <div class="mb-3">
      <select class="form-select" id="state-dropdown" aria-label="Default select example" name="state">
      </select>
    </div>
    <div class="mb-3">
      <select class="form-select" id="city-dropdown" aria-label="Default select example" name="city">
      </select>
    </div>
    <input id="formtype" type="hidden" name="formtype", value="registration">
      <button class='btn btn-primary' id='backButton'>Back</button>
        <button type="submit" id = "submitbtn1" class="btn btn-primary" value="submit" name="submitbtn1">Submit</button>
        <button type="button" id = "editstudentbtn" class="btn btn-primary" value="submit" name="editstudentbtn" hidden>Edit Details</button>
        <button type="button" id = "submitstudentbtn" class="btn btn-primary" value="submit" name="submitstudentbtn" hidden>Submit Details</button>
    <div class="text-center">
    <div id='signinmsg'>
    <p>already a member? <a href="login.php">Sign in</a></p>
    </div>
  </div>
  </form>
</div>

</body>
</html>
<?php
}
else
{
?>
  <!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
<script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
  $(document).ready(function()
  {
      $("#submitbtn").click(function()
      {
        console.log("Working");
      });
      $("#backButton").hide();

    $('form[id="form1"]').validate(
      {
        rules:
        {
          fname:{required: true},
          lname:{required:true},
          uname:{
            required:true,
            minlength: 5,
            maxlength: 8,
            remote:{
              url:'checkAvailability.php',
              method:'POST',
              data:{
                type:'username',
                id: 0,
              }
            }
          },
          pswd:{
            required:true,
            minlength: 5,
            maxlength: 8,
          },
          cnfpswd:{
            required: true,
            equalTo : "#pwd",
	        },
          email:{
            required: true,
            email: true,
            remote:{
              url:'checkAvailability.php',
              method:'POST',
              data:{
                type:'email',
                id: 0,
              }
            }
          },
          mobno:{
            required:true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          country:{
            required: true,
          },
          state:{
            required:true,
          },
          city:{
            required: true,
          }
        },
        messages:
        {
          fname:'This field is required',
          lname:'This field is required',
          uname:{
            required: 'This field is required',
            minlength: 'length must be between 5 to 8 characters',
            maxlength: 'length must be between 5 to 8 characters',
            remote: 'Username already exists',
          },
          pswd:{
            required: 'This field is required',
            minlength: 'length must be between 5 to 8 characters',
            maxlength: 'length must be between 5 to 8 characters',
          },
          cnfpswd:{
			   		required : 'Confirm Password is required',
			   		equalTo : 'Password not matching',
			   	},
          email:{
            required: 'This field is required',
            minlength: 'Enter a valid email',
            remote: 'Email already exists',
          },
          mobno:{
            required: "This field is required",
            number: "Please enter a valid numeric mobile number",
            minlength: "Mobile number must be 10 digits",
            maxlength: "Mobile number must be 10 digits",
          },
          country:{
            required:"This field is required",
          },
          state:{
            required:"This field is required",
          },
          city:{
            required:"This field is required",
          }
        },
        errorClass: "error",
        validClass: "valid",
        submitHandler: function(form) {  
          form.submit();  
        }  
        
      });
  });
</script>

<!-- script for dropdowns -->
<script>
  $(document).ready(function(){
    $("#state-dropdown").hide();
    $("#city-dropdown").hide();
    $("#country-dropdown").on("change", function(){
      var countryid = $(this).val();
      $.ajax({
        url:'states-by-country.php',
        type: 'post',
        data:{country_id : countryid},
        success: function(result){
          $("#state-dropdown").show();
          $("#state-dropdown").html(result);
          $("#city-dropdown").html('<option value="">Select State First</option>');
        }

      });
    });

    $("#state-dropdown").on("change", function(){
      var stateid = $(this).val();
      $.ajax({
        url:'city-by-states.php',
        type: 'post',
        data:{state_id : stateid},
        success: function(result){
          $("#city-dropdown").show();
          $("#city-dropdown").html(result);
        }
      });
    });
  });
</script> 
<body>
<div class="container mt-3" id='formcontainer'>
  <h2>Registration Form</h2>
  <form class='formaction' action="indexoutput.php" method="post" id="form1">
    <input type="hidden" id="usrid" value="0">
  <div class="mb-3 mt-3">
      <div class="form-check hidetype">
        <input class="form-check-input" type="radio" name="user" id="student" value="student" checked>
        <label class="form-check-label" id='reguser' for="flexRadioDefault1">
          Register User
        </label>
      </div>
      <div class="form-check hidetype">
        <input class="form-check-input" type="radio" name="user" id="admin" value="admin">
        <label class="form-check-label" id='regadmin' for="flexRadioDefault2">
          Register Admin
        </label>
      </div>
    </div>
    <div class="mb-3 mt-3">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" id="fname" placeholder="Enter First name" name="fname">
      <div class="fname text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="lname">Last Name:</label>
      <input type="text" class="form-control" id="lname" placeholder="Enter Last name" name="lname">
      <div class="lname text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="uname" placeholder="Enter User name" name="uname">
      <span id="usernameAvailability"></span>
      <div class="uname text-danger"></div>
    </div>
    <div class="mb-3 pwdhide">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
      <div class="pwd text-danger"></div>
    </div>
    <div class="mb-3 pwdhide">
      <label for="cnfpwd">Confirm Password:</label>
      <input type="password" class="form-control" id="cnfpwd" placeholder="Enter Confirmed password" name="cnfpswd">
      <div class="cnfpwd text-danger"></div>
    </div>
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
      <span id="emailAvailability"></span>
      <div class="email text-danger"></div>
    </div>
    <div class="mb-3">
      <label for="num">Mobile Number:</label>
      <input type="number" class="form-control" id="number" placeholder="Enter Mobile number" name="mobno"  pattern="[1-9]{1}[0-9]{9}">
      <div class="number text-danger"></div>
    </div>
    <div class="mb-3">
      <select class="form-select" id="country-dropdown" aria-label="Default select example" name="country">
        <option value="">Select Country</option>
        <?php
          include_once("connection.php");
          $sql = "select * from countries";
          $result = $conn->query($sql);
          if($result->num_rows>0)
          {
            while($row = $result->fetch_assoc())
            {
          ?>
            <option value="<?php echo $row['id'];?>"><?php echo $row["name"];?></option>
          <?php
            }
          }
          ?>
      </select>
    </div>
    <div class="mb-3">
      <select class="form-select" id="state-dropdown" aria-label="Default select example" name="state">
      </select>
    </div>
    <div class="mb-3">
      <select class="form-select" id="city-dropdown" aria-label="Default select example" name="city">
      </select>
    </div>

    <input id="formtype" type="hidden" name="formtype", value="registration">
      <button class='btn btn-primary' id='backButton'>Back</button>
        <button type="submit" id = "submitbtn" class="btn btn-primary" value="submit" name='submitbtn'>Submit</button>
    
    <div class="text-center">
    <div id='signinmsg'>
    <p>already a member? <a href="login.php">Sign in</a></p>
    </div>
  </div>
  </form>
</div>

</body>
</html>
<?php
}


?>
