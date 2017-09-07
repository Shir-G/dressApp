<?php
include 'stylistConfig.php';

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
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Editor</title>
</head>
<body id="editor_body">
    <header>
        <a href="homepage.php"><h1>DressApp</h1></a>
        <ul class="nav nav-pills">
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
    <!-- <canvas id="holder" >
    </canvas> -->
    <section id="selectedItems">
<?php
        foreach ($itemArray as $item) {
            $itemQuery = "SELECT * FROM `items3` WHERE item_id = '$item' ";
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

    <canvas id="holder" ></canvas>

    <section id="editor_buttons">
        <form id="canvasForm" method="post" required>
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
            <button id="makeCanvas" class="btn btn-secondary ">Create Outfit</button>
            
        </form>
    <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" data-content="<ul><li>Drag the items inside the box.</li><li>In order to increase or decrease the item size - click on it and then press the up or down key on your keyboard. <br> <small> You can deselect an item by clicking elsewhere on the screen.</small></li></ul>">
      Tips
    </button>
    </section>

</html>