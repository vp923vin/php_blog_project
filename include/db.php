<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'login_system';

$conn = new mysqli($hostname, $username, $password, $database);

if($conn->connect_error)
{
    echo "Unsuccessful connection" . $conn->connect_error;
}
// else{
//     echo "Connection Success";
// }
