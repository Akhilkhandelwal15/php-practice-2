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
ini_set("display_errors", 1);
if(!isset($_GET['search']))
{
    $adminid = $_GET['id'];
    if(isset($_GET['order']))
    {
        $order = $_GET['order'];
    }
    else
    {
        $order = "desc";
    }
    if(isset($_GET['column']))
    {
        $column = $_GET['column'];

    }
    else
    {
        $column = "firstname";
    }
    if(isset($_GET['msg'])&& $_GET['msg']=='updatesuccess')
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                console.log("hello");
                $("#updateusermessage").html("<h3>user Updated Successfully</h3>").fadeIn();
                    setTimeout(function(){
                    $("#updateusermessage").fadeOut();
                }, 2000);
            });
        </script>
        <?php
    }
    if(isset($_GET['dltmsg'])&& $_GET['dltmsg']=='deletesuccess')
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                console.log("hello");
                $("#deleteusermessage").html("<h3>user Deleted Successfully</h3>").fadeIn();
                    setTimeout(function(){
                    $("#deleteusermessage").fadeOut();
                }, 2000);
            });
        </script>
        <?php
    }
    if(isset($_GET['msg'])&& $_GET['msg']=='addusersuccess')
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                console.log("hello");
                $("#addusermessage").html("<h3>user Added Successfully</h3>").fadeIn();
                    setTimeout(function(){
                    $("#addusermessage").fadeOut();
                }, 2000);
            });
        </script>
        <?php
    }

    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin Pannel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="pagination.css">
    </head>

    <body>
        <script>
            $(document).ready(function() {
                $(".anchor").click(function() {
                    var userId = $(this).val();
                    $('#deleteButton_' + userId).attr('href', 'deleteuser.php?id=' + userId + '&adminid=' + <?php echo json_encode($adminid); ?> + '&column=' + <?php echo json_encode($column); ?> + '&order=' + <?php echo json_encode($order); ?>);
                });
            });
        </script>
        <?php
        $typeofuser = $_SESSION['typeofuser'];
        include('connection.php');
        $sql = "select id, firstname, lastname, username, email, mobile_number, type from user";
        $result = $conn->query($sql);
        $id = $_GET['id'];

        //sorting

        $columnsarray = array('id','firstname','username','email');
        if(isset($_GET['column']) && in_array($_GET['column'], $columnsarray))
        {
            $column = $_GET['column'];
        }
        else
        {
            $column = $columnsarray[0];
        }

        if(isset($_GET['order']) && strtolower($_GET['order'])=='asc')
        {
            $sort_order = 'ASC';
        }
        else
        {
            $sort_order = 'DESC';
        }
        
        
        
        //count total users
        $count = "select count(*) as count from user";
        $countresult = $conn->query($count);
        $row = $countresult->fetch_assoc();
        $userscount = $row['count'];

        // pagination
        $limit = 5;
        $total_rows = $result->num_rows;
        $totalPages = ceil($total_rows / $limit);
        $pn;
        if (!isset($_GET['page'])) {
            $pn = 1;
        } else {
            $pn = $_GET['page'];
        }
        $queryString = "?";

        $initial_page_number = ($pn - 1) * $limit;


        $sql2 = "SELECT id, firstname, lastname, username, email, mobile_number, type FROM user ORDER BY " . $column . " " . $sort_order. " LIMIT " . $initial_page_number . ',' . $limit;

        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {

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

            echo "<div class='d-flex justify-content-center'>";

            echo "<div class='text-center'>";
            echo "<h2 class='text-info col-md-8'> This is Admin Dashboard</h2>";
            echo "</div>";


            echo "<a href='adduser.php?id=$id' id='addUserButton' type='button' class='btn btn-primary'>Add User</a>";
            echo "<a href='logout.php' type='button' class='btn btn-primary'>Logout</a>";
            echo "<a href='changePassword.php?id=$id' type='button' class='btn btn-primary'>Change Password</a>";
            echo "</div>";
            echo "<div> Total Users are: $userscount </div>";
            ?>
    <form id="searchForm" action="adminedit.php" method="POST">
        <input type="text" id="searchInput" name="query" placeholder="Search.....">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <script>
        $(document).ready(function(){
            $('#searchForm').submit(function() {
                var searchValue = $('#searchInput').val();
                var newAction = "adminedit.php?page=<?php echo 1; ?>&id=<?php echo $id; ?>&column=<?php echo $column; ?>&order=<?php echo $order; ?>&search=" + searchValue;

                $(this).attr('action', newAction);
            });
        });
    </script>

            <table class='table table-hover' id='myTable'>
                <tr>
                    <th>ID</th>
                    <th><a href="adminedit.php?column=firstname&order=<?php echo $asc_or_desc; ?>&id=<?php echo $id; ?>">Name<i class="fas fa-sort<?php echo $column == 'firstname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                    <th><a href="adminedit.php?column=username&order=<?php echo $asc_or_desc; ?>&id=<?php echo $id; ?>">Username<i class="fas fa-sort<?php echo $column == 'username' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                    <th><a href="adminedit.php?column=email&order=<?php echo $asc_or_desc; ?>&id=<?php echo $id; ?>">Email<i class="fas fa-sort<?php echo $column == 'email' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                    <th>Mobile Number</th>
                    <th>User Type</th>
                    <th>Edit Details</th>
                    <th>Delete User</th>
                </tr>"
            <?php
            while ($row = $result2->fetch_assoc()) {
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
                        <a href='edituser.php?userid=" . $row['id'] . "&id=" . $_GET['id'] . "' class='btn btn-success'>Edit</a>
                        </td>
                        <td>
                    
                        <button class='btn btn-danger anchor' data-toggle='modal' data-target='#myModal_$userid' value =" . $row['id'] . ">Delete</button>
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
        echo "<div style='text-align:center' id='updateusermessage' class='text-success'> </div>";
        echo "<div style='text-align:center' id='deleteusermessage' class='text-success'> </div>";
        echo "<div style='text-align:center' id='addusermessage' class='text-success'></div>";

        echo "<div>";
        echo '<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">';
        echo '<ul class="pagination navbar-nav">';
        
        ?>
        
        <div class="pagination">
            <?php
            if($totalPages>1)
            {
            if (($pn > 1)) {
            ?>
                <a class="previous-page" id="prev-page" href="<?php echo $queryString; ?>page=<?php echo (($pn - 1)); ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>" title="Previous Page"><span>&#10094; Previous</span></a>
            <?php } ?>
            <?php
            if (($pn - 1) > 1) {
            ?>
                <a href='adminedit.php?page=1&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>'>
                    <div class='page-a-link'>1</div>
                </a>
                <div class='page-before-after'>...</div>
            <?php
            }

            for ($i = ($pn - 1); $i <= ($pn + 1); $i++) {
                if ($i < 1)
                    continue;
                if ($i > $totalPages)
                    break;
                if ($i == $pn) {
                    $class = "active";
                } else {
                    $class = "page-a-link";
                }
            ?>
                <a href='adminedit.php?page=<?php echo $i; ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>'>
                    <div class='<?php echo $class; ?>'><?php echo $i; ?></div>
                </a>
            <?php
            }

            if (($totalPages - ($pn + 1)) >= 1) {
            ?>
                <div class='page-before-after'>...</div>
            <?php
            }
            if (($totalPages - ($pn + 1)) > 0) {
                if ($pn == $totalPages) {
                    $class = "active";
                } else {
                    $class = "page-a-link";
                }
            ?>
                <a href='adminedit.php?page=<?php echo $totalPages; ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>'>
                    <div class='<?php echo $class; ?>'><?php echo $totalPages; ?></div>
                </a>
            <?php
            }
            if (($pn < $totalPages)) {
            ?>
                <a class="next" id="next-page" href="<?php echo $queryString; ?>page=<?php echo (($pn + 1)); ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>" title="Next Page"><span>Next &#10095;</span></a>
            <?php
            }
            }
            ?>
            <?php

            echo '</ul>';
            echo '</nav>';
            echo "</div>";

}
else
{
    if(!isset($_REQUEST['query']))
    {
        $search_item = $_GET['search'];
    }
    else
    {
        $search_item = $_REQUEST['query'];
    }
    $adminid = $_GET['id'];
    if(isset($_GET['order']))
    {
        $order = $_GET['order'];
    }
    else
    {
        $order = "desc";
    }
    if(isset($_GET['column']))
    {
        $column = $_GET['column'];

    }
    else
    {
        $column = "firstname";
    }
    if(isset($_GET['msg'])&& $_GET['msg']=='updatesuccess')
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                console.log("hello");
                $("#updateusermessage").html("<h3>user Updated Successfully</h3>").fadeIn();
                    setTimeout(function(){
                    $("#updateusermessage").fadeOut();
                }, 2000);
            });
        </script>
        <?php
    }
    if(isset($_GET['dltmsg'])&& $_GET['dltmsg']=='deletesuccess')
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                console.log("hello");
                $("#deleteusermessage").html("<h3>user Deleted Successfully</h3>").fadeIn();
                    setTimeout(function(){
                    $("#deleteusermessage").fadeOut();
                }, 2000);
            });
        </script>
        <?php
    }
    if(isset($_GET['msg'])&& $_GET['msg']=='addusersuccess')
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                console.log("hello");
                $("#addusermessage").html("<h3>user Added Successfully</h3>").fadeIn();
                    setTimeout(function(){
                    $("#addusermessage").fadeOut();
                }, 2000);
            });
        </script>
        <?php
    }

    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin Pannel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="pagination.css">
    </head>

    <body>
        <script>
            $(document).ready(function() {
                $(".anchor").click(function() {
                    var userId = $(this).val();
                    $('#deleteButton_' + userId).attr('href', 'deleteuser.php?id=' + userId + '&adminid=' + <?php echo json_encode($adminid); ?> + '&column=' + <?php echo json_encode($column); ?> + '&order=' + <?php echo json_encode($order); ?>);
                });
            });
        </script>
        <?php
        // session_start();
        if (!isset($_SESSION['logged_in'])) {
            header('Location: login.php');
            exit();
        }
        include('connection.php');
        $sql = "select id, firstname, lastname, username, email, mobile_number, type from user WHERE firstname LIKE '%$search_item%' OR lastname LIKE '%$search_item%' OR username LIKE '%$search_item%' OR email LIKE '%$search_item%' ";
        $result = $conn->query($sql);
        $id = $_GET['id'];
        $typeofuser = "Admin";
        //sorting

        $columnsarray = array('id', 'firstname','username','email');
        if(isset($_GET['column']) && in_array($_GET['column'], $columnsarray))
        {
            $column = $_GET['column'];
        }
        else
        {
            $column = $columnsarray[0];
        }

        if(isset($_GET['order']) && strtolower($_GET['order'])=='asc')
        {
            $sort_order = 'ASC';
        }
        else
        {
            $sort_order = 'DESC';
        }

        //count total users
        $count = "select count(*) as count from user WHERE firstname LIKE '%$search_item%' OR lastname LIKE '%$search_item%' OR username LIKE '%$search_item%' OR email LIKE '%$search_item%'";
        $countresult = $conn->query($count);
        $row = $countresult->fetch_assoc();
        $userscount = $row['count'];

        // pagination
        $limit = 5;
        $total_rows = $result->num_rows;
        $totalPages = ceil($total_rows / $limit);
        $pn;
        if (!isset($_GET['page'])) {
            $pn = 1;
        } else {
            // $page_number = $_GET['page'];
            $pn = $_GET['page'];
        }
        $queryString = "?";

        $initial_page_number = ($pn - 1) * $limit;

        $sql2 = "SELECT id, firstname, lastname, username, email, mobile_number, type FROM user 
        WHERE firstname LIKE '%$search_item%' OR lastname LIKE '%$search_item%' OR username LIKE '%$search_item%' OR email LIKE '%$search_item%' 
        ORDER BY $column $sort_order LIMIT $initial_page_number, $limit";

        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {

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

            echo "<div class='d-flex justify-content-center'>";

            echo "<div class='text-center'>";
            echo "<h2 class='text-info col-md-8'> This is Admin Dashboard</h2>";
            echo "</div>";


            echo "<a href='adduser.php?id=$id' id='addUserButton' type='button' class='btn btn-primary'>Add User</a>";
            echo "<a href='logout.php' type='button' class='btn btn-primary'>Logout</a>";
            echo "<a href='changePassword.php?id=$id' type='button' class='btn btn-primary'>Change Password</a>";
            echo "</div>";
            echo "<div> Total Users are: $userscount </div>";
            ?>
            <form id="searchForm" action="adminedit.php" method="POST">
                <input type="text" id="searchInput" name="query" placeholder="Search....." value=<?php echo $search_item?>>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <script>
                $(document).ready(function(){
                    $('#searchForm').submit(function() {
                        var searchValue = $('#searchInput').val();
                        var newAction = "adminedit.php?page=<?php echo 1; ?>&id=<?php echo $id; ?>&column=<?php echo $column; ?>&order=<?php echo $order; ?>&search=" + searchValue;

                        $(this).attr('action', newAction);
                    });
                });
            </script>

            <table class='table table-hover' id='myTable'>
                <tr>
                    <th>ID</th>
                    <th><a href="adminedit.php?column=firstname&order=<?php echo $asc_or_desc; ?>&id=<?php echo $id; ?>&search=<?php echo $search_item?>">Name<i class="fas fa-sort<?php echo $column == 'firstname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                    <th><a href="adminedit.php?column=username&order=<?php echo $asc_or_desc; ?>&id=<?php echo $id; ?>&search=<?php echo $search_item?>">Username<i class="fas fa-sort<?php echo $column == 'username' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                    <th><a href="adminedit.php?column=email&order=<?php echo $asc_or_desc; ?>&id=<?php echo $id; ?>&search=<?php echo $search_item?>">Email<i class="fas fa-sort<?php echo $column == 'email' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                    <th>Mobile Number</th>
                    <th>User Type</th>
                    <th>Edit Details</th>
                    <th>Delete User</th>
                </tr>"
            <?php
            while ($row = $result2->fetch_assoc()) {
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
                        <a href='edituser.php?userid=" . $row['id'] . "&id=" . $_GET['id'] . "' class='btn btn-success'>Edit</a>
                        </td>
                        <td>
                    
                        <button class='btn btn-danger anchor' data-toggle='modal' data-target='#myModal_$userid' value =" . $row['id'] . ">Delete</button>
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
        else
        {

            echo "<div class='d-flex justify-content-center'>";

            echo "<div class='text-center'>";
            echo "<h2 class='text-info col-md-8'> This is " . $typeofuser . " Dashboard</h2>";
            echo "</div>";


            echo "<a href='adduser.php?id=$id' id='addUserButton' type='button' class='btn btn-primary'>Add User</a>";
            echo "<a href='logout.php' type='button' class='btn btn-primary'>Logout</a>";
            echo "<a href='changePassword.php?id=$id' type='button' class='btn btn-primary'>Change Password</a>";
            echo "</div>";
            echo "<div> Total Users are: $userscount </div>";
            ?>
            <form action="adminedit.php?page=<?php echo (($pn)); ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>&search=<?php echo $search_item?>" method="post">
                <input type="text" name="query" placeholder="Search....." value='<?php echo $search_item; ?>'>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <table class='table table-hover' id='myTable'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>                   
                    <th>Mobile Number</th>
                    <th>User Type</th>
                    <th>Edit Details</th>
                    <th>Delete User</th>
                </tr>"
            <?php
            echo "</table>";
            echo "No Records Found";
        }
        echo "<div style='text-align:center' id='updateusermessage' class='text-success'></div>";
        echo "<div style='text-align:center' id='deleteusermessage' class='text-success'></div>";
        echo "<div style='text-align:center' id='addusermessage' class='text-success'></div>";

        echo "<div>";
        echo '<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">';
        echo '<ul class="pagination navbar-nav">';
       
        ?>
        
        <div class="pagination">
            <?php
            if($totalPages>1)
            {

 
            // echo $search_item;
            if (($pn > 1)) {
            ?>
                <a class="previous-page" id="prev-page" href="<?php echo $queryString; ?>page=<?php echo (($pn - 1)); ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>&search=<?php echo $search_item ?>" title="Previous Page"><span>&#10094; Previous</span></a>
            <?php } ?>
            <?php
            if (($pn - 1) > 1) {
            ?>
                <a href='adminedit.php?page=1&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>&search=<?php echo $search_item?>'>
                    <div class='page-a-link'>1</div>
                </a>
                <div class='page-before-after'>...</div>
            <?php
            }

            for ($i = ($pn - 1); $i <= ($pn + 1); $i++) {
                if ($i < 1)
                    continue;
                if ($i > $totalPages)
                    break;
                if ($i == $pn) {
                    $class = "active";
                } else {
                    $class = "page-a-link";
                }
            ?>
                <a href='adminedit.php?page=<?php echo $i; ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>&search=<?php echo $search_item?>'>
                    <div class='<?php echo $class; ?>'><?php echo $i; ?></div>
                </a>
            <?php
            }

            if (($totalPages - ($pn + 1)) >= 1) {
            ?>
                <div class='page-before-after'>...</div>
            <?php
            }
            if (($totalPages - ($pn + 1)) > 0) {
                if ($pn == $totalPages) {
                    $class = "active";
                } else {
                    $class = "page-a-link";
                }
            ?>
                <a href='adminedit.php?page=<?php echo $totalPages; ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>&search=<?php echo $search_item?>'>
                    <div class='<?php echo $class; ?>'><?php echo $totalPages; ?></div>
                </a>
            <?php
            }
            if (($pn < $totalPages)) {
            ?>
                <a class="next" id="next-page" href="<?php echo $queryString; ?>page=<?php echo (($pn + 1)); ?>&id=<?php echo $id ?>&column=<?php echo $column ?>&order=<?php echo $order ?>&search=<?php echo $search_item?>" title="Next Page"><span>Next &#10095;</span></a>
            <?php
                       }
            }
            ?>
            <?php

            echo '</ul>';
            echo '</nav>';
            echo "</div>";
}
        ?>