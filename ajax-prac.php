<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            function loadtable()
            {
                $.ajax({
                        url: 'ajax-load.php',
                        type:'post',
                        success: function(data){
                            $("#table-data").html(data);
                        }
                    });
                }
            loadtable();

            $("#submitform").click(function(e){
                e.preventDefault();
                var firstname = $("#fname").val();
                var lastname = $("#lname").val();
                // console.log(firstname, lastname);
                $.ajax({
                    url: 'ajax-prac-sql.php',
                    type: 'POST',
                    data: {first_name: firstname, last_name: lastname},
                    success: function(result){
                        if(result==1)
                        {
                            loadtable();
                        }
                        else
                        {
                            alert("Error");
                        } 
                    }
                })
            });

            $(document).on("click",".deletebutton", function(){
                var userid = $(this).data('id');
                var element = $(this);
                $.ajax({
                    url:"ajax-delete.php",
                    type:'POST',
                    data: {id: userid},
                    success:function(result){
                        if(result==1)
                        {
                            $(element).closest("tr").fadeOut();
                        }
                        else
                        {
                            alert("error: data not deleted");
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>
    <form>
        <table id='table-fields'>
            <tr>
                <td>
                    firstname
                </td>
                <td>
                    lastname
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" id="fname"> 
                </td>
                <td>
                    <input type="text" id="lname">
                </td>
                <td>
                    <input type="Submit" value="Submit" id="submitform">
                </td>
            </tr>
            <tr id='table-row'>
                <td id='table-data'></td>
            </tr>
        </table>
    </form>
    <!-- <button id="submit">Load data</button> -->
</body>
</html>