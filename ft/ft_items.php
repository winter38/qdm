<?php


function ft_items($player){

	global $ui;
	$res = '';
	$items = qdm_player_items($player['id']);
	$style = '';
	if( !$items ) $res .= '<div>Инвентарь пуст</div>';
	else{

		//$res .= '<table class="table_items">';
		//$res .= '<tr><th>I</th><th>Наименование</th><th>Количество</th></tr>';
		$ci = count($items);
		for( $i = 0; $i < $ci; $i++ ){ 

			$style .= '.item_'.$items[$i]['item_id'].'{background-image: url(' . $ui['items'] . $items[$i]['item_id'] . '.png);}';
			$title = $items[$i]['name'] . "\n" . $items[$i]['descr'];
			$res .= '<div class="div_items item_'.$items[$i]['item_id'].'" title="'. $title .'">';
			$res .= '<span class="div_items_count">'.$items[$i]['count'].'</span>';
			$res .= '</div>';
			// $res .= '<tr>';
			// $res .= '<td class="items_img"><img src="'. $ui['items'] . $items[$i]['item_id'] . '.png"></td>';
			// $res .= '<td>' . $items[$i]['name'] . '</td>';
			// $res .= '<td>' . $items[$i]['count'] . '</td>';
			// $res .= '</tr>';
		}
		//$res .= '</table>';
	}
	$style = '<style>' . $style . '</style>';
	$res = $style . '<div class="item_cont">' . $res . '<div class="clear"></div></div>';

	return $res;
}

?>