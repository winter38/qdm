<?php


// -------------------------------------------->
//  qdm_player()
//    get one player info
//  parameters:
//    $id - id of player
//  notes:  -
//
// -------------------------------------------->
function qdm_player($id){

    global $db;
    $debug = 0;

    $sqlq = "SELECT *
            FROM qdm_players p, qdm_player_cfg c, qdm_player_statistic s
            WHERE     p.id = $id 
                  and c.player_id = p.id
                  and c.player_id = s.player_id
                  and p.id = s.player_id";

    $qresult = $db->query($sqlq);
    $data = mysqli_fetch_assoc($qresult);
    $data['id'] = $id;
    if( $debug ) d_debug($sqlq, 'qdm_player sql');
    if( $debug ) d_debug($data, 'player data');


    $data['b_str'] = $data['str'];
    $data['b_con'] = $data['con'];
    $data['b_dex'] = $data['dex'];

    $level = calc_level($data['exp']);
    $data = array_merge($data, $level);
    qdm_fill_skills($data);



    return $data;
}


// -------------------------------------------->
//  qdm_players()
//    get all player info
//  parameters:
//    $filter (string) - custom filter
//  notes:  -
//
// -------------------------------------------->
function qdm_players($filter = ''){

    global $db;

    $sqlq = "SELECT *
            FROM `qdm_players`
            WHERE active = 1
            $filter";


    $qresult = $db->query($sqlq);
    if (mysql_num_rows($qresult) == 0) {
        return array();
    }

    $data = array();

    while( $q_data = mysqli_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    return $data;
}


// -------------------------------------------->
//  qdm_player_items_add()
//    add items to player
//  parameters:
//    $filter (string) - custom filter
//  notes:  -
//
// -------------------------------------------->
function qdm_player_items_add($player_id, $item, $count){

    global $db;

    $sqlq = "SELECT *
             FROM `qdm_player_items`
             WHERE item_id = $item
             and   player_id = $player_id";
    $qresult = $db->query($sqlq);

    if( $qresult->num_rows ){

        $data = mysqli_fetch_assoc($qresult);
        $count += $data['count'];
        $sqlq = "UPDATE qdm_player_items
                 SET count = $count 
            WHERE item_id = $item
            and   player_id = $player_id";
       $qresult = $db->query($sqlq);

    }
    else{

        $sqlq = "INSERT  INTO qdm_player_items
                 (`count`, `item_id`, `player_id`) 
                 VALUES ($count, $item, $player_id)";


       $qresult = $db->query($sqlq);

    }

    return $data;
}


function qdm_player_items($player_id, $type = false){

    global $db;

    $filter = '';
    if( $type ) $filter = "and i.type='$type'";

    $sqlq = "SELECT *
             FROM `qdm_player_items` pi,
                  `qdm_items` i
             WHERE   pi.player_id = $player_id
               AND   pi.item_id = i.id
               $filter";
    $qresult = $db->query($sqlq);

    if( $qresult->num_rows ){

        $data = array();
        while( $q_data = mysqli_fetch_assoc($qresult) ) $data[] = $q_data;
        return $data;
    }
    else return array();    
}

function qdm_player_item_by_id($player_id, $item_id){

    global $db;

    $sqlq = "SELECT *
             FROM `qdm_player_items` pi,
                  `qdm_items` i
             WHERE   pi.player_id = $player_id
               AND   pi.item_id = i.id
               AND   i.id = $item_id";
    $qresult = $db->query($sqlq);

    if( $qresult->num_rows ){

        $data = mysqli_fetch_assoc($qresult);
        return $data;
    }
    else return array();    
}


// Change item count for given value (NOT SET IT)
function qdm_player_item_count_update($player_id, $item_id, $count){

    global $db;

    $item = qdm_player_item_by_id($player_id, $item_id);

    if( !$item && !$item['count'] ) return false;
    $count = $item['count'] + $count;
    if( $count < 0 ) $count = 0; 

    $sqlq = "UPDATE  qdm_player_items
             SET count = $count
             where item_id = $item_id
             AND player_id = $player_id";
    $qresult = $db->query($sqlq);

    return $qresult;
  
}


?>