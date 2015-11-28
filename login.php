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
			$sql="SELECT * FROM login WHERE username='$user' and password='$pass' and isFb='n'";
			$result=mysqli_query($con,$sql);
			if (!$result)
			{
    die(mysqli_error($con));
			}
			$count1=mysqli_num_rows($result);
			if ($count1==1) {
				echo "Success!";
				if(isset($_SESSION['fb_user_details']))
				{
					unset($_SESSION['fb_user_details']);
				}
				$_SESSION['uname'] = $user;
				$row = mysqli_fetch_array($result);
				$_SESSION['name'] = $row['Name'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['uid']=$row['uid'];
				$_SESSION['friend'] ="";
				$_SESSION['friendname']="";
				header("Location: newuitest.php");
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
if(isset($_POST['signup']))
{
	header("Location: signup.php");
}
?>
<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style>
body{
	
background-image: url('background-imager//bg image.jpg');
}
</style>
</head>
<body>
<div class="topnavbar">&nbsp&nbsp&nbsp
<font color="#B517A5" size="25" face="Wolf in the City">Visual</font>
<font color="#F1B80A" size="25" face="Wolf in the City">Bookmarker: </font>
<font color="#FFF" size="25" face="Wolf in the City">Create,    Share   and   Organize   your   Ideas..</font>
</div>
<div class="loginform">
<form class="form-horizontal" name="loginform" method="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label"><font color="#fff" face="Century Gothic" size= 5>Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="uname">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label" face="Century Gothic">Password</font></label>
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
      <button type="submit" class="btn btn-warning" name="submit">Sign in</button>&nbsp &nbsp
	  <button type="submit" class="btn btn-success" name="signup">Sign up</button>&nbsp &nbsp
<?php	


$app_id ='905672359472425';
$app_secret ='e371a95422c469c13d0f1bfce2f51022';
$required_scope 	= 'public_profile, email'; //Permissions required
$redirect_url 		= 'http://localhost/visualbookmark/fbloginsuccess.php'; //FB redirects to this page with a code
	
require_once('Facebook/FacebookSession.php');
require_once('Facebook/FacebookRequest.php');
require_once('Facebook/FacebookResponse.php');
require_once('Facebook/FacebookSDKException.php');
require_once('Facebook/FacebookRequestException.php');
require_once('Facebook/FacebookRedirectLoginHelper.php');
require_once('Facebook/FacebookAuthorizationException.php');
require_once('Facebook/GraphObject.php');
require_once('Facebook/GraphUser.php');
require_once('Facebook/GraphSessionInfo.php');
require_once('Facebook/Entities/AccessToken.php');
require_once('Facebook/HttpClients/FacebookCurl.php');
require_once('Facebook/HttpClients/FacebookHttpable.php');
require_once('Facebook/HttpClients/FacebookCurlHttpClient.php');
	
//import required class to the current scope
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRedirectLoginHelper;


FacebookSession::setDefaultApplication($app_id , $app_secret);
$helper = new FacebookRedirectLoginHelper($redirect_url);
try {
  $session = $helper->getSessionFromRedirect();
  
} catch(FacebookRequestException $ex) {
	die(" Error : " . $ex->getMessage());
} catch(\Exception $ex) {
	die(" Error : " . $ex->getMessage());
}

if ($session){ //if we have the FB session
	//get user data
	//var_dump($session);
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
	echo $user_profile;
	//save session var as array
	$_SESSION["fb_user_details"] = $user_profile->asArray(); 
	
	$user_id = ( isset( $_SESSION["fb_user_details"]["id"] ) )? $_SESSION["fb_user_details"]["id"] : "";
	$user_name = ( isset( $_SESSION["fb_user_details"]["name"] ) )? $_SESSION["fb_user_details"]["name"] : "";
	$user_email = ( isset( $_SESSION["fb_user_details"]["email"] ) )? $_SESSION["fb_user_details"]["email"] : "";
	
	session_write_close();
	header("Location: newuitest.php");
}	



//
if ($session){ //if we have the FB session
	//var_dump($session);
	######## Fetch user Info ###########
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
    $user_id =  $user_profile->getId(); 
    $user_name = $user_profile->getName(); 
	$user_email =  $user_profile->getEmail();
	$location =  $user_profile->getLocation();
	$_SESSION['uname'] = $user_email;
	session_write_close();
	header("Location: newuitest.php");
    ######## Check User Permission called 'publish_actions' ##########
    
}
else{ 

	//display login url

	$login_url = $helper->getLoginUrl(array( 'scope' => $required_scope ));
	echo '<a href="'.$login_url.'"><img src="fb_login.png" height="40px"></img></a>'; 
}
	?>
    </div>
  </div>
</form>
</div>
</body>
</html>