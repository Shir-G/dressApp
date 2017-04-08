<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: homepage.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>index</title>
</head>
<body>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="fbConfig.php">Facebook</a>
</body>
</html>