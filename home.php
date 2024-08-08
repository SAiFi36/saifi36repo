<?php
include 'config.php';

// Redirect if session user is not set
if (!isset($_SESSION['user'])) {
    // Ensure no output has been sent before this
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<body>
<h1> Hello <?php echo htmlspecialchars($_SESSION['user']); ?> </h1>
<p>Connection successful!</p>
</body>
</html>
