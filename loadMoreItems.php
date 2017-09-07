<?php 
    include 'connect.php';

    if (isset($_POST['limit']) && isset($_POST['offset']) && isset($_POST['category'])) {
        $limit = $_POST['limit'];
        //$lastID = $_POST['lastID'];
        $offset = $_POST['offset'];
        $categ = $_POST['category'];
        $categ = str_replace('&', '&amp;', $categ);
        $thinCateg = str_replace(array(' ', '&amp;'), '', $categ);
        //$result = array();

        $load_query = "SELECT * FROM `items3` WHERE item_type='".$categ."' LIMIT ".$limit." OFFSET ".$offset;
        //echo "<script>console.log(".$load_query.");</script>";
        $res = mysql_query($load_query)or die("Query not retrieved:  " .mysql_error());;

        $rowCount = mysql_num_rows($res);
        if ($rowCount < $limit) {
            echo '<style type="text/css">#btn_'.$thinCateg.' {
                                    display: none;
                                }
                              </style>';
        }
        //else{
            while ($loadMore = mysql_fetch_assoc($res)) {
                echo '<label class="itemcb" data-cat="'.$thinCateg.'">
                            <input type="checkbox" class="cb_item" name="items[]" value="'.$loadMore['item_id'].'">
                            <span class="item-checkbox-img"></span>
                            <img src="'.$loadMore['image'].'"  >
                        </label><?php $lastID = '.$loadMore['item_id'].' ?>';
                //array_push($outfitsData, $data);
                //$lastID = $loadMore['id'];
            }
            
            // $result['data'] = $outfitsData;
            // $result['lastID'] = $lastID;
        //}
        //echo json_encode($result);

    }
 ?>
