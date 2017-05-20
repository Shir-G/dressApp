<?php
    include 'user_config.php'; 

    $category = "";
    $isSearching = false;

    if(isset($_POST['category']) && !empty($_POST['category'])){
        $isSearching = true;
        $category = $_POST["category"];
        $search_query= mysql_query("SELECT * FROM outfits WHERE category = '$category'");
        if(mysql_num_rows($search_query) != 0){
            $search_rs = mysql_fetch_assoc($search_query);
        }
    } 
    if (isset($_POST['clear'])) {
        $isSearching = false;
    }

    $load_query = "SELECT * FROM `outfits` ORDER BY `outfits`.`id` DESC LIMIT 6";//select the latest outfits uploaded
    $res = mysql_query($load_query);

    $limit = 6; //number of items to reload each time

    
?>
<!DOCTYPE html>
<html>
<head>
    <title>Outfit Search</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="includes/script.js"></script>
</head>
<body>
    <h1>Outfit Search</h1>
    <a href="logout.php">Logout?</a><br>
    <a href="homepage.php">Homepage</a><br>
     <section>
        <form method="post" action="outfitSearch.php">
            <input type="text" name="category" id="searchInputField" placeholder="Search a Category" value="<?php echo $category; ?>">
            <button href="#" id="outfitSearchBtn">Search</button>
        </form>
        <?php if ($isSearching) { 
        ?>
        <form method="post" action="outfitSearch.php">
           <button id="clearSearch" name="clear">X</button> 
        </form>
        <?php } ?>
    </section>
    <section>

        <?php 
        if ($isSearching) {
            if(mysql_num_rows($search_query)!=0){
                do {
        ?>
                    <section>
                        <p><?php echo $search_rs['id']; ?></p>
                        <img src="<?= $search_rs['src']?>">
                    </section>
        <?php   
                } while ($search_rs=mysql_fetch_assoc($search_query));
                //mysql_free_result($search_rs);    
            }
            else{
                echo "No Results Found";
            }
            //mysql_free_result($result);
        }
        else {
            while ($load = mysql_fetch_assoc($res)) {
                echo $load['id']."<br>";
            }
        ?>
            <!-- <img src="<?= $load['img'] ?>"> -->
        <div  id="items"></div>
        
        <button class="loadBtn" type="submit" name='load' value=<?= $limit ?>>Load More</button>

        
        <?php
        }   
        ?>
        
    </section>
</body>
</html>