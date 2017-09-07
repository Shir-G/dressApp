<?php 
include "connect.php"

if (isset($_POST['outfits']) && isset($_POST['category']) && isset($_POST['outfitId']) && isset($_POST['image'])) {
    $info = json_decode($_POST['outfits']);
    $category = $_POST['category'];
    $outfitId = $_POST['outfitId'];
    $img = $_POST['image'];
    
    $x = array();
    $y = array();
    $height = array();
    $width = array();
    foreach ($info as $outfit) {
        array_push($x, $outfit->{'x'});
        array_push($y, $outfit->{'y'});
        array_push($height, $outfit->{'height'});
        array_push($width, $outfit->{'width'});             
    }

    $x = implode(",",$x);
    $y = implode(",",$y);
    $height = implode(",",$height);
    $width = implode(",",$width);
    

    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    
    $file_dest = 'http://www.dressapp.org/pics/outfit'. $outfitId.'.png';
    $file_name = '../pics/outfit' .$outfitId.'.png';
    if (file_put_contents($file_name, $fileData)) {
    
        $update_outfit_query = "UPDATE `outfits` SET `x` = '$x', `y` = '$y', `height` = '$height', `width` = '$width', `category` = '$category', `img` = '$file_dest' WHERE `id` = ".$outfitId;

        $retval = mysql_query( $update_outfit_query, $conn );       
        if(! $retval ) { 
            die('Could not enter data: ' . mysql_error());
        }
    }

}

?>