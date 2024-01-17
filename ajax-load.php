<?php
    include("connection.php");
    $sql = "select * from test";
    $result = $conn->query($sql);

    if($result->num_rows>0)
    {
        $output='<table id="table-data">
        <tr>
            <td>
                Id
            </td>
            <td>
                firstname
            </td>
            <td>
                lastname
            </td>
            <td>
                Delete
            </td>
        </tr>';

        while($row = $result->fetch_assoc())
        {
            $output.= "<tr>
            <td>
                {$row['id']}
            </td>
            <td>
                {$row['Firstname']}
            </td>
            <td>
                {$row['Lastname']}
            </td>
            <td>
                <button class='deletebutton' data-id='{$row['id']}'> Delete </button>
            </td>
        </tr>";
        }
        $output.="</table>";
        $conn->close();
        echo $output;
    }
    else
    {
        echo "No records found";
    }
   
?>