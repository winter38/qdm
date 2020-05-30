<?php

// -------------------------------------------->
// $location - int - player current location
// -------------------------------------------->
function qdm_shop_list($location){

    global $db;
    $debug = 0;

    $sqlq = "SELECT *
            FROM `qdm_items`
            where shop_loc = $location";

    $qresult = $db->query($sqlq);

    $data = array();
    while ( $row = mysqli_fetch_assoc($qresult) ) {
        $data[] = $row;
    }

    return $data;
}


// -------------------------------------------->
// $id - int - item id
// -------------------------------------------->
function qdm_shop_item_price($id){

    global $db;
    $debug = 0;

    $sqlq = "SELECT price_min
            FROM `qdm_items`
            where id = $id";

    $qresult = $db->query($sqlq);
    $data = mysqli_fetch_assoc($qresult);
 
    return $data['price_min'];
}


// -------------------------------------------->
// $id - int - item id
// -------------------------------------------->
function qdm_shop_item($id){

    global $db;
    $debug = 0;

    $sqlq = "SELECT *
            FROM `qdm_items`
            where id = $id";

    $qresult = $db->query($sqlq);
    $data = mysqli_fetch_assoc($qresult);
 
    return $data;
}


?>
