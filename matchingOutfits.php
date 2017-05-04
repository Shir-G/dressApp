<?php 
    include 'user_config.php';

    $outfitsArr = array();

    if (isset($_POST['outfit'])) {
        $itemID = $_POST['outfit'];

        $find_outfit_query = "SELECT * FROM `outfits`";
        $result = mysql_query($find_outfit_query) or die("Query not retrieved:  " .mysql_error());

        while ($row = mysql_fetch_assoc($result)) {
            $items = explode(",", $row['items']);
            foreach ($items as $item) {
                if ($item == $itemID) {
                    array_push($outfitsArr, $row);
                }
            }
        }
        
        
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Matching Outfits</title>
</head>
<body>
    <h1>Matching outfits</h1>
    <a href="logout.php">Logout?</a><br>
    <a href="homepage.php">Homepage</a><br>

    <?php 
    foreach ($outfitsArr as $outfit) {
        
    }
    ?>

</body>
</html>