<?php



function ft_cfg($player){
	page_cfg($player);

}



function page_cfg($player){

	global $ui;

	if( !empty($player['avatar']) ){ $avatar = '<img src="'.$ui['avatars'].$_SESSION['uid'].'.png">'; }
	else{ $avatar = ''; }
	$res = '';
	$res .= '<form action="script/fp.php?s=save_cfg" method="post" enctype="multipart/form-data">';
	$res .= '<div class="avatar_div upload_avatar_prev">' . $avatar . '</div>';
	
	$buf['name'] = 'avatar';
	$buf['style'] = 'margin: 5px 0;';
	$res .= i_html_field_file($buf);

	$res .= '<br>';

	$buf['value'] = 'Сохранить';
	$res .= i_html_but_submit($buf);
	$res .= '</form>';

	echo $res;
}

?>