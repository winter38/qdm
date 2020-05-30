<?php

// get list of skill - what player can see
function skill_list($p1){
    $list = array();
    skill_dagger_mastery($list, $p1);
    skill_raiper_mastery($list, $p1);
    skill_short_sword_mastery($list, $p1);
    skill_long_sword_mastery($list, $p1);
    skill_bastard_mastery($list, $p1);
    skill_poleaxe_mastery($list, $p1);
}



// -------------------------------------------->
//  qdm_skill()
//    get info abaut skill
//  parameters:
//    $player - int - player id
//    $skill  - int - skill  id
//  notes:  -
//
// -------------------------------------------->
function qdm_skill($player, $skill = 0){

    global $db;
    $debug = 0;

    // 1-skill known
    // 2-class

    $filter = "where     player_id = '$player'";
    if( $skill ) $filter .= " and skill_id = '$skill'";

    $sqlq = "SELECT *
            FROM `qdm_skill_progress`
            $filter";

    $qresult = $db->query($sqlq);
    

    if (mysqli_num_rows($qresult) == 0) {
        return array();
    }

    $data = array();

    $q_data = mysqli_fetch_assoc($qresult);

    if( $debug ) d_echo($data, 'qdm_skill sql');

    return $q_data;
}


// -------------------------------------------->
//  qdm_skill_cfg()
//    get info abaut skill
//  parameters:
//    $player - int - player id
//    $skill  - int - skill  id
//  notes:  -
//
// -------------------------------------------->
function qdm_skill_cfg($skill, $level){

    global $db;
    $debug = 0;

    // 1-skill known
    // 2-class

    $sqlq = "SELECT *
            FROM qdm_skill_cfg
            where     skill_id = '$skill'
                  and skill_level <= $level
            order by skill_level";

    $qresult = $db->query($sqlq);
    
   
    if (mysqli_num_rows($qresult) == 0) {
        return array();
    }



    $data = array();
    while( $q_data = mysqli_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    if( $debug ) d_echo($sqlq);

    return $data;
}



// -------------------------------------------->
//  qdm_skill_add()
//    Add or activate skill
//  parameters:
//    $player - int - player id
//    $skill  - int - skill  id
//  notes:  -
//
// -------------------------------------------->
function qdm_skill_add($player, $skill = 0){

    global $db;
    $debug = 0;

    $filter = "where player_id = '$player' AND skill_id = $skill";
    $ts = time() + 300;

    if( qdm_skill($player, $skill) ){

        
        $sqlq = "UPDATE `qdm_skill_progress`
            set `active` = 1, `act_ts` = $ts 
            $filter";

        $qresult = $db->query($sqlq);
    }
    else{

        $sqlq = "INSERT
                 INTO `qdm_skill_progress`
                (`player_id`, `skill_id`, `active`, `act_ts`)
                VALUES($player, $skill, 1, $ts)";
        $qresult = $db->query($sqlq);
    }

    if( $debug ) d_echo($sqlq, 'qdm_skill sql');

    return $qresult;
}


// -------------------------------------------->
//  qdm_skill_deact()
//    Deactivate skill
//  parameters:
//    $player - int - player id
//    $skill  - int - skill  id
//  notes:  -
//
// -------------------------------------------->
function qdm_skill_deact($player, $skill = 0){

    global $db;
    $debug = 0;

    $filter = "where player_id = '$player' AND skill_id = $skill";
 
    $sqlq = "UPDATE `qdm_skill_progress`
        set `active` = 0
        $filter";

    $qresult = $db->query($sqlq);
   

    if( $debug ) d_echo($sqlq, 'qdm_skill sql');
    // die();
    return $qresult;
}

// -------------------------------------------->
//  qdm_skills_act()
//    get info abaut skill
//  parameters:
//    $player - int - player id
//    $skill  - int - skill  id
//  notes:  -
//
// -------------------------------------------->
function qdm_skills_act($player, $ts = 0){

    global $db;
    $debug = 0;

    // 1-skill known
    // 2-class

    $filter = "and act_ts < " . time();

    $sqlq = "SELECT *
            FROM qdm_skills s, qdm_skill_progress p
            where     p.player_id = '$player'
                  and s.id = p.skill_id
                  and p.active = 1
            ";
    if( $ts ) $sqlq .= $filter;

    $qresult = $db->query($sqlq);
    
   
    if (mysqli_num_rows($qresult) == 0) {
        return array();
    }



    $data = array();
    while( $q_data = mysqli_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    if( $debug ) d_echo($data, 'qdm_skill sql');

    return $data;
}



// -------------------------------------------->
//  qdm_skills()
//    get game skills
//  parameters:
//    $filter - custom filter
//  notes:  -
//
// -------------------------------------------->
function qdm_skills($class = 0){

    global $db;
    $debug = 0;

    // 1-skill known
    // 2-class

    $filter = "where class = '0' and class = '$class'";

    $sqlq = "SELECT *
            FROM `qdm_skills`
            $filter";

    $qresult = $db->query($sqlq);

    if (mysqli_num_rows($qresult) == 0) {
        return array();
    }

    $data = array();

    while( $q_data = mysqli_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    if( $debug ) d_debug($sqlq, 'qdm_skills sql');

    return $data;
}



function qdm_skills_can_learn($player){

    $class = 0;
    $skills = qdm_skills($class);
    $skills_id = array_keys($skills);
    $skill_index = array();


    $ci = count($skills);
    for( $i = 0; $i < $ci; $i++ ){ 
        $skill_index[$skills[$i]['id']] = $i ;
    }

    // Get skills of player class + no class
    // Add skill progress
    // Add calculated level
    // d_echo($player);

    $ci = count($skills);
    for( $i = 0; $i < $ci; $i++ ){ 

        $skill_info = qdm_skill($player['id'], $skills_id[$i]);
        $add_info = array();
        if( $skill_info ) $add_info = calc_level($skill_info['exp']);
        $skills[$i] = array_merge($skills[$i], $skill_info, $add_info);

        $skill = $skills[$i];
        // here we can check additional parameters
        // debug($skills[$i]);
        if( $skill['req'] ){
            // d_echo($player['skills'][$skill['req']]);
            // d_echo($skills[$i]);
            // player dont have required skills


            if( !isset($player['skills'][$skill['req']]) ){
                unset($skills[$i]);
                continue;
            }

            $index = $skill_index[$skill['req']];
            $cur = $skills[$index]; // requeried skill info
            if( !isset($cur['lvl']) ){
                unset($skills[$i]);
                continue;
            }

            if( $skill['req_level'] > $cur['lvl'] ){
                unset($skills[$i]);
                continue;
            }
            
            if( $cur['player_level'] > $player['lvl'] ){
                unset($skills[$i]);
                continue;
            }
        }
    }

    $skills = array_values($skills);
    return $skills;


}



// -------------------------------------------->
//  qdm_skill_update_exp()
//    update info about skill - exp
//  parameters:
//    $player_id - int - player id
//    $skill_id  - int - skill  id
//    $exp       - int - gained exp
//  notes:  -
//
// -------------------------------------------->
function qdm_skill_update_exp($player_id, $skill_id, $exp){

    global $db;
    $debug = 0;

    $info = qdm_skill($player_id, $skill_id);

    if( $info ){

        $exp = $exp + $info['exp'];
    }

    $sqlq = "UPDATE qdm_skill_progress
             set exp = $exp
             where     player_id = '$player_id'
                   and skill_id = $skill_id
            ";

    $qresult = $db->query($sqlq);

    if( $debug ) d_echo($sqlq, 'qdm_skill_update_exp sql');

    return $qresult;
}




?>