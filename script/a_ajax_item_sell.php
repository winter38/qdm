<?php

// check iuf player have item - and then sold sell it


$player = qdm_player($_SESSION['uid']);
$gold = $player['gold'];
$gold_add = 0;

if( !isset($_GET['id']) ){
    echo json_encode(array('gold' => 0));
    die;
}
$id = (int)$_GET['id'];


$item   = qdm_shop_item($id);
$p_item = qdm_player_item_by_id($player['id'], $id);

if( !$item || !$p_item ){
    echo json_encode(array('gold' => 0));
    die;
}

// take 1 item from player
$sell = qdm_player_item_count_update($player['id'], $id, -1);
if( $sell ){
    $gold_add = $item['price_min'];
    qdm_gold_update($player['id'], $gold_add);
}
$res['gold'] = $gold_add;
$res = json_encode($res);
echo $res;


?>