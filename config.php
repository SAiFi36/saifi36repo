<?php
$host = '172.31.48.11';  // Replace with your MariaDB host
$username = 'saifi36';  // Replace with your MariaDB username
$password = 'secret';   // Replace with your MariaDB password
$database = 'project';  // Replace with your MariaDB database name

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $database);

// Start a session
session_start();

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection was successful
echo "Connection successful!";
?>
