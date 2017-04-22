<?php
include 'user_config.php';
$itemArray = array();
if(!empty($_POST['shirt'])) {
    foreach($_POST['shirt'] as $check) {
            array_push($itemArray, $check);
    }
}
if(!empty($_POST['pants'])) {
    foreach($_POST['pants'] as $check) {
            array_push($itemArray, $check);
    }
}
if(!empty($_POST['shoes'])) {
    foreach($_POST['shoes'] as $check) {
            array_push($itemArray, $check);
    }
}
if(!empty($_POST['accessories'])) {
    foreach($_POST['accessories'] as $check) {
            array_push($itemArray, $check);
    }
}
if(!empty($_POST['dresses'])) {
    foreach($_POST['dresses'] as $check) {
            array_push($itemArray, $check);
    }
}
if(!empty($_POST['overwear'])) {
    foreach($_POST['overwear'] as $check) {
            array_push($itemArray, $check);
    }
}
if(!empty($_POST['jumpsuits'])) {
    foreach($_POST['jumpsuits'] as $check) {
            array_push($itemArray, $check);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <script src="includes/editor.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <title></title>
</head>
<body>
    <!-- <div id="holder">
        <img id="pic1" class="draggable" src="images/1.png" >
        <img id="pic2" class="draggable" src="images/2.png">
        <img id="pic4" class="draggable" src="images/4.png">
    </div> -->
    <canvas id="holder" >
<!--         <img id="pic1" class="draggable" src="images/1.png" >
        <img id="pic2" class="draggable" src="images/2.png">
        <img id="pic4" class="draggable" src="images/4.png"> -->
    </canvas>
    <section id="selectedItems">
<?php
    foreach ($itemArray as $item) {
        $itemQuery = "SELECT * FROM `items` WHERE item_id = '$item' ";
        $result = mysql_query($itemQuery) or die("failed to login" .mysql_error());
        $itemRow = mysql_fetch_array($result);
?>
        <section class="item_section">
            <img src="<?= $itemRow['image'] ?>"  class="itemImage" draggable="true" ">
        </section>
<?php
    }
?>
    </section>
</body>
</html>