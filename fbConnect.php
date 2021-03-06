<?php
echo "<script>console.log('connect!');</script>";
if(!session_id()){ 
    session_start();
}
// Include the autoloader provided in the SDK
require_once __DIR__ . '\includes\Facebook\autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;


$appId = '1045482048929474'; //Facebook App ID
$appSecret = '6ce4033c510be98b28a55785b06c36f5'; // Facebook App Secret
$redirectURL = 'http://www.dressapp.org/desktop/'; // Callback URL
//$redirectURL = 'http://localhost:8080/dressApp/'; // Callback URL
$fbPermissions = array('email');  //Optional permissions

$fb = new Facebook(array(
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.2',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
        $accessToken = $helper->getAccessToken();
        //$accessToken = $session->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}
?>