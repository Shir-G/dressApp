<?php
    include 'connect.php';
    session_start();

    $user = NULL;
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' ";
        $result = mysql_query($query) or die("failed to login" .mysql_error());
        $row = mysql_fetch_array($result);

        if (count($row)>0) {
        $user = $row;
        }
    }
    else{
        header("Location: index.php");
    }
    
?>