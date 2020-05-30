<?php

// check iuf player have item - and then sold sell it


$player = qdm_player($_SESSION['uid']);
$gold = $player['gold'];
$gold_add = 0;

if( !isset($_GET['id']) ){
    echo json_encode(array('status' => 0));
    die;
}
$id = (int)$_GET['id'];


$item   = qdm_shop_item($id);
if( !$item || !$item['price_max'] > $gold  ){
    echo json_encode(array('status' => 0));
    die;
}

$res = qdm_player_items_add($player['id'], $id, 1);
qdm_gold_update($player['id'], -$item['price_max']);

$res['status'] = 1;
$res = json_encode($res);
echo $res;



?>