<?php
$servername = "localhost";
$username = "root"; //not a safe password, change
$password = ""; // definitely not safe, change
$dbname = "Hilton"; //xampp

//standard
$conn = new mysqli($servername, $username, $password, $dbname);

//check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
