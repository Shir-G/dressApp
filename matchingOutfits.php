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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/script.js"></script>
</head>
<body>
    <h1>Matching outfits</h1>
    <a href="logout.php">Logout?</a><br>
    <a href="homepage.php">Homepage</a><br>

    <form id="outfitForm" method="post" action="outfit.php">
    <?php 
        foreach ($outfitsArr as $outfit) {
    ?>
        <a class="outfit" href=""><img width=300 src="<?= $outfit['img']; ?>"></a>
        <input type="hidden" name="outfit" value="<?= $outfit['id']; ?>">
    <?php    
        }
    ?>   

    </form>
    

</body>
</html>