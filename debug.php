<?php

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
// --------------------------------------------->

echo html_header();
$a = '';
$grp[] = array(1);
$grp[] = array(0,2);
$grp[] = array(3);
$t1 = microtime();

$log = qdm_versus(array(1,2,5,6), $grp, 1);
d_echo(log_to_html($log));

$t2 = microtime();
$time = $t2-$t1;
d_debug($time, 'time ' . $time . ' s');
draw_debug();
unset($_SESSION['d']);


echo html_footer();
?>