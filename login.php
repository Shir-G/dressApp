<?php
    include 'connect.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: homepage.php");
    }

    $msg='';//message presented to the user after login attempt

    //get values from login.php form
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        //echo "$email";

        //to prevent sql injection
        $email = stripcslashes($email);
        $password = stripcslashes($password);
        $email = mysql_real_escape_string($email);
        $password = mysql_real_escape_string($password);

        $login = true; //flag if login attempt went wrong

        //get the user info from the DB
        $query = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysql_query($query) or die("failed to login" .mysql_error());
        $row = mysql_fetch_array($result);

        if ($row['email'] == $email) { //if user is found
            if (password_verify($password, $row['password'])) { //verify if password was entered correctly
                $msg = "welcome ".$row['username'];
            }
            else {
                echo "password incorrect";
                $login=false;
            }
        }
        else {
            echo "email incorrect";
            $login=false;
        }

        if ($login) { //if credentials are right
            
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: homepage.php"); //redirect to hompage
        }
        else $msg = "Sorry, those credentials don't match";
        }

?>

<!DOCTYPE html>
<html>
<head>
    <title>login</title>
</head>
<body>
    <?php if (!empty($msg)) { ?>
        <p> <?= $msg ?></p>
    <?php } ?>
    <form action="login.php" method="post">
    <table>
        <tr>
            <td>Email</td><td><input type="email" name="email" required></input></td>
        </tr>
        <tr>
            <td>Password</td><td><input type="password" name="password"></input></td>
        </tr>
    </table>
        <input type="submit" name="submit" value="submit"></input>
    </form>
</body>
</html>