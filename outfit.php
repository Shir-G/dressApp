<?php

$connected = false;
session_start();
include_once 'connect.php';
if (isset($_SESSION['user_id'])){
    $connected = true;
    include 'stylistConfig.php';
}

$category='';

if (isset($_GET['outfit']) || isset($_POST['outfit'])) {
    $outfitId = (isset($_POST['outfit'])) ? $_POST['outfit'] : $_GET['outfit'];
    echo "<script>console.log($outfitId);</script>";

    $outfitQuery = "SELECT * FROM `outfits` WHERE id = '$outfitId' ";
    $result = mysql_query($outfitQuery) or die("Query not retrieved:  " .mysql_error());
    $items = mysql_fetch_array($result);
    $category = $items['category'];

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
    $itemQuery = "SELECT * FROM `items3` WHERE item_id in ($itemsId) ";
    $result = mysql_query($itemQuery) or die("Query not retrieved:  " .mysql_error());
    while ($itemRow = mysql_fetch_array($result)) array_push($items, $itemRow);
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
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        createCanvas(<?= json_encode($outfit) ?>, <?= json_encode($items) ?>)
    </script>
    <title></title>
</head>

<body id="outfit_body">
    <header>
        <a href="homepage.php"><h1>DressApp</h1></a>
        <ul class="nav nav-pills">
        <?php
        if (!$connected) {
        ?>
            <li class="nav-item">
                <a href="index.php">Sign In</a>
            </li>
        <?php
        } 
        else {
        ?>
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
            if ($connected) {
                if ($stylist['profile_image'] != NULL) {                
            ?>
                    <img src="<?= $stylist['profile_image'] ?>" class="img-responsive">
            <?php  
                }else{
            ?>
                    <img src="http://www.dressapp.org/images/default-profile.png" class="img-responsive">
            <?php
                }
            }
            ?>
            </li>
            <?php
        }
            ?>
        </ul>
    </header>
    <div class="alert-box success">You've just liked this outfit ♥</div>
    <canvas id="holder" ></canvas>
    
    <section id="outfit_details">

        <!-- Sharingbutton Facebook -->
        <a class="resp-sharing-button__link btn btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=www.dressapp.org/desktop/outfit.php?outfit=<?= $outfitId ?>" target="_blank" aria-label="Facebook">
            <!-- <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--medium">
                <div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                </svg>
                </div> -->
                Share on Facebook
            </div>
        </a>
        <form id="editForm" method="post" action="editOutfit.php">
            <input type="hidden" name="editId" value="<?= $outfitId ?>">
            <input type="submit" name="edit" value="Edit Outfit" class="btn btn-outline-secondary">
        </form>

    <h1>Outfit Details:</h1>
        <h2>Category: <?= $category ?></h2>
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