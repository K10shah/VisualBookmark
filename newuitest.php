<html>
<?php
	session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
	if(!(isset($_SESSION['name'])) && !(isset($_SESSION['fb_user_details'])))
	{
	header("Location: login.php");
	exit();
	die();
	}
	else{
	$_SESSION['friend'] ="";
	if(isset($_SESSION['fb_user_details']))
	{
			
	$_SESSION['uname'] = $_SESSION["fb_user_details"]["email"];
	$_SESSION['name']=$_SESSION["fb_user_details"]["name"];
	
	session_write_close();
	
	$user=$_SESSION["fb_user_details"]["email"];
	
	$user = stripslashes($user);
	$user = mysqli_real_escape_string($con,$user);
	$count1=0;
	$sql = "select * from login where username='$user'";
	
	$result = mysqli_query($con,$sql);
	if(!$result)
	{
		die(mysqli_error($con));
	}
	$count1=mysqli_num_rows($result);
	if($count1 > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
			unset($_SESSION['uid']);
			$_SESSION['uid'] = $row['uid'];
			session_write_close();
		}
	}
	$sql="SELECT * FROM login WHERE username='$user'";
	$result=mysqli_query($con,$sql);
	if (!$result)
	{
		die(mysqli_error($con));
	}
	$count1=mysqli_num_rows($result);
	if ($count1 == 0)
	{
		header("location: login.php");
		$sql2="insert into login(username,password,Name,isFb) values('$user','pass','$_SESSION[name]','y')";
		$result2=mysqli_query($con,$sql2);
		if (!$result2)
		{
			die(mysqli_error($con));
		}
		
		$sql3="SELECT * FROM login WHERE username='$user'";
		$result3 = mysqli_query($con,$sql3);
		if(!$result3)
			{
				die(mysqli_error($con));
			}
		while($row = mysqli_fetch_array($result3))
		{
		$temp = $row['uid'];
		$sql4="insert into profile(profileid) values('$temp')";
		$result4 = mysqli_query($con,$sql4);
		if(!$result4)
			{
				die(mysqli_error($con));
			}
		}
	}
	$sql = "select * from login where username='$user'";
	$result = mysqli_query($con,$sql);
	if(!$result)
	{
		die(mysqli_error($con));
	}
	$count1=mysqli_num_rows($result);
	if($count1 > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
			session_start();
			$_SESSION['uid'] = $row['uid'];
			session_write_close();
		}
	}
	}
	session_write_close();
	}
				
			if(isset($_GET['edit']))
			{
				$pinid = $_GET['which_clicked'];
				header("Location: editpin.php?pinid=".$pinid);
			}
			if(isset($_GET['editboard']))
			{
				$id = $_GET['which_board_clicked'];
				header("Location: editboard.php?boardid=".$id);
			}
?>
<head>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<script>
$(document).ready( function() {

    $(".appearing-name-photo").hide(); //hide your div initially
    $(".arrowupbutton").hide();
	$("#wrapper").load('pindata.php');
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
	$("#mypin").click(function(){
		window.location.href='newuitest.php';
	});
	
	//my boards handler
	$("#myboard").click(function(){
		$("#wrapper").load('boarddata.php');
	});
	
	
	//my inbox handler
	$("#myinbox").click(function(){
		window.location.href='inbox.php';
	});
	
	//editprofilebutton
	$("#editprofile").click(function(){
		window.location.href='editprofile.php';
	});
	
	
	//document ready function ending here
	});

</script>
</head>
<body>
<div class="topnavbar">&nbsp&nbsp
<font color="#B517A5" size="25" face="Wolf in the City">Visual</font>
<font color="#F1B80A" size="25" face="Wolf in the City">Bookmarker: </font>
<font color="#FFF" size="25" face="Wolf in the City">Create,    Share   and   Organize   your   Ideas..</font>
<div class="top-menu-form" style="top:15px;">
			 <div class = "col-sm-1" ><font size="6" font face="Century Gothic">
     <a class="logout" href="logout.php">Logout</a> </font>
	</div><form name="" action="friendprof.php" method="get">
	<div class="col-sm-6">
      <input type="email" class="form-control" id="inputEmail3" font face="Century Gothic" placeholder="Insert User E-mail" name="friendname">
    </div>
	<div class = "col-sm-4">
	<button type="submit" class="btn btn-success" name="reg" font face="Century Gothic">Search a User</button>
	</div>
	</form></div>
</div>
<div class="secondnavbar">
<div class="appearing-name-photo">

<img src="<?php 
$profileid = $_SESSION['uid'];
$sql = "select * from profile where profileid = '$profileid'";

$result=mysqli_query($con,$sql);
if(!$result)
	{
		die(mysqli_error($con));
	}
$count=mysqli_num_rows($result);
if($count == 1)	
{
	$row = mysqli_fetch_array($result);
	if($row['profilephoto'] <> NULL)
	echo $row['profilephoto'];
	else
		echo "facebook_blank_face3.jpeg";
}
else
{
	echo "facebook_blank_face3.jpeg";
}
?>" width="40px" height="40px" class="img-rounded"/> &nbsp <font size="5" color="#fff"> <?php echo $_SESSION['name'];?></font>
</div>
<div class="editprofile" id="editprofile">
<button class="btn btn-warning"><?php echo $_SESSION['name']; ?> &nbsp <span class="glyphicon glyphicon-pencil"></span></button>
</div>
</div>
<div class="thirdnavbar">
<?php
if($_SESSION['fb_user_details'] <> null)
	{
	
	$user=$_SESSION["fb_user_details"]["email"];
	
	$user = stripslashes($user);
	$user = mysqli_real_escape_string($con,$user);
	$count1=0;
	$sql="SELECT * FROM login WHERE username='$user'";
	$result=mysqli_query($con,$sql);
	if (!$result)
	{
		die(mysqli_error($con));
	}
	$count1=mysqli_num_rows($result);

	if ($count1 == 0)
	{
		header("location: login.php");
		$sql2="insert into login(username,password,Name,isFb) values('$user','pass','$_SESSION[name]','y')";
		$result2=mysqli_query($con,$sql2);
		if (!$result2)
		{
			die(mysqli_error($con));
		}
		
		$sql3="SELECT * FROM login WHERE username='$user'";
		$result3 = mysqli_query($con,$sql3);
		if(!$result3)
			{
				die(mysqli_error($con));
			}
		while($row = mysqli_fetch_array($result3))
		{
		$temp = $row['uid'];
		$sql4="insert into profile(profileid) values('$temp')";
		$result4 = mysqli_query($con,$sql4);
		if(!$result4)
			{
				die(mysqli_error($con));
			}
		}
	}

	}

?>

<div class="upper-tabs">
<font face="Century Gothic" size=6>
<center>
<button id="mypin" class="btn btn-primary"><font face="Century Gothic">My Pin
</button>
&nbsp
<button id="myboard" class="btn btn-primary">My Boards
</button>
&nbsp
<button id="myinbox" class="btn btn-primary">Inbox
</button>
<center>
</div>
</div>
<div class="profile-pic"><center>
<img src="<?php 
$profileid = $_SESSION['uid'];
$sql = "select * from profile where profileid = '$profileid'";

$result=mysqli_query($con,$sql);
if(!$result)
	{
		die(mysqli_error($con));
	}
$count=mysqli_num_rows($result);
if($count >0 )	
{
	$row = mysqli_fetch_array($result);
	if($row['profilephoto']<>NULL)
	{	
echo $row['profilephoto'];
	}
	else
	{
		echo 'facebook_blank_face3.jpeg';
	}
}
else
{
	echo 'facebook_blank_face3.jpeg';
}
?>" class="prof-img img-rounded"/>
<br><div class="profile-pic-text"><b><font color="#fff" SIZE ="4">
<?php echo $_SESSION['name'];?></b></font></div>
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
			if(isset($_GET['del'])&&isset($_GET['which_clicked']))
			{

			$bid = $_GET['which_clicked'];
			$sql2 = "delete from bookmarks where bookmarkid = '$bid'";
			$result=mysqli_query($con,$sql2);
				if(!$result)
					{
						die(mysqli_error($con));
					}
			$sql3 = "delete from pinreference where bookmarkid = '$bid'";
			$result=mysqli_query($con,$sql3);
				if(!$result)
					{
						die(mysqli_error($con));
					}
			echo"<script>
			$('#wrapper').load(pindata.php');
			</script>";
			}
			
			//board deletion login
			if(isset($_GET['delboard'])&&isset($_GET['which_board_clicked']))
			{

			$boardid = $_GET['which_board_clicked'];
			$sql2 = "delete from boards where boardid = '$boardid'";
			$result=mysqli_query($con,$sql2);
				if(!$result)
					{
						die(mysqli_error($con));
					}
			$sql3 = "delete from pinreference where boardid = '$boardid'";
			$result=mysqli_query($con,$sql3);
				if(!$result)
					{
						die(mysqli_error($con));
					}
			echo"<script>
			$('#wrapper').load('boarddata.php');
			</script>";
			}

?>
</html>