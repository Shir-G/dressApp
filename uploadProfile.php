<?php
    include 'stylistConfig.php';

    $changeSucceed = false;

    if (isset($_FILES['profileImage'])) {
        $file = $_FILES['profileImage'];

        $file_ext = explode('.', $file['name']);
        $file_ext = strtolower(end($file_ext));

        if ($file['error'] === 0) {
            $file_name_new = uniqid('', true).'.'.$file_ext;
            $file_dest = 'profileImages/'.$file_name_new;

            if (move_uploaded_file($file['tmp_name'], $file_dest)) {
                $file_dest = 'http://www.dressapp.org/desktop/' .$file_dest;
                $update_query = "UPDATE `stylists` SET `profile_image` = '$file_dest'  WHERE `stylist_id` = ".$user['user_id'];
                $retval = mysql_query( $update_query, $conn );
                if(! $retval ) { //if qurey execution didnt succeed
                    die('Could not enter data: ' . mysql_error());
                }
                else $changeSucceed = true;
            }
        } 
    }

    if (!empty($_POST['description'])){
        $desc = $_POST['description'];
        $update_query = "UPDATE `stylists` SET `description` = '$desc' WHERE `stylist_id` = ".$user['user_id'];
        $retval = mysql_query( $update_query, $conn );
        if(! $retval ) { //if qurey execution didnt succeed
            die('Could not enter data: ' . mysql_error());
        }
        else $changeSucceed = true;
    }

    if ($changeSucceed) {
        header("Location: editProfile.php");
    }

?>