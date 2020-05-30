<?php

// VS fight

if( isset($_GET['id']) ){

	$id = (int)$_GET['id'];

	// Update last time vs fight
	qdm_utc_vs_update($_SESSION['uid']);

	// Remove from list
	if( $id > 0 ) qdm_vs_remove($id);
	$players = array();
	$players[] = $_SESSION['uid'];
	$players[] = $id;



	// Indexes of players
	$grp = array();
	$grp[] = array(0);
	$grp[] = array(1);

	// sleep(60);
	$log = qdm_versus($players, $grp, 0);
	qdm_log_vs($log);
	// d_echo($_SERVER['HTTP_REFERER']);
	unset($_SESSION['last_log']);
	$_SESSION['last_log'] = $log;

	$player = qdm_player($_SESSION['uid']);
	$player['stamina'] = $player['stamina'] - 10;
	qdm_stamina_update($player);

}

ob_clean();
$link = $_SERVER['HTTP_REFERER'];
Header("Location:$link");
die;

?>