<?php
    error_reporting(E_ALL ^ E_DEPRECATED);//discard all deprecated warnings
    $servername = "188.121.44.180";
    $username = "dressapp";
    $password = "Dressapp1";
    $dbname = "dressapp";

    $conn = mysql_connect($servername, $username, $password);
    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }        
    mysql_select_db($dbname);
    
    //echo "Connected successfully";
?>