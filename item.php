<?php
    include 'user_config.php';

    
    if (isset($_POST['action'])) {
        $userid = $user['user_id'];
        $itemid = $_POST['action'];
        $add_closet_query = "UPDATE `users` SET `my_closet` = CONCAT_WS(',', my_closet, '$itemid') WHERE `user_id` ='". $user['user_id']."'";// the id field generated automatically
            
        $retval = mysql_query( $add_closet_query, $conn );
        $insertId = mysql_insert_id();
        if(! $retval ) { //if qurey execution didnt succeed
            die('Could not enter data: ' . mysql_error());
        }
        else echo "successfully!!!";
    }   


    if (!empty($_POST['item_id'])) {
        $item_id = $_POST['item_id'];
        $item_image = '';

        $query = "SELECT * FROM items WHERE item_id = '$item_id' ";
        $result = mysql_query($query) or die("failed to login" .mysql_error());
        $item =  mysql_fetch_array($result);

        if ($item['item_id'] == $item_id) {
            $item_image = $item['image'];
        }
        else echo "Item Not Found";
              
    }

    function addToCloset($item_id){
            $find_closet_query = "SELECT `my_closet` FROM users WHERE `user_id` ='". $user['user_id']."'";
            $closet = mysql_result(mysql_query($find_closet_query),0);
            $items_in_closet = explode(",", $closet);
            $added_to_closet = "false";
            if ($added_to_closet == "false") {
                if (!array_search($item_id,$items_in_closet)) {
                    $add_closet_query = "UPDATE `users` SET `my_closet` = CONCAT_WS(',', my_closet, '$item_id') WHERE `user_id` ='". $user['user_id']."'";
                    $retval = mysql_query( $add_closet_query, $conn );
                    $insertId = mysql_insert_id();
                    if(! $retval ) { //if qurey execution didnt succeed
                        die('Could not enter data: ' . mysql_error());
                    }
                    else echo "successfully!!!";
                }
                $added_to_closet = "true";
            }
        }
        
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/script.js"></script>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <div class="alert-box success">Item was added successfully to you closet!</div>
    <a href="homepage.php">HOMEPAGE</a>
    <h1> Item Page</h1>
    <?php if( !empty($user) ): ?>

        <br />Welcome <?= $user['username']; ?> 
        <br /><br />
        <?php if (!empty($item_image)) { ?>
            <img src="<?= $item_image?>">
            <p>
                price: <?= $item['price'] ?> <br>
                store: <?= $item['store'] ?>
            </p>
            <br /><br />
        <?php } ?>
        <form id="items_buttons" method="post" >
            <button id="addBtn" type="submit" name='submit' value="<?= $_POST['item_id'] ?>">send</button>
        </form>
        
        <!-- add remove icon after clicking -->

    <?php else: ?>

        <h1>Please Login or Register</h1>
        <a href="login.php">Login</a> or
        <a href="register.php">Register</a>

    <?php endif; ?>

</body>
</html>