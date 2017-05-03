<?php
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
        $email = $_POST['email'];
        $permissions = $_POST['account_permissions'];

        if($password==$confirm_password){ //if the password 'field' and the 'confirm password' field match
            $password = password_hash($password,PASSWORD_BCRYPT); //encrypt password before saving it to the DB

            $query = "INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `my_closet`, `liked_outfits`, `account_permissions`) VALUES ('', '$username', '$email', '$password', NULL, NULL, '$permissions')";
            
            $retval = mysql_query( $query, $conn );
            $insertId = mysql_insert_id();              
            if(! $retval ) { //if qurey execution didnt succeed
                die('Could not enter data: ' . mysql_error());
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
                        die('Could not enter data: ' . mysql_error());
                        $msg = 'Sorry there must have been an issue creating your account';
                    }
                }

                $_SESSION['user_id'] = $row['user_id']; //save user info for the session
                header("Location: homepage.php");
            }
        }
        else $msg = 'password and confirmed password do not match'; 
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>register</title>
</head>
<body>
    <?php if (!empty($msg)) { ?>
        <p> <?= $msg ?></p>
    <?php } ?>
    <form action="register.php" method="post">
        get account as a:<br>
        <table>
            <tr>
                <td><input type="radio" name="account_permissions" value="user" checked>user</input></td>
                <td><input type="radio" name="account_permissions" value="stylist">stylist</input></td>
            </tr>
            <tr>
              <td>Email</td><td><input type="email" name="email" required></input>  </td>
            </tr>
            <tr>
                <td>User Name</td><td><input type="text" name="username" required></input></td>
            </tr>
            <tr>
                <td>Password</td><td><input type="password" name="password"></input></td>
            </tr>
            <tr>
                <td>Confirm Password</td><td><input type="password" name="confirm_password" required></input></td>
            </tr>
        </table>
        <input type="submit" name="submit" value="submit"></input>
    </form>
</body>
</html>