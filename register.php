<?php
    require_once 'includes/phpPasswordHashingLib/passwordLib.php';
    include 'connect.php';
    session_start();
    if (isset($_SESSION['user_id'])) { //if user is already logged in
        header("Location: homepage.php");
    }

    $msg = ''; //message presented to the user after registration attempt

    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) { //if user filled thest fields
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $email = strtolower($_POST['email']);
        //$permissions = "stylist";
        $hash = md5( rand(0,1000) );

        if($password==$confirm_password){ //if the password 'field' and the 'confirm password' field match
            $password = password_hash($password,PASSWORD_BCRYPT); //encrypt password before saving it to the DB

            $query = "INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `my_closet`, `liked_outfits`, `account_permissions`, `hash`) VALUES ('', '$username', '$email', '$password', NULL, NULL, 'stylist', '$hash')";
            
            $retval = mysql_query( $query, $conn );
            $insertId = mysql_insert_id();              
            if(! $retval ) { //if qurey execution didnt succeed
                die('Could not insert row: ' . mysql_error());
                $msg = 'Sorry there must have been an issue creating your account';
            }
            else {
                $query = "SELECT * FROM users WHERE email = '$email' ";
                $result = mysql_query($query) or die("failed to login" .mysql_error());
                $row = mysql_fetch_array($result);

                if ($row['account_permissions'] == "stylist") {
                    $create_stylist_query = "INSERT INTO `stylists` (`stylist_id`) VALUES ('".$row['user_id']."')";
                    $retval = mysql_query( $create_stylist_query, $conn );
                    if(! $retval ) { //if qurey execution didnt succeed
                        die('Could not insert row stylist: ' . mysql_error());
                        $msg = 'Sorry there must have been an issue creating your account';
                    }
                }

                if ($row['active']==0) {
                    $to      = $email; // Send email to our user
                    $subject = 'Signup | Verification'; // Give the email a subject 
                    $message = '
                     
                    Thanks for signing up!
                    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
                     
                    ------------------------
                    Username: '.$username.'
                    ------------------------
                     
                    Please click this link to activate your account:
                    http://www.dressapp.org/alpha/verify.php?email='.$email.'&hash='.$hash.'
                     
                    '; // Our message above including the link
                                         
                    $headers = 'From:noreply@DressApp.com' . "\r\n"; // Set from headers
                    mail($to, $subject, $message, $headers); // Send our email

                    $_SESSION['user_id'] = $row['user_id']; //save user info for the session
                    $_SESSION['register'] = "true";
                    header("Location: homepage.php");
                }
                else {
                    $msg = 'Go to your inbox and verify your account <br>';

                }
            }
        }
        else $msg = 'password and confirmed password do not match'; 
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body id="register_page">
    <?php if (!empty($msg)) { ?>
        <p> <?= $msg ?></p>
    <?php } ?>
    <header>
        <a href="homepage.php"><h1>DressApp</h1></a>
    </header>
    <main>
        <form action="register.php" method="post">
            <input type="email" name="email" required placeholder="Email"></input>
            <input type="text" name="username" required placeholder="User Name"></input>
            <input type="password" name="password" placeholder="Password"></input>
            <input type="password" name="confirm_password" required placeholder="Confirm Password"></input>
            <input type="submit" name="submit" value="submit"></input>
        </form>
    </main>
    
</body>
</html>