<?php
    include 'stylistConfig.php';

    $imgsrc = '';

    if ($stylist['profile_image'] != NULL) {
        $imgsrc = $stylist['profile_image'];
    }  
    else {
        $imgsrc = "http://www.dressapp.org/images/default-profile.png";
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body id="edit_profile">
    <header>
        <a href="homepage.php"><h1>DressApp</h1></a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="allItems.php">Create an Outfit</a>
            </li>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Options<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="editProfile.php?stylistID=<?= $user['user_id']; ?>">Edit your profile</a></li>
                    <li><a href="logout.php" class="nav-link">Logout</a> </li>
                </ul>
            </li>
            <li class="nav-item">
            <?php
                if ($stylist['profile_image'] != NULL) {
            ?>
                    <img src="<?= $stylist['profile_image'] ?>" class="img-responsive">
            <?php  
                }else{
            ?>
                    <img src="http://www.dressapp.org/images/default-profile.png" class="img-responsive">
            <?php
                }
            ?>
            </li>
            
        </ul>
    </header>
    <main>
        <div class="card">
            <img class="card-img-top" src="<?= $imgsrc ?>" alt="Card image cap">
            <div class="card-block">
                <h4 class="card-title">Little Bit About You..</h4>
                <p class="card-text"><?= $stylist['description'] ?></p>
            </div>
        </div>
        <table>
            <form action="uploadProfile.php" method="post" enctype="multipart/form-data">
                <tr>
                    <td>Description:</td><td><textarea rows="5" cols="50" name="description" class="form-control"></textarea></td>
                </tr>
                <tr>
                    <td>Image:</td><td><input type="file" name="profileImage"></td>
                </tr>
                <tr>
                    <td></td><td><input type="submit" name="submit" value="submit" class="btn btn-outline-secondary btn-lg"></input></td>
                </tr>
            </form>
        </table>
    </main>
</body>
</html>