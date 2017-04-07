<?php
    include 'user_config.php';
    //$shir = '12345';
    if (isset($_GET['itemID'])) {
        $shir = $_GET['itemID'];
    }

    $query = "UPDATE `users` SET `my_closet` = CONCAT_WS(',', my_closet, '$shir') WHERE `user_id` ='". $user['user_id']."'";
    $retval = mysql_query( $query, $conn );
    $insertId = mysql_insert_id();
    if(! $retval ) { //if qurey execution didnt succeed
        die('Could not enter data: ' . mysql_error());
    }
    else echo "successfully!!!"
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    <h1> Test</h1>
    <?php if( !empty($user) ): ?>

        <br />Welcome <?= $user['username']; ?> 
        <br /><br />You are successfully logged in!
        <br /><br />
        <h3><?= $shir; ?></h3><br>
        <a href="logout.php">Logout?</a>

    <?php else: ?>

        <h1>Please Login or Register</h1>
        <a href="login.php">Login</a> or
        <a href="register.php">Register</a>

    <?php endif; ?>

</body>
</html>