
<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Pannel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<!-- <style>tr .highlight {
				background-color: #f9fafb;
			}</style> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
</head>
<body>
<?php
    session_start();
    $typeofuser = $_SESSION['typeofuser'];
    include('connection.php');
    $sql = "select id, firstname, lastname, username, email, mobile_number, type from user";
    $result = $conn->query($sql);
    $id = $_GET['id'];

    //sorting

    $columnsarray = array('firstname','username','email');
    if(isset($_GET['column']) && in_array($_GET['column'], $columnsarray))
    {
        $column = $_GET['column'];
    }
    else
    {
        $column = $columnsarray[0];
    }

    if(isset($_GET['order']) && strtolower($_GET['order'])=='desc')
    {
        $sort_order = 'DESC';
    }
    else
    {
        $sort_order = 'ASC';
    }

    $sort_sql = "SELECT * FROM user ORDER BY $column $sort_order";

    $sort_result = $conn->query($sort_sql);

    


    // pagination
    $limit = 2;
    $total_rows = $result->num_rows;
    $total_pages = ceil($total_rows/$limit);
    if(!isset($_GET['page']))
    {
        $page_number = 1;
    }
    else
    {
        $page_number = $_GET['page'];
    }

    $initial_page_number = ($page_number-1)*$limit;

    $sql2 = "select id, firstname, lastname, username, email, mobile_number, type from user LIMIT " . $initial_page_number . ',' . $limit;  
    $result2 = $conn->query($sql2);

    if($sort_result->num_rows>0)
    {        
        $up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order);
        if($sort_order=='ASC')
        {
            $asc_or_desc = 'desc';
        }
        else
        {
            $asc_or_desc = 'asc';
        }
        $add_class = ' class="highlight"';
        echo "<div lass=d-flex justify-content-center'>";
        
        echo "<div class='text-center'>";
        echo "<h2 class='text-info col-md-8'> This is ". $typeofuser ." Dashboard</h2>";
        echo "</div>";
       
        echo "<div class='text-center col-md-4'>";
        echo       "<div class='input-group rounded'>
        <input type='search' id='search' class='form-control rounded' placeholder='Search' aria-label='Search' aria-describedby='search-addon' />
        <span class='input-group-text border-0' id='search-addon'>
            <i class='fas fa-search'></i>
        </span>
        </div>
        ";
        echo "</div>";
        echo "<a href='adduser.php?id=$id' id='addUserButton' type='button' class='btn btn-primary'>Add User</a>";
        echo "<a href='logout.php' type='button' class='btn btn-primary'>Logout</a>";
        echo "<a href='changePassword.php?id=$id' type='button' class='btn btn-primary'>Change Password</a>";
        echo "</div>";

        ?>
        <table class='table table-hover' id='myTable'>
                <tr>
                    <th>ID</th>
                    <th><a href="prac.php?column=firstname&order=<?php echo $asc_or_desc; ?>">Name<i class="fas fa-sort<?php echo $column == 'firstname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="prac.php?column=username&order=<?php echo $asc_or_desc; ?>">Username<i class="fas fa-sort<?php echo $column == 'username' ? '-' . $up_or_down : ''; ?>"></i></a></th>
					<th><a href="prac.php?column=email&order=<?php echo $asc_or_desc; ?>">Email<i class="fas fa-sort<?php echo $column == 'email;' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                    <th>Mobile Number</th>
                    <th>User Type</th>
                    <th>Edit Details</th>
                    <th>Delete User</th>
                </tr>"
        <?php
        while($row = $sort_result->fetch_assoc()) 
        {
            $username = $row['username'];
            $userid = $row['id'];
            
            echo "<div><tr>
                    <td>".$row["id"]."</a></td>";
                    ?>
                    <td<?php echo $column == 'firstname' ? $add_class : ''; ?>><?php echo $row['firstname']." ".$row['lastname']; ?></td>
					<td<?php echo $column == 'username' ? $add_class : ''; ?>><?php echo $row['username']; ?></td>
					<td<?php echo $column == 'email' ? $add_class : ''; ?>><?php echo $row['email']; ?></td>
                    <?php
                    echo "<td>".$row["mobile_number"]."</td>
                    <td>".$row["type"]."</td>
                    <td>
                        <a href=edituser.php?id=" .$row['id']." class='btn btn-success'>Edit</a>
                    </td>
                    <td>
                   
                    <button class='btn btn-danger anchor' data-toggle='modal' data-target='#myModal_$userid' value =".$row['id'].">Delete</button>
                    </td>
                </tr></div>";

                echo "</div>";

                echo "<div class='modal fade' id='myModal_$userid' role='dialog'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header text-center'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <h2 class='modal-title'>Delete Account</h2>
                    </div>
                    <div class='modal-body text-center'>
                        <p>Are you sure you want to delete $username ?</p>
                        <div class='btn-group btn-group-justified'>
                            <a type='button' href='#' class='btn btn-primary' data-dismiss='modal'>Cancel</a>
                            <a class='btn btn-danger' id='deleteButton_$userid'>Delete</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        ";
        }
        echo "</table>";
    
    }
    echo "<div>";
        echo '<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">';
            echo '<ul class="pagination navbar-nav">';

                for ($page_number = 1; $page_number <= $total_pages; $page_number++) 
                {
                    echo '<li class="page-item"><a class="page-link" href="adminedit.php?page=' . $page_number . '&id='.$id .'">' . $page_number . '</a></li>';
                }

            echo '</ul>';
        echo '</nav>';
    echo "</div>";

    
    
    // session_unset();
    // session_destroy();
    // <a href=deleteuser.php?id=" .$row['id']." class='btn btn-danger' data-toggle='modal' data-target='#myModal'>Delete</a>
?>