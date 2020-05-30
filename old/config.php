<?php


$INFO['sql_driver']			=	'mysql';
$INFO['sql_host']			=	'localhost';
$INFO['sql_database']			=	'winter';
$INFO['sql_user']			=	'winter';
$INFO['sql_pass']			=	'tgnsnm2012';
$mysql_connect = mysql_pconnect($INFO['sql_host'], $INFO['sql_user'], $INFO['sql_pass']);
$BD = mysql_select_db('winter', $mysql_connect);
mysql_query("SET NAMES utf8;");

$INFO['path']  = '/home/u44987/warwolfru/www/winterwolf/';

$INFO['cards']   = '/home/u44987/warwolfru/www/winterwolf/cards';
$INFO['fonts'] = '/home/u44987/warwolfru/www/winterwolf/lib/game/fonts';
$INFO['cads_img'] = '/cards/img_cards/';
$INFO['avatars'] = 'avatars/';
$INFO['skills'] = 'skills/';




// ids of skills
define('QDM_MAX_POINTS',     5);
define('SKILL_ANATOMY',    '1');
define('DAGGER_MASTERY',   '2');
define('ST_SWORD_MASTERY', '3');
define('SWORD_MASTERY',    '4');
define('AXES_MASTERY',     '5');
define('BASTARD_MASTERY',  '6');
define('UNARMED_MASTERY',  '7');
define('BOW_MASTERY',      '8');
//define('BOW_MASTERY',      '9');
define('SHIRT_ARM_MASTERY',      '11');
define('LEATHER_ARM_MASTERY',    '12');
define('CHN_SHIRT_ARM_MASTERY',  '13');
define('BRIGANDINE_ARM_MASTERY', '14');
define('FULLPLATE_ARM_MASTERY',  '15');

define('SHIELD_MASTERY',   '16');
define('DODGE_MASTERY',    '17');
//define('BOW_MASTERY',      '18');
//define('BOW_MASTERY',      '19');
define('DAGGER_FOCUS',       '20');
define('ST_SWORD_FOCUS',     '21');
define('SWORD_FOCUS',        '22');
define('AXES_FOCCS',         '23');
define('BASTARD_FOCUS',      '24');
define('UNARMED_FOCUS',      '25');
define('BOW_FOCUS',          '26');
?>