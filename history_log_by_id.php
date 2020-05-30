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

$id = (int)$_GET['id'];
$data = qdm_log_history_by_id($id);

$res = log_to_html($data['log'], 1);

d_block($res['t_log'], 'Общий лог', 0);
d_block($res['html'], 'Подробный лог');


echo html_footer();

?>