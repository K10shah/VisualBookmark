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
	die();}
?>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="js/masonry.pkgd.min.js"></script>
</head>
<body>
<div class="topnavbar">
</div>
<div class="secondnavbar">
<div class="appearing-name-photo">
<img src="facebook_blank_face3.jpeg" width="40px" height="40px" class="img-rounded"/> &nbsp <font size="5"> <?php echo $_SESSION['uname'];?></font>
</div>
</div>
<div class="boardpincontent">
<div id="wrapper">
<?php
$whichboard = $_GET['selboard'];
$emailstore = $_SESSION['uname'];
		$emailstore = stripslashes($emailstore);
		$emailstore = mysqli_real_escape_string($con,$emailstore);
		  $sql1 ="SELECT * FROM bookmarks where bookmarkid in (select pinid from pinreference where bid='$whichboard')";
			$result=mysqli_query($con,$sql1);
			if (!$result)
			{
    die(mysqli_error($con));
			}
			echo "<div id='columns'>";
				echo "<script>
				$(document).ready( function() {
  var container = $('#columns');
  $('#columns').masonry({
    columnWidth: 10,
    itemSelector: '.pin',
	isOriginLeft: true
				});
				
				}); </script>";
			$count2=mysqli_num_rows($result);
			if($count2 > 0)
			{
				
				while($row = mysqli_fetch_array($result))
				{	
					
					echo "<div class ='pin'><a href='".$row['link']."'><img src='".$row['image']."'/></a><p>".$row['caption']."</p></div>";
				}
				
			}
			
echo "</div>";
?>
</div>
</div>
</body>
</html>