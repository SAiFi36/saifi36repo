<?php
include 'config.php';


if(!isset($_SESSION['user']))
{
        header("Location:index.html");
        exit;
}
//echo($_SESSION['user']);

?>
<h1> Hello <?php echo($_SESSION['user'])?> </h1>
