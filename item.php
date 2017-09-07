<?php
    include 'stylistConfig.php';

    if (isset($_POST['item_id'])){
        $itemid = $_POST['item_id'];
        $query = "SELECT * FROM items WHERE item_id = '$itemid' ";
        $result = mysql_query($query) or die("Query not retrieved:  " .mysql_error());
        $item =  mysql_fetch_array($result);
    
        if ($item['item_id'] == $itemid) {
            $item_image = $item['image'];
        }
    }

/*    include 'user_config.php';

    $fetch_item_query = " SELECT `my_closet` FROM users WHERE `user_id` ='". $user['user_id']."'";
    $result = mysql_result(mysql_query($fetch_item_query) ,0);

    if (isset($_POST['action'])) {
        $userid = $user['user_id'];
        $itemid = $_POST['action'];
        
        $fetch_item_query = " SELECT `my_closet` FROM users WHERE `user_id` ='". $user['user_id']."'";
        $result = mysql_result(mysql_query($fetch_item_query) ,0);
        if (strcmp($result,"") == 0) $add_closet_query = "UPDATE `users` SET `my_closet` = '$itemid' WHERE `user_id` ='". $user['user_id']."'";
        else $add_closet_query = "UPDATE `users` SET `my_closet` = CONCAT_WS(',', my_closet, '$itemid') WHERE `user_id` ='". $user['user_id']."'";
            
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
        $result = mysql_query($query) or die("Query not retrieved:  " .mysql_error());
        $item =  mysql_fetch_array($result);

        if ($item['item_id'] == $item_id) {
            $item_image = $item['image'];
        }
        else echo "Item Not Found";
              
    }*/

/*    else {
        $itemid = $_GET['itemID'];
        $query = "SELECT * FROM items WHERE item_id = '$itemid' ";
        $result = mysql_query($query) or die("Query not retrieved:  " .mysql_error());
        $item =  mysql_fetch_array($result);

        if ($item['item_id'] == $itemid) {
            $item_image = $item['image'];
        }
        else echo "Item Not Found";

             
    }*/

        
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/script.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body id="item_body">
    <header>
        <a href="homepage.php"><h1>DressApp</h1></a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="allItems.php">Create an Outfit</a>
            </li>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Options<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="editProfile.php?stylistID=<?= $user['user_id']; ?>">Edit your profile</a></li>
                    <li><a href="logout.php" class="nav-link">Logout</a> </li>
                </ul>
            </li>
            <li class="nav-item">
            <?php
                if ($stylist['profile_image'] != NULL) {
            ?>
                    <img src="<?= $stylist['profile_image'] ?>" class="img-responsive">
            <?php  
                }else{
            ?>
                    <img src="http://www.dressapp.org/images/default-profile.png" class="img-responsive">
            <?php
                }
            ?>
            </li>
            
        </ul>
        </header>
    <div class="alert-box success">Item was added successfully to your closet!</div>
    <main class="container">
        <section>
        <?php if (!empty($item_image)) { ?>
            <img src="<?= $item_image?>">
            <p>
                price: <?= $item['price'] ?> <br>
                store: <?= $item['store'] ?>
            </p>
            <br /><br />
        <?php } ?>
<!--         <div class="btn-group-vertical">
    <form id="items_buttons" method="post" >
        <button class="btn btn-outline-secondary btn-lg" id="addBtn" type="submit" name='submit' value="<?= $_POST['item_id'] ?>">Add to My Closet</button>
    </form>
    <form action="matchingOutfits.php" method="post">
        <button class="btn btn-outline-secondary btn-lg" id="searchBtn" type="submit" name='outfit' value="<?= $_POST['item_id'] ?>">Find a Matching Outfit</button>
    </form>
</div> -->
        </section>
        <!-- add remove icon after clicking -->
    </main>

        


</body>
</html>