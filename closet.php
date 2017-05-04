<?php
    include 'user_config.php';
    if( empty($user) ){
        header("Location: index.php");
    }


    $find_closet_query = "SELECT `my_closet` FROM users WHERE `user_id` ='". $user['user_id']."'";
    $closet = mysql_result(mysql_query($find_closet_query) ,0);
    $items_in_closet = explode(",", $closet);


    $myCloset = array();

    foreach ($items_in_closet as $item) {
        $fetch_item_query = " SELECT * FROM items WHERE `item_id` = '".$item."' ";
        $result = mysql_query($fetch_item_query) or die("Query not retrieved:  " .mysql_error());
        $itemRow = mysql_fetch_array($result);
        array_push($myCloset, $itemRow);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="includes/style.css">  
    <title>My Closet</title>
</head>
<body>
    <h1> My Closet</h1>
    <a href="logout.php">Logout?</a><br>
    <a href="homepage.php">Homepage</a>

    <?php 
        foreach ($myCloset as $singleItem) {
    ?>
        
        <section class="closet_items">
            <!-- <a href="<?= "item.php?itemID=".$singleItem."" ?>"> -->
                <img src="<?= $singleItem['image'] ?>">
            <!-- </a> -->
        </section>
        
    <?php
        }
    ?>
    
</body>
</html>