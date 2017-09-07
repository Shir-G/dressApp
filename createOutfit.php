<?php
include 'stylistConfig.php';


if (isset($_POST['outfits']) && isset($_POST['category']) && isset($_POST['image'])) {
    $info = json_decode($_POST['outfits']);
    $category = $_POST['category'];
    $img = $_POST['image'];

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

    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);

    $result = mysql_query("SHOW TABLE STATUS LIKE 'outfits'");
    $data = mysql_fetch_assoc($result);
    $outfitId = $data['Auto_increment'];
    
    $file_dest = 'http://www.dressapp.org/pics/outfit'. $outfitId.'.png';
    $file_name = '../pics/outfit' .$outfitId.'.png';

    if (file_put_contents($file_name, $fileData)){
        $add_outfit_query = "INSERT INTO `outfits` (`src`, `x`, `y`, `height`, `width`, `category`, `items`, `img`, `stylist`) VALUES ('$src', '$x', '$y', '$height', '$width', '$category', '$itemId', '$file_dest', '".$stylist['stylist_id']."')";
            
        $retval = mysql_query( $add_outfit_query, $conn );       
        if(! $retval ) { //if qurey execution didnt succeed
            die('Could not enter data: ' . mysql_error());
        }
    }
    echo $outfitId;
}

 ?>