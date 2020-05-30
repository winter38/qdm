<?php

// Deactivate skill
if( isset($_GET['id']) ){
	$skill_id = (int)$_GET['id'];
	$res = qdm_skill_deact($_SESSION['uid'], $skill_id);
	if( $res ) qdm_add_pts_skill($_SESSION['uid'], 1);
}


go_back();

?>