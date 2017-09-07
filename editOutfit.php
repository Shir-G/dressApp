<?php
header('Access-Control-Allow-Origin: *');
// header('Content-type: application/json');
include 'stylistConfig.php';
// include 'connect.php';

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
else if (isset($_POST['editId'])) {
    $outfitId = $_POST['editId'];

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

}

// if (isset($_FILES['image']) ) {
//     $file = $_FILES['image'];


//     $file_ext = explode('.', $file['name']);
//     $file_ext = strtolower(end($file_ext));

//     if ($file['error'] === 0) {
//         // $file_name_new = uniqid('', true).'.'.$file_ext;
//         $file_name_new = "newOutfit".'.'.$file_ext;
//         $file_dest = 'profileImages/'.$file_name_new;
//         if (move_uploaded_file($file['tmp_name'], $file_dest)) {
//             $update_query = "UPDATE `outfits` SET `img` = '$file_dest'  WHERE `id` = 29";//.$outfitId;
//             $retval = mysql_query( $update_query, $conn );
//             if(! $retval ) { //if qurey execution didnt succeed
//                 die('Could not enter data: ' . mysql_error());
//             }

//         }
//     } 
// }

/*else if (isset($_POST['outfits']) && isset($_POST['category']) && isset($_POST['outfitId'])) {
    $info = json_decode($_POST['outfits']);
    $category = $_POST['category'];
    $id = $_POST['outfitId']);

    //$src = array();
    $x = array();
    $y = array();
    $height = array();
    $width = array();
    //$itemId = array();
    foreach ($info as $outfit) {
        //array_push($src, $outfit->{'imgSrc'});
        array_push($x, $outfit->{'x'});
        array_push($y, $outfit->{'y'});
        array_push($height, $outfit->{'height'});
        array_push($width, $outfit->{'width'});  
        //array_push($itemId, $outfit->{'id'});            
    }

    //$src = implode(",",$src);
    $x = implode(",",$x);
    $y = implode(",",$y);
    $height = implode(",",$height);
    $width = implode(",",$width);
    //$itemId = implode(",",$itemId);
    $update_outfit_query = "UPDATE `outfits` SET `x` = $x, `y` = $y, `height` = $height, `width` = $width, `category` = $category WHERE `id` = ".$id;
        
    $retval = mysql_query( $update_outfit_query, $conn );       
    if(! $retval ) { //if qurey execution didnt succeed
        die('Could not enter data: ' . mysql_error());
    }
}*/




// if ($user['account_permissions'] != "stylist") {
//     header("Location: hompage.php");
// }


?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/editOutfit.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        createCanvas(<?= json_encode($outfit) ?>, <?= json_encode($items) ?>)
    </script>
    <title>Edit</title>
</head>

<body id="edit_body">
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
    <canvas id="holder" data-outfit-id="<?= $outfitId ?>"></canvas>
    <section id="edit_buttons">
        <form id="editForm" method="post" required>
            <select id="category" class="form-control">
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
            <button id="makeCanvas" class="btn btn-secondary ">Save Outfit</button>
            
        </form>

        <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-content="<ul><li>Change the items position by dragging them inside the box.</li><li>In order to increase or decrease the item size - click on it and then press the up or down key on your keyboard. <br> <small> You can deselect an item by clicking elsewhere on the screen.</small></li></ul>">
          Tips
        </button>
    
    </section>

    

</body>
</html>