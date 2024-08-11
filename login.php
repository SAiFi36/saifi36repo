<?php
include 'config.php'; // Ensure this is included after starting the session in your main script

// Start a session
session_start();

if(!isset($_REQUEST['submit'])) {
    header("Location: index.php");
    exit;
}

$test_query = "SELECT * FROM users WHERE username='" . $_REQUEST['uname'] . "' AND password='" . $_REQUEST['pass'] . "'";
$query_result = mysqli_query($conn, $test_query, MYSQLI_STORE_RESULT);

if(mysqli_num_rows($query_result) == 0) {
    ?>
    <script>
        alert("WRONG CREDENTIALS");
        window.location = "index.php";
    </script>
    <?php
} else {
    while($test = mysqli_fetch_array($query_result)) {
        $_SESSION['user'] = $test['username'];
    }
    ?>
    <script>
        window.location = 'home.php';
    </script>
    <?php
}
?>
