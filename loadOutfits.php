<?php 
    include 'connect.php';

    if (isset($_POST['limit'])) {
        $limit = $_POST['limit'];
        $load_query = "SELECT * FROM `outfits` ORDER BY `outfits`.`id` DESC LIMIT 6 OFFSET ";
        $res = mysql_query($load_query.$limit);

        while ($loadMore = mysql_fetch_assoc($res)) {
            echo $loadMore['id']."<br>";
        }
    }
 ?>