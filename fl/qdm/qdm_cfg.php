<?php 

// Cfg structures for engine
//
// wapaons
// hp
// armors
// user



// qdm_config()
//   base values
// parameters:
//   -
// return:
//   Array - structure
//      $player['weapon']
//      $player['armor']
//      $player['hp']
function qdm_config(){

    $res['armors'] = qdm_cfg_armors();
    $res['weapons'] = qdm_cfg_wepons();
    $res['hp'] = qdm_cfg_hp();
    $res['base_armor'] = 10;
    $res['base_hp']    = 20;

    return $res;
}


// qdm_cfg_wepons()
//   get info about weapons
// parameters:
//   $id - int - user id
// return:
//   array
function qdm_cfg_wepons(){

    $weps = array();

    $wep = array();
    $wep['id'] = 1;  // raipier   18-20   x2
    $wep['name'] = 'нож';
    $wep['dmg'] = 4;
    $wep['crit'] = 2;
    $wep['crit_range'] = 18;
    $weps[1] = $wep;

    $wep = array();
    $wep['id'] = 2;  // short sword 19-20 x2
    $wep['name'] = 'короткий меч';
    $wep['dmg'] = 6;
    $wep['crit'] = 2;
    $wep['crit_range'] = 19;
    $weps[2] = $wep;

    $wep = array();
    $wep['id'] = 3;  // short sword 19-20 x2
    $wep['name'] = 'рапира';
    $wep['dmg'] = 6;
    $wep['crit'] = 2;
    $wep['crit_range'] = 18;
    $weps[3] = $wep;

    $wep = array();
    $wep['id'] = 4;  // long sword 19-20  x3
    $wep['name'] = 'Длинный меч';
    $wep['dmg'] = 8;
    $wep['crit'] = 3;
    $wep['crit_range'] = 19;
    $weps[4] = $wep;

    $wep = array();
    $wep['id'] = 5;  // bastard sword 19-20 x2
    $wep['name'] = 'бастардный клинок';
    $wep['dmg'] = 10;
    $wep['crit'] = 2;
    $wep['crit_range'] = 19;
    $weps[5] = $wep;

    $wep = array();
    $wep['id'] = 6;  // alebarda 20 x3
    $wep['name'] = 'Алебарда';
    $wep['dmg'] = 12;
    $wep['crit'] = 3;
    $wep['crit_range'] = 20;
    $weps[6] = $wep;

    return $weps;
}


// qdm_cfg_hp()
//   get info about hps
// parameters:
//   $id - int - user id
// return:
//   array
function qdm_cfg_hp(){

    $hp = array();

    $hp[1] = 16; // more crit
    $hp[2] = 16; // more crit
    $hp[3] = 18; //
    $hp[4] = 20; //
    $hp[5] = 22; // - def?

    return $hp;
}


// qdm_cfg_wepons()
//   get info about armors
// parameters:
//   $id - int - user id
// return:
//   array
function qdm_cfg_armors(){

    $armors = array();

    $armor = array();
    $armor['id'] = 1;  // mex
    $armor['name'] = 'Рубашка';
    $armor['ac'] = 1;
    $armor['mod'] = 10;
    $armors[1] = $armor;

    $armor = array();
    $armor['id'] = 2;  // leather
    $armor['name'] = 'кожанный доспех';
    $armor['ac'] = 2;
    $armor['mod'] = 10;
    $armors[2] = $armor;

    $armor = array();
    $armor['id'] = 3;  // chain
    $armor['name'] = 'кольчуга';
    $armor['ac'] = 3;
    $armor['mod'] = 5;
    $armors[3] = $armor;

    $armor = array();
    $armor['id'] = 4;  // chain shirt
    $armor['name'] = 'кольчужная рубашка';
    $armor['ac'] = 4;
    $armor['mod'] = 4;
    $armors[4] = $armor;

    $armor = array();
    $armor['id'] = 5;  // brigandine
    $armor['name'] = 'панцырь';
    $armor['ac'] = 5;
    $armor['mod'] = 3;
    $armors[5] = $armor;

    $armor = array();
    $armor['id'] = 6;  // fullplate
    $armor['name'] = 'полный доспех';
    $armor['ac'] = 6;
    $armor['mod'] = 2;
    $armors[6] = $armor;

    return $armors;
}


// qdm_cfq_user()
//   create basic user structure
// parameters:
//   $id - int - user id
// return:
//   array
function qdm_cfq_user(){

    static $counter = 1;

    // Basic
    $char = array();
    $char['id']   = 0; // $p1['id'];
    $char['index'] = 0; // $p1['id'];
    $char['name'] = '';
    $char['type'] = 0;
    $char['team'] = 0;
    $char['init'] = 0;
    $char['exp']  = 0;

    

    $char['lvl']  = 1;
    $char['max_hp'] = 0;
    $char['hp']     = 0;
    $char['armor']  = 0;
    $char['dodge']  = 0;
    $char['sheld']  = 0;
    $char['nat_armor']  = 0; // natural armor
    $char['weapon'] = 0;
    $char['atk'] = 0;
    $char['dmg'] = 0;
    $char['armor_add'] = 0;
    $char['kills'] = array();
    $char['skills'] = array();
    

    // example
    // $char['skills'][1]['val_1'] = 1; 
    // $char['skills'][1]['exp']   = 1; // will be updated in DB
    // $char['skills'][1]['effect'] = array(); // affecting user structure
    // $char['skills'][1]['effect']['str'] = +1; // or -1

    // $char['skills'][$id]

    # summ
    # id level eff stat
    # 12     1   1  dex
    # 12     2   2  dex
    # 12     4   1  str

    $char['dex'] = 0;
    $char['str'] = 0;
    $char['con'] = 0;
    $char['stamina_max'] = 0;

    // Statistic
    $char['stat'] = array();
    $stat = &$char['stat'];

    $stat['miss'] = 0;
    $stat['crit_count']  = 0;
    $stat['crit_dmg'] = 0;
    $stat['block'] = 0;
    $stat['eva'] = 0;
    $stat['hits'] = 0;
    $stat['miss'] = 0;
    $stat['dmg'] = 0;
    $stat['hp_lost'] = 0;
    $stat['defended'] = 0;
    $stat['atacked'] = 0;

    $counter++;

    return $char;
}


?>