<?php
session_start(); // Start the session

// Redirect if session user is not set
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Hello <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
    <p>Connection successful!</p>
    <a href="logout.php">Logout</a>
</body>
</html>
