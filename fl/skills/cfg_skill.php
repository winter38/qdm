<?php

define('S_SECOND_BREATH', 1); // второе дыхание
define('S_MIGHTY_BLOW',   2); // могучий удар
define('S_BATTLE_EXP',    3); // боевой опыт
define('S_ANATOMY',       4); // Анатомия
define('S_COOL_ACT',      5); // Пафос
define('S_INTIMIDATE',    6); // Запугивание

define('S_PROF_MINER',       100); // Шахтер
define('S_PROF_WOODCUTTER',  101); // Дровосек
define('S_PROF_HERBALIST',   102); // Травник
define('S_PROF_CHEF',        103); // Повар
define('S_PROF_ALCHEMY',     104); // Алхимик


define('S_CLERIC_HEAL',      1001); // Хил, поффесия клерик
define('S_CLERIC_GRP_HEAL',  1002); // Хил групповой, поффесия клерик


// Focus on weapon
define('S_WEP_DAGGER',       11);
define('S_WEP_SHORT_SWORD',  12);
define('S_WEP_RAPIER',       13);
define('S_WEP_LONG_SWORD',   14);
define('S_WEP_BASTARD',      15);
define('S_WEP_POLEAXE',      16);

define('S_ARM_1',         21);
define('S_ARM_2',         22);
define('S_ARM_3',         23);
define('S_ARM_4',         24);
define('S_ARM_5',         25);
define('S_ARM_6',         26);

/*
INSERT INTO `winter`.`qdm_skill_cfg` 
(`id`, `skill_id`, `skill_level`, `stat_name`, `stat_value`, `val_1`, `val_2`, `val_3`, `key_val_1`, `key_val_2`, `key_val_3`, `descr`) 
VALUES 
(NULL, '11', '5', '', '0', '1', '', '',  'wep_hit', '', '', 'Специализация: +1 дополнительная атака'), 
(NULL, '12', '5', '', '0', '1', '1', '', 'wep_atk', 'wep_dmg', '', 'Специализация: +1 к урону, + 1 к атаке'),
(NULL, '13', '5', '', '0', '2', '', '',  'wep_atk', '', '', 'Специализация: +2 к попаданию'), 
(NULL, '14', '5', '', '0', '2', '', '',  'wep_dmg', '', '', 'Специализация: +2 к урону'),
(NULL, '15', '5', '', '0', '2', '', '',  'wep_dmg', '', '', 'Специализация: +2 к урону'), 
(NULL, '16', '5', '', '0', '1', '5', '', 'wep_dmg', 'wep_crit_dmg', '', 'Специализация: +1 к урону, +5 к критическому урону');
*/


// $player - array - player structure
function skill_on_player_init(&$player){

	$cfg = qdm_config();
	$skills = &$player['skills'];

    $keys = array();
    $keys[] = S_WEP_DAGGER;
    $keys[] = S_WEP_SHORT_SWORD;
    $keys[] = S_WEP_RAPIER;
    $keys[] = S_WEP_LONG_SWORD;
    $keys[] = S_WEP_BASTARD;
    $keys[] = S_WEP_POLEAXE;

    $keys[] = S_ARM_1;
    $keys[] = S_ARM_2;
    $keys[] = S_ARM_3;
    $keys[] = S_ARM_4;
    $keys[] = S_ARM_5;
    $keys[] = S_ARM_6;

    // d_echo($player); die();

    $ci = count($keys);
    for( $i = 0; $i < $ci; $i++ ){ 
        $key = $keys[$i];
        if( isset($skills[$key]) ){

            $skill = &$skills[$key];
            $skill['exp'] += 10; // Basic exp per one battle

            if( isset($skill['retry']) ){
                if( $player['weapon'] !== $key ){
                    $player['weapon'] = mt_rand(1, count(qdm_cfg_wepons()));
                }
            }
        }
    }


    $key = S_ANATOMY;
	if( isset($skills[$key]) ){

        $skill = &$skills[$key];
        $skill['exp'] += 35;
    }

    $key = S_MIGHTY_BLOW;
	if( isset($skills[$key]) ){

        $skill = &$skills[$key];
        $cfg = qdm_skill($player['id'], $key);

        $player['dmg'] += $cfg['cfg_1'];
        $player['atk'] -= $cfg['cfg_1'];

        $skill['exp'] += 25;

    }

    // remove to function on_player_init change stats
    $key = S_BATTLE_EXP;
    if( isset($skills[$key]) ){

        $skill = &$skills[$key];
        $cfg = qdm_skill($player['id'], $key);

        $player['dodge'] += $cfg['cfg_1'];
        $player['atk']   -= $cfg['cfg_1'];

        $skill['exp'] += 25;
    }
}

?>