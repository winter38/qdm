<?php



function qdm_ores(){

	$res = array();
	$ar = array();
	$ar['name'] = 'Медь';
	$ar['item_id'] = 1; 
 	$ar['w'] = 100;
	$ar['c'] = 0.6;


	$res[] = $ar;


	$ar['name'] = 'Железистый кварцит';
	$ar['item_id'] = 2;
	$ar['w'] = 40;
	$ar['c'] = 0.4;


	$res[] = $ar;

	return $res;

}


function qdm_herbs(){

	$res = array();
	$ar = array();
	$ar['name'] = 'Листья черного чая';
	$ar['item_id'] = 1001; 
 	$ar['w'] = 100;
	$ar['c'] = 0.6;


	$res[] = $ar;


	$ar['name'] = 'Листя зеленного чая';
	$ar['item_id'] = 1002;
	$ar['w'] = 60;
	$ar['c'] = 0.4;


	$res[] = $ar;

	return $res;

}


function qdm_wood(){

	$res = array();
	$ar = array();
	$ar['name'] = 'бревно Сосны';
	$ar['item_id'] = 2001; 
 	$ar['w'] = 100;
	$ar['c'] = 0.6;


	$res[] = $ar;


	$ar['name'] = 'бревно Сосны';
	$ar['item_id'] = 2001;
	$ar['w'] = 60;
	$ar['c'] = 0.4;


	$res[] = $ar;

	return $res;

}


function qdm_select_prof_item($arr){

	$ci = count($arr);
	$total_weight = 0;
	$cum_weight = array();
	for( $i = 0; $i < $ci; $i++ ){ 

		$total_weight += $arr[$i]['w'];
		$cum_weight[] = $total_weight;

	}

	$select_ore = mt_rand(1,$total_weight);

	$ci = count($ci);
	$index = NULL;
	for( $i = $ci; $i > 0; $i-- ){ 
		
		if( $cum_weight[$i] >= $select_ore && $cum_weight[$i-1] < $select_ore ){
			$index = $i;
			break;
		}
		$index = 0;
	}
	$ore = $arr[$index];

	return $ore;
}


?>