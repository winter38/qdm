<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
ini_set('log_errors', 0);
include_once('config.php');
include_once('../lib/functions.php');

qdm_debug(1);

// -------------------------------------------->
//  calc_level()
//    calcs level and exp to next level
//  parameters:
//    $exp (int) - current experiance
//  return
//    array
//     ['lvl']      - int -  current level
//     ['to_level'] - int -  exp to next level
//  notes:  -
//
// -------------------------------------------->
function calc_level($exp){

    $level = 1;
    $to_level = 0;
    $exp_level = 0;

    if( !$exp ){ $exp = 1; } // if 0 - will tell us 0 level

    // calc level
    $ci = 10000; // max level -_-
    $i = 1;
    //for( $i = 1; $i < $ci; $i++ ){
    while( $exp_level < $exp ){
        $exp_level = ($i-1)*1000 + $exp_level;
        if( $exp_level >= $exp ){
            $level = $i - 1; // for current level
            break;
        }
        $i++;
    }
    
    
    $current_level_exp = 0;
    // calc exp
    $ci = $level + 1; // calc exp to next level
    for( $i = 1; $i < $ci; $i++ ){
        $current_level_exp = ($i-1)*1000 + $current_level_exp;
    }

    $to_level = $current_level_exp + $level*1000;
    $guage = round((($exp - $current_level_exp) / ($level*1000))*100); // procents

    $data = array();
    $data['lvl']      = $level;
    $data['exp']      = $exp;
    $data['to_level'] = $to_level;
    $data['progress'] = $guage;

    return $data;

}

// -------------------------------------------->
//  calc_exp()
//    calcs level and exp to next level
//  parameters:
//    $exp     (int) - current player experiance
//    $opp_exp (int) - current opponent experiance
//  return
//    (array) - gained exp info
//  notes:  -
//
// -------------------------------------------->
function calc_exp($exp, $opp_exp, $dmg){
    $p1 = calc_level($exp);
    $p2 = calc_level($opp_exp);

    $diff = ($p2['lvl'] - $p1['lvl'])/10;
    $experiance = round($dmg + $dmg*$diff);
    
    if( $experiance < 0 ) $experiance = 1;
    $exp_summ = $experiance + $exp;
    $p1_new = calc_level($exp_summ);
    
    $result = array();
    $result['exp'] = $experiance;
    $result['up']  = $p1_new['lvl'] - $p1['lvl'];
    $result['lvl']  =  $p1['lvl'];
    $result['new_lvl']  = $p1_new['lvl'];
    return $result;
}


// -------------------------------------------->
//  calc_skill_exp()
//    calcs level and exp to next level
//  parameters:
//    $exp     (int) - current player experiance
//    $opp_exp (int) - current opponent experiance
//  return
//    (array) - gained exp info
//  notes:  -
//
// -------------------------------------------->
function calc_skill_exp($exp){

    $level = 1;
    $to_level = 0;
    $exp_level = 0;

    if( !$exp ){ $exp = 1; } // if 0 - will tell us 0 level

    // calc level
    $ci = 10000; // max level -_-
    $i = 1;
    
    //for( $i = 1; $i < $ci; $i++ ){
    while( $exp_level < $exp ){
        $exp_level = ($i-1)*200 + $exp_level;
        if( $exp_level >= $exp ){
            $level = $i - 1; // for current level
            break;
        }
        $i++;
    }
    
    
    $current_level_exp = 0;
    // calc exp
    $ci = $level + 1; // calc exp to next level
    for( $i = 1; $i < $ci; $i++ ){
        $current_level_exp = ($i-1)*200 + $current_level_exp;
    }

    $to_level = $current_level_exp + $level*200;
    $guage = round((($exp - $current_level_exp) / ($level*200))*100); // procents

    $data = array();
    $data['lvl']      = $level;
    $data['exp']      = $exp;
    $data['to_level'] = $to_level;
    $data['progress'] = $guage;

    return $data;
}


// -------------------------------------------->
//  get_players()
//    get all player info
//  parameters:
//    $filter (string) - custom filter
//  notes:  -
//
// -------------------------------------------->
function get_players($filter = ''){

    $sqlq = "SELECT *
            FROM `qdm_players`
            WHERE active = 1
            $filter";


    $qresult = mysql_query($sqlq);
    if (mysql_num_rows($qresult) == 0) {
        return array();
    }

    $data = array();

    while( $q_data = mysql_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    return $data;
}

// -------------------------------------------->
//  get_npc()
//    get all npc info
//  parameters:
//    $filter (string) - custom filter
//  notes:  -
//
// -------------------------------------------->
function get_npc($filter = ''){

    $sqlq = "SELECT *
            FROM `qdm_npc`
            WHERE active = 1
            $filter";


    $qresult = mysql_query($sqlq);
    if (mysql_num_rows($qresult) == 0) {
        return array();
    }

    $data = array();

    while( $q_data = mysql_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    return $data;
}


// -------------------------------------------->
//  player_info()
//    get one player info
//  parameters:
//    $id - id of player
//  notes:  -
//
// -------------------------------------------->
function player_info($id){

    $sqlq = "SELECT *
            FROM `qdm_players`
            WHERE id = $id";

    $qresult = mysql_query($sqlq);
    $data = mysql_fetch_assoc($qresult);

    return $data;
}

// -------------------------------------------->
//  get_npc_info()
//    get npc info
//  parameters:
//    $filter (string) - custom filter
//  notes:  -
//
// -------------------------------------------->
function npc_info($id){

    $sqlq = "SELECT *
            FROM `qdm_npc`
            WHERE id = $id";


    $qresult = mysql_query($sqlq);
    $data    = mysql_fetch_assoc($qresult);

    return $data;
}


// qdm_auth()
//   check if user loged in
// parameters:
//   - 
// return:
//   - 
 
//   -
// dependencies:
//   -
function qdm_auth(){
    // if( !isset($_SESSION['uid']) ){ login(); }
} // qdm_auth

// qdm_debug()
//   check if user loged in
// parameters:
//   - 
// return:
//   - 
 
//   -
// dependencies:
//   -
function qdm_debug($status = 0){
    
    if( $status ){
        ini_set('display_errors',1);
        error_reporting(E_ALL|E_STRICT);
        ini_set('log_errors', 0);
    }
} // qdm_debug


// -------------------------------------------->
//  qdm_player_stats()
//    get one player stats
//  parameters:
//    $id - id of player
//  notes:  -
//
// -------------------------------------------->
function qdm_player_stats($id){

    $sqlq = "SELECT *
            FROM `qdm_player_stats`
            WHERE player_id = $id";

    $qresult = mysql_query($sqlq);
    $data = mysql_fetch_assoc($qresult);
    if( !$data ){

        qdm_default_stats($id);
        $qresult = mysql_query($sqlq);
        $data = mysql_fetch_assoc($qresult);
    }

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
function qdm_skills($filter = ''){

    $sqlq = "SELECT *
            FROM `qdm_skills`
            $filter";

    $qresult = mysql_query($sqlq);

    if (mysql_num_rows($qresult) == 0) {
        return array();
    }

    $data = array();

    while( $q_data = mysql_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    return $data;
}

// -------------------------------------------->
//  qdm_skill_info()
//    get game skills
//  parameters:
//    $skill_id - id of skill
//  notes:  -
//
// -------------------------------------------->
function qdm_skill_info($skill_id){

    $sqlq = "SELECT *
            FROM `qdm_skills`
            WHERE id = $skill_id";

    $qresult = mysql_query($sqlq);

    $data = array();

    $data = mysql_fetch_assoc($qresult);

    return $data;
}

// -------------------------------------------->
//  qdm_skill_exp_update()
//    update skill info
//  parameters:
//    $skill_id - id of skill
//  notes:  -
//
// -------------------------------------------->
function qdm_skill_exp_update($player_id, $skill_id, $exp){

    $sqlq = "UPDATE `qdm_skill_progress`
            SET exp = $exp
            WHERE skill_id = $skill_id
            AND player_id = $player_id";

    $qresult = mysql_query($sqlq);

    return $qresult;
}

// -------------------------------------------->
//  qdm_player_skills()
//    get player skills
//  parameters:
//    $id - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_player_skills($filter = ''){

    $sqlq = "SELECT *
            FROM `qdm_skill_progress`
            $filter";

    $qresult = mysql_query($sqlq);
    if( !$qresult ){
        return array();
    }

    $data = array();

    while( $q_data = mysql_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }

    return $data;
}


// -------------------------------------------->
//  qdm_status_skill()
//    get skill status
//  parameters:
//    $player_id - player id
//    $skill_id  - skill id
//  notes:  -
//
// -------------------------------------------->
function qdm_status_skill($player_id, $skill_id){

    $sqlq = "SELECT active FROM qdm_skill_progress
             WHERE player_id = $player_id
             AND skill_id = $skill_id";

    $qresult = mysql_query($sqlq);
    if($qresult){
        $data = mysql_fetch_assoc($qresult);
        $qresult = $data['active'];
    }
    return $qresult;
}
// -------------------------------------------->
//  qdm_deactivate_skill()
//    deactivete player skill
//  parameters:
//    $player_id - player id
//    $skill_id  - skill id
//  notes:  -
//
// -------------------------------------------->
function qdm_deactivate_skill($player_id, $skill_id){

    $player = player_info($player_id);
    $player['skills']++; // increase skill count

    // update player info
    $sqlq = "UPDATE `qdm_players`
            SET `skills` = {$player['skills']}
            WHERE id = $player_id";

        //d_print_pre($sqlq);

    $qresult = mysql_query($sqlq);

    if($qresult){

        // deactive skill
        $sqlq = "UPDATE `qdm_skill_progress`
                SET `active` = 0
                WHERE player_id = $player_id
                AND skill_id = $skill_id";

            //d_print_pre($sqlq);
        $qresult = mysql_query($sqlq);
    }

    return $qresult;

}


// -------------------------------------------->
//  qdm_activate_skill()
//    deactivete player skill
//  parameters:
//    $player_id - player id
//    $skill_id  - skill id
//  notes:  -
//
// -------------------------------------------->
function qdm_activate_skill($player_id, $skill_id){


    $player = player_info($player_id);
    if( $player['skills'] > 0 ){

        $player['skills']--; // increase skill count

        // update player info
        $sqlq = "UPDATE `qdm_players`
                SET `skills` = {$player['skills']}
                WHERE id = $player_id";



        // add or activate skill
        $qresult = mysql_query($sqlq);

        if($qresult){

            qdm_add_skill($player_id, $skill_id);

            $sqlq = "UPDATE `qdm_skill_progress`
                    SET `active` = 1
                    WHERE player_id = $player_id
                    AND skill_id = $skill_id";

            $qresult = mysql_query($sqlq);
        }

        return $qresult;
    }
    return false;
}


// -------------------------------------------->
//  qdm_add_skill()
//    add skill to player
//  parameters:
//    $player_id - player id
//    $skill_id  - skill id
//  notes:  -
//
// -------------------------------------------->
function qdm_add_skill($player_id, $skill_id){

    $sqlq = "SELECT * FROM qdm_skill_progress
             WHERE player_id = $player_id
             AND skill_id = $skill_id";

    $qresult = mysql_query($sqlq);
    $data = mysql_fetch_assoc($qresult);

    if( empty($data) ){
        $sqlq = "INSERT INTO qdm_skill_progress (player_id, skill_id, exp)
                 VALUES ($player_id, $skill_id, 0)";

        $qresult = mysql_query($sqlq);
    }
    return $qresult;
}


// -------------------------------------------->
//  qdm_default_stats()
//    insert default
//  parameters:
//    $id - id of player
//  notes:  -
//
// -------------------------------------------->
function qdm_default_stats($id){

    $sqlq = "INSERT INTO `qdm_player_stats` (`player_id`, `points`)
             VALUES ($id, " . QDM_MAX_POINTS . ");";

    $qresult = mysql_query($sqlq);

    return $qresult;
}


// -------------------------------------------->
//  qdm_add_stat()
//    add one stat
//  parameters:
//    $uid - id of player
//    $stat (string) - stat name (coloum name in table)
//  notes:  -
//
// -------------------------------------------->
function qdm_add_stat($uid, $stat){

    $player = qdm_player_stats($uid);

    if( $player['points'] > 0 ){

        $points = $player['points'];
        $atribut = $player[$stat];

        $points--;
        $atribut++;

        $stat = mysql_real_escape_string($stat);

        $sqlq = "UPDATE `qdm_player_stats`
            SET `points` = $points,
                `$stat`  = $atribut
            WHERE id = $uid";

        //d_print_pre($sqlq);

        $qresult = mysql_query($sqlq);
        //var_dump_pre($qresult);
    }
    //d_print_pre($player);
}


// -------------------------------------------->
//  qdm_minus_stat()
//    minus one stat
//  parameters:
//    $uid - id of player
//    $stat (string) - stat name (coloum name in table)
//  notes:  -
//  statistic must be on another table
//  skills and their exp on another
//
// -------------------------------------------->
function qdm_minus_stat($uid, $stat){

    $player = qdm_player_stats($uid);

    if( $player[$stat] > 0 ){

        $points = $player['points'];
        $atribut = $player[$stat];

        $atribut--;
        $points++;

        $stat = mysql_real_escape_string($stat);

        $sqlq = "UPDATE `qdm_player_stats`
            SET `points` = $points,
                `$stat`  = $atribut
            WHERE id = $uid";

        //d_print_pre($sqlq, 1);

        $qresult = mysql_query($sqlq);
    }
}

// -------------------------------------------->
//  save_battle()
//    check login
//  parameters:
//    $player_id (int)   - id of player
//    $opponent_id (int) - id of player
//    $full_log (string) - for log
//  notes:  -
//
// -------------------------------------------->
function save_battle($player_id, $opponent_id, $full_log, $short_log){

    $log = mysql_real_escape_string($full_log);
    $shortlog = mysql_real_escape_string($short_log);

    $date = time();
    // ------------------------------------------------------------------------>
    $sqlq = "INSERT INTO `qdm_battles` (`player_id`, `opponent_id`, `date`, `log`, `shortlog`) VALUES ($player_id, $opponent_id, $date, '$log', '$shortlog');";
    $qresult = mysql_query($sqlq);
}

// -------------------------------------------->
//  save_player_data()
//    save player statistic
//  parameters:
//    $data (array)   - data
//    $win (int)         - 1 - player win
//                         0 - player lose
//  notes:  -
//
// -------------------------------------------->
function save_player_data($data){
    
    if( !isset($data['id']) ){ return false; }
    
    $player_data = player_info($data['id']);
    $player_data['btl_count']++;
    
    if( $data['win'] ){ $player_data['win']++; }
    else{ $player_data['lose']++; }
    $exp = $player_data['exp'] + $data['exp'];
    
    // new level!!!
    if( $data['lvl'] < $data['new_lvl'] ){
    
        $stats  = qdm_player_stats($data['id']);
        $stats['points']++;
        
        $sqlq = "UPDATE `qdm_player_stats` SET
              points = {$stats['points']}
              WHERE id = {$data['id']};";

        // print_pre($sqlq);
        $qresult = mysql_query($sqlq);
        
        $player_data['skills']++;
    }
    
    // ------------------------------------------------------------------------>
    $sqlq = "UPDATE `qdm_players` SET
             `btl_count` = {$player_data['btl_count']},
             `win` = {$player_data['win']},
             `lose` = {$player_data['lose']},
             `exp` = $exp,
             `skills` = {$player_data['skills']}
              WHERE id = {$data['id']};";

    // print_pre($sqlq);
    $qresult = mysql_query($sqlq);
}


// -------------------------------------------->
//  save_player_one_battle_time()
//    save player statistic
//  parameters:
//    $player_id (int)   - player id
//  notes:  -
//
// -------------------------------------------->
function save_player_one_battle_time($player_id){
    
    $time = time() + 43200; // 12h delay
    $sqlq = "UPDATE `qdm_players` SET
            `one_battle_time` = $time
            WHERE id = $player_id";
    
    $qresult = mysql_query($sqlq);
    
    return $qresult;
}





// -------------------------------------------->
//  default_player_statistic()
//    create defaukt statistic record for player
//  parameters:
//    $id (int)   - id of player
//  notes: SETS: crit, evasion, block
//
// -------------------------------------------->
function default_player_statistic($id){

    $sqlq = "INSERT INTO `qdm_player_statistic`
            (`player_id`)
            VALUES ($id);";
    $qresult = mysql_query($sqlq);

    return $qresult;
}


// -------------------------------------------->
//  get_player_statistic()
//    get player statistic
//  parameters:
//    $id (int)   - id of player
//  notes:  -
//
// -------------------------------------------->
function get_player_statistic($id){

    // ------------------------------------------------------------------------>
    $sqlq = "SELECT *
             FROM qdm_player_statistic
             WHERE player_id = $id;";

    // print_pre($sqlq);
    $qresult = mysql_query($sqlq);
    $data    = mysql_fetch_assoc($qresult);

    if( !$data ){
        default_player_statistic($id);

        $qresult = mysql_query($sqlq);
        $data    = mysql_fetch_assoc($qresult);
    }

    return $data;
}



// -------------------------------------------->
//  save_player_statistic()
//    save player statistic
//  parameters:
//    $id (int)    - id of player
//    $data(array) - array of data
//  notes:  -
// (values - crit, eveision, block)
// -------------------------------------------->
function save_player_statistic($id, $data){

    if( !empty($data) ){

        $crit  = 0;
        $eva   = 0;
        $block = 0;
        $hits  = 0;
        $miss  = 0;
        $dmg   = 0;
        $hp_lost = 0;
        $max_crit = 0;

        $qdata = get_player_statistic($id);

        if( !empty($qdata) ){

            $crit  = $qdata['crit'];
            $eva   = $qdata['evasion'];
            $block = $qdata['block'];
            $hits  = $qdata['hits'];
            $miss  = $qdata['miss'];
            $dmg   = $qdata['dmg'];
            $hp_lost = $qdata['hp_lost'];
            $max_crit = $qdata['max_crit'];

        }else{ return false; }


        if( isset($data['crit']) )     $crit  = $crit   + $data['crit'];
        if( isset($data['evasion']) )  $eva   = $eva    + $data['evasion'];
        if( isset($data['block']) )    $block = $block  + $data['block'];
        if( isset($data['hits']) )     $hits  = $hits   + $data['hits'];
        if( isset($data['miss']) )     $miss  = $miss   + $data['miss'];
        if( isset($data['dmg']) )      $dmg   = $dmg    + $data['dmg'];
        if( isset($data['hp_lost']) )  $hp_lost = $hp_lost + $data['hp_lost'];
        if( isset($data['max_crit']) ){

            if( $max_crit < $data['max_crit'] )  $max_crit = $data['max_crit'];
        }

        // -------------------------------------------------------------------->
        $sqlq = "UPDATE `qdm_player_statistic` SET
                 `crit`    = $crit,
                 `evasion` = $eva,
                 `block`   = $block,
                 `hits`    = $hits,
                 `miss`    = $miss,
                 `dmg`     = $dmg,
                 `hp_lost` = $hp_lost,
                 `max_crit` = $max_crit
                  WHERE player_id = $id;";

        // print_pre($sqlq);
        $qresult = mysql_query($sqlq);
        // -------------------------------------------------------------------->
    }

    return $qresult;
}

// -------------------------------------------->
//  check_login()
//    checks login info
//  parameters:
//    $login    (sting) - login
//    $password (sting) - password
//  notes:  -
//
// -------------------------------------------->
function check_login($login, $password){

    $login = mysql_real_escape_string($login);

    $sqlq = "SELECT *
            FROM `qdm_players`
            WHERE login = '$login'";


    $qresult = mysql_query($sqlq);

    if( $qresult ){

        $q_data = mysql_fetch_assoc($qresult);
        // login exists
        if( $q_data ){
            // check password
            if( $password == $q_data['pwd'] ){ $_SESSION['uid'] = $q_data['id']; }
        }
    }
    $link = 'http://warwolf.org/winterwolf/qdm';
    Header("Location:$link");
}

// draw login form
function login(){

   $html =  '<html>
    <body>
    <form method="POST" action="login.php">
    <table>
      <tr>
        <td>Login</td>
        <td><input type="text" name="login"></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="send"></td>
      </tr>

    </table>
    </form>
    </body>
    </html>';

    echo $html;
    die();
}

// -------------------------------------------->
//  html_skill_table()
//    draw skill block
//  parameters:
//    $player_id - player id
//  notes:  -
//
// -------------------------------------------->
function html_skill_block($player_id){

    global $INFO;

    $html = '<table class="skill_table"><tr><td>';
    $html .= '<div class="skill_block_name sskills">Доступные умения</div><div class="hide">';
    
    $player = player_info($player_id);
    $filter = "WHERE `player_id` = $player_id";
    $skills = qdm_player_skills($filter);
    $ci = count($skills);
    $player_has = '0';
    for( $i = 0; $i < $ci; $i++ ){
        $player_has .= ',' . $skills[$i]['skill_id'];
    }
    
    $filter = "WHERE class = 0 AND req <= {$player['level']} AND id NOT IN ($player_has) ";
    $skills = qdm_skills($filter);
    
    $ci = count($skills);

    for( $i = 0; $i < $ci; $i++ ){

        $name = '<div class="skill_name">' . $skills[$i]['name'] . '</div>';
        if( $skills[$i]['img'] == '' ){ $img = $INFO['skills'] . 'empty.png'; }
        else{ $img = $INFO['skills'] . $skills[$i]['img']; }
        $skill_ico = '<div class="skill_ico"><img src="' . $img . '"></div>';
        $skill_ico = '<a title="' . $skills[$i]['descr'] . '" href="script.php?skill=s&id=' . $skills[$i]['id'] . '">' . $skill_ico . '</a>';

        $progress = '<div class="skill_exp">' .$skills[$i]['descr'] . '</div>';
        $block  = '<div class="skill_block">' . $skill_ico . $name . $progress . '<div class="clear"></div></div>';
        $html .= $block;
    }
    $html .= '</div></td>';
    
    
    $html .= '<td><div class="skill_block_name askills">Активные умения</div><div class="hide">';

    $filter = "WHERE `player_id` = $player_id
               AND `active` = 1";
    $active_skills = qdm_player_skills($filter);

    $ci = count($active_skills);

    for( $i = 0; $i < $ci; $i++ ){

        $skill = qdm_skill_info($active_skills[$i]['skill_id']);
        $level = calc_skill_exp($active_skills[$i]['exp']);
        $exp_block = '<div class="skill_exp_block">' . $level['exp'] . '/' . $level['to_level'] . '</div>';
        if( $skill['img'] === '' ){ $img = $INFO['skills'] . 'empty.png'; }
        else{ $img = $INFO['skills'] . $skill['img']; }
        $skill_ico = '<div class="skill_ico"><img src="' . $img . '"></div>';
        $skill_ico = '<a href="script.php?skill=s&id=' . $active_skills[$i]['skill_id'] . '">' . $skill_ico . '</a>';

        $name = '<div class="skill_name">' . $skill['name'] . ' (' . $level['lvl'] . ')</div><br>';
        $progress = '<div class="skill_exp"><div class="meter animate">
        <span style="width: '.$level['progress'].'%"><span></span></span></div></div>';
        $block = '<div class="skill_block">' . $skill_ico . $name . $progress . $exp_block . '<div class="clear"></div></div>';
        $html .= $block;
    }
    $html .= '</div></td>';


    $html .= '<td><div class="skill_block_name iskills">Неактивные умения</div><div class="hide">';

    $filter = "WHERE `player_id` = $player_id
               AND `active` = 0";
    $inactive_skills = qdm_player_skills($filter);

    $ci = count($inactive_skills);

    for( $i = 0; $i < $ci; $i++ ){
        
        $skill = qdm_skill_info($inactive_skills[$i]['skill_id']);
        $level = calc_skill_exp($inactive_skills[$i]['exp']);
        $name = '<div class="skill_name">' . $skill['name'] . ' (' . $level['lvl'] . ')</div><br>';

        $exp_block = '<div class="skill_exp_block">' . $level['exp'] . '/' . $level['to_level'] . '</div>';
        if( $skill['img'] === '' ){ $img = $INFO['skills'] . 'empty.png'; }
        else{ $img = $INFO['skills'] . $skill['img']; }
        $skill_ico = '<div class="skill_ico"><img src="' . $img . '"></div>';
        $skill_ico = '<a href="script.php?skill=s&id=' . $inactive_skills[$i]['skill_id'] . '">' . $skill_ico . '</a>';
        
        $progress = '<div class="skill_exp"><div class="meter animate">
        <span style="width: '.$level['progress'].'%"><span></span></span></div></div>';
        $block = '<div class="skill_block">' . $skill_ico . $name . $progress . $exp_block . '<div class="clear"></div></div>';
        $html .= $block;
    }
    $html .= '</div></td></tr></table>';

    return $html;
}



?>