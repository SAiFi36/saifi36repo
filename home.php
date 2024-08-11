<?php
session_start(); // Start the session here to check if the user is logged in

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
</body>
</html>
