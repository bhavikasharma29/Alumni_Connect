<?php
$host = "localhost";
$user = "root";  // Change if needed
$password = "";  // Change if you set a MySQL password
$database = "alumni_portal";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
