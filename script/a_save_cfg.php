<?php

// d_echo('test');
// d_echo($_SESSION);
// echo $_SERVER['DOCUMENT_ROOT'];

if( isset($_FILES['avatar']) ){
	$ext = strtolower(substr($_FILES['avatar']['name'],-3));
	$dir = $ui['path'] . '/' . $ui['avatars'];
	$name = $_SESSION['uid'] . '.png';
	
	// if( $ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' ){
	// 	if( $width > $max_width || $height > $max_height ){ 
	// 		$res = image_resize($move_to, $ext);
	// 		if( $res ) move_uploaded_file($_FILES['avatar']['tmp_name'], $move_to);
	// 	}
	// 	else move_uploaded_file($_FILES['avatar']['tmp_name'], $move_to);
	// }	

		
	// elseif( $ext == 'gif' ){ // gif no resize (may be animation)
	// 	list($width, $height) = getimagesize($file);
	// 	if( $width > $max_width || $height > $max_height ){ }
	// 	else{
	// 		move_uploaded_file($_FILES['avatar']['tmp_name'], $move_to);
	// 		image_resize($move_to, $ext);
	// 	}
	// }
	$res = ufsi_image_resize($_FILES['avatar']['tmp_name'], 100, 100, $dir, $name);

	// d_echo($res); die;
}

ob_clean();
$link = $_SERVER['HTTP_REFERER'];
Header("Location:$link");

?>