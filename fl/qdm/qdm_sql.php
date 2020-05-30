<?php

// Functions with sql - tmp
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

    global $db, $ui;

    $login = $db->real_escape_string($login);

    $sqlq = "SELECT *
            from  `qdm_players` p, qdm_players_security s
            where      p.login = '$login' 
                  and  s.id = p.id
                  and  s.status > 0";


    $qresult = $db->query($sqlq);

    if( $qresult ){

        $q_data = mysqli_fetch_assoc($qresult);

        // login exists
        if( $q_data ){
            // check password
            if( $password == $q_data['pwd'] ){ $_SESSION['uid'] = $q_data['id']; }
        }
    }

    $link = $ui['host'];
    header("Location:/qdm");
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

    global $db;
    $debug = 0;

    $player = qdm_player($uid);

    if( $player['pts_stat'] > 0 ){

        $points = $player['pts_stat'];
        $atribut = $player['b_' . $stat];

        $points--;
        $atribut++;

        $stat = $db->real_escape_string($stat);

        $sqlq = "UPDATE `qdm_player_cfg`
            SET `pts_stat` = $points,
                `$stat`  = $atribut
            WHERE player_id = $uid";

        //d_print_pre($sqlq);

        $qresult = $db->query($sqlq);

        if( $debug ) d_echo($sqlq);
        // die;
        //var_dump_pre($qresult);
    }
    
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

    global $db;
    $debug = 1;

    $player = qdm_player($uid);

    if( $player[$stat] > 0 ){

        $points = $player['pts_stat'];
        $atribut = $player['b_' . $stat];

        $atribut--;
        $points++;

        $stat = $db->real_escape_string($stat);

        $sqlq = "UPDATE `qdm_player_cfg`
            SET `pts_stat` = $points,
                `$stat`  = $atribut
            WHERE player_id = $uid";

        //d_print_pre($sqlq, 1);

        $qresult = $db->query($sqlq);

        if( $debug ) d_debug($sqlq, 'qdm_add_stat sql');
    }
}


function qdm_add_pts($uid, $count){

    global $db;
    $debug = 0;

    $player = qdm_player($uid);

    $points = $player['pts_stat'];
    $points += $count;

    $sqlq = "UPDATE `qdm_player_cfg`
        SET `pts_stat` = $points
        WHERE player_id = $uid";

    //d_print_pre($sqlq, 1);

    $qresult = $db->query($sqlq);

    if( $debug ) d_debug($sqlq, 'qdm_add_pts sql');
}

function qdm_add_pts_skill($uid, $count){

    global $db;
    $debug = 0;

    $player = qdm_player($uid);

    $points = $player['pts_skill'];
    $points += $count;

    $sqlq = "UPDATE `qdm_player_cfg`
        SET `pts_skill` = $points
        WHERE player_id = $uid";

    //d_print_pre($sqlq, 1);

    $qresult = $db->query($sqlq);

    if( $debug ) d_debug($sqlq, 'qdm_add_pts_skill sql');
}


function qdm_minus_pts_skill($uid, $count){

    global $db;
    $debug = 0;

    $player = qdm_player($uid);

    $points = $player['pts_skill'];
    $points -= $count;

    $sqlq = "UPDATE `qdm_player_cfg`
        SET `pts_skill` = $points
        WHERE player_id = $uid";

    //d_print_pre($sqlq, 1);

    $qresult = $db->query($sqlq);

    if( $debug ) d_debug($sqlq, 'qdm_add_pts_skill sql');
    return $qresult;
}



// -------------------------------------------->
//  qdm_vs_list()
//    get info abaut all battles
//  parameters:
//    -
//  notes:  -
//
// -------------------------------------------->
function qdm_vs_list(){

    global $db;
    $debug = 0;

    // 1-skill known
    // 2-class

    $sqlq = "SELECT *
            FROM qdm_vs";

    $qresult = $db->query($sqlq);
    
   
    if (mysqli_num_rows($qresult) == 0) {
        return array();
    }



    $data = array();
    while( $q_data = mysqli_fetch_assoc($qresult) ){
        $data[] = $q_data;
    }
    
    if( $debug ) d_echo($data, 'qdm_skill_cfg sql');
    
    return $data;
}


// -------------------------------------------->
//  qdm_vs_is_active()
//    check is current player is waiting vs battle
//  parameters:
//    $player_id - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_vs_is_active($id){

    global $db;
    $debug = 0;

    $sqlq = "SELECT *
            FROM qdm_vs
            where player_id = $id";

    $qresult = $db->query($sqlq);
    
   
    if (mysqli_num_rows($qresult) == 0) {
        return false;
    }

    $data =  mysqli_fetch_assoc($qresult);

    return $data;
}


// -------------------------------------------->
//  qdm_vs_remove()
//    remove yser from vs list
//  parameters:
//    $player - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_vs_remove($player_id = false ){

    global $db;
    $debug = 0;

    if( !$player_id ) $player_id = $_SESSION['uid'];

    $sqlq = "DELETE 
            FROM qdm_vs
            where player_id = $player_id";

    $res = $db->query($sqlq);

    return $res;
}


// -------------------------------------------->
//  qdm_vs_add()
//    add player to vs list
//  parameters:
//    $player - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_vs_add($player_id = false){

    global $db;
    $debug = 0;

    if( !$player_id ) $player_id = $_SESSION['uid'];

    $sqlq = "INSERT into qdm_vs
            (`player_id`, `ts`) VALUES
            ($player_id, 0)";

    $res = $db->query($sqlq);

    return $res;
}


// -------------------------------------------->
//  qdm_exp_update()
//    update player exp
//  parameters:
//    $player - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_exp_update($player_id, $exp ){

    global $db;
    $debug = 0;

    $sqlq = "UPDATE  qdm_players
            set exp = $exp
            where id = $player_id ";

    $res = $db->query($sqlq);

    return $res;
}

// -------------------------------------------->
//  qdm_gold_update()
//    update player exp
//  parameters:
//    $player - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_gold_update($player_id, $gold){

    global $db;
    $debug = 0;

    $cur = qdm_player($player_id);
    $gold = $gold + $cur['gold'];

    $sqlq = "UPDATE  qdm_players
            set gold = $gold
            where id = $player_id ";

    $res = $db->query($sqlq);

    return $res;
}


// -------------------------------------------->
//  qdm_utc_vs_update()
//    update player last time vs fight
//  parameters:
//    $player - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_utc_vs_update($player_id){

    global $db;
    $debug = 0;

    $sqlq = "UPDATE  qdm_player_cfg
            set utc_vs = ".time()."
            where player_id = $player_id";

    $res = $db->query($sqlq);

    return $res;
}


// -------------------------------------------->
//  qdm_stamina_update()
//    update player stamina
//  parameters:
//    $player - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_stamina_update($player){

    global $db;
    $debug = 0;
    $time = time();

    $sqlq = "UPDATE  qdm_player_cfg
            set stamina = ".$player['stamina'].",
            utc_stamina = $time
            where player_id = ".$player['id']."";

    $res = $db->query($sqlq);

    return $res;
}




// -------------------------------------------->
//  qdm_statistic_update()
//    update statistic
//  parameters:
//    $player - int - player id
//    $stat   - array - statisstic params
//  notes:  -
//
// -------------------------------------------->
function qdm_statistic_update($player_id, $stat){

    global $db;
    $debug = 0;

    $cur = qdm_player($player_id);
    

    $fields = '';
    
    $keys = array();
    $keys[] = 'crit';
    $keys[] = 'evasion';
    $keys[] = 'block';
    $keys[] = 'crit';
    $keys[] = 'hits';
    $keys[] = 'miss';
    $keys[] = 'dmg';
    $keys[] = 'hp_lost';
    // $keys[] = 'max_crit';
    $keys[] = 'win';
    $keys[] = 'kill';
    $keys[] = 'btl_count';
    $keys[] = 'mining';


    $ci = count($keys);
    for ($i = 0; $i < $ci; $i++) { 

        $key = $keys[$i];
        if( isset($stat[$key]) && isset($cur[$key]) ){
            $cur[$key] += $stat[$key];
            if( $fields ) $fields .= ", ";
            $fields .= "`$key` = " . $cur[$key] . " \n";
        }
    }

    if( isset($stat['max_crit']) && isset($cur['max_crit']) && $stat['max_crit'] > $cur['max_crit'] ){
        if( $fields ) $fields .= ", ";
         $fields .= "`max_crit` = " . $stat['max_crit'] . " \n";
    }
    
    $sqlq = "UPDATE  qdm_player_statistic
            SET $fields
            where player_id = $player_id ";
    // d_echo($sqlq);        die();
    $res = $db->query($sqlq);

    return $res;
}

// -------------------------------------------->
//  qdm_log_vs()
//    save log
//  parameters:
//    $player - int - player id
//  notes:  -
//
// -------------------------------------------->
function qdm_log_vs($log){

    global $db;
    $debug = 0;

    $players = $log['header']['pls'];
    $player = $players[0]['id'];
    $opp    = $players[1]['id'];
    $ts = time();

    $log = serialize($log);

    $log = $db->real_escape_string($log);
    $sqlq = "INSERT into qdm_battles
            (`player_id`, `opponent_id`, `date`, `log`) VALUES
            ($player, $opp, $ts, '$log')";

    $res = $db->query($sqlq);

    return $res;
}


// -------------------------------------------->
//  qdm_log_history()
//    show battle vs history
//  parameters:
//    -
//  notes:  -
//
// -------------------------------------------->
function qdm_log_history(){

    global $db;
    $debug = 0;

    // $log = serialize($log);

    $sqlq = "SELECT *
            FROM `qdm_battles`
            ORDER BY `date` DESC
            LIMIT 0 , 30";

    $qresult = $db->query($sqlq);
    if( $qresult->num_rows ){

        $data = array();
        while( $q_data = mysqli_fetch_assoc($qresult) ){
            $q_data['log'] = unserialize($q_data['log']);
            $data[] = $q_data;
            
        }
        return $data;
    }
    return array();
}


// -------------------------------------------->
//  qdm_log_history_by_id()
//    show battle vs history
//  parameters:
//    $id - int - log id
//  notes:  -
//
// -------------------------------------------->
function qdm_log_history_by_id($id){

    global $db;
    $debug = 0;

    $sqlq = "SELECT *
            FROM `qdm_battles`
            where id = $id";

    $qresult = $db->query($sqlq);
    $data = array();
    $data = mysqli_fetch_assoc($qresult);
    $data['log'] = unserialize($data['log']);

    return $data;
}



// -------------------------------------------->
//  qdm_log_history_by_id()
//    show battle vs history
//  parameters:
//    $id - int - log id
//  notes:  -
//
// -------------------------------------------->
function qdm_log_history_by_player($player_id){

    global $db;
    $debug = 0;
    $date = time() - 3600 * 24 * 7;
    $sqlq = "SELECT `id`, `date`
            FROM `qdm_battles`
            where opponent_id = $player_id
            and `date` > $date
            ORDER BY `date` DESC";

    $qresult = $db->query($sqlq);
    if( $qresult->num_rows ){

        $data = array();
        while( $q_data = mysqli_fetch_assoc($qresult) ){
            $data[] = $q_data;
        }
        return $data;
    }
    return array();
}




?>