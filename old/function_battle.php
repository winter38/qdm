<?php

include_once('config.php');
include_once('../lib/functions.php');

// qdm_versus()
//   rolls for 1 player
// parameters:
//   $p1 - array info of player 1
//   $p2 - array info of player 2
//   $log - log file
//
// return:
//   -

//
// dependancies:

function qdm_versus($p1, $p2, $log){

    $cfg = qdm_battle_config();

    $p1_stats = qdm_player_stats($p1['id']);
    $p2_stats = qdm_player_stats($p2['id']);
    // Random stuff ----------------------------------------------------------->
    $player = array(
        'id'     => $p1['id'],
        'name'   => $p1['name'],
        'hp'     => mt_rand(10, $cfg['hp'][mt_rand(1, $cfg['max_hp'])]) + $cfg['base_hp'] + 3*$p1_stats['con'],
        'armor'  => mt_rand(1, $cfg['max_armor']),
        'weapon' => mt_rand(1, $cfg['max_weapon']),
        'dex'    => $p1_stats['dex'],
        'str'    => $p1_stats['str'],
        'con'    => $p1_stats['con'],
        'miss'   => 0,
        'crit_count' => 0,
        'crit_dmg' => 0,
        'block'  => 0,
        'eva'    => 0,
        'hits'   => 0,
        'miss'   => 0,
        'dmg'    => 0,
        'init'   => mt_rand(1, 20) + $p1_stats['dex']

    );
    $player['max_hp'] = $player['hp'];

    $opponent = array(
        'id'     => $p2['id'],
        'name'   => $p2['name'],
        'hp'     => mt_rand(10, $cfg['hp'][mt_rand(1, $cfg['max_hp'])]) + $cfg['base_hp'] + 3*$p2_stats['con'],
        'armor'  => mt_rand(1, $cfg['max_armor']),
        'weapon' => mt_rand(1, $cfg['max_weapon']),
        'dex'    => $p2_stats['dex'],
        'str'    => $p2_stats['str'],
        'con'    => $p2_stats['con'],
        'miss'   => 0,
        'crit_count' => 0,
        'crit_dmg' => 0,
        'block'  => 0,
        'eva'    => 0,
        'hits'   => 0,
        'miss'   => 0,
        'dmg'    => 0,
        'init'   => mt_rand(1, 20) + $p2_stats['dex']
    );
    $opponent['max_hp'] = $opponent['hp'];
    // ------------------------------------------------------------------------>

    //$log .= '</div>';
    // ------------------------------------------------------------------------>
    //d_print_pre("{$p1['name']}({$player['max_hp']}) VS  {$p2['name']}({$opponent['max_hp']})");

    if( $player['init'] > $opponent['init'] ){
        $first_name = $player['name'];
        $second_name = $opponent['name'];
    }
    else{
        $first_name = $opponent['name'];
        $second_name = $player['name'];
    }
    $log['header'] = array();
    $log['header'][$p1['id']]['armor']  = $player['armor'];
    $log['header'][$p2['id']]['armor']  = $opponent['armor'];
    $log['header'][$p1['id']]['weapon'] = $player['weapon'];
    $log['header'][$p2['id']]['weapon'] = $opponent['weapon'];
    $log['header'][$p1['id']]['hp']     = $player['max_hp'];
    $log['header'][$p2['id']]['hp']     = $opponent['max_hp'];
    // Battle ----------------------------------------------------------------->
    while( $opponent['hp'] > 0 && $player['hp'] > 0 ){

        $log_tmp = array();
        // Iniative - fist player hits
        if( $player['init'] > $opponent['init'] ){ qdm_battle_one_hit($player, $opponent, $log_tmp); }
        else{ qdm_battle_one_hit($opponent, $player, $log_tmp); }

        if( $opponent['hp'] <= 0 || $player['hp'] <= 0 ){ break; } // if player hp < 0 - end battle

        // Iniative - second player hits
        if( $player['init'] > $opponent['init'] ){ qdm_battle_one_hit($opponent, $player, $log_tmp); }
        else{ qdm_battle_one_hit($player, $opponent, $log_tmp); }
        $log['body'][] = $log_tmp;
    }
    // ------------------------------------------------------------------------>

    //d_echo('--------------');
    //d_echo($player);
    //d_echo($opponent);

    // save_battle($p1['id'], $p2['id'], $log, 'x'); // save log TODO - optimize log and log parser

    // save statistic data ---------------------------------------------------->

    // Player 1 --------------------------------------------------------->>
    $data = array();

    $data['crit']     =  $player['crit_count'];
    $data['evasion']  =  $player['eva'];
    $data['block']    =  $player['block'];
    $data['hits']     =  $player['hits'];
    $data['miss']     =  $player['miss'];
    $data['dmg']      =  $player['dmg'];
    $data['hp_lost']  =  $opponent['dmg'];
    $data['max_crit'] =  $player['crit_dmg'];

    // get player passive skills and incrise theit exp

    save_player_statistic($p1['id'], $data);
    // ------------------------------------------------------------------>>

    // Player 2 --------------------------------------------------------->>
    $data = array();

    $data['crit']     =  $opponent['crit_count'];
    $data['evasion']  =  $opponent['eva'];
    $data['block']    =  $opponent['block'];
    $data['hits']     =  $opponent['hits'];
    $data['miss']     =  $opponent['miss'];
    $data['dmg']      =  $opponent['dmg'];
    $data['hp_lost']  =  $player['dmg'];
    $data['max_crit'] =  $opponent['crit_dmg'];

    save_player_statistic($p2['id'], $data);
    // ------------------------------------------------------------------>>

    $p1_exp = calc_exp($p1['exp'], $p2['exp'], $player['dmg']);
    $p2_exp = calc_exp($p2['exp'], $p1['exp'], $opponent['dmg']);
    $p1_exp['id'] = $p1['id'];
    $p2_exp['id'] = $p2['id'];
        
    if(   $player['hp'] <= 0 ){ $p1_exp['win'] = 0; }
    else{ $p1_exp['win'] = 1; }
    if(   $opponent['hp'] <= 0 ){ $p2_exp['win'] = 0; }
    else{ $p2_exp['win'] = 1; }

    save_player_data($p1_exp);
    save_player_data($p2_exp);

    // update skill info -------------------------------->>
    $rounds = count($log['body']);
    
    $players = array();
    $players[] = $player;
    $players[] = $opponent;
    
    $cj = count($players);
    for( $j = 0; $j < $cj; $j++ ){
    
        $player_id = $players[$j]['id'];
        $weapon = $players[$j]['weapon'];
        $filter = "WHERE `player_id` = $player_id
                   AND `active` = 1";
        $active_skills = qdm_player_skills($filter);
        
        $ci = count($active_skills);
        
        
        for( $i = 0; $i < $ci; $i++ ){
    
            $skill_id = $active_skills[$i]['skill_id'];
            $exp  = $active_skills[$i]['exp'];
    
            switch($skill_id){
    
                case SKILL_ANATOMY:
                
                    $exp = $exp + 10;
                    qdm_skill_exp_update($player_id, $skill_id, $exp);
                    break;
                   
                case
                    DAGGER_MASTERY:
                    if( $weapon == 1 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
    
                case ST_SWORD_MASTERY:
                    if( $weapon == 2 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case SWORD_MASTERY:
                    if( $weapon == 3 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case AXES_MASTERY:
                    if( $weapon == 4 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case BASTARD_MASTERY:
                    if( $weapon == 5 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case UNARMED_MASTERY:
                    
                    $exp = $exp + $rounds;
                    qdm_skill_exp_update($player_id, $skill_id, $exp);
                    break;
    
                case BOW_MASTERY:
    
                    $exp = $exp + $rounds;
                    qdm_skill_exp_update($player_id, $skill_id, $exp);
                    break;
    
            }  // switch
        } // for( $i ...
    } // end for( $j = 0 ...
    // -------------------------------------------------->>
    $log['header'][$p1['id']]['dmg'] = $player['dmg'];
    $log['header'][$p2['id']]['dmg'] = $opponent['dmg'];
    $log['header'][$p1['id']]['exp'] = $p1_exp;
    $log['header'][$p2['id']]['exp'] = $p2_exp;

    // ------------------------------------------------------------------------>
    d_echo($log);
}


// qdm_versus_npc()
//   rolls for 1 player
// parameters:
//   $p1 - array info of player 1
//   $p2 - array info of npc
//   $log - log file
//
// return:
//   -

//
// dependancies:

function qdm_versus_npc($p1, $p2, $log){
    
    d_echo($p1);
    d_echo($p2);
    
    $cfg = qdm_battle_config();

    $p1_stats = qdm_player_stats($p1['id']);
    
    // Random stuff ----------------------------------------------------------->
    $player = array(
        'id'     => $p1['id'],
        'name'   => $p1['name'],
        'hp'     => mt_rand(10, $cfg['hp'][mt_rand(1, $cfg['max_hp'])]) + $cfg['base_hp'] + 3*$p1_stats['con'],
        'armor'  => mt_rand(1, $cfg['max_armor']),
        'weapon' => mt_rand(1, $cfg['max_weapon']),
        'dex'    => $p1_stats['dex'],
        'str'    => $p1_stats['str'],
        'con'    => $p1_stats['con'],
        'miss'   => 0,
        'crit_count' => 0,
        'crit_dmg' => 0,
        'block'  => 0,
        'eva'    => 0,
        'hits'   => 0,
        'miss'   => 0,
        'dmg'    => 0,
        'init'   => mt_rand(1, 20) + $p1_stats['dex']

    );
    $player['max_hp'] = $player['hp'];

    $opponent = array(
        'id'     => $p2['id'],
        'name'   => $p2['name'],
        'hp'     => mt_rand(10, $cfg['hp'][mt_rand(1, $cfg['max_hp'])]) + $cfg['base_hp'] + 3*$p2['con'],
        'armor'  => mt_rand(1, $cfg['max_armor']),
        'weapon' => mt_rand(1, $cfg['max_weapon']),
        'dex'    => $p2['dex'],
        'str'    => $p2['str'],
        'con'    => $p2['con'],
        'miss'   => 0,
        'crit_count' => 0,
        'crit_dmg' => 0,
        'block'  => 0,
        'eva'    => 0,
        'hits'   => 0,
        'miss'   => 0,
        'dmg'    => 0,
        'init'   => mt_rand(1, 20) + $p2['dex']
    );
    $opponent['max_hp'] = $opponent['hp'];
    // ------------------------------------------------------------------------>
    
    
    
    //$log .= '</div>';
    // ------------------------------------------------------------------------>
    //d_print_pre("{$p1['name']}({$player['max_hp']}) VS  {$p2['name']}({$opponent['max_hp']})");

    if( $player['init'] > $opponent['init'] ){
        $first_name = $player['name'];
        $second_name = $opponent['name'];
    }
    else{
        $first_name = $opponent['name'];
        $second_name = $player['name'];
    }
    $log['header'] = array();
    $log['header'][$p1['id']]['armor']  = $player['armor'];
    $log['header'][$p2['id']]['armor']  = $opponent['armor'];
    $log['header'][$p1['id']]['weapon'] = $player['weapon'];
    $log['header'][$p2['id']]['weapon'] = $opponent['weapon'];
    $log['header'][$p1['id']]['hp']     = $player['max_hp'];
    $log['header'][$p2['id']]['hp']     = $opponent['max_hp'];
    // Battle ----------------------------------------------------------------->
    while( $opponent['hp'] > 0 && $player['hp'] > 0 ){

        $log_tmp = array();
        // Iniative - fist player hits
        if( $player['init'] > $opponent['init'] ){ qdm_battle_one_hit($player, $opponent, $log_tmp); }
        else{ qdm_battle_one_hit($opponent, $player, $log_tmp); }

        if( $opponent['hp'] <= 0 || $player['hp'] <= 0 ){ break; } // if player hp < 0 - end battle

        // Iniative - second player hits
        if( $player['init'] > $opponent['init'] ){ qdm_battle_one_hit($opponent, $player, $log_tmp); }
        else{ qdm_battle_one_hit($player, $opponent, $log_tmp); }
        $log['body'][] = $log_tmp;
    }
    // ------------------------------------------------------------------------>

    //d_echo('--------------');
    //d_echo($player);
    //d_echo($opponent);

    // save_battle($p1['id'], $p2['id'], $log, 'x'); // save log TODO - optimize log and log parser

    // save statistic data ---------------------------------------------------->

    // Player 1 --------------------------------------------------------->>
    $data = array();

    $data['crit']     =  $player['crit_count'];
    $data['evasion']  =  $player['eva'];
    $data['block']    =  $player['block'];
    $data['hits']     =  $player['hits'];
    $data['miss']     =  $player['miss'];
    $data['dmg']      =  $player['dmg'];
    $data['hp_lost']  =  $opponent['dmg'];
    $data['max_crit'] =  $player['crit_dmg'];

    // get player passive skills and incrise theit exp

    save_player_statistic($p1['id'], $data);
    // ------------------------------------------------------------------>>

    // Player 2 --------------------------------------------------------->>
    $data = array();

    $data['crit']     =  $opponent['crit_count'];
    $data['evasion']  =  $opponent['eva'];
    $data['block']    =  $opponent['block'];
    $data['hits']     =  $opponent['hits'];
    $data['miss']     =  $opponent['miss'];
    $data['dmg']      =  $opponent['dmg'];
    $data['hp_lost']  =  $player['dmg'];
    $data['max_crit'] =  $opponent['crit_dmg'];
    // ------------------------------------------------------------------>>

    $p1_exp = calc_exp($p1['exp'], $p2['exp'], $player['dmg']);
    $p2_exp = calc_exp($p2['exp'], $p1['exp'], $opponent['dmg']);
    $p1_exp['id'] = $p1['id'];
    $p2_exp['id'] = $p2['id'];
        
    if(   $player['hp'] <= 0 ){ $p1_exp['win'] = 0; }
    else{ $p1_exp['win'] = 1; }
    if(   $opponent['hp'] <= 0 ){ $p2_exp['win'] = 0; }
    else{ $p2_exp['win'] = 1; }

    save_player_data($p1_exp);
    //save_player_data($p2_exp);

    // update skill info -------------------------------->>
    $rounds = count($log['body']);
    
    $players = array();
    $players[] = $player;
    
    $cj = count($players);
    for( $j = 0; $j < $cj; $j++ ){
    
        $player_id = $players[$j]['id'];
        $weapon = $players[$j]['weapon'];
        $filter = "WHERE `player_id` = $player_id
                   AND `active` = 1";
        $active_skills = qdm_player_skills($filter);
        
        $ci = count($active_skills);
        
        
        for( $i = 0; $i < $ci; $i++ ){
    
            $skill_id = $active_skills[$i]['skill_id'];
            $exp  = $active_skills[$i]['exp'];
    
            switch($skill_id){
    
                case SKILL_ANATOMY:
                
                    $exp = $exp + 10;
                    qdm_skill_exp_update($player_id, $skill_id, $exp);
                    break;
                   
                case
                    DAGGER_MASTERY:
                    if( $weapon == 1 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
    
                case ST_SWORD_MASTERY:
                    if( $weapon == 2 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case SWORD_MASTERY:
                    if( $weapon == 3 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case AXES_MASTERY:
                    if( $weapon == 4 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case BASTARD_MASTERY:
                    if( $weapon == 5 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case UNARMED_MASTERY:
                    
                    $exp = $exp + 10;
                    qdm_skill_exp_update($player_id, $skill_id, $exp);
                    break;
    
                case BOW_MASTERY:
    
                    $exp = $exp + 10;
                    qdm_skill_exp_update($player_id, $skill_id, $exp);
                    break;
    
            }  // switch
        } // for( $i ...
    } // end for( $j = 0 ...
    // -------------------------------------------------->>
    $log['header'][$p1['id']]['dmg'] = $player['dmg'];
    $log['header'][$p2['id']]['dmg'] = $opponent['dmg'];
    $log['header'][$p1['id']]['exp'] = $p1_exp;
    $log['header'][$p2['id']]['exp'] = $p2_exp;

    // ------------------------------------------------------------------------>
    d_echo($log);
}


function qdm_battle_config(){

    // Config --------------------------------------------------------------------->
    $weapons = array();
    $armor   = array();
    $hp      = array();
    $skill   = array();
    
    $cfg = array();
    
    $cfg['hp'][1] = 16; // more crit
    $cfg['hp'][2] = 16; // more crit
    $cfg['hp'][3] = 18; //
    $cfg['hp'][4] = 20; //
    $cfg['hp'][5] = 22; // - def?
    $cfg['max_hp'] = count($cfg['hp']);
    
    $armor[1] = 1; // mex
    $armor[2] = 2; // leather
    $armor[3] = 3; // chain shirt, +3dex
    $armor[4] = 4; // brigandine, +1 dex
    $armor[5] = 5; // fullplate, no dex
    $cfg['armor'] = $armor;
    $cfg['max_armor'] = count($armor);
    
    $cfg['weapon'][1] = 5;  // raipier   18-20   x2
    $cfg['weapon'][2] = 6;  // short sword 19-20 x2
    $cfg['weapon'][3] = 8;  // long sword 19-20  x2
    $cfg['weapon'][4] = 10; // bastard sword 19-20 x2
    $cfg['weapon'][5] = 12; // alebarda 20 x3
    $cfg['max_weapon'] = 5;
    
    $cfg['weapon_descr'][1] = 'СЂР°РїРёСЂРѕР№';  // raipier   18-20   x2
    $cfg['weapon_descr'][2] = 'РєРѕСЂРѕС‚РєРёРј РјРµС‡РµРј';  // short sword 19-20 x2
    $cfg['weapon_descr'][3] = 'РґР»РёРЅРЅС‹Рј РјРµС‡РµРј';  // long sword 19-20  x2
    $cfg['weapon_descr'][4] = 'РїРѕР»СѓС‚РѕСЂРЅРёРєРѕРј'; // bastard sword 19-20 x2
    $cfg['weapon_descr'][5] = 'Р°Р»РµР±Р°СЂРґРѕР№'; // alebarda 20 x3
    
    $cfg['armor_descr'][1] = 'СЂСѓР±Р°С€РєРµ';
    $cfg['armor_descr'][2] = 'РєРѕР¶Р°РЅРЅРѕР№ Р±СЂРѕРЅРµ';
    $cfg['armor_descr'][3] = 'РєРѕР»СЊС‡СѓР¶РЅР°СЏ СЂСѓР±Р°С€РєРµ';
    $cfg['armor_descr'][4] = 'РєРѕР»СЊС‡СѓРіРµ';
    $cfg['armor_descr'][5] = 'РїРѕР»РЅС‹С… Р»Р°С‚Р°С…';
    
    $cfg['crit_range'][1] = 18;
    $cfg['crit_range'][2] = 19;
    $cfg['crit_range'][3] = 19;
    $cfg['crit_range'][4] = 19;
    $cfg['crit_range'][5] = 20;
    
    $cfg['crit_mod'][1] = 2;
    $cfg['crit_mod'][2] = 2;
    $cfg['crit_mod'][3] = 2;
    $cfg['crit_mod'][4] = 2;
    $cfg['crit_mod'][5] = 3;
    
    $cfg['base_armor'] = 10;
    $cfg['base_hp'] = 10;
    // ---------------------------------------------------------------------------->
    
    return $cfg;
}


// qdm_battle_check_crit()
//   check critical for weapon
// parameters:
//   $hit - without mod
//   $weapon - weapon type
//   $dmg - damage value
//   $opp_defense - opponent defense
// return:
//   true/false (if true it will owerwrite damage value)


// dependancies:

function qdm_battle_check_crit($hit, $player, &$dmg, $opp_defense){

    $cfg = qdm_battle_config();

    $crit_range = $cfg['crit_range'][$player['weapon']];
    //if( $player['skill'] == 20 + $player['weapon'] ){ $crit_range = $cfg['skill'][$player['skill']]; } // imroved critical

    if( $hit >= $crit_range && $hit >= $opp_defense || $hit == 20 ){
        $confirm = mt_rand(1, 20);
        if( $confirm >= $opp_defense ){

            $dmg = $dmg * $cfg['crit_mod'][$player['weapon']];

            return true;
        }
    }

    return false;
}


// This part makes battle for all active players
function qdm_battle_players_duel($players){
    
    $ci = count($players);
    for( $i = 0; $i < $ci-1; $i++ ){
    
        for( $j = $i+1; $j < $ci; $j++ ){
            //$players[$i]
            //$players[$j]
            qdm_versus($players[$i], $players[$j], $log);
        }
    }
}

// -------------------------------------------->
// one_hit()
//   basic rolls for 1 player
// parameters:
//   $player - array
//   $opponent - array
// Array structure
//   $player['weapon']
//   $player['armor']
//   $player['hp']
// return:
//   -


// dependancies:

function qdm_battle_one_hit( &$player, &$opponent, &$log_file){

    $cfg = qdm_battle_config();

    $defense = $cfg['base_armor'] + $cfg['armor'][$opponent['armor']];
    $dmg = mt_rand(1, $cfg['weapon'][$player['weapon']]);
    $hit = mt_rand(1, 20);
    qdm_battle_log_hit($player, $opponent, $hit, $dmg, $log_file);
}


// qdm_battle_log_hit()
//   creates log
// parameters:
//   $player - array
//   $opponent - array
//   hit - dice value (with mod)
//   $file - string - add to the string
// return:
//


// dependancies:

function qdm_battle_log_hit(&$player, &$opponent, &$hit, &$dmg, &$file, $log_type = 0){

    global $msg;
    
    $cfg = qdm_battle_config();
    
    $del = ' ';
    $eva = 0;

    $defense   = $cfg['base_armor'] + $opponent['defense'] + $opponent['dex'];    // full def (eveision)
    $block_def = $cfg['base_armor'] + $opponent['defense'];                       // armor def
    $miss_def  = $cfg['base_armor'];                                              // base def

    if( $player['skill'] == 10 + $opponent['armor'] ){ $defense++; }            // armor skill (id 11+)

    $dmg  = floor( $dmg + $player['str']/2 );                                   // add str
    $crit = qdm_battle_check_crit($hit, $player, $dmg, $defense);

    $struct = array();
    $struct['atk']  = $player['id'];
    $struct['targ'] = $opponent['id'];

    if( $crit ){
        $player['crit_count']++;
        if( $dmg > $player['crit_dmg'] ) $player['crit_dmg'] = $dmg;
        $log_dmg = $dmg;
        $struct['crit'] = 1;
    }
    else{ $struct['crit'] = 0; }

    // d_print_pre($hit);
    $hit  = $hit + floor( $player['str']/2 );                                   // add str to hit
    if( $player['skill'] == $player['weapon'] ){ $hit++; }                      // weapon skill

    if( $hit >= $defense ){
        $opponent['hp'] = $opponent['hp'] - $dmg;
        $player['dmg'] += $dmg;

        $struct['dmg']  = $dmg;
        $msg_max_hit = count($msg['hit']);
        $msg_max_crit = count($msg['crit']);


        if( $crit ){  $struct['msg'] = mt_rand(0, $msg_max_crit);  }
        else{         $struct['msg'] = mt_rand(0, $msg_max_hit); }

        $player['hits']++;
    }
    else{

        if( $hit <= $miss_def ){

            $player['miss']++;
            $struct['dmg'] = -1;
        }
        elseif( $hit <= $block_def ){

            $opponent['block']++;
            $struct['dmg'] = -2;
        }
        else{
            $opponent['eva']++;
            $struct['dmg'] = -3;
        }

        $msg_max_miss = count($msg['miss']);
        $struct['msg'] = mt_rand(1, $msg_max_miss);

    }

    $file[] = $struct;
}


?>