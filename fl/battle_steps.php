<?php


// Use player skill - second breath
function qdm_skill_second_breath(&$p1, &$grp, $players, &$file){

    $msg    = array();
    $struct = array();
    $msg    = msg_fill($msg);

    $cfg    = qdm_config();
    $skills = &$p1['skills'];

    // Move to function before
    if( isset($skills[S_SECOND_BREATH]) ){
        if( $skills[S_SECOND_BREATH]['count'] && ($p1['hp']/$p1['max_hp']) < 0.5 ){

            $skill = &$skills[S_SECOND_BREATH];

            $min_range = $skill['min_range'];
            $max_range = $skill['max_range'];

            $skill['count']--;
            $hp = mt_rand($min_range, $max_range); // tmp

            $p1['hp']        += $hp;
            $skill['msg']     = mt_rand(0, count($msg['skill'][S_SECOND_BREATH]));
            $skill['action']  = S_SECOND_BREATH;
            $skill['player']  = $p1['index'];
            $skill['hp_heal'] = $hp;
            $skill['exp']    += $hp*40;

            $file[] = $skill;
        }
    }
}

// Use player skill - S_INTIMIDATE
function qdm_skill_intimidate(&$p1, &$grp, &$players, &$file){

    $msg    = array();
    $struct = array();
    $msg    = msg_fill($msg);

    $cfg    = qdm_config();
    $skills = &$p1['skills'];

    // Move to function before
    if( isset($skills[S_INTIMIDATE]) ){

        // 50% chance activate
        if( $skills[S_INTIMIDATE]['count'] && mt_rand(0, 1) ){

            $skill = &$skills[S_INTIMIDATE];

            $team = $players[$index]['team'];
            $tmp_grp = $grp;
            unset($tmp_grp[$team]); // Don`t count friendly team
            $opp_grp     = array_values($tmp_grp);

            $dice_ = mt_rand(1, 20);
            $bonus = floor($p1['cha']/3);
            $dice = $bonus + $dice_;
            $succ  = array();

            // check will of all opponents
            $ci = count($opp_grp);
            for( $i = 0; $i < $ci; $i++ ){ 
                
                $cj = count($opp_grp[$i]);
                for( $j = 0; $j < $cj; $j++ ){ 
                   
                    $opp_index = $opp_grp[$i][$j];
                    $opp = &$players[$opp_index];

                    $save = mt_rand(1, 20) + $opp['will'] + $pl['save'];

                    if( $dice > $save ){

                        $tmp = array();
                        $tmp['duration'] = 2;
                        $tmp['atk']   = $skill['power'];
                        $tmp['save']  = $skill['power'];
                        $opp['tmp'][] = $tmp;
                        $succ[] = $opp_index;
                    }
                }
            }

            $skill['count']--;
            if( count($succ) ) $skill['msg'] = mt_round(0, count($msg['skill'][S_INTIMIDATE]));
            else               $skill['msg'] = mt_round(0, count($msg['skill']['no_intimidate']));
            
            $skill['action']  = S_INTIMIDATE;
            $skill['dice']    = $dice_;
            $skill['bonus']   = $bonus;
            $skill['exp']    += $p1*5 + 10;
            $skill['player']  = $p1['index'];
            $skill['targer']  = $succ;
            $skill['bonus'][] = 'АТК ' . $skill['power'];
            $skill['bonus'][] = 'спасброски ' . $skill['power'];
      
            $file[] = $skill;
        }
    }
}

// Unset tmp effects
function qdm_tmp_effects(&$p1){

    $check = isset($p1['tmp']) && count($p1['tmp']);

    if( $check ){

        $ci = count($p1['tmp']);
        for( $i = 0; $i < $ci; $i++ ){

            if( $p1['tmp'][$i]['duration'] > 1 ) $p1['tmp'][$i]['duration']--;
            else unset($p1['tmp'][$i]);
        }

        $p1['tmp'] = array_values($p1['tmp']);
    }

    return true;
}

function qdm_grp_bonus(&$grp, &$players, &$file){

    $msg = msg_fill();
    $max_grp_msg = count($msg['grp']) - 1;

    $grp_bonus = false;
    $ck = count($grp);
    for( $k = 0; $k < $ck; $k++ ){

        $cur_grp = $grp[$k];
        $pl_live = count($cur_grp);
        if( $pl_live < 2 ) continue;

        for( $j = 0; $j < $pl_live; $j++ ){ 
            

            $tmp = array();
            $tmp['duration'] = 0;
            $tmp['atk'] = 1;
            $tmp['def'] = 1;

            $players[$cur_grp[$j]]['tmp'][] = $tmp;
        }

        $grp_log = array();
        $grp_log['action'] = -2; // buff
        $grp_log['players'] = $cur_grp;
        $grp_log['bonus'][] = 'АТК + 1';
        $grp_log['bonus'][] = 'КБ +1';
        $grp_log['msg']   = mt_rand(0, $max_grp_msg);

        $file[] = $grp_log;
    }
}

// sort players by initiative
function qdm_player_initiative(&$players){

    $ci = count($players);
    for( $i = 0; $i < $ci; $i++ ){
        $init_zero = ( $players[$i]['init'] < 10 ) ? '0' . $players[$i]['init'] : $players[$i]['init'];
        $init[$i] = $init_zero . '_' . $i;
    }
    rsort($init);

    return $init;
}

// Get random opponent
function qdm_find_opponent($players, $grp, $index){

    $team = $players[$index]['team'];
    $tmp_grp = $grp;
    unset($tmp_grp[$team]); // Don`t count friendly team
    $tmp_grp     = array_values($tmp_grp);
    $teams_count = count($tmp_grp)-1;
    $opp_grp     = mt_rand(0, $teams_count);
    $opp_count   = count($tmp_grp[$opp_grp])-1;
    $rnd         = mt_rand(0, $opp_count);
    $op_index    = $tmp_grp[$opp_grp][$rnd];

    return $op_index;
}

// Use player skill - S_CLERIC_HEAL
function qdm_cleric_heal(&$p1, &$players, &$grp){

    $msg    = array();
    $struct = array();
    $msg    = msg_fill($msg);

    $cfg    = qdm_config();
    $skills = &$p1['skills'];

    // Move to function before
    if( isset($skills[S_CLERIC_HEAL]) && mt_rand(0, 1) ){

        $skill = &$skills[S_CLERIC_HEAL];

        $min_range = $skill['min_range'];
        $max_range = $skill['max_range'];

        if( !$skills[S_CLERIC_HEAL]['count'] ) return false;

        // TODO: need to configure hp limit

        // Heal team
        $team = $grp[$p1['team']];
        $ci = count($team);

        if( !$ci ) return false;
        else{
            // find lowest hp
            $target = false;
            $life   = 1;

            for( $i = 0; $i < $ci; $i++ ){ 
                $pl = &$players[$team[$i]];
                $cur_life = $pl['hp']/$pl['max_hp'];
                if( $cur_life && $cur_life < 0.6 && $cur_life < $life ){
                    $target = $team[$i];
                    $life   = $cur_life;
                }
            }

            if( $target ){

                $pl = &$players[$target];
                $skill['count']--;
                $hp = mt_rand($min_range, $max_range); // tmp
                $pl['hp']        += $hp;
                $skill['action']  = S_CLERIC_HEAL;
                $skill['msg']     = mt_round(0, count($msg['skill'][S_CLERIC_HEAL]));
                $skill['player']  = $p1['index'];
                $skill['target']  = $targer;
                $skill['hp_heal'] = $hp;
                $skill['exp']    += $hp*40;

                $file[] = $skill;
                return true;
            }
        }
    }
    return false;
}

// Use player skill - S_CLERIC_GRP_HEAL
function qdm_cleric_grp_heal(&$p1, &$players, &$grp){

    $msg    = array();
    $struct = array();
    $msg    = msg_fill($msg);
    $cfg    = qdm_config();
    $skills = &$p1['skills'];

    if( isset($skills[S_CLERIC_GRP_HEAL]) && mt_rand(0, 1) ){

        $skill = &$skills[S_CLERIC_GRP_HEAL];

        $min_range = $skill['min_range'];
        $max_range = $skill['max_range'];

        if( !$skills[S_CLERIC_GRP_HEAL]['count'] ) return false;

        // TODO: need to configure hp limit

        // Heal team
        $team = $grp[$p1['team']];
        $ci = count($team);

        if( $ci < 2 ) return false;
        else{

            $target = false;
            $life   = 1;

            // just check if there are wounded ppl
            for( $i = 0; $i < $ci; $i++ ){ 
                $pl = &$players[$team[$i]];
                $cur_life = $pl['hp']/$pl['max_hp'];
                if( $cur_life && $cur_life < 0.6 && $cur_life < $life ){
                    $target = $team[$i];
                    $life   = $cur_life;
                    break;
                }
            }

            if( $target ){

                $skill['count']--;
                $hp = mt_rand($min_range, $max_range);
                $skill['action']  = S_CLERIC_GRP_HEAL;
                $skill['msg']     = mt_round(0, count($msg['skill'][S_CLERIC_GRP_HEAL]));
                $skill['player']  = $p1['index'];

                for( $i = 0; $i < $ci; $i++ ){ 
                    $pl = &$players[$team[$i]];

                    $pl['hp']          += $hp;
                    $skill['target'][]  = $team[$i];
                }

                $pl = &$players[$targer];
                
                $skill['hp_heal'] = $hp*$ci;
                $skill['exp']    += $hp*$ci;
                $struct['skill'][S_CLERIC_GRP_HEAL] = $skill;
                $file[] = $struct;
                return true;
            }
        }
    }
    return false;
}

function qdm_tmp_bonus_apply(&$p1){

    if( isset($p1['tmp']) ) return false;

    $ci = count($p1['tmp']);
    for( $i = 0; $i < $ci; $i++ ){ 
        
        $cur = $p1['tmp'][$i];
        
        $keys = array_keys($cur);

        $cj = count($keys);
        for( $j = 0; $j < $cj; $j++ ){ 
            
            $key = $keys[$i];
            switch( $key ) {
                case 'atk':  $p1['bonus']['atk'] += $cur[$key];  break;
                case 'def':  $p1['bonus']['def'] += $cur[$key];  break;
                case 'save': $p1['bonus']['save'] += $cur[$key];  break;
                default: break;
            }

        }

    }

}

?>