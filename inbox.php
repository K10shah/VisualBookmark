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
}?>
<html>
<head>
<style>
body{
	
background-image: url('background-imager//Elegant_Background-9.jpg');
}	
</style>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
            var locations = ["messages.php"];
            var len = locations.length;

            var iframe = $('#Iframe1');
            var i = 0;
            setInterval(function () {
            $(iframe).attr('src', locations[++i % len]); }, 5000);
			
			$("#back-button").click(function(){
				window.location = "newuitest.php";
			});
			
        });
</script>
</head>
<body id="inboxbody">
<div class="topnavbar"><div class="col-sm-3"><font color="#FFF" size="10" face="Impact">Visual Bookmark</font></div>
<div class="back col-sm-2" style="top:18px;" id="back-button">
<button type="submit" class="btn btn-success" name="reg">Home</button>
</div>
<div class="top-menu-form">
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
	echo $row['profilephoto'];
}
else
{
	echo "facebook_blank_face3.jpeg";
}
?>" width="40px" height="40px" class="img-rounded"/> &nbsp <font size="5" color="#fff"> <?php echo $_SESSION['uname'];?></font>
</div>
</div>
<div class="left-pane">
<?php
$emailstore = $_SESSION['uname'];
$emailstore = stripslashes($emailstore);
$emailstore = mysqli_real_escape_string($con,$emailstore);
$sql = "select * from friends where person in(select uid from login where username='$emailstore')";
$result=mysqli_query($con,$sql);
if (!$result)
{
	die(mysqli_error($con));
}
$count=mysqli_num_rows($result);
echo "<div class='friendlist'><b><font color='#fff'>You follow : </b></br>
	<br>";
if($count==0)
{
	echo "&nbsp No friends \n added yet<br><br>";
}
else
{
	
	
	while($row = mysqli_fetch_array($result))
	{
		$id =$row['following'];
		$sql1 = "select * from login where uid='$id'";
		$result1=mysqli_query($con,$sql1);
		if (!$result1)
		{
			die(mysqli_error($con));
		}
		while($row1 = mysqli_fetch_array($result1) )
		{
			if(isset($_SESSION['friend']) && ($_SESSION['friend']==$row1['uid']))
			{
				echo "<form name='inboxfriends' action='inbox.php' method='get'><div class='friendrow col-sm-6'>
		 <button type='submit' class='btn btn-primary' value='add' name='add'> ".$row1['username']."</button>
		 <input type='hidden' id ='which_clicked' name='which_clicked' value=".$row1['uid'].">
			</div></br></form>";
			}
			else{
				echo "<form name='inboxfriends' action='inbox.php' method='get'><div class='friendrow col-sm-6'>
		 <button type='submit' class='btn btn-default'value='add' name='add'> ".$row1['username']."</button>
		 <input type='hidden' id ='which_clicked' name='which_clicked' value=".$row1['uid'].">
			</div></br></form>";
			}
			
		}
echo "<br><br>";		
}}
echo"<b>Your followers : </b><br><br>";
$sql = "select * from friends where following in(select uid from login where username='$emailstore')";
$result=mysqli_query($con,$sql);
if (!$result)
{
	die(mysqli_error($con));
}
$count=mysqli_num_rows($result);
if($count==0)
{
	echo "&nbspSorry No one following you yet <br>";
}
else
{
	
	while($row = mysqli_fetch_array($result))
	{
		$id =$row['person'];
		$sql1 = "select * from login where uid='$id'";
		$result1=mysqli_query($con,$sql1);
		if (!$result1)
		{
			die(mysqli_error($con));
		}
		while($row1 = mysqli_fetch_array($result1) )
		{
			if(isset($_SESSION['friend']) && ($_SESSION['friend']==$row1['uid']))
			{
				echo "<form name='inboxfriends' action='inbox.php' method='get'><div class='friendrow col-sm-6'>
		 <button type='submit' class='btn btn-primary' value='add' name='add'> ".$row1['username']."</button>
		 <input type='hidden' id ='which_clicked' name='which_clicked' value=".$row1['uid'].">
			</div></br></form>";
			}
			else{
				echo "<form name='inboxfriends' action='inbox.php' method='get'><div class='friendrow col-sm-6'>
		 <button type='submit' class='btn btn-default'value='add' name='add'> ".$row1['username']."</button>
		 <input type='hidden' id ='which_clicked' name='which_clicked' value=".$row1['uid'].">
			</div></br></form>";
			}
			
		}
		
	}
	
	
	
}
if(isset($_GET['add']))
	{
		$clicked = $_GET['which_clicked'];
		$_SESSION['friend'] = $_GET['which_clicked'];	
		if($_SESSION['friend']<>"")
			//header("location: index.php");
		session_write_close();
	}
	echo"</div>";
	
	echo "</div>";
?>
</div>
<div class="messagecontent">
<iframe width=100% src="messages.php" height="100%" style="border:none;" id="Iframe1" name="i-frame"></iframe>
</div>
<div class="messageentry">
<form name="addingmessage" action="inbox.php" method="post"><br>
<br>

<div class="form-group col-lg-5" width="50%" height="80%">
  <label for="comment">Message:</label>
  <textarea class="form-control" rows="5" id="comment" name="tarea" ></textarea>
</div>
<br>
<div class="msgbtn">
<button type="submit" class="btn btn-warning" name="postit">POST</button>
</div>
</form>
</div>
<?php
if(isset($_POST['postit']))
{
	if($_POST['tarea']=="" )
	{
	}
	else if($_SESSION['friend'])
	{
		$message = $_POST['tarea'];
		$sql = "select * from login where username='$emailstore'";
		$result=mysqli_query($con,$sql);
		if (!$result)
		{
			die(mysqli_error($con));
		}
		while($row = mysqli_fetch_array($result) )
		{
			$sender = $row['uid'];
		}
		$receiver = $_SESSION['friend'];
		$sql1 = "insert into inbox(message,sender,receiver) value('$message','$sender','$receiver')";
		$result1 = mysqli_query($con,$sql1);
		if (!$result1)
		{
			die(mysqli_error($con));
		}
		
	}
}
?>

</body>
</head>