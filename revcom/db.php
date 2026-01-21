<?php
$conn = new mysqli("localhost", "root", "", "RV");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set UTF-8 charset
$conn->set_charset("utf8");
?>
