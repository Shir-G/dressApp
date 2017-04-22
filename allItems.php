<?php  
    include 'user_config.php';
    $shirts = array();
    $pants = array();
    $shoes = array();
    $accessories = array();
    $dresses = array();
    $overwear = array();
    $jumpsuits = array();
    $itemsQuery = "SELECT * FROM `items`";
    $result = mysql_query($itemsQuery) or die("Query not retrieved:  " .mysql_error());
    while($item = mysql_fetch_assoc($result)){
        switch ($item['item_type']) {
            case "shirt":
                array_push($shirts, $item);
                break;
            case "pants":
                array_push($pants, $item);
                break;
            case "shoes":
                array_push($shoes, $item);
                break;
            case "accessories":
                array_push($accessories, $item);
                break;
            case "dress":
                array_push($dresses, $item);
                break;
            case "overwear":
                array_push($overwear, $item);
                break;
            case "jumpsuit":
                array_push($jumpsuits, $item);
                break;
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>All Items</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
<form action="outfitEditor.php" method="post">
        <h2>Shirts</h2> 
    <?php
        foreach ($shirts as $shirt) {
    ?>      
            <label>
                <input type="checkbox" name="shirt[]" value="<?= $shirt['item_id'] ?>">
                <section class="item_section">
                    <img src="<?= $shirt['image'] ?>"  >
                </section>
            </label>
    <?php
        }
    ?>
        <br>
        <h2>Pants</h2>
    <?php
        foreach ($pants as $pant) {
    ?>
            <label>
                <input type="checkbox" name="pants[]" value="<?= $pant['item_id'] ?>">
                <section class="item_section">
                    <img src="<?= $pant['image'] ?>" width="100px">
                </section>
            </label>
    <?php
        }
    ?>
        <h2>Shoes</h2> 
    <?php
        foreach ($shoes as $shoe) {
    ?>
            <label>
                <input type="checkbox" name="shoes[]" value="<?= $shoe['item_id'] ?>">
                <section class="item_section">
                    <img src="<?= $shoe['image'] ?>" width="100px">
                </section>
            </label>
    <?php
        }
    ?>
        <h2>Accessories</h2>
    <?php
        foreach ($accessories as $accessory) {
    ?>
            <label>
                <input type="checkbox" name="accessories[]" value="<?= $accessory['item_id'] ?>">
                <section class="item_section">
                    <img src="<?= $accessory['image'] ?>" width="100px">
                </section>
            </label>
    <?php
        }
    ?>
        <h2>Dresses</h2>
    <?php
        foreach ($dresses as $dress) {
    ?>
            <label>
                <input type="checkbox" name="dresses[]" value="<?= $dress['item_id'] ?>">
                <section class="item_section">
                    <img src="<?= $dress['image'] ?>" width="100px">
                </section>
            </label>
    <?php
        }
    ?>
        <h2>Overwear</h2>
    <?php
        foreach ($overwear as $overItem) {
    ?>
            <label>
                <input type="checkbox" name="overwear[]" value="<?= $overItem['item_id'] ?>">
                <section class="item_section">
                    <img src="<?= $overItem['image'] ?>" width="100px">
                </section>
            </label>
    <?php
        }
    ?>
        <h2>Jumpsuits</h2>
    <?php
        foreach ($jumpsuits as $jumpsuit) {
    ?>
            <label>
                <input type="checkbox" name="jumpsuits[]" value="<?= $jumpsuit['item_id'] ?>">
                <section class="item_section">
                    <img src="<?= $jumpsuit['image'] ?>" width="100px">
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