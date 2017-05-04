<?php  
    include 'user_config.php';

    $itemsQuery = "SELECT * FROM `items` ORDER BY `items`.`item_type` ASC";
    $result = mysql_query($itemsQuery) or die("Query not retrieved:  " .mysql_error());
    $category = NULL;

?>

<!DOCTYPE html>
<html>
<head>
    <title>All Items</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
<a href="logout.php">Logout?</a><br>
<?php 
    if ($user['account_permissions'] == "stylist"){
?>
    <a href="editProfile.php?stylistID="<?= $user['user_id']; ?>>Edit your profile details</a>
<?php } ?>
<form action="outfitEditor.php" method="post">
<?php 
     while($item = mysql_fetch_assoc($result)){
        if ($item['item_type'] != $category){
            $category = $item['item_type'];
?>
        <h2><?= $category ?></h2>
<?php
        }
?>
        <label>
            <input type="checkbox" name="items[]" value="<?= $item['item_id'] ?>">
            <section class="item_section">
                <img src="<?= $item['image'] ?>"  >
            </section>
        </label>
<?php
    }
?>
    <br>
    <input type="submit" name="submit" value="submit"></input>        
</form>        

</body>
</html>