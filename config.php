<?php

$conn = new mysqli('localhost','tinku','Tinku@123','my_users');
session_start();
//Connection - Check
if ($conn->connect_error){
        die("Connetion Failed". $conn->connect_error);
}

//Success
//echo "CONNECTION WORKING";
//echo $_SESSION['user'];
?>
