<?php 
include 'connect.php';

$outfid_id = 1;

$query = "SELECT * FROM `outfits` WHERE id = $outfid_id";
$result = mysql_query($query) or die("failed to find outfid_id" .mysql_error());
$ratingRow = mysql_fetch_assoc($result);
$people = $ratingRow['total_people'];
$total = $ratingRow['total_rates'];

//holds the num pf people ant total votes for new calculation in ajax method
$string = $people." ".$total;

//if the ajax method was called and returned coerrect values
if (isset($_POST['star']) && isset($_POST['total'])) {
    $stars = $_POST['star'];
    $total = $_POST['total'];
    $people = $_POST['people'];

    //updates the values in the DB
    $stars_query = "UPDATE `outfits` SET rate = ".$stars." , total_people = ".$people.", total_rates = ".$total." WHERE id =".$outfid_id;
        
    $retval = mysql_query( $stars_query, $conn );
    if(! $retval ) { //if qurey execution didnt succeed
        die('Could not enter data: ' . mysql_error());
    }

}


?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/outfitRate.js"></script>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <section id="rate_section" title=" <?= $string ?> ">
        <button class="ratings_stars" value="1" name="star"></button>
        <button class="ratings_stars" value="2" name="star"></button>
        <button class="ratings_stars" value="3" name="star"></button>
        <button class="ratings_stars" value="4" name="star"></button>
        <button class="ratings_stars" value="5" name="star"></button>
        <div id="total_votes"><?= $ratingRow['rate'] ?></div>
    </section>
</body>
</html>