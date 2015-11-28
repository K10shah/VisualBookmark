
<?php
		session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
?> 
<?php 
if(isset($_POST['submit'])){
$uname = $_POST['uname'];
$pass123 = $_POST['upass'];
if($uname=="" || $pass123=="")
{
print '<script type="text/javascript">';
				print "alert('No field should be empty')"; 
				print '</script>';  
}
else{
			$user=$_POST['uname']; 
			$pass=$_POST['upass'];

			$user = stripslashes($user);
			$pass = stripslashes($pass);
			$user = mysqli_real_escape_string($con,$user);
			$pass = mysqli_real_escape_string($con,$pass);
			$sql="SELECT * FROM login WHERE username='$user' and password='$pass'";
			$result=mysqli_query($con,$sql);
			if (!$result)
			{
    die(mysqli_error($con));
			}
			$count1=mysqli_num_rows($result);
			if ($count1==1) {
				echo "Success!";
				$_SESSION['uname'] = $user;
				$row = mysqli_fetch_array($result);
				$_SESSION['name'] = $row['Name'];
				$_SESSION['username'] = $row['username'];;
				header("Location: success.php");
				session_write_close();
			} 
			else {
				print '<script type="text/javascript">';
				print "alert('Invalid username or password');"; 
				print '</script>';  
			}
			mysqli_close($con);
}
}
?>
<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</head>
<body>
<div class="loginform">
<form class="form-horizontal" name="loginform" method="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="uname">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="upass">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning" name="submit">Sign in</button>
    </div>
  </div>
</form>
</div>
</body>
</html>