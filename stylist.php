<?php
    include 'user_config.php';

    if (isset($_GET['stylistID'])) {
        $stylistID = $_GET['stylistID'];
        $stylist_query = "SELECT * FROM `stylists` WHERE stylist_id = '".$stylistID."'";
        $result = mysql_query($stylist_query) or die("failed to login" .mysql_error());
        $stylistRow = mysql_fetch_assoc($result);
    }

    if (isset($_POST['follow'])) {
        $stylist = $_POST['follow'];
        $follow_query = "UPDATE `users` SET `follow` = CONCAT_WS(',', follow, '$stylist') WHERE `user_id` ='". $user['user_id']."'";
            
        $retval = mysql_query( $follow_query, $conn );
        if(! $retval ) { //if qurey execution didnt succeed
            die('Could not enter data: ' . mysql_error());
        }
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <script src="includes/script.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <title>Stylist</title>
</head>
<body>
    <div class="alert-box success">you now follow <?= $stylistRow['username'] ?></div>
    <h1> Stylist</h1>
    <?php if( !empty($user) ): ?>
        <a href="logout.php">Logout?</a><br>
        <?php
            if ($user['user_id'] == $_GET['stylistID']){
        ?>
            <a href="editProfile.php?stylistID="<?= $_GET['stylistID']; ?>>Edit your profile details</a>
        <?php } ?>
        <h3><?php echo "Stylist ID: ".$stylistRow['stylist_id']; ?></h3>
        <h4>Description:</h4>
        <p><?= $stylistRow['description'] ?></p>
        <img src="<?= $stylistRow['profile_image'] ?>">

        <form id="follow_button" method="post">
            <button id="followBtn" type="submit" name='follow' value="<?= $_GET['stylistID'] ?>">Follow</button>
        </form>
        

    <?php else: ?>

        <h1>Please Login or Register</h1>
        <a href="login.php">Login</a> or
        <a href="register.php">Register</a>

    <?php endif; ?>

</body>
</html>