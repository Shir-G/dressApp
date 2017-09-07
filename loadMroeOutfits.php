<?php 
    include 'connect.php';

    if (isset($_POST['load']) && isset($_POST['lastID']) && isset($_POST['stylist'])) {
        $limit = $_POST['load'];
        $lastID = $_POST['lastID'];
        $stylist = $_POST['stylist'];
        $result = array();

        //$load_query = "SELECT * FROM `outfits` WHERE `id` IN (".$array.") AND `id`<".$lastID." ORDER BY `outfits`.`id` DESC LIMIT ".$limit;
        $load_query = "SELECT * FROM `outfits` WHERE `stylist` = ".$stylist." AND `id` < ".$lastID." ORDER BY `outfits`.`id` DESC LIMIT ".$limit;
        $res = mysql_query($load_query);

        $rowCount = mysql_num_rows($res);
        if ($rowCount ==0) {
            $result['data'] = '<style type="text/css">
                                .loadBtn {
                                    display: none;
                                }
                              </style>';
        }
        else{

            $outfitsData = array();
            while ($loadMore = mysql_fetch_assoc($res)) {
                $data = '<a class="outfit col-6 col-md-4" id="outfit-id-' .$loadMore["id"] .'" href=""><img width=300 src='.$loadMore["img"] .' onclick="clickFunc('. $loadMore["id"] .')"></a>';
                array_push($outfitsData, $data);
                $lastID = $loadMore['id'];
            }
            
            $result['data'] = $outfitsData;
            $result['lastID'] = $lastID;
        }
        echo json_encode($result);

    }
 ?>