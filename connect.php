<?php
    $servername = "localhost";
    $username = "root";
    $password = "pass2591";
    $dbname = "dressapp";

    $conn = mysql_connect($servername, $username, $password);
    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }        
    mysql_select_db($dbname);
    
    //echo "Connected successfully";
?>