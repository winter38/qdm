<?php

// Statistic

include_once('../lib/functions.php');
include_once('functions.php');
include_once('config.php');
include_once('msg.php');  // for logs

session_start();
qdm_auth(1);

$filter = 'ORDER BY `win` DESC';
$players = get_players($filter);



$htm = '';
$ci = count($players);

for( $i = 0; $i < $ci; $i++ ){

    if( !empty($players[$i]['avatar']) ){ $avatar = '<img src="'.$INFO['avatars'].$players[$i]['avatar'].'">'; }
    else{ $avatar = ''; }
    
    $tmp = '<div class="avatar">'.$avatar.'</div>';
    $name = '<div class="name_block">'.$players[$i]['name'].'</div>';
    $btls = '<div>Боев '.$players[$i]['btl_count'].'</div>';
    $wins = '<div>Побед '.$players[$i]['win'].'</div>';
    $info = '<div class="info_block">'.$name.$btls.$wins.'</div>';
   
    $htm .= '<div class="stat">' . $tmp . $info .'<div class="clear"></div></div>';


}

$html = '
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title></title>
  </head>
  <body>
    <div class="data">
    '.$htm.'
    </div>
  </body>
</html>';

echo $html;

?>