<?php
    include 'user_config.php'; 

    $category = "";

    if(isset($_POST['category'])){
        $category = $_POST["category"];
    } 

    $search_query= mysql_query("SELECT * FROM outfits WHERE category = '$category'");
    if(mysql_num_rows($search_query) != 0){
        $search_rs = mysql_fetch_assoc($search_query);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Outfit Search</title>
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
    </section>
    <section>
        <?php 
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
        ?>
        
    </section>
</body>
</html>