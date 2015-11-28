
<html>
<head>
</head><body>
<?php

session_start(); //Session should always be active

$app_id ='905672359472425';
$app_secret ='e371a95422c469c13d0f1bfce2f51022';
$required_scope 	= 'public_profile, email, publish_actions'; //Permissions required
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


//if user wants to log out
if(isset($_GET["log-out"]) && $_GET["log-out"]==1){
	unset($_SESSION["fb_user_details"]);
	//session var is set, redirect user 
	header("location: fbcode.php");
}

//Test normal login / logout with session

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
	$_SESSION['uname'] = $user_email;
	$_SESSION['ses'] = null;
	session_write_close();
	header("location: fbloginsuccess.php");
	
}else{ 
	
	//session var is still there
	if(isset($_SESSION["fb_user_details"]))
	{
		print 'Hi '.$_SESSION["fb_user_details"]["name"].' you are logged in! [ <a href="?log-out=1">log-out</a> ] ';
		print '<pre>';
		print_r($_SESSION["fb_user_details"]);
		print '</pre>';
	}
	else
	{
		//display login url 
		//$login_url = $helper->getLoginUrl( array( 'scope' => $required_scope ) );
		//echo '<a href="'.$login_url.'">Login with Facebook</a>'; 
	}
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
    ######## Check User Permission called 'publish_actions' ##########
    
}else{ 

	//display login url 
	$login_url = $helper->getLoginUrl();
	header("location:".$login_url);	
	echo '<a href="'.$login_url.'"><img src="fb_login.png" height="40px"></img></a>'; 
}

?>
</body>
</html>