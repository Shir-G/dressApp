<?php
include 'user_config.php';

if (isset($_POST['outfit'])) {
    $outfitId = $_POST['outfit'];

    $outfitQuery = "SELECT * FROM `outfits` WHERE id = '$outfitId' ";
    $result = mysql_query($outfitQuery) or die("Query not retrieved:  " .mysql_error());
    $items = mysql_fetch_array($result);

    $outfit = new stdClass();
    foreach ($items as $key => $value) {
        if (!is_numeric($key)) {
            $val = explode(",", $value);
            if (sizeof($val) > 1) {
                $i=0;
                foreach ($val as $info) $outfit->{$key}[$i++] = $info;
            } else {
                $outfit->{$key} = $val[0];
            }
        }
    }

    $items = array();
    $itemsId = implode(",",$outfit->items);
    $itemQuery = "SELECT * FROM `items` WHERE item_id in ($itemsId) ";
    $result = mysql_query($itemQuery) or die("Query not retrieved:  " .mysql_error());
    while ($itemRow = mysql_fetch_array($result)) array_push($items, $itemRow);

    $isLiked = false;
    $fetch_item_query = " SELECT `liked_outfits` FROM users WHERE `user_id` ='". $user['user_id']."'";
    $result = mysql_result(mysql_query($fetch_item_query) ,0);
    $liked_outfits = explode(",", $result);
    foreach ($liked_outfits as $key => $value) {
        if($value == $outfitId) {
            $isLiked = true;
            break;
        }
    }

}

if (isset($_POST['likedOutfit'])) {
    $likedOutfit = $_POST['likedOutfit'];
    
    $fetch_item_query = " SELECT `liked_outfits` FROM users WHERE `user_id` ='". $user['user_id']."'";
    $result = mysql_result(mysql_query($fetch_item_query) ,0);
    if (strcmp($result,"") == 0) $like_outfit_query = "UPDATE `users` SET `liked_outfits` = '$likedOutfit' WHERE `user_id` ='". $user['user_id']."'";
    else $like_outfit_query = "UPDATE `users` SET `liked_outfits` = CONCAT_WS(',', liked_outfits, '$likedOutfit') WHERE `user_id` ='". $user['user_id']."'";
    
    $retval = mysql_query( $like_outfit_query, $conn );       
    if(! $retval ) { //if qurey execution didnt succeed
        die('Could not enter data: ' . mysql_error());
    }
}

if (isset($_POST['dislikedOutfit'])) {
    $dislikedOutfit = $_POST['dislikedOutfit'];
    
    $fetch_item_query = " SELECT `liked_outfits` FROM users WHERE `user_id` ='". $user['user_id']."'";
    $result = mysql_result(mysql_query($fetch_item_query) ,0);
    $liked_outfits = explode(",", $result);
    foreach ($liked_outfits as $key => $value) {
        if($value == $dislikedOutfit) {
            unset($liked_outfits[$key]);
            break;
        }
    }
    $liked_outfits = implode(",", $liked_outfits);
    $like_outfit_query = "UPDATE `users` SET `liked_outfits` = '". $liked_outfits ."' WHERE `user_id` ='". $user['user_id']."'";
    $retval = mysql_query( $like_outfit_query, $conn );       
    if(! $retval ) { //if qurey execution didnt succeed
        die('Could not enter data: ' . mysql_error());
    }
}

// if ($user['account_permissions'] != "stylist") {
//     header("Location: hompage.php");
// }


?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/outfit.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <script type="text/javascript">
        createCanvas(<?= json_encode($outfit) ?>, <?= json_encode($items) ?>)
    </script>
    <title></title>
</head>

<body id="bd">
    <div class="alert-box success">You've just liked this outfit ♥</div>
    <a href="homepage.php">HOMEPAGE</a><br>
    <a href="logout.php">Logout?</a><br>
    <canvas id="holder" >
    </canvas>
    <div>
<?php
    if ($isLiked) {
?>
        <button id="dislikeOutfit" value="<?= $outfitId ?>">Dislike Outfit</button>
<?php
    } else {
?>
        <button id="likeOutfit" value="<?= $outfitId ?>">Like Outfit</button>
<?php
    }
?>
    </div>
    <h1>Items Details:</h1>
    <section>
        <form id="itemForm" action="item.php" method="post">
        <div id="info">
<?php
            foreach ($items as $itemRow) {
                foreach ($itemRow as $key => $value) {
                    if (!is_numeric($key)) {
                        if ($key == "item_id" || $key == "image" || $key == "qr_code") continue;
                        if ($key == "item_type") echo "<a class='item' id='item-id-" .$itemRow['item_id'] ."' href=''><strong>" .$value ."</strong></a><br>";
                        else echo $key ." = " .$value ."<br>";
                    }
                }
                echo "<br>";
            }
?>
        </div>
        <input type="hidden" id="itemInput" name="item_id">
        </form>
    </section>
</body>
</html>