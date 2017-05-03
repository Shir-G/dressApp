<?php
include 'user_config.php';
if ($user['account_permissions'] != "stylist") {
    header("Location: hompage.php");
}

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
<a href="logout.php">Logout?</a>
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
            <img src="<?= $itemRow['image'] ?>"  class="itemImage" draggable="true" ">
        </section>
<?php
    }
?>
    </section>
</body>
</html>