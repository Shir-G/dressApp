<?php
   include 'user_config.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Closet</title>
</head>
<body>
    <h1> My Closet</h1>
    <?php if( !empty($user) ): ?>

        <br />Welcome <?= $user['username']; ?> 
        <br /><br />You are successfully logged in!
        <br /><br />
        <a href="logout.php">Logout?</a>

    <?php else: ?>

        <h1>Please Login or Register</h1>
        <a href="login.php">Login</a> or
        <a href="register.php">Register</a>

    <?php endif; ?>
</body>
</html>