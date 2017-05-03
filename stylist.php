<?php
    include 'user_config.php';

    if (isset($_GET['stylistID'])) {
        $stylistID = $_GET['stylistID'];
        $stylist_query = "SELECT * FROM `stylists` WHERE stylist_id = '".$stylistID."'";
        $result = mysql_query($stylist_query) or die("failed to login" .mysql_error());
        $stylistRow = mysql_fetch_assoc($result);
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stylist</title>
</head>
<body>
    <h1> Stylist</h1>
    <?php if( !empty($user) ): ?>
        <a href="logout.php">Logout?</a><br>
        <a href="editProfile.php">Edit your profile details</a>
        <h3><?php echo "Stylist ID: ".$stylistRow['stylist_id']; ?></h3>
        <h4>Description:</h4>
        <p><?= $stylistRow['description'] ?></p>
        <img src="<?= $stylistRow['profile_image'] ?>">
        

    <?php else: ?>

        <h1>Please Login or Register</h1>
        <a href="login.php">Login</a> or
        <a href="register.php">Register</a>

    <?php endif; ?>

</body>
</html>