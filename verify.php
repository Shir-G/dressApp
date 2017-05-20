<?php 
    include 'connect.php';

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        // Verify data
        $email = mysql_escape_string($_GET['email']); // Set email variable
        $hash = mysql_escape_string($_GET['hash']); // Set hash variable
        
        $search = mysql_query("SELECT email, hash, active FROM users WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error()); 
        $match  = mysql_num_rows($search);

        if($match > 0){
            // We have a match, activate the account
            mysql_query("UPDATE users SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysql_error());
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: homepage.php");
        }else{
            // No match -> invalid url or account has already been activated.
            header("Location: homepage.php");
        }
    }

?>