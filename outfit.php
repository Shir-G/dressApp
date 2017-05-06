<?php
include 'user_config.php';

if (isset($_POST['outfit'])) {
    $outfitId = $_POST['outfit'];

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
    // $hello = "hi <br>";
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
    <script type="text/javascript">
    createCanvas(<?= json_encode($outfit) ?>, <?= json_encode($items) ?>)
    </script>
    <title></title>
</head>

<body id="bd">
    <a href="logout.php">Logout?</a><br>
    <canvas id="holder" >
    </canvas> 
    <h1>Items Details:</h1>
    <section>
        <form id="itemForm" action="item.php" method="post">
        <div id="info">
        <!-- <?php
        // echo "<script type='text/javascript'> document.write(check()) </script> ";
        // $hello = ob_get_contents() ?> -->
<?php
            // echo "------------------------------<br>";
            // echo "!!! " .$hello;
            // if ($items != array()) {
                foreach ($items as $itemRow) {
                    foreach ($itemRow as $key => $value) {
                        if (!is_numeric($key)) {
                            if ($key == "item_id" || $key == "image") continue;
                            if ($key == "item_type") echo "<a class='item' id='item-id-" .$itemRow['item_id'] ."' href=''><strong>" .$value ."</strong></a><br>";
                            else echo $key ." = " .$value ."<br>";
                        }
                    }
                    echo "<br>";
                }
            // }
?>
        </div>
        <input type="hidden" id="itemInput" name="item_id">
        </form>
    </section>
</body>
</html>