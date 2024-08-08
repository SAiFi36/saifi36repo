<?php

$conn = new mysqli('172.31.48.9','saifi36','password','project');
session_start();
//Connection - Check
if ($conn->connect_error){
        die("Connetion Failed". $conn->connect_error);
}

//Success
//echo "CONNECTION WORKING";
//echo $_SESSION['user'];
?>
