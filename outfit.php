<?php
include 'user_config.php';
include 'connect.php';

if (isset($_POST['outfit'])) {
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

// if ($user['account_permissions'] != "stylist") {
//     header("Location: hompage.php");
// }


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
    <canvas id="holder" >
    </canvas>    
</body>
</html>