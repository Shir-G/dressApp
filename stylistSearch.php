<?php
    include 'user_config.php'; 

    $name = "";

    if(isset($_POST['name'])){
        $name = $_POST["name"];
    } 

    $search_query= mysql_query("SELECT * FROM users WHERE account_permissions = 'stylist' AND username like '%$name%'");
    if(mysql_num_rows($search_query) != 0){
        $search_rs = mysql_fetch_assoc($search_query);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Stylist</title>
</head>
<body>

    <section>
        <form method="post" action="stylistSearch.php">
            <input type="text" name="name" id="searchInputField" placeholder="Search for a Stylist" value="<?php echo $name; ?>">
            <button href="#" id="stylistSearchBtn">search</button>
        </form>
    </section>

    <section>
        <?php 
            if(mysql_num_rows($search_query)!=0){
                do {
        ?>
                    <section>
                        <p><?php echo $search_rs['username']; ?></p>
                        <!--<?php $row=mysql_query("SELECT `img` FROM `tbl_stylists_209` WHERE name = '$name'") ?> -->
                        <a href="stylist.php?stylistID=<?php echo $search_rs['user_id']; ?>">
                            <!-- <img src="<?php echo $search_rs['img']; ?>"> -->
                            go to stylist page
                        </a>
                    </section>
        <?php   
                } while ($search_rs=mysql_fetch_assoc($search_query));
                //mysql_free_result($search_rs);    
            }
            else{
                echo "No Results Found";
            }
            //mysql_free_result($result);   
        ?>
        
    </section>

</body>
</html>