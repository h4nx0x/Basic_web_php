<?php

$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "db_admin";

$conn = new mysqli($server_name, $username, $password, $database_name);
mysqli_set_charset($conn, 'UTF8');
if ($conn->connect_error) {
    die("MySQL connect error!!!");
}

?>