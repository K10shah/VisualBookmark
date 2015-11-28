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
	//session ver is set, redirect user 
	header("location: fbcode.php");
	
}

//Test normal login / logout with session
if(isset($_SESSION['ses']))
{
	$session = $_SESSION['ses'];
}
if ($session)
{ //if we have the FB session
	//get user data
	
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
	
	//save session var as array
	$_SESSION["fb_user_details"] = $user_profile->asArray(); 
	
	$user_id = ( isset( $_SESSION["fb_user_details"]["id"] ) )? $_SESSION["fb_user_details"]["id"] : "";
	$user_name = ( isset( $_SESSION["fb_user_details"]["name"] ) )? $_SESSION["fb_user_details"]["name"] : "";
	$user_email = ( isset( $_SESSION["fb_user_details"]["email"] ) )? $_SESSION["fb_user_details"]["email"] : "";
	session_write_close();
	$_SESSION['ses'] = $session;
	$user_permissions = (new FacebookRequest($session, 'GET', '/me/permissions'))->execute()->getGraphObject(GraphUser::className())->asArray();
    
	
	$found_permission = false;
    foreach($user_permissions as $key => $val){         
        if($val->permission == 'publish_actions'){
            $found_permission = true;
        }
    }
    
	###### post image if 'publish_actions' permission available ########
    // if($found_permission){
		// $image = "http://localhost/visualbookmark/facebook_blank_face3.jpeg"; //server path to image
		// $post_data = array('link' =>'www.google.com', 'message' => 'This is test Message', 'description'=>'Test share code' );
		// $response = (new FacebookRequest( $session, 'POST', '/me/feed', $post_data ))->execute()->getGraphObject();
    // }

	
	header("location: newuitest.php");
	
}else
{ 
	
	//session var is still there
	var_dump($session);
	if(isset($_SESSION["fb_user_details"]))
	{
		print 'Hi '.$_SESSION["fb_user_details"]["name"].' you are logged in! [ <a href="?log-out=1">log-out</a> ] ';
		print $_SESSION["fb_user_details"]["name"];
		print '<pre>';
		print_r($_SESSION["fb_user_details"]);
		print $_SESSION['uname'];	
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
if ($session)
{ //if we have the FB session
	var_dump($session);
	######## Fetch user Info ###########
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
    $user_id =  $user_profile->getId(); 
    $user_name = $user_profile->getName(); 
	$user_email =  $user_profile->getEmail();
	$location =  $user_profile->getLocation();
	
	session_write_close();
    ######## Check User Permission called 'publish_actions' ##########
   
}
else
{ 

	//display login url 
	//$login_url = $helper->getLoginUrl( array( 'scope' => $required_scope ) );
	//echo '<a href="'.$login_url.'">Login with Facebook</a>'; 
}
//header("Location: index.php");
?>
<form action="fbpostcode.php" method="post">
<input type="submit" name="postit" value="post"/>
</form>
<?php
if(isset($_POST['submit']))
{
$user_permissions = (new FacebookRequest($session, 'GET', '/me/permissions'))->execute()->getGraphObject(GraphUser::className())->asArray();
    $found_permission = false;
    foreach($user_permissions as $key => $val){         
        if($val->permission == 'publish_actions'){
            $found_permission = true;
			echo $found_permission;
        }
    }
    
	###### post image if 'publish_actions' permission available ########
    // if($found_permission){
		// $image = "http://localhost/visualbookmark/facebook_blank_face3.jpeg"; //server path to image
		// $post_data = array('link' =>'www.google.com', 'message' => 'This is test Message', 'description'=>'Test share code' );
		// $response = (new FacebookRequest( $session, 'POST', '/me/photos', $post_data ))->execute()->getGraphObject();
    // }
}
?>
