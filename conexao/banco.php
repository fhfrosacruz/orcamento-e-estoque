<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tapecaria";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}



$conn->set_charset("utf8")

 ?>
