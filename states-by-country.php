<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "connection.php";
$country_id = $_POST["country_id"];

$result = mysqli_query($conn,"SELECT * FROM states where country_id = $country_id");
?>
<option value="">Select State</option>

<?php
    while($row = mysqli_fetch_array($result)) {
?>
        <option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
<?php
    }
?>