<?php

// Add skill
if( isset($_GET['id']) ){

	$skill_id = (int)$_GET['id'];
	$res = qdm_skill_add($_SESSION['uid'], $skill_id);

	if( $res ) $res = qdm_minus_pts_skill($_SESSION['uid'], 1);
}


go_back();

?>