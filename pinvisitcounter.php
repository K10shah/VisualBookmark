<?php
session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
	if(!isset($_SESSION['name'])){
	header("Location: login.php");
	exit();
	die();
	}
$pinid = $_GET['pinid'];
$sql = "select * from bookmarks where bookmarkid = '$pinid'";
$result=mysqli_query($con,$sql);
if (!$result)
{
	die(mysqli_error($con));
}
$count2=mysqli_num_rows($result);
if($count2 > 0)
{
	
	$row = mysqli_fetch_array($result);
	$vcount = $row['visitcount'];
	$vcount= $vcount + 1;
	$sql2 = "update bookmarks SET visitcount='$vcount' where bookmarkid = '$pinid'";
	$result=mysqli_query($con,$sql2);
if (!$result)
{
	die(mysqli_error($con));
}
	header("Location: ".$row['link']);
}
else
{
	header("location: newuitest.php");
}
?>