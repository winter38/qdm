<?php

include_once('../lib/functions.php');
include_once('functions.php');
include_once('functions_battle.php');
include_once('config.php');
include_once('msg.php');  // for logs

qdm_debug(1);

// Find player equal by level
// else get npc
// Page must output battle log

session_start();
qdm_auth();

$res = '';

// TODO - make function!
if( isset($_SESSION['uid']) ){
    
    $uid = $_SESSION['uid'];
    $player = player_info($uid);
    
    // player battle time is right
    if( time() > $player['one_battle_time'] ){
    
        
        $filter = "AND level = {$player['level']}
                   AND id != $uid";
        $players = get_players($filter);
        
        // find player
        if( !empty($players) ){ 
            $ci = count($players); 
            $i = mt_rand(0, $ci);
            $opponent = $players[$i];
            
            $players = array();
            $players[] = $player;
            $players[] = $opponent;
            
            
            $log = array();
            $res = qdm_battle_players_duel($players);
        }
        // find npc
        else{
            
            $npc = get_npc();
           
            if( !empty($npc) ){ 
                $ci = count($npc)-1; 
                $i = mt_rand(0, $ci);
                
                $opponent = $npc[$i];

                $log = array();
                $res = qdm_versus_npc($player, $opponent, $log);

            }
        }
        // save_player_one_battle_time($uid);
    }
}


$html = '
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title></title>
    	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
  </head>
  <body>
  '.$res.'
  </body>
</html>';
echo($html);

?>