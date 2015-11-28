<?php
		session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
?>
<html>
<head>
<style>
body{
	
background-image: url('background-imager//Elegant_Background-9.jpg');
}</style>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="topnavbar">&nbsp&nbsp
<font color="#FFF" size="10" face="Impact">Visual Bookmark</font>
</div>
		<div class="regform">
<form class="form-horizontal" method="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
 <div class="form-group">
    <label for="name" class="col-sm-2 control-label"><b><font color="#fff">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name" name="name" placeholder="Name">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" name ="uname" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</font></b></label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" name="upass" placeholder="Password">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success" name="reg">Register</button> &nbsp
	  <button type="submit" class="btn btn-danger" name="goback">Go back to login page</button>
    </div>
  </div>
 
  <br>
  <?php
if(isset($_POST['reg'])){
if($_POST['uname']=="" || $_POST['upass']=="" || $_POST['name']=="")
{ echo "<div class='alert alert-danger' id = 'emptywarn' role='alert'><font color='red'> No field can be empty </font> ...</div>";
echo "<script type='javascript'>
	document.getElementById('validdata').style.display= 'none';
	document.getElementById('invaliddata').style.display= 'none';
	</script>
	";
}}
?>
<?php
global $checkval; $checkval = 'Invalid';
global $empty; $empty = 'yes';
if(isset($_POST['reg'])){
$email_a=$_POST['uname'];
$email_a = stripslashes($email_a);
$email_a = mysqli_real_escape_string($con,$email_a);
$sql1="SELECT * FROM login WHERE username='$email_a'";
$result1=mysqli_query($con,$sql1);
$count1=mysqli_num_rows($result1);
if (!$result1)
			{
    die(mysqli_error($con));
			}
if($_POST['uname']=="" || $_POST['upass']=="" || $_POST['name']=="")
{
}
else
{
	if((filter_var($email_a, FILTER_VALIDATE_EMAIL))&&($count1==0))
{
	$checkval="valid";
}
else{
echo "<div class='alert alert-danger' id='invaliddata' role='alert'><font color='red'> Invalid or already existing username</font></div>";
$checkval="invalid";
}
}
}
if(isset($_POST['reg'])){
if($_POST['uname']=="" || $_POST['upass']=="" || $_POST['name']=="")
{
$empty="yes";
}
else $empty="no";
echo "<script type='javascript'>
	document.getElementById('emptywarn').style.display= 'none';
	<script>
	";
}
if($checkval=="valid" && $empty=="no")
{
	echo "<script type='javascript'>
	document.getElementById('emptywarn').style.display= 'none';
	document.getElementById('invaliddata').style.display= 'none';
	</script>";
	$sql2="insert into login(username,password,Name,isFb) values('$email_a','$_POST[upass]','$_POST[name]','n')";
	$result2=mysqli_query($con,$sql2);
	if (!$result2)
				{
		die(mysqli_error($con));
				}
		echo "<div class='alert alert-success' id='validdata' role='alert'><font color='green'> You have successfully registered </font></div> ";
	
	$sql3="SELECT * FROM login WHERE username='$email_a'";
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

if(isset($_POST['goback']))
{
	header("Location: login.php");
}
?>
</form>
</div>
</body>
</html>
