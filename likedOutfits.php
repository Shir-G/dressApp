<?php
    include 'user_config.php';
    if( empty($user) ){
        header("Location: index.php");
    }

    // if (isset($_POST['removeItem'])) {
    //     $itemToRemove = $_POST['removeItem'];
    //     $fetch_item_query = " SELECT `my_closet` FROM users WHERE `user_id` ='". $user['user_id']."'";
    //     $result = mysql_result(mysql_query($fetch_item_query) ,0);
    //     $items_in_closet = explode(",", $result);
    //     foreach ($items_in_closet as $key => $value) {
    //         if($value == $itemToRemove) {
    //             unset($items_in_closet[$key]);
    //             break;
    //         }
    //     }
    //     $items_in_closet = implode(",", $items_in_closet);
    //     $update_closet_query = "UPDATE `users` SET `my_closet` = '". $items_in_closet ."' WHERE `user_id` ='". $user['user_id']."'";
    //     $retval = mysql_query( $update_closet_query, $conn );
    //     if(! $retval ) { //if qurey execution didnt succeed
    //         die('Could not enter data: ' . mysql_error());
    //     }
    // }

    $liked_outfits_query = "SELECT `liked_outfits` FROM users WHERE `user_id` ='". $user['user_id']."'";
    $outfits = mysql_result(mysql_query($liked_outfits_query) ,0);
    $likedOutfits = explode(",", $outfits);

    $likedOutfitsList = array();

    foreach ($likedOutfits as $outfit) {
        $fetch_outfit_query = " SELECT * FROM outfits WHERE `id` = '".$outfit."' ";
        $result = mysql_query($fetch_outfit_query) or die("Query not retrieved:  " .mysql_error());
        $outfitRow = mysql_fetch_array($result);
        array_push($likedOutfitsList, $outfitRow);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="includes/style.css"> 
    <script src="includes/script.js"></script> 
    <title>Liked Outfits</title>
</head>
<body>
    
    <h1> Liked Outfits</h1>
    <a href="logout.php">Logout?</a><br>
    <a href="homepage.php">Homepage</a>
<?php
    if (sizeof($likedOutfitsList[0]) > 1) {
?>
        <form id="outfitForm" method="post" action="outfit.php">
<?php
            foreach ($likedOutfitsList as $singleOutfit) {
?>
                <a class="outfit" id="outfit-id-<?= $singleOutfit['id'] ?>" href=""><img width=300 src="<?= $singleOutfit['img']; ?>"></a>
<?php
            }
?>
            <input type="hidden" id="outfitInput" name="outfit">
        </form>
<?php
    } else echo "<br><br>No outfit was liked!";
?>
</body>
</html>