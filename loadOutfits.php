<?php 
    include 'connect.php';

    if (isset($_POST['limit'])) {
        $limit = $_POST['limit'];
        $load_query = "SELECT * FROM `outfits` ORDER BY `outfits`.`id` DESC LIMIT 6 OFFSET ";
        $res = mysql_query($load_query.$limit);

        $rowCount = mysql_num_rows($res);
        if ($rowCount < $limit) {
            echo '<style type="text/css">
                    .loadBtn {
                        display: none;
                    }
                  </style>';
        }

        while ($loadMore = mysql_fetch_assoc($res)) {
            // echo $loadMore['id']."<br>";
            echo '<a class="outfit" id="outfit-id-' .$loadMore["id"] .'" href=""><img width=300 src='.$loadMore["img"] .' onclick="clickFunc('. $loadMore["id"] .')"></a>';
            
        }
    }
 ?>