<?php


ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
ini_set('log_errors', 0);

// Main libriaries ----------------------------->
//include_once('../lib/functions.php');
include_once('config.php');
session_start();



inc_fl_lib('msg.php');
inc_fl_lib('php.php');
inc_fl_lib('html.php');
inc_fl_lib('lib.php');
inc_fl_lib('qdm/qdm_cfg.php');
inc_fl_lib('qdm/qdm_sql.php');
inc_fl_lib('qdm.php');
inc_fl_lib('skill.php');
inc_fl_lib('mining.php');
inc_fl_lib('shop.php');
// --------------------------------------------->

$_SESSION['debug'] = 1;
$_SESSION['d'] = array();
$t1 = microtime();

// Draw login page
if( !isset($_SESSION['uid']) ){ login(); }
echo html_header();


$player = qdm_player($_SESSION['uid']);

// Select page
$page = isset($_GET['s']) ? $_GET['s'] : 'main';
draw_ui($player, $page);

// //$one_battle_time = time(); 
// //$one_battle_time = date("H:i:s", $one_battle_time);

// // Single battle button
// //if( time() > $player['one_battle_time'] ){ $one_battle = '<a href="battle.php" class="but">Random fight</a>'; }
// //else{ $one_battle = '<span class="but">Left: ' . $one_battle_time . ' s</span>'; }


// //$active_skill_html = html_skill_block($player_id);

// // Draw page
// // page($player);


// // d_debug(skills_block());

// // session_destroy();

// // Engine test

// // $a = '';
// // $grp[] = array(7,8,9,10);
// // $grp[] = array(0,1);
// // $grp[] = array(2,3);
// // $grp[] = array(4,5,6);
// // $grp[] = array(11,12,13,14,15);
// // 
// // $char = qdm_versus(array(1,3,5,8,11,23,45,456,345,456,67,145,1456,1345,1456,137), $grp, $a);



$t2 = microtime();
$time = (float)$t2-(float)$t1;
d_debug($time, 'time ' . $time . ' s');
// d_mem();
// echo($char);
debug($player, 'Player');

draw_debug();
unset($_SESSION['d']);
echo html_footer();

// d_echo(17 % 3);
?>