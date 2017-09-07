<?php  
    include 'stylistConfig.php';

    $allCategories = array();
    $categoriesQuery = "SELECT `item_type` FROM `items3` ORDER BY `items3`.`item_type` ASC";
    $catRes = mysql_query($categoriesQuery) or die("Query not retrieved:  " .mysql_error());
    while ( $row = mysql_fetch_array($catRes, MYSQL_ASSOC)) {
        if(!empty($allCategories)){
            if (end($allCategories)!=$row['item_type']) {
                array_push($allCategories, $row['item_type']);
            }
        }
        else array_push($allCategories, $row['item_type']);
        
    }

    $allTheItems = array();
    foreach ($allCategories as $categ) {
        $limit = 10;
        $itemsQuery = "SELECT * FROM `items3` WHERE item_type='".$categ."' LIMIT ".$limit;
        $result = mysql_query($itemsQuery) or die("Query not retrieved:  " .mysql_error());
        

        $lastID = '';
        $offset = $limit;

        while ($itemrow = mysql_fetch_assoc($result)) {
            array_push($allTheItems, $itemrow);
        }
    }
    $category = NULL;

    /*$limit = 10;
    $itemsQuery = "SELECT * FROM `items3` ORDER BY `items3`.`item_type` ASC LIMIT ".$limit;//select the latest outfits uploaded
    $result = mysql_query($itemsQuery) or die("Query not retrieved:  " .mysql_error());
    $category = NULL;

    $lastID = '';
    $offset = $limit;*/
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Items</title>
    <link rel="stylesheet" href="includes/style.css">
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="includes/allItems.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body id="all_items_body">
    <header>
        <a href="homepage.php"><h1>DressApp</h1></a>
        <ul class="nav nav-pills">
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
    <form action="outfitEditor.php" method="post">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
            <ul class="nav nav-tabs">
    <?php
                foreach ($allCategories as $categoryNav) {
                    $thinCategory = str_replace(array(' ', '&amp;'), '', $categoryNav);
                    if ($categoryNav == $allCategories[0]) {
    ?>
                        <li class="active"><a href="#<?= $thinCategory ?>" data-toggle="tab" id="tab_<?= $thinCategory ?>"><?= $categoryNav ?><span class = "badge pull-right"></span></a></li>
    <?php
                    }
                    else{
    ?>
                        <li><a class="tab" href="#<?= $thinCategory ?>" data-toggle="tab" id="tab_<?= $thinCategory ?>"><?= $categoryNav ?><span class = "badge pull-right"></span></a></li>
    <?php 
                    }
                }
    ?>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
    <?php
                foreach ($allCategories as $categ){
                    $thinCateg = str_replace(array(' ', '&amp;'), '', $categ);
                    if ($categ == $allCategories[0]) {
    ?> 
                        <div class="tab-pane fade in active" id="<?= $thinCateg ?>">
    <?php
                    }
                    else{
    ?>
                        <div class="tab-pane fade" id="<?= $thinCateg ?>">
    <?php
                    }
    ?>
                            <section class="cat_<?= $thinCateg ?>">
    <?php
                            foreach ($allTheItems as $item){
                                if ($item['item_type'] == $categ){
    ?>
                                <label class="itemcb" data-cat="<?= $thinCateg ?>">
                                    <input type="checkbox" name="items[]" value="<?= $item['item_id'] ?>" class="cb_item">
                                    <span class="item-checkbox-img"></span>
                                    <img src="<?= $item['image'] ?>"  >
                                </label> 
    <?php
                            }
                        }
    ?>  
                            </section>
                            <br>
                                <button id="btn_<?= $thinCateg ?>" class="loadBtn btn btn-outline-secondary btn-lg" type="submit" name='load' value=<?= $limit ?> data-offset="<?= $offset ?>" data-cat="<?= $categ ?>">Load More</button>
                        </div>
    <?php
                }
    ?>
            </div>
        </div>
    </div>
<!--     <?php 
          foreach ($allCategories as $categ) {
              $category = $categ;
      ?>
              <h2><?= $categ ?></h2>
              <button id="btn_<?= $category ?>" class="loadBtn btn btn-outline-secondary btn-lg" type="submit" name='load' value=<?= $limit ?> data-last-id="<?= $lastID ?>" data-offset="<?= $offset ?>" data-cat="<?= $category ?>">Load More</button>
              <section class="cat_<?= $category ?>">
      <?php        
              foreach ($allTheItems as $item){
                  if ($item['item_type'] == $category) {
      ?>
      
                  <label class="itemcb">
                      <input type="checkbox" name="items[]" value="<?= $item['item_id'] ?>">
                      <span class="item-checkbox-img"></span>
                      <img src="<?= $item['image'] ?>"  >
                  </label>
      
      <?php
                  }
              }
      ?> 
              
              </section>
      <?php 
          } 
      ?>
              <button class="loadBtn btn btn-outline-secondary btn-lg btn-block" type="submit" name='load' value=<?= $limit ?> data-last-id="<?= $lastID ?>" data-offset="<?= $offset ?>" data-cat="<?= $category ?>">Load More</button>
             
              
          <br>-->
          <input type="submit" name="submit" value="submit" class="btn btn-lg "></input>         
    </form>        
</main>
</body>
</html>