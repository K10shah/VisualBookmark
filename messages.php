<html>
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
$emailstore = $_SESSION['uname'];
$emailstore = stripslashes($emailstore);
$emailstore = mysqli_real_escape_string($con,$emailstore);
?>
<head>

<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
</head>
<body>
<?php
$ownername = $_SESSION['name'];
if($_SESSION['friend']){
$friendid = $_SESSION['friend'];
$sql = "select * from login where uid =".$_SESSION['friend'];
$result=mysqli_query($con,$sql);
if (!$result)
{
	die(mysqli_error($con));
}
while($row = mysqli_fetch_array($result) )
{
	$friendname = $row['Name'];

}
$sql1 = "select * from login where username='$emailstore'";
$result1 = mysqli_query($con,$sql1);
if (!$result1)
{
	die(mysqli_error($con));
}
while($row1 = mysqli_fetch_array($result1) )
{
	$uid = $row1['uid'];
}
$sql3 = "select * from profile where profileid =".$_SESSION['friend'];
$result=mysqli_query($con,$sql3);
if (!$result)
{
	die(mysqli_error($con));
}
while($row = mysqli_fetch_array($result) )
{
	if($row['profilephoto']==NULL)
		$friendimage='facebook_blank_face3.jpeg';
	else
		$friendimage = $row['profilephoto'];

}
$sql4 = "select * from profile where profileid =".$uid;
$result=mysqli_query($con,$sql4);
if (!$result)
{
	die(mysqli_error($con));
}
while($row = mysqli_fetch_array($result) )
{
	if($row['profilephoto']==NULL)
		$ownerimage='facebook_blank_face3.jpeg';
	else
		$ownerimage = $row['profilephoto'];

}
$sql2 = "select * from inbox where ((sender='$uid' and receiver='$friendid')or(sender='$friendid' and receiver='$uid'))";
$result2 = mysqli_query($con,$sql2);
if (!$result2)
{
	die(mysqli_error($con));
}
echo "<br><br>";
while($row2 = mysqli_fetch_array($result2) )
{
	//showing messages in a custom div
	if($row2['sender']==$uid)
	{$messagesender = $ownername;
	$imagedisp = $ownerimage;}
	else if($row2['sender']==$friendid)
	{$messagesender = $friendname;
	$imagedisp = $friendimage;}

	echo "<div class='snippet'> <img src='$imagedisp' width=20px height='20px' class='image-rounded	'/><font size='5'><b>
	$messagesender </b></font> <font size='3'>:  
	".$row2['message']." 
	</div><br>";
}}
else
echo "No friend selected";	
?>

</body>
</html>