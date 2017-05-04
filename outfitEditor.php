<?php
include 'user_config.php';
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
    <script src="includes/editor.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <title></title>
</head>
<body>
<a href="logout.php">Logout?</a><br>
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