<?php 

// details database
$hostname = 'localhost';
$username =  'root';
$password = '';
$database = 'api_user';

// create connection with local db
$conn = mysqli_connect($hostname, $username, $password, $database);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);

}
// else{
//    echo "connected successfully!";
// }

