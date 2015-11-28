<html><?php
session_start(); //Session should always be active

$app_id ='905672359472425';
$app_secret ='e371a95422c469c13d0f1bfce2f51022';
$required_scope 	= 'public_profile, email, publish_actions'; //Permissions required
$redirect_url 		= 'http://localhost//visualbookmark//fbloginsuccess.php'; //FB redirects to this page with a code

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
	//var_dump($session);
	######## Fetch user Info ###########
	
	echo "there is a session";
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
    $user_id =  $user_profile->getId(); 
    $user_name = $user_profile->getName(); 
	$user_email =  $user_profile->getEmail();
	$location =  $user_profile->getLocation();
    ######## Check User Permission called 'publish_actions' ##########
    $user_permissions = (new FacebookRequest($session, 'GET', '/me/permissions'))->execute()->getGraphObject(GraphUser::className())->asArray();
    
	
	$found_permission = false;
    foreach($user_permissions as $key => $val){         
        if($val->permission == 'publish_actions'){
            $found_permission = true;
        }
    }
    
	###### post image if 'publish_actions' permission available ########
    if($found_permission){
		$image = "http://localhost/visualbookmark/facebook_blank_face3.jpeg"; //server path to image
		$post_data = array('link' =>'www.google.com', 'message' => 'This is test Message', 'description'=>'Test share code' );
		$response = (new FacebookRequest( $session, 'POST', '/me/photos', $post_data ))->execute()->getGraphObject();
    }

header("location: fbcode.php");

}else{ 
	echo "no session";
	//display login url 
	//$login_url = $helper->getLoginUrl( array( 'scope' => $required_scope ) );
	//echo '<a href="'.$helper->getLoginUrl().'"><img src="fb_login.png" height="40px"></img></a>'; 
}
?>
</html>