<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
ini_set('log_errors', 0);
include_once('../lib/functions.php');
include_once('functions.php');
include_once('functions_battle.php');
include_once('config.php');
include_once('msg.php');  // for logs

session_start();
d_echo($_SESSION);
if( !isset($_SESSION['uid']) ){ login(); }

$player_id = $_SESSION['uid'];
$player = player_info($player_id);
$stats  = qdm_player_stats($player_id);
// d_print_pre($player);

$exp = calc_level($player['exp']);
$level = $exp['lvl'];

$one_battle_time = $player['one_battle_time'] - time(); 
//$one_battle_time = date("H:i:s", $one_battle_time);

// Single battle button
if( time() > $player['one_battle_time'] ){ $one_battle = '<a href="battle.php" class="but">Random fight</a>'; }
else{ $one_battle = '<span class="but">Left: ' . $one_battle_time . ' s</span>'; }

if( !empty($player['avatar']) ){ $avatar = '<img src="'.$INFO['avatars'].$player['avatar'].'">'; }
else{ $avatar = ''; }

$filter = 'WHERE class = 0';
$skills = qdm_skills($filter);

$html_skills = '';
$ci = count($skills);
for( $i = 0; $i < $ci; $i++ ){
    $html_skills.= $skills[$i]['descr'] . '<div><a class="skill" title="' . $skills[$i]['descr'] . '" href="script.php?skill=s&id=' . $skills[$i]['id'] . '">'. $skills[$i]['name'] .'</a></div>';
}

$active_skill_html = html_skill_block($player_id);


$html = '
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title></title>
    	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
	<script>
		$(function() {
			$(".meter > span").each(function() {
				$(this)
					.data("origWidth", $(this).width())
					.width(0);
			});
		});
		$(document).ready(function () {
    	    $(".askills").click(function () {
	        $(".askills + .hide").slideToggle("slow");	    
          })
    });
    $(document).ready(function () {
    	    $(".iskills").click(function () {
	        $(".iskills + .hide").slideToggle("slow");	    
          });
    });
    $(document).ready(function () {
    	    $(".sskills").click(function () {
	        $(".sskills + .hide").slideToggle("slow");	    
          });
    });
    
		var time = 500;
		$(function() {
			$(".meter > span").each(function() {
				 console.info("%s numbers %d, ","time",time)
				 time = time + 500
				$(this)
        .delay(time)
        .animate({
						width: $(this).data("origWidth")
					}, 1200);
			});
		});
	</script>
  </head>
  <body>
    <div class="data">
      <table><tr><td valign="top">
        <table class="player_info">
          <tr>
            <td class="avatar" rowspan="4"><div class="name">' . $avatar . '</div></td>
            <td><div class="name">'.$player['name'].' (' . $level . ') </div></td>
          </tr>
          <tr>
            <td class="td_meter"><div class="meter animate" style="width:auto"><span style="width: '.$exp['progress'].'%"><span></span></span></div></td>
          </tr>
          <tr>
            <td style="text-align:center; font-size: 10px;">'.$exp['exp'].'/'.$exp['to_level'].'</td>
          </tr>
          <tr>
            <td style="height: auto;">&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Боев</td>
            <td class="value"><div class="btl_count">'.$player['btl_count'].'</div></td>
          </tr>
          <tr>
            <td>Побед</td>
            <td class="value"><div class="win">'.$player['win'].'</div></td>
          </tr>
        </table>
        <table class="player_info">
          <tr>
            <td>Свободных очков</td>
            <td class="value"><div class="points">'.$stats['points'].'</div></td>
          </tr>
          <tr>
            <td>Сила</td>
            <td class="value"><div class="str">'.$stats['str'].'</div><a class="minus" href="script.php?a=m&stat=str"></a><a class="pluss" href="script.php?a=p&stat=str"></a></div></td>
          </tr>
          <tr>
            <td>Ловкость</td>
            <td class="value"><div class="dex">'.$stats['dex'].'</div><a class="minus" href="script.php?a=m&stat=dex"></a><a class="pluss" href="script.php?a=p&stat=dex"></a></div></td>
          </tr>
          <tr>
            <td>Телосложение</td>
            <td class="value"><div class="con">'.$stats['con'].'</div><a class="minus" href="script.php?a=m&stat=con"></a><a class="pluss" href="script.php?a=p&stat=con"></a></div></td>
          </tr>
          <tr>
            <td>Свободных умений</td>
            <td class="value"><div class="skills_left">'.$player['skills'].'</div></div></td>
          </tr>
          <tr>
            <td colspan="2" class="skill_list">'.$one_battle.'</td>
          </tr>
    
        </table>
      </td><td valign="top">
    ' . $active_skill_html . '
      </td></tr></table>
    </div>
    <div style="clear:both"></div>
  </body>
</html>';

echo $html;

//die();


//d_print_pre($cfg);
// Charactiristic
// weapon skills
// armor skills
// weapon skills ------->
// adds +1 to hit, for type of weapon

// function weapon_skill($skill_id){

// }

$msg = array();
$msg = msg_fill($msg);
$log = array();

//var_dump_pre($player);
// var_dump_pre('HP : ' . $player['hp']);
// var_dump_pre('hits : ' . $player['hits']);
// var_dump_pre('miss : ' . $player['miss']);
// var_dump_pre('Weapon : ' . $player['weapon']);

//var_dump_pre($opponent);
// var_dump_pre('HP : ' . $opponent['hp']);
// var_dump_pre('hits : ' . $opponent['hits']);
// var_dump_pre('miss : ' . $opponent['miss']);
// var_dump_pre('Weapon : ' . $opponent['weapon']);

 $cfg = qdm_battle_config();
 $players = get_players(); // players info
 // qdm_battle_players_duel($players);


?>
