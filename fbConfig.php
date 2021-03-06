<?php
    include 'connect.php';
    require_once 'fbConnect.php';

    $fbButton = '<a href="logout.php">LOGOUT</a>';

    if(isset($accessToken)){
        if(isset($_SESSION['facebook_access_token'])){
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }else{
            // Put short-lived access token in session
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            
              // OAuth 2.0 client handler helps to manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();
            
            // Exchanges a short-lived access token for a long-lived one
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
            
            // Set default access token to be used in script
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        
        // Redirect the user back to the same page if url has "code" parameter in query string
        if(isset($_GET['code'])){
            header('Location: ./');
        }
        
        // Getting user facebook profile info
        try {
            $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
            $fbUserProfile = $profileRequest->getGraphNode()->asArray();
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            session_destroy();
            // Redirect user back to app login page
            header("Location: ./");
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        // Insert or update user data to the database
        $fbUserData = array(
            'oauth_provider'=> 'facebook',
            'oauth_uid'     => $fbUserProfile['id'],
            'first_name'    => $fbUserProfile['first_name'],
            'last_name'     => $fbUserProfile['last_name'],
            'email'         => $fbUserProfile['email'],
            'gender'        => $fbUserProfile['gender'],
            'locale'        => $fbUserProfile['locale'],
            'picture'       => $fbUserProfile['picture']['url'],
            'link'          => $fbUserProfile['link']
        );

        $permissions = "user";
        $username = $fbUserData['first_name'];
        $femail = $fbUserData['email'];
        $hash = "123";//md5( rand(0,1000) );

        $findUserQuery = "SELECT * FROM users WHERE email = '$femail'";
        $findUserResult = mysql_query( $findUserQuery, $conn );
        if (mysql_num_rows($findUserResult) == 0) {
            $fbButton = '<p>Sorry, you need to sign up first<p/>';

/*            $query = "INSERT INTO `users` (`username`, `email`, `account_permissions`, `hash`, `active`) VALUES ('$username', '$femail', '$permissions', '$hash', 1)";
            $retval = mysql_query( $query) or die(mysql_error());
            $insertId = mysql_insert_id();              
            if(! $retval ) {
                die('Could not enter data: ' . mysql_error());
                echo 'Sorry there must have been an issue creating your account';
            }
            else {
                $query = "SELECT * FROM users WHERE email = '$femail' ";
                $result = mysql_query($query) or die("failed to login" .mysql_error());
                $row = mysql_fetch_array($result);
    
                $_SESSION['user_id'] = $row['user_id'];
                //header("Location: fb.php");
            }*/
        }
        else {
            $foundUser = mysql_fetch_array($findUserResult);
            $_SESSION['user_id'] = $foundUser['user_id'];
            //header("Location: fb.php");
        }
        
        
        // Get logout url
        $logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');
        
        // Render facebook profile data
        if(empty($fbUserData)){
            $fbButton = '<h3 style="color:red">Some problem occurred, please try again.</h3><a href="logout.php">logout</a>';
        }
        
    }else{

        // Get login url
        $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
        
        // Render facebook login button
        $fbButton = '<a href="'.htmlspecialchars($loginURL).'">LOGIN WITH FACEBOOK</a>';
    }
?>