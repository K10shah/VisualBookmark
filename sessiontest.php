<?php
	session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
	if(!isset($_SESSION['uid']) && !isset($_SESSION['fb_user_details'])){
	header("Location: login.php");
	exit();
	die();
	//$username = $_GET['friendname'];
	$origuserid = $_SESSION['uid'];
	//$_SESSION['friendname'] = $_GET['friendname'];
	echo $_SESSION['uid'];
	
	session_write_close();
	}
?>