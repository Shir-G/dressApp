<?php
include 'user_config.php';

if (isset($_POST['outfits']) && isset($_POST['category'])) {
    $info = json_decode($_POST['outfits']);
    $category = $_POST['category'];

    $src = array();
    $x = array();
    $y = array();
    $height = array();
    $width = array();
    $itemId = array();
    foreach ($info as $outfit) {
        array_push($src, $outfit->{'imgSrc'});
        array_push($x, $outfit->{'x'});
        array_push($y, $outfit->{'y'});
        array_push($height, $outfit->{'height'});
        array_push($width, $outfit->{'width'});  
        array_push($itemId, $outfit->{'id'});            
    }

    $src = implode(",",$src);
    $x = implode(",",$x);
    $y = implode(",",$y);
    $height = implode(",",$height);
    $width = implode(",",$width);
    $itemId = implode(",",$itemId);
    $add_outfit_query = "INSERT INTO `outfits` (`src`, `x`, `y`, `height`, `width`, `category`, `items`) VALUES ('$src', '$x', '$y', '$height', '$width', '$category', '$itemId')";
        
    $retval = mysql_query( $add_outfit_query, $conn );       
    if(! $retval ) { //if qurey execution didnt succeed
        die('Could not enter data: ' . mysql_error());
    }
}

if ($user['account_permissions'] != "stylist") {
    header("Location: hompage.php");
}

$itemArray = array();
foreach ($_POST['items'] as $check) {
    array_push($itemArray, $check);
}

?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/editor.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <title></title>
</head>
<body id="bd">
    <a href="logout.php">Logout?</a><br>
    <a href="homepage.php">HOMEPAGE</a><br>
    <canvas id="holder" >
    </canvas>
    <section id="selectedItems">
<?php
    foreach ($itemArray as $item) {
        $itemQuery = "SELECT * FROM `items` WHERE item_id = '$item' ";
        $result = mysql_query($itemQuery) or die("Query not retrieved:  " .mysql_error());
        $itemRow = mysql_fetch_array($result);
?>
        <section class="item_section">
            <img src="<?= $itemRow['image'] ?>"  class="itemImage item-id-<?= $itemRow['item_id'] ?>" draggable="true" ">
        </section>
<?php
    }
?>
    </section>
    <button id="makeJpg">make jpg</button>
    <form id="canvasForm" method="post" required>
        <select id="category">
            <option value="casual">Casual</option>
            <option value="winter">Winter</option>
            <option value="fall">Fall</option>
            <option value="summer">Summer</option>
            <option value="spring">Spring</option>
            <option value="daytime">daytime</option>
            <option value="evening">Evening</option>
            <option value="sport">Sport</option>
            <option value="work">Work</option>
            <option value="holiday">Holiday</option>
            <option value="formal">Formal</option>
        </select>
        <button id="makeCanvas" >make canvas</button>
    </form>
    
</body>
</html>