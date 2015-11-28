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
	$username = $_GET['friendname'];
	$origuserid = $_SESSION['uid'];
	
	session_write_close();
	}
?>
<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script>
$(document).ready(function() {
  // var $container = $("#columns");
  // // // initialize Masonry after all images have loaded  
  // $("#columns").masonry({
    // columnWidth: 10,
    // itemSelector: ".pin",
	// isOriginLeft: true
  // });
$("#wrapper").load('friendpindata.php');
    $(".appearing-name-photo").hide(); //hide your div initially
    $(".arrowupbutton").hide();
	
    $(window).scroll(function() {
		var bottomOfOthDiv = $(window).height() - $(".profile-pic").offset().top - $(".profile-pic").height();
		var bottomoftopnav = $(window).height() - $(".topnavbar").offset().top - $(".topnavbar").height();
		
		
		
        if((bottomoftopnav - bottomOfOthDiv) <= 0) { //scrolled past the other div?
            $(".appearing-name-photo").show(); //reached the desired point -- show div
			$(".arrowupbutton").show();
        }
		else
		{
			$(".appearing-name-photo").hide();
			$(".arrowupbutton").hide();
		}

    });

	$(".arrowupbutton").click(function(){
		$('html, body').animate({scrollTop : 0},10);
		return false;
	});
	
	
	//My pin handler
	$("#pin").click(function(){
		$("#wrapper").load('friendpindata.php');
	});
	
	//my boards handler
	$("#board").click(function(){
		$("#wrapper").load('friendboarddata.php');
	});
	
	$("#back-button").click(function(){
				window.location = "newuitest.php";
			});
});
</script>
</head>
<body>

<div class="topnavbar">
<div class="col-sm-3"><font color="#FFF" size="10" face="Impact">Visual Bookmark</font></div>
<div class="back col-sm-2" style="top:18px;" id="back-button">
<button type="submit" class="btn btn-success" name="reg">Home</button>
</div>
<div class="top-menu-form" style="top:15px;" >
			 <div class = "col-sm-1"><font size="6">
     <a class="logout" href="logout.php">Logout</a> </font>
	</div><form name="" action="friendprof.php" method="get">
	<div class="col-sm-4">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Username" name="friendname">
    </div>
	<div class = "col-sm-4">
	<button type="submit" class="btn btn-success" name="reg">Search a user</button>
	</div>
	</form></div>
</div>
<div class="secondnavbar">

<?php 
$_SESSION['friendname'] = $_GET['friendname'];
$sql ="select * from login where username = '$_GET[friendname]'";
$result=mysqli_query($con,$sql);
			if (!$result)
			{
				die(mysqli_error($con));
			}
	$count=mysqli_num_rows($result);
	if($count>0)
	{
	echo "<div class='appearing-name-photo'>
<img src='facebook_blank_face3.jpeg' width='40px' height='40px' class='img-rounded'/> &nbsp <font size='5' color='#fff'>".$_GET['friendname']."</font>
</div>
</div>
<div class='thirdnavbar'>
<div class='upper-tabs'>
<center>
<button id='pin' class='btn btn-danger'>Pins
</button>
&nbsp
<button id='board' class='btn btn-danger'>Boards
</button>";
$row = mysqli_fetch_array($result);
$friendid = $row['uid'];
$origuserid = $_SESSION['uid'];
//echo $_SESSION['friendname'];
$sql2 = "select * from friends where person='$origuserid' and following='$friendid'";
$result = mysqli_query($con,$sql2);
if (!$result)
{
	die(mysqli_error($con));
}
$count3=mysqli_num_rows($result);
if($count3==1)
{
	echo "<br><b>Following</b>";
}
else
{
	echo"<br><div style='top:280px;'><form name='follow' action='friendprof.php?friendname=".$_GET['friendname']."' method='post'><button id='follow'name='follow' class='btn btn-danger'>Follow
</button></form></div>";
}
echo "<center>
</div>

</div>
<div class='profile-pic'><center>
<img src='facebook_blank_face3.jpeg' class='prof-img img-rounded'/>
<br><br><font color='#fff'><b>".$_GET['friendname'];
	}
	else echo "<div class='thirdnavbar'><b></font><br><br><Br><br><br><font size='10'>No such user found</font>";
	?>
	</b>
</center>
</div>
<div class="pincontent">
<div id="wrapper">
</div>
</div>

<div class="arrowupbutton">
<img src="arrowup.png" height="40px"/>
</div></a>
</body>
<?php
if(isset($_POST['follow']))
{
	$sql4 = "insert into friends(person,following) values('$_SESSION[uid]','$friendid')";
				$result4 = mysqli_query($con,$sql4);
				if (!$result4)
						{
							die(mysqli_error($con));
						}
	header("location:friendprof.php?friendname=".$_GET['friendname'] );
}
if(isset($_GET['like']))
{
	$likedby = $_GET['friendname'];
	$pinid = $_GET['which_clicked'];
	$sql5 = "insert into pinlike(likedby,pinid) values('$likedby','$pinid')";
	$result5 = mysqli_query($con,$sql5);
	if (!$result5)
	{
		die(mysqli_error($con));
	}
}
?>
</html>
