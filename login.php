<?php
include 'config.php'; // Include database connection and config

session_start(); // Start the session

if (!isset($_REQUEST['submit'])) {
    header("Location: index.php");
    exit;
}

$username = $_REQUEST['uname'];
$password = $_REQUEST['pass'];

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
