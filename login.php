<?php
include 'config.php';

// Start the session
session_start();

// Redirect if session user is already set
if (isset($_SESSION['user'])) {
    header("Location: home.php");
    exit;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    // Prepare and execute a statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $uname, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>
                alert('WRONG CREDENTIALS');
                window.location = 'index.php';
              </script>";
    } else {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user['username'];
        echo "<script>window.location = 'home.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit;
}
?>
