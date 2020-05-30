<?php

// check iuf player have item - and then sold sell it


$player = qdm_player($_SESSION['uid']);
$gold   = $player['gold'];

if( !isset($_GET['id']) ){
    echo json_encode(array('status' => 0));
    die;
}
$id = (int)$_GET['id'];

$item   = qdm_shop_item($id);

if( !$item['bonus'] ){
    echo json_encode(array('status' => 0));
    die;
}
qdm_player_item_count_update($player['id'], $id, -1);


$bonus = json_decode($item['bonus']);
foreach ($bonus as $property => $value){

    switch ($property) {
        case 'stamina':
            $player['stamina'] += $value;
            qdm_stamina_update($player);
            $res['status'] = 1;
            break;
        
        default:
            $res['status'] = 0;
            break;
    }

}

$stamina = qdm_stamina($player);
$res = array_merge($stamina, $res);

// $res = qdm_player_items_add($player['id'], $id, 1);
// qdm_gold_update($player['id'], -$item['price_max']);

// $res['status'] = 1;
$res = json_encode($res);
echo $res;


?>