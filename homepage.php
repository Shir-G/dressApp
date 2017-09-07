<?php
    include 'stylistConfig.php';

    if ($user['account_permissions'] == 'stylist') {

        $stylist_outfits_query = "SELECT `outfits` FROM stylists WHERE `stylist_id` ='". $user['user_id']."'";
        $outfits = mysql_result(mysql_query($stylist_outfits_query) ,0);
        $limit = 6;
        //$load_query = "SELECT * FROM `outfits` WHERE `id` IN (".$outfits.") ORDER BY `outfits`.`id` DESC LIMIT ".$limit;//select the latest outfits uploaded
        $load_query = "SELECT * FROM `outfits` WHERE `stylist`= ".$stylist['stylist_id']." ORDER BY `outfits`.`id` DESC LIMIT ".$limit;
        $res = mysql_query($load_query);
    }
    
     //number of items to reload each time
        $lastID='';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="includes/style.css">
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="includes/stylistHomepage.js"></script>
    <script src="includes/script.js"></script>
</head>
<body id="homepage_body">
<?php
    if (isset($_SESSION['register'])) {
?>
            <header>
                <a href="homepage.php"><h1>DressApp</h1></a>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </header>

            <main class="container">
                <section id="homepage_intro" >
                    <h2>Hey there <?= $user['username']; ?>,</h2>
                    <p  class="lead">Please Check out your email inbox, an Email was sent in order to verify your account.</p>
            </section>
            </main>
<?php
    }
    else if ($user['account_permissions'] == 'stylist') {
?>
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

        <main class="container">
            
            <section id="homepage_intro" >
                <h2>
                    Hey there <?= $user['username']; ?>. <small> Go ahead, do your thing. </small> 
                </h2>
            </section>
            

            <section >
                <form id="outfitForm" method="post" action="outfit.php">
                    <div class="row">
                <?php
                     while ($load = mysql_fetch_assoc($res)) {
                ?>
                        <a class="outfit col-6 col-md-4" id="outfit-id-<?= $load['id'] ?>" href=""><img width=300 src="<?= $load['img']; ?>"></a>
                <?php
                    $lastID = $load['id'];
                    }
                ?>
                        <div id="items"></div>
                    </div>
                     
                    <div id="loadbtn_section">
                        <button class="loadBtn btn btn-outline-secondary btn-lg" type="submit" name='load' value=<?= $limit ?> data-last-id="<?= $lastID ?>" data-stylist-id="<?= $stylist['stylist_id'] ?>">Load More</button>
                    </div>
                    <input type="hidden" id="outfitInput" name="outfit">
                </form>
            </section>

        </main>

            <!-- <br />Welcome <?= $user['username']; ?> 
            <br /><br />You are successfully logged in!
            <br /><br />
            <a href="logout.php">Logout?</a><br>
            <a href="stylistSearch.php">Search Stylist</a>
            <a href="outfitSearch.php">Search Outfit</a>
            <a href="likedOutfits.php">Liked Outfits</a>
            <?php 
            if ($user['account_permissions'] == "stylist") {
            ?>
                <a href="allItems.php">Create an Outfit</a>
                <a href="editProfile.php?stylistID="<?= $user['user_id']; ?>>Edit your profile details</a>
            <?php
            }
            ?>
            -->
           <!--  <h2>Search Item</h2>
            <form action="item.php" method="post">
                <input type="text" name="item_id" required></input>
                <input type="submit" name="submit" value="submit"></input>
            </form> 
            
            <a href="closet.php">See All Items in My Closet</a> -->

<?php
    }
    else{
?>

        <header>
            <a href="homepage.php"><h1>DressApp</h1></a>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </header>

        <main class="container">
            <section id="homepage_intro" >
                <h2>Hey there <?= $user['username']; ?>,</h2>
                <p  class="lead">Unfortunately, you will not be able to sign in.<br> In order to use this site you need to have "Stylist" permissions :(</p>
        </section>
        </main>
<?php
    }
?>

</body>
</html>