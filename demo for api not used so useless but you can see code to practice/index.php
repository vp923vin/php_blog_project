<?php
// database file 
include('dbconnect.php');

if(isset($_GET['key']))
{
    // store the key value to the the variable 
    $key = mysqli_real_escape_string($conn, $_GET['key']);

    // check the the key data is present in datbase or not
    $checkRes = mysqli_query($conn, "select status from `api_token` where `token`= '$key';");
    if(mysqli_num_rows($checkRes) > 0)
    {
        $checkRow = mysqli_fetch_assoc($checkRes);
        // echo "<pre>";
        // print_r($checkRow);
        // die();
        if($checkRow['status'] == 1)
        {
            // get data from database
            $sql = "select * from users;";
            $result = mysqli_query($conn, $sql);

            // count the number of rows from the table
            $count = mysqli_num_rows($result);
            header('Content-Type:application/json');
            if($count > 0)
            {
                while($rows = mysqli_fetch_assoc($result))
                {
                $arr[] = $rows;

                }
                // json form data from database
                echo json_encode(['status' => 'true', 'data' => $arr, 'result'=>'found']);
            }
            else
            {
                echo json_encode(['status' => 'true', 'data' => "No data Found", 'result'=>'not found']);
            }
        }
        else
        {

        }
        

    }
    else
    {
        echo json_encode(['status' => 'false', 'data' => "Please Provide a valid api key"]);
    }
   

}
else
{
    echo json_encode(['status' => 'false', 'data' => "Please Provide api key"]);
}



























// table format data view in frontend

    // echo "<table>
    //         <thead >
    //             <tr>
    //                 <th>ID</th>
    //                 <th>Fname</th>
    //                 <th>Lname</th>
    //                 <th>Email</th>
    //             </tr>
    //         </thead>";
    //      echo "<tbody>
    //             <tr>
    //                 <td>".$rows['id']."</td>
    //                 <td>".$rows['fname']."</td>
    //                 <td>".$rows['lname']."</td>
    //                 <td>".$rows['email']."</td><td>
    //             </tr>
    //         </tbody>";
    //      echo "</table>";