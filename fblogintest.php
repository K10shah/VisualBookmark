<html>
<?php
		session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
	
?>
<head>
</head>
<?php	
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
	
	use Facebook\FacebookResponse;
	use Facebook\FacebookRequest;
	use Facebook\FacebookSession;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;
	use Facebook\AccessToken;
	use Facebook\FacebookCurl;
	use Facebook\FacebookHttpable;
	use Facebook\FacebookCurlHttpClient;
	
	$app_id ='905672359472425';
	$app_secret ='e371a95422c469c13d0f1bfce2f51022';
	$required_scope     = 'public_profile, publish_actions, email'; //Permissions required
	$redirect_url='http://localhost/visualbookmark/;
	
	FacebookSession::setDefaultApplication($app_id,$app_secret);
	$helper = new FacebookRedirectLoginHelper($redirect_url);
	try {
	$sess = $helper->getSessionFromRedirect();
	$_SESSION['uname'] = "FBUser";
	$_SESSION['name']="FBuser"; 
	
} catch(FacebookRequestException $ex) {

} catch(\Exception $ex) {

}
	if($sess)
	{
		
		// $request = new FacebookRequest($sess,'GET','/me');
		// $response = $request->execute();
		// $graph = $response->getGraphObject(GraphUser::classname());
		// $name = $graph->getName();
		// $_SESSION['uname'] = $name;
		// $_SESSION['name'] = $name;
		// session_write_close();
	}
	else{
		echo '<a href="'.$helper->getLoginUrl().'"><img src="fb_login.png" height="40px"></img></a>';
	}
	?>
</html