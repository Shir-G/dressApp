<?php
    include 'user_config.php';

    if ($user['user_id'] == $_GET['stylistID']) {
        if (!empty($_POST['description'])){
            $desc = $_POST['description'];
            $update_query = "UPDATE `stylists` SET `description` = '$desc' WHERE `stylist_id` = ".$user['user_id'];
            $retval = mysql_query( $update_query, $conn );
            if(! $retval ) { //if qurey execution didnt succeed
                die('Could not enter data: ' . mysql_error());
            }
            else header("Location: stylist.php?stylistID=".$user['user_id']);
        }

        if (!empty($_POST['profileImage'])){
            $pic = $_POST['profileImage'];
            $update_query = "UPDATE `stylists` SET `profile_image` = '$pic'  WHERE `stylist_id` = ".$user['user_id'];
            $retval = mysql_query( $update_query, $conn );
            if(! $retval ) { //if qurey execution didnt succeed
                die('Could not enter data: ' . mysql_error());
            }
            else header("Location: stylist.php?stylistID=".$user['user_id']);
        }
    }



    

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
<table>
    <form action="editProfile.php" method="post">
        <tr>
            <td>Description:</td><td><input type="text" name="description"></td>
            <td><input type="submit" name="submit" value="submit"></input></td>
        </tr>
    </form>
    <form action="editProfile.php" method="post">
        <tr>
            <td>Image:</td><td><input type="file" name="profileImage"></td>
            <td><input type="submit" name="submit" value="submit"></input></td>
        </tr>
    </form>
</table>
</body>
</html>