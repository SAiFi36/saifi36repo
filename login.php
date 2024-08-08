	<?php

	include 'config.php';

	if(!isset($_REQUEST['submit']))
	{
			header("Location:index.php");
			exit;
	}

	//print_r($_REQUEST);
	$test_query = "SELECT * FROM users WHERE username='".$_REQUEST['uname']."' and password='".$_REQUEST['pass']."'";
	//print_r($test_query);

	$query_result=mysqli_query($conn,$test_query,MYSQLI_STORE_RESULT);

	if(mysqli_num_rows($query_result)==0)
	{?>
			<script>
					alert("WRONG CREDENTIALS");
					window.location = "index.php";
			</script>
	<?php
	}

	else
	{
			while($test=mysqli_fetch_array($query_result))
			{
			$_SESSION['user']=$test['username'];
	//      print_r($_SESSION['user']);
			}

	?>

			<script>
					window.location = 'home.php';
			</script>
	<?php
	}

	?>
