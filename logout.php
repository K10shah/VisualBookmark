<?php
		session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
	if(isset($_SESSION['name'])){
		
	session_destroy();
	}
	session_destroy();
	unset($_SESSION['fb_user_details']);
	header("Location: login.php"); 

	
?>