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

$data = qdm_log_history();
$res = '<div class="d_block_div"><table class="history_table"><tr class="header"><td class="history_h_id">ID боя</td><td class="history_h_atk">Атакующий</td><td class="history_h_def">Оппонент</td><td>Дата и время</td><td>Ссылка на бой</td></tr>';

$ci = count($data);

for( $i = 0; $i < $ci; $i++ ){ 
  if($i & 1) $res .= '<tr class="first">';
  else $res .= '<tr class="second">';
	$cur = $data[$i];

	$player    = qdm_player($cur['player_id']);
	$opponent  = qdm_player($cur['opponent_id']);
	$p_exp     = calc_level($player['exp']);
	$op_exp    = calc_level($opponent['exp']);

	$file_1 = $ui['path'] . '/' . $ui['avatars'] . $player['id'] . '.png';
	$file_2 = $ui['path'] . '/' . $ui['avatars'] . $opponent['id'] . '.png';
	$player_avatar = file_exists($file_1) ? '<img src="'.$ui['avatars'].$player['id'].'.png">' : '';
	$opponent_avatar = file_exists($file_2) ? '<img src="'.$ui['avatars'].$opponent['id'].'.png">' : '';

	$pl = '<div>' . $player['name'] . ' [<b>' . $p_exp['lvl'] . '</b>]</div>';
	//$pl .= '<div>' . $player_avatar . '</div>';

	$op = '<div>' . $opponent['name'] . ' [<b>' . $op_exp['lvl'] . '</b>]</div>';
	//$op .= '<div>' . $opponent_avatar . '</div>';

	$res .= '<td>' . $cur['id'] . '</td>'; // ид драки
	$res .= '<td class="history_td_name">' . $pl. '</td>';
	$res .= '<td class="history_td_name">' . $op . '</td>';
	$res .= '<td>' . date('d.m.Y h:m:s',$cur['date']) . '</td>';
	$res .= '<td><a href="history_log_by_id.php?id=' . $cur['id'] . '">посмотреть лог</a></td>';

	// player Avatar - <img src="'.$ui['avatars'].$player['id'].'.png">
	// opponent Avatar - <img src="'.$ui['avatars'].$opponent['id'].'.png">

	// Чтобы узнать уровнеь
	// $exp    = calc_level($player['exp']);
	// $exp['lvl']    - уровень игрока


	$res .= '</tr>';
}

$res .= '</table></div>';
echo($res);

echo html_footer();

?>