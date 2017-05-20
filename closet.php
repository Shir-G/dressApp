<?php
    include 'user_config.php';
    if( empty($user) ){
        header("Location: index.php");
    }

    if (isset($_POST['removeItem'])) {
        $itemToRemove = $_POST['removeItem'];
        $fetch_item_query = " SELECT `my_closet` FROM users WHERE `user_id` ='". $user['user_id']."'";
        $result = mysql_result(mysql_query($fetch_item_query) ,0);
        $items_in_closet = explode(",", $result);
        foreach ($items_in_closet as $key => $value) {
            if($value == $itemToRemove) {
                unset($items_in_closet[$key]);
                break;
            }
        }
        $items_in_closet = implode(",", $items_in_closet);
        $update_closet_query = "UPDATE `users` SET `my_closet` = '". $items_in_closet ."' WHERE `user_id` ='". $user['user_id']."'";
        $retval = mysql_query( $update_closet_query, $conn );
        if(! $retval ) { //if qurey execution didnt succeed
            die('Could not enter data: ' . mysql_error());
        }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/closet.js"></script>
    <link rel="stylesheet" href="includes/style.css">  
    <title>My Closet</title>
</head>
<body>
    <div class="alert-box success">Item was successfully removed from your closet!</div>
    <h1> My Closet</h1>
    <a href="logout.php">Logout?</a><br>
    <a href="homepage.php">Homepage</a>
<?php
    if (sizeof($myCloset[0]) > 1) {
?>
        <form id="itemForm" action="item.php" method="post">
<?php
            foreach ($myCloset as $singleItem) {
    ?>
                <div id="div-item-<?= $singleItem['item_id'] ?>">
                    <input type="button" id="remove-<?= $singleItem['item_id'] ?>" class="removeFromCloset" value="X">
                    <section class="closet_items">
                        <a class="item" id="item-id-<?= $singleItem['item_id'] ?>" href="">
                            <img src="<?= $singleItem['image'] ?>">
                        </a>
                    </section>
                </div>
<?php
            }
?>
            <input type="hidden" id="itemInput" name="item_id">
        </form>
<?php
    } else echo "<br><br>No items in the closet!";
?>
</body>
</html>