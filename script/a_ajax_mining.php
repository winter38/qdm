<?php


$player = qdm_player($_SESSION['uid']);

$skill_id = S_PROF_MINER;
if( isset($player['skills'][$skill_id]) ){
   	
	$skill_info = calc_level($player['skills'][$skill_id]['exp']);

	$ores = qdm_ores();
	$ore  = qdm_select_prof_item($ores);
	$chance = mt_rand(1, 100);
	$bonus = $skill_info['lvl'];
	if( $chance > ((100-$ore['c']*100)+$bonus) ){
		$tmp = array();
		$tmp['msg'] = ' Вы добыли ' . $ore['name'];
		$tmp['date'] = date('d.m.Y H:m:s', time());
		$_SESSION['mining'][] = $tmp;
		qdm_player_items_add($player['id'], $ore['item_id'], 1);

		$exp = 50 + 30*(1 - $ore['c'])*$skill_info['lvl'];
		qdm_skill_update_exp($player['id'], $skill_id, $exp);
	}
	else{
		$tmp = array();
		$tmp['msg'] = 'Руда не найдена';
		$tmp['date'] = date('d.m.Y H:m:s', time());
		$_SESSION['mining'][] = $tmp;
		$exp = $skill_info['lvl']*10;
		qdm_skill_update_exp($player['id'], $skill_id, $exp);
	}

	// d_echo($_SESSION['mining']); die;
	qdm_statistic_update($player['id'], array('mining' => 1));

	$player['stamina'] = $player['stamina'] - 10;
	qdm_stamina_update($player);
	$stamina = qdm_stamina($player);
	$stamina['exp'] = $exp;
	$stamina['msg'] = $tmp['msg'];
	$stamina['date'] = $tmp['date'];
	$res = json_encode($stamina);
	echo $res;
}




?>