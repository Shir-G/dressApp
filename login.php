<?php
    require_once 'includes/phpPasswordHashingLib/passwordLib.php';
    include 'connect.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: homepage.php");
    }

    $msg='';//message presented to the user after login attempt

    //get values from login.php form
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = strtolower($_POST['email']);
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
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_array($result);

            if ($row['active'] == 0) {
                $msg = "Please check your email to activate your account";
            }
            else{
                if ($row['email'] == $email) { //if user is found
                    if (!password_verify($password, $row['password'])) { //verify if password was entered correctly
                        $msg = "password incorrect";
                        $login=false;
                    }
                }
                else {
                    $msg = "email incorrect";
                    $login=false;
                }
            }
        }
        else {
            $login = false;
            $msg = "Sorry, these credentials don't match";
        }

        if ($login) { //if credentials are right
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: homepage.php"); //redirect to hompage
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body id="login_page">
    <header>
        <a href="homepage.php"><h1>DressApp</h1></a>
    </header>
    <main>
        <form action="login.php" method="post">
            <input type="email" name="email"  placeholder="Email" required></input>
            <input type="password" name="password" placeholder="Password"></input>
            
            <input type="submit" name="submit" value="submit"></input>
        </form>      
        <a href="register.php">Don't have an account yet? Register here</a>
        <?php if (!empty($msg)) { ?>
            <p> <?= $msg ?></p>
        <?php } ?>      
    </main>


    
</body>
</html>