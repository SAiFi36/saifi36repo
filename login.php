<?php
session_start(); // Start the session

include 'config.php'; // Include database connection and config

if (!isset($_POST['submit'])) {
    header("Location: index.php");
    exit;
}

$username = $_POST['uname'];
$password = $_POST['pass'];

// Ensure the query is safe from SQL injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

$test_query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$query_result = mysqli_query($conn, $test_query);

if (mysqli_num_rows($query_result) == 0) {
    ?>
    <script>
        alert("WRONG CREDENTIALS");
        window.location = "index.php";
    </script>
    <?php
} else {
    while ($test = mysqli_fetch_array($query_result)) {
        $_SESSION['user'] = $test['username'];
    }
    ?>
    <script>
        window.location = 'home.php';
    </script>
    <?php
}
?>
