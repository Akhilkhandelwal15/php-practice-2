<?php
    session_start();
    if (!isset($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit();
    }
?>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
    include('connection.php');
    include('index.php');
    $id =  $_GET['userid'];
    $sql = "select * from user where (id='$id')";

    if($conn->query($sql))
    {
        $result = $conn->query($sql);

        if($result->num_rows>0)
        {
            $row = $result->fetch_assoc();
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $username = $row['username'];
            $email = $row['email'];
            $mobno = $row['mobile_number'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
        }
    }
    // echo $state;
    // echo $city;
    // echo $country;

    $statesql = "select * from states where (country_id = $country and id=$state)";
    $stateresult = $conn->query($statesql);
    while($row = $stateresult->fetch_assoc())
    {
        $selectedstate = $row['name'];
    }

    $citysql = "select * from cities where (state_id = $state and id=$city)";
    $cityresult = $conn->query($citysql);
    while($row = $cityresult->fetch_assoc())
    {
        $selectedcity = $row['name'];
    }
    // echo $selectedcity;
?>


<script>
   $(document).ready(function(){

        $("#formcontainer > h2:first").text("Edit User");
        $("#title").text("Edit User form");
        $("#reguser").text("User");
        $("#regadmin:first").text("Admin");
        $(".pwdhide").hide();
        $("#fname").attr('value','<?php echo $firstname; ?>');
        $("#lname").attr('value','<?php echo $lastname; ?>');
        $("#uname").attr('value','<?php echo $username; ?>');
        $("#email").attr('value','<?php echo $email; ?>');
        $("#number").attr('value',<?php echo $mobno;?>);
        $("#usrid").attr('value',<?php echo $id;?>);
        $("#state-dropdown").show();
        $("#city-dropdown").show();

        $("#country-dropdown option[value='<?php echo $country;?>']").attr('selected', true);

        var selectedstate = <?php echo json_encode($selectedstate); ?>;
        var state = <?php echo json_encode($state); ?>;
        $("#state-dropdown").append('<option value="' + state + '">' + selectedstate + '</option>')
        $("#state-dropdown option[value='" + state + "']").attr('selected', true); 

        var selectedcity = <?php echo json_encode($selectedcity); ?>;
        var city = <?php echo json_encode($city); ?>;

        $("#city-dropdown").append('<option value="' + city + '">' + selectedcity + '</option>')
        $("#city-dropdown option[value='" + city + "']").attr('selected', true);  

        $("#submit").text("update");
        $(".formaction").attr('action', 'edituseroutput.php?id=<?php echo $id; ?>');
        $("#signinmsg").hide();
        $("#backButton").show();
        $("#backButton").click(function (){
            window.history.back();
        });
        // $("#edituserflag").val('true');
   });
</script>

