<?php

    include 'user_config.php';

    $query = "SELECT * FROM stylists WHERE stylist_id = ".$user['user_id'];
    $result = mysql_query($query) or die("failed to login" .mysql_error());
    $stylist = mysql_fetch_array($result);

?>