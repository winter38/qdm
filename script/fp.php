<?php

session_start();
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
ini_set('log_errors', 0);


// main script
include_once('../config.php');
inc_fl_lib('lib.php');
inc_fl_lib('qdm/qdm_cfg.php');
inc_fl_lib('qdm/qdm_sql.php');
inc_fl_lib('html.php');
inc_fl_lib('qdm.php');
inc_fl_lib('mining.php');
inc_fl_lib('player.php');
inc_fl_lib('skill.php');
inc_fl_lib('shop.php');

if( isset($_GET['s']) ){

	$script = 'a_' . $_GET['s'] . '.php';

	if( file_exists($script) ){

		include_once($script);
	}
}

?>