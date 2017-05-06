<?php
    include 'user_config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
</head>
<body>
    <h1> Homepage</h1>
    <?php if( !empty($user) ): ?>

        <br />Welcome <?= $user['username']; ?> 
        <br /><br />You are successfully logged in!
        <br /><br />
        <a href="logout.php">Logout?</a><br>
        <a href="stylistSearch.php">Search Stylist</a>
        <a href="outfitSearch.php">Search outfit</a>
        <?php 
        if ($user['account_permissions'] == "stylist") {
        ?>
            <a href="allItems.php">Create an Outfit</a>
        <?php
        }
        ?>

        <h2>Search Item</h2>
        <form action="item.php" method="post">
            <input type="text" name="item_id" required></input>
            <input type="submit" name="submit" value="submit"></input>
        </form>

        <a href="closet.php">See All Items in My Closet</a>

    <?php else: ?>

        <h1>Please Login or Register</h1>
        <a href="login.php">Login</a> or
        <a href="register.php">Register</a>

    <?php endif; ?>

</body>
</html>