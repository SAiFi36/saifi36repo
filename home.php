<?php
session_start();
include 'config.php';

// Redirect if session user is not set
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = htmlspecialchars($_SESSION['user']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Hello <?php echo $user; ?></h1>
    <p>Connection successful!</p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
