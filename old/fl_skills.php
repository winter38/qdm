<?php

qdm_auth(1);

// skill_weapon_bonus()
//   add plaer skill weapon bonus
// parameters:
//   &$player_conf - array - player config
// return:
//   - 
 
//   -
// dependencies:
//   -
function skill_weapon_bonus(&$player_conf){
    
    $weapon_skill = 0; // initial bonus
    
    $filter = "WHERE skill_id = {$player_conf['weapon']}
               AND player_id = {$player_conf['id']}";
        
    $data = qdm_player_skills($filter); // player skills

    if( !empty($data) ){  
    
        $exp = $data[0]['exp'];
        $skill_data = calc_skill_exp($exp); // calc skill rank
        $weapon_skill = floor($skill_data['lvl'] / 2); // 2 per 1 dmg
        $player_conf['weapon_add'] = $player_conf['weapon_add'] + $weapon_skill;
    }
    
    
    // Check anatomy - rank 5 will give add dmg
    
    $filter = "WHERE skill_id = " . SKILL_ANATOMY . "
               AND player_id = {$player_conf['id']}";
        
    $data = qdm_player_skills($filter); // player skills

    if( !empty($data) ){  
    
        $exp = $data[0]['exp'];
        $skill_data = calc_skill_exp($exp); // calc skill rank
        $weapon_skill = $skill_data['lvl']; // 2 per 1 dmg
        
        if( $weapon_skill > 4 ){ $player_conf['weapon_add']++; }
    }
    
} // skill_weapon_bonus


// skill_armor_bonus()
//   add player skill armomr bonus
// parameters:
//   &$player_conf - array - player config
// return:
//   - 
 
//   -
// dependencies:
//   -
function skill_armor_bonus(&$player_conf){
    
    $armor_skill = 0; // initial bonus
    $armor_id = $player_conf['armor'] + 10;
    $filter = "WHERE skill_id = $armor_id
               AND player_id = {$player_conf['id']}";
    $data = qdm_player_skills($filter);
    
    if( !empty($data) ){  
    
        $exp = $data[0]['exp'];
        $skill_data = calc_skill_exp($exp);
        $armor_skill = $skill_data['lvl'];
        $player_conf['armor_add'] = $player_conf['armor_add'] + $armor_skill;
        
    }
} // skill_armor_bonus



// skill_hp_bonus()
//   add player hp anatomy bonus
// parameters:
//   &$player_conf - array - player config
// return:
//   - 
 
//   -
// dependencies:
//   -
function skill_hp_bonus(&$player_conf){
    
    $filter = "WHERE skill_id = " . SKILL_ANATOMY . "
               AND player_id = {$player_conf['id']}";
    $data = qdm_player_skills($filter);
    
    if( !empty($data) ){  
    
        $exp = $data[0]['exp'];
        $skill_data = calc_skill_exp($exp);
        $skill_rank = $skill_data['lvl'] * 2;
        $player_conf['hp'] = $player_conf['hp'] + $skill_rank;
        $player_conf['max_hp'] = $player_conf['max_hp'] + $skill_rank;
        
        
    }
} // skill_hp_bonus


// skills_update()
//   update player skills
// parameters:
//   $players
// return:
//   - 
 
//   -
// dependencies:
//   -
function skills_update($players, &$log){


    $cj = count($players);
    for( $j = 0; $j < $cj; $j++ ){
    
        $player_id = $players[$j]['id'];
        $weapon = $players[$j]['weapon'];
        $armor  = $players[$j]['armor'];
        $filter = "WHERE `player_id` = $player_id
                   AND `active` = 1";
        $active_skills = qdm_player_skills($filter);
        // TODO count rounds!
        if( !$log['header'][$j]['player'] ){ continue; }
        
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
                
                case
                    SHIRT_ARM_MASTERY:
                    if( $armor == 1 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
    
                case LEATHER_ARM_MASTERY:
                    if( $armor == 2 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case CHN_SHIRT_ARM_MASTERY:
                    if( $armor == 3 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case BRIGANDINE_ARM_MASTERY:
                    if( $armor == 4 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
                    
                case FULLPLATE_ARM_MASTERY:
                    if( $armor == 5 ){
                        $exp = $exp + $rounds;
                        qdm_skill_exp_update($player_id, $skill_id, $exp);
                    }
                    break;
    
            }  // switch
        } // for( $i ...
    } // end for( $j = 0 ...
} // skills_update





?>