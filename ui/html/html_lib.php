<?php

include_once 'html_elem.php';

// htmlescape()
//   escapes html
// parameters:
// return:        
//   $data - mixed(string/array) - html

//   -
function htmlescape($data){

  if( is_array($data) ){
      $ci = count($data);
      $keys = array_keys($data);
      for( $i = 0; $i < $ci; $i++ ){
          $key = $keys[$i];
          $data[$key] = i_htmlescape($data[$key]); 
      }
  }
  else{
      $data = htmlspecialchars($data, ENT_QUOTES);
  }
  return $data;
} // htmlescape

function check_debug(){

	if( isset($_SESSION['debug']) && $_SESSION['debug'] ) return true;
	else return true;
}


// d_debug()
//   echo variable in div
// parameters:
//   $val - mixed - value to output
//   $enable - enables output
// return:
//   output

function d_debug($val, $header = ''){ 

	if( !check_debug() ) return false;
	if( $header === '' ) $header = 'Блок ';

	echo '<div class="debug_div">';
	echo '<div class="debug_div_header plus">' . $header . '</div>';
	echo '<div class="debug_div_body" style="display: none;">';
	d_echo($val);
	echo '</div>';
	echo '</div>';
	echo '<div style="clear: both"></div>';
}

function debug($val){ 
	// $_SESSION['d'][] = $val; 
}

function draw_debug(){

	if( isset($_SESSION['d']) ){

		$ci = count($_SESSION['d']);
		for( $i = 0; $i < $ci; $i++ ){ 
			d_debug($_SESSION['d'][$i]);
		}
	}
}


// log_to_html()
//   echo variable in div
// parameters:
//   $val - mixed - value to output
//   $enable - enables output
// return:
//   output

function log_to_html($log){

	$players = $log['header']['players'];
	$teams = $log['header']['teams'];
	$cfg = qdm_config();
	$html = '';
	$res = '';
	$t_log = '';


	$ci = count($teams);
	for ($i=0; $i < $ci; $i++) { 
		
		$grp = '<div class="log_team_grp">';
		$tmp = '';

		$cur_team = $teams[$i];
		$cj = count($cur_team);
		$last = $cj - 1;


		$team_hp = 0;
		for ($j=0; $j < $cj; $j++) {
			$index = $cur_team[$j];
			$cur = $players[$index];
			$team_hp += $cur['max_hp'];


			// HTML of one player
			$div = $cur['hp'] / $cur['max_hp'];
			$div = round($div * 100);
			if( $div < 0 ) $div = 0;
			
			$hp = ' <span class="log_user_hp"><span class="log_user_hp_left">' . $cur['hp'] . '</span>/';
			$hp .= '<span class="log_user_max_hp">' . $cur['max_hp'] . '</span></span>';
			$meter = '<div class="hp_meter"><span class="filled" style="width: '.$div.'px;"><span>'.$hp.'</span></span></div>';

			$tmp .= '<div class="log_nick">' . $players[$index]['name'];
			$tmp .= '<span class="log_user_level">[' . $cur['lvl'] . ']</span>';
			
			$tmp .= $meter;
			$tmp .= '<span class="arms"> AC: ' . $cfg['armors'][$cur['armor']]['ac'] . '/' . $cfg['armors'][$cur['armor']]['mod'] .'</span>';
			$tmp .= '<div class="weps wep_' . $cur['weapon'] . '"></div>';
			// if( $j !== $last ) $tmp .= ',';
			$tmp .= '</div>'; 


			// Statistic
			$res .= '<div class="stat_block">';
			$res .= '<table class="stat_table"><tr>';
			$res .= '<td colspan="2">'.$players[$index]['name'] . '<span class="log_user_level">[' . $cur['lvl'] . ']</span>' . '</td>';
			$res .= '</tr><tr>';
			$acc  =  round( ($cur['stat']['hits'] / ($cur['stat']['miss'] + $cur['stat']['hits']))*100 );
			$crit_max = ( $cur['stat']['hits'] == 0 ) ? 1 : $cur['stat']['hits'];
			$crit =  round( ( ($cur['stat']['crit_count']) / $crit_max )*100 );
			$dodge = round( ( $cur['stat']['eva'] / $cur['stat']['defended']  )*100 );
			$res .= '<td>Точность:</td><td>' . $acc . '%</td>';
			$res .= '</tr><tr>';
			$res .= '<td>Крит:</td><td>' . $crit . '%</td>';
			$res .= '</tr><tr>';
			$res .= '<td>Уворот:</td><td>' . $dodge . '%</td>';
			$res .= '</tr><tr>';
			$res .= '<td>Выжил:</td><td>' . $cur['stat']['atacked'] . ' раундов</td>';
			$res .= '</tr><tr>';
			$res .= '<td>Выдержал:</td><td>' . $cur['stat']['defended'] . ' нападений</td>';
			$res .= '</tr><tr>';
			$res .= '<td>Успешно атаковал:</td><td>' . $cur['stat']['hits'] . '</td>';
			$res .= '</tr></table>';
			$res .= '</div>';

		}


		// Team html
		$grp .= '<div class="log_grp_name">Команда ' . ($i+1);
		$grp .= ' [<span class="log_grp_hp">' . $team_hp . '</span> hp]</div>';
		$grp .= $tmp;
		$grp .= '</div>';
		$html .= $grp;


		// Statistic
	}
	$html .= '<div style="clear: both"></div>';

	$stat = $res;
	// d_debug($res, 'Stat');

	$t_log .= '<table class="t_log">';
	$t_log .= '<tr class="header"><td>Атакующий</td><td>О</td><td>Урон</td><td>КБ</td><td>+Л</td><td>Защитник</td><td>ОЖ</td><td>А ур</td><td>З ур</td></tr>';
    $ci = count($log['body']);
	for ($i=0; $i < $ci; $i++) {

        $round = $i + 1;
        $html .= '<div class="log_round"><div class="log_round_header">Ход ' . $round . '</div><div style="padding-left: 15px">';
        
		$cj = count($log['body'][$i]);
		$t_log .= '<tr><td colspan="9" class="t_log_subheader">Ход ' . $round . '</td></tr>';
		for ($j=0; $j < $cj; $j++) { 

			$cur = $log['body'][$i][$j];
			$attacker = $players[$cur['p1']];
			$defender = $players[$cur['p2']];

			// d_echo($cur);

			$msg = msg_log($log['header'], $cur, $attacker['name'], $defender['name']);

			$int = ( $cur['dmg'] > 0 ) ? $cur['dmg'] : '';
		    if( $cur['crit'] ) $int = '<b>' . $int . '</b>';
		    $txt_dmg = '<span class="log_round_dmg"> -' .  $int  . '</span>';

			$t_log .= '<tr>';
			$t_log .= '<td>' .$attacker['name'] . '</td>';
			$t_log .= '<td>' .'<div class="weps wep_' . $attacker['weapon'] . '"></div>' . '</td>';
			$t_log .= '<td style="text-align:right">' . $txt_dmg . '</td>';
			$t_log .= '<td>' . '<span class="arms">' . $cfg['armors'][$defender['armor']]['ac'] .'</span>' . '</td>';
			$t_log .= '<td>' . '<span class="arms">' . $cfg['armors'][$defender['armor']]['mod'] .'</span>' . '</td>';
			$t_log .= '<td>' . $defender['name'] . '</td>';
			$t_log .= '<td style="text-align:right">' . '[<span class="log_round_hp_left">' . $cur['p2_hp'] . '</span>/<span class="log_round_max_hp">' . $cur['p2_max_hp'] . '</span>]'; '</td>';
			$t_log .= '<td style="text-align:right">' . '<span class="log_user_level">' . $attacker['lvl'] . '</span>' . '</td>';
			$t_log .= '<td style="text-align:right">' . '<span class="log_user_level">' . $defender['lvl'] . '</span>' . '</td>';
			$t_log .= '</tr>';

			$html .= $msg . '</br>';
		}

        $html .='</div></div>';
        
    }
    $t_log .= '</table>';
    // d_debug($t_log, 'Short log');

    $result = '';
    // d_echo($players);

    $ci = count($players);
    for ($i=0; $i < $ci; $i++) { 
    	$p = $players[$i];
    	if( $p['id'] == $_SESSION['uid'] ){

    		if( ($p['hp'] > 0) )$result .= '<div class="vs_res">Победа!</div>';
    		else $result .= '<div class="vs_res">Поражение!</div>';

    		$result .= '<div><span class="exp_earned">+'.$p['res']['exp_earned'].'</span> опыта</div>';
    		$result .= '<div><span class="gold_earned">+'.$p['res']['gold'].'</span> монет</div>';
    		$result .= '<div class="ch_i_delim"></div>';
    	}
    	else continue;
    }


    $buf = array();
    $buf['html']  = $html;
    $buf['stat']  = $stat;
    $buf['t_log'] = $t_log;
    $buf['res']   = $result; // log for player

	return $buf;
}


function tpl_but_a($link, $text = '', $class = '', $title = ''){

	if( $class ) $class = ' class="' . $class . '"';
	if( $title ) $title = ' title="' . $title . '"';
	$res = '<a href="'.$link.'"'. $class . $title .'>' . $text . '</a>';

	return $res;
}


// draw login form
function login(){

   $html  = html_header_login();
   $html .= '
    <div class="page">
    <div class="login">

    <form method="POST" action="script/fp.php?s=login">
    <table style="width: 300px; margin: auto;">
  
      <tr>
        <td style="width: 130px">Имя</td>
        <td><input type="text" name="login" class="text"></td>
      </tr>
      <tr>
        <td>Пароль</td>
        <td><input type="password" name="password" class="text"></td>
      </tr>
      <tr>
       
        <td colspan="2"><input type="submit" class="submit" value="Войти"></td>
      </tr>

    </table>
    </div>
    </div>
    </form>
    ' . html_footer();

    echo $html;
    die();
}



function html_header(){

	$html = '<!DOCTYPE HTML>
	<html>
	  <head>
	  <meta http-equiv="content-type" content="text/html; charset=utf8">
	  <title></title>
	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	  <script type="text/javascript" src="ui/scripts/lib.js"></script>
	  <script type="text/javascript" src="ui/scripts/jquery.jcountdown.min.js"></script>
	  <script type="text/javascript" src="ui/scripts/jquery.mousewheel.min.js"></script>
	  <script type="text/javascript" src="ui/scripts/jquery.mCustomScrollbar.js"></script>
	  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	  <link href="visual/style.css" type="text/css" rel="stylesheet">
	  </head>
	<body>';

	return $html;

}

function html_header_login(){

	$html = '<!DOCTYPE HTML>
	<html>
	  <head>
	  <meta http-equiv="content-type" content="text/html; charset=utf8">
	  <title></title>
	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	  <script type="text/javascript" src="ui/scripts/lib.js"></script>
	  <link href="visual/style.css" type="text/css" rel="stylesheet">
	  <link href="http://fonts.googleapis.com/css?family=Metal+Mania" rel="stylesheet" type="text/css">
	  </head>
	<body class="login_page">';

	return $html;

}

function html_footer(){

	$html = '</body></html>';

	return $html;

}

function html_arena(){

	$battles = qdm_vs_list();
	$res = '<div class="ui_block">';
	$script = 'script/fp.php?s=vs_sign';
	

	// Deleay for vs fights in indicator --------------------------------->
	$player = qdm_player($_SESSION['uid']);
	$delta = time() - $player['utc_vs'];
	$is_batle = ( $delta > 15*60 ) ? 1 : 0;
	$time_left = ( $delta < 15*60 ) ? 15*60 - $delta : 0;
	// ------------------------------------------------------------------->
	$time = time() - 3600 + $time_left; // WHY 1hour ofset???
	// d_echo($time_left);

	$format = date("m d, Y H:i:s", $time);
	$js = '
	<script>
	$(".countdown").countdown({
		htmlTemplate: "%y y, %m m, %d, %h : %i : %s",
		htmlTemplate: "%h : %i : %s",
		date: "'.$format.'",
		yearsAndMonths: true,
		servertime: function() { 
		    var time = null; 
		    $.ajax({url: "get_time.php", 
		        async: false, 
				dataType: "text", 
		        success: function( data, status, xhr ) {  
					time = data;
		        }, 
				error: function(xhr, status, err) { 
		            time = new Date(); 
					time = time.getTime();
		    	}
			});

		    return time; 
		},
		hoursOnly: false,
		onComplete: function( event ) {
			// alert("a");
			$(this).html("Готов к бою");
		},
		onPause: function( event, timer ) {

			$(this).html("Pause");
		},
		onResume: function( event ) {
		
			$(this).html("Resumed");
		},
		leadingZero: true
	});

</script>';

	$res .= '<div class="countdown"></div>' . $js;

	if( !$battles ){
		$res .= '<span class="arena_title">Арена пуста</span><div class="arena_div">';
		if( !qdm_vs_ia_active($_SESSION['uid']) ) $res .= '<div class="bts">' . tpl_but_a($script, '', 'swords', 'Выжидать противника') . '</div>';
	}
	else{

		$ci = count($battles);
		$res .= '<div class="ui_block"><span class="arena_title">Арена ('.$ci.')</span><div class="arena_div">';
		$res .= '<div class="arena_content">';
		if( !qdm_vs_ia_active($_SESSION['uid']) ) $res .= '<div class="bts">' . tpl_but_a($script, '', 'swords', 'Выжидать противника') . '</div>';
		
		for ($i = 0; $i < $ci; $i++) {
			$user = qdm_player($battles[$i]['player_id']);
			$exp = calc_level($user['exp']);
			$level = $exp['lvl'];
			$name = '<div class="active"></div>' . $user['name'].' <b>[' . $level . ']</b>';
			$res .= '<div class="areana_td">';
			$fref = 'script/fp.php?s=vs&id=' . $battles[$i]['player_id'];
			$fref_quit = 'script/fp.php?s=vs_quit';
			$res .= $name . ' ';
			if( $battles[$i]['player_id'] != $_SESSION['uid'] ){
				if( $is_batle ) $res .=  tpl_but_a($fref, 'Напасть', 'vs_btn');
			}
			else $res .=  tpl_but_a($fref_quit, 'Выйти', 'vs_quit');
			$res .= '</div>';
		}
		$res .= '</div>';
	}
	$res .= '</div></div></div>';

	return $res;

}

function last_log(){
	$res = '<div class="ui_block"><span class="arena_title">Прошлая битва</span>';
	$res .= '<div class="arena_div">';
	$res .= '<div class="arena_content">';
	if( isset($_SESSION['last_log']) ){ 
		$log = log_to_html($_SESSION['last_log']);
		// d_echo($log);
		$res .= $log['res'];
		$res .= $log['t_log'];
		$res .= $log['stat'];
		$res .= $log['html'];
	}
	$res .= '</div></div></div>';

	return $res;
}

function skills_block(){

	global $i_ui;
	$skills = qdm_skills();
	$html = '';


	$player = qdm_player($_SESSION['uid']);
    $act_skills = qdm_act_skills($_SESSION['uid']);
    $ci = count($act_skills);
    $act_ids = array();
    for( $i = 0; $i < $ci; $i++ ){
    	$act_ids[$act_skills[$i]['id']] = 1;
    }


    $ci = count($skills);

	// d_echo($act_ids);
	// $player['pts_skll'];
	$html .= '<div class="free_skills">Свободных умений: ' . $player['pts_skill'] . '</div>';
	$html .= '<div class="skill_scroll">';
	$html .= '<div class="skill_scroll_header">Умения школы мастерства</div>';
	$html .= '<div class="skill_scroll_header_hr"></div>';
	$html .= '<div class="content_2 content">';
    for( $i = 0; $i < $ci; $i++ ){
    	
    	$skill = $skills[$i];
    	$skill_info = qdm_skill($_SESSION['uid'], $skill['id']);
    	
    	if( $skill_info ){

    		$skill_level = calc_level($skill_info['exp']);
    		$skill_level = ' [' . $skill_level['lvl'] . ']';
    	}
   		else{ $skill_level = '';}
   		// tpl_but_a('script/fp.php?s=add_skill', 'Выход')
        $name  = '<div class="skill_name">' . $skills[$i]['name'] . $skill_level;

        $fp = 'script/fp.php?s=add_skill&id=' . $skill['id'];
        if( $player['pts_skill'] && !isset($act_ids[$skill['id']]) ) $name .= tpl_but_a($fp, '', 'stat_pluss', 'Овладеть');
        $name .= '</div>';

        if( $skills[$i]['img'] == '' ){ $img = $i_ui['skills'] . 'empty.png'; }


        else{ $img = $i_ui['skills'] . $skills[$i]['img']; }


        $skill_ico = '<div class="skill_ico"><img src="' . $img . '"></div>';
        $skill_ico = '<a title="' . $skill['descr'] . '" href="script.php?skill=s&id=' . $skills[$i]['id'] . '">' . $skill_ico . '</a>';

        $progress = '<div class="skill_descr">' .$skills[$i]['descr'] . '</div>';
        $block  = '<div class="skill_block_long">' . $name . $progress . '<div class="clear"></div></div>';
        $html .= $block;
    }
    $html .= '</div></div></div>';

    
    $html .= '<div class="skill_scroll">';
	$html .= '<div class="skill_scroll_header">Выученные умения</div>';
	$html .= '<div class="skill_scroll_header_hr"></div>';



	$html .= '<div class="content_2 content">';
    $ci = count($act_skills);
    for( $i = 0; $i < $ci; $i++ ){
    	
    	$name = '';
    	$skill = $act_skills[$i];
    	$skill_info = qdm_skill($_SESSION['uid'], $skill['id']);

    	if( $skill_info ){

    		$skill_level = calc_level($skill_info['exp']);
    		$skill_level = ' [' . $skill_level['lvl'] . ']';
    	}
   		else{ $skill_level = '';}

   		// Counter
   		$time = $skill['act_ts'] - 3600; // WHY 1hour ofset???

		$format = date("m d, Y H:i:s", $time);
		$js = '
		<script>
			$(".countdown_'.$i.'").countdown({
				htmlTemplate: "%y y, %m m, %d, %h : %i : %s",
				htmlTemplate: "%h : %i : %s",
				date: "'.$format.'",
				yearsAndMonths: true,
				servertime: function() { 
				    var time = null; 
				    $.ajax({url: "get_time.php", 
				        async: false, 
						dataType: "text", 
				        success: function( data, status, xhr ) {  
							time = data;
				        }, 
						error: function(xhr, status, err) { 
				            time = new Date(); 
							time = time.getTime();
				    	}
					});

				    return time; 
				},
				hoursOnly: false,
				onComplete: function( event ) {
					// alert("a");
					$(this).html("Выученно");
				},
				onPause: function( event, timer ) {

					$(this).html("Pause");
				},
				onResume: function( event ) {
				
					$(this).html("Resumed");
				},
				leadingZero: true
			});
		</script>';
		$name .= $js;

   		// tpl_but_a('script/fp.php?s=add_skill', 'Выход')
        $name  .= '<div class="skill_name">' . $act_skills[$i]['name'] . $skill_level;
        if( $skill['act_ts'] < time() ) $name  .= ' <span class="countdown_'.$i.' skill_counter"></span>';
        else $name  .= ' <span class="countdown_'.$i.' skill_counter_noact"></span>';
        $fp = 'script/fp.php?s=deact_skill&id=' . $skill['id'];
       	$name .= tpl_but_a($fp, '', 'stat_minus', 'Овладеть');
        $name .= '</div>';

        if( $act_skills[$i]['img'] == '' ){ $img = $i_ui['skills'] . 'empty.png'; }


        else{ $img = $i_ui['skills'] . $act_skills[$i]['img']; }


        $skill_ico = '<div class="skill_ico"><img src="' . $img . '"></div>';
        $skill_ico = '<a title="' . $skill['descr'] . '" href="script.php?skill=s&id=' . $act_skills[$i]['id'] . '">' . $skill_ico . '</a>';

        $progress = ''; //<div class="skill_descr">' .$act_skills[$i]['descr'] . '</div>';
        $block  = '<div class="skill_block_long">' . $name . $progress . '<div class="clear"></div></div>';
        $html .= $block;
    }
	

    $html .= '</div></div></div>';
    $html .= '</td>';

    // echo($html);

    // for( $i = 0; $i < $ci; $i++ ){

    //     $skill = $skills[$i];
    //     $level = calc_level($skills[$i]['exp']);
    //     $exp_block = '<div class="skill_exp_block">' . $level['exp'] . '/' . $level['to_level'] . '</div>';
    //     if( $skill['img'] === '' ){ $img = $i_ui['skills'] . 'empty.png'; }
    //     else{ $img = $i_ui['skills'] . $skill['img']; }
    //     $skill_ico = '<div class="skill_ico"><img src="' . $img . '"></div>';
    //     $skill_ico = '<a href="script.php?skill=s&id=' . $skills[$i]['skill_id'] . '">' . $skill_ico . '</a>';

    //     $name = '<div class="skill_name">' . $skill['name'] . ' (' . $level['lvl'] . ')</div><br>';
    //     $progress = '<div class="skill_exp"><div class="meter animate">
    //     <span style="width: '.$level['progress'].'%"><span></span></span></div></div>';
    //     $block = '<div class="skill_block">' . $skill_ico . $name . $progress . $exp_block . '<div class="clear"></div></div>';
    //     $html .= $block;
    // }
    // $html .= '</div></td>';
    return $html;
}


// Compact view (html) of active skills
function skills_act_block(){

	global $i_ui;
	$html = '<div class="skill_blocks">';

	$skills = qdm_act_skills($_SESSION['uid'], 1);

    $ci = count($skills);

    for( $i = 0; $i < $ci; $i++ ){
    	
    	$skill = $skills[$i];
    	
    	$skill_lvl = calc_level($skill['exp']);
    	$skill_level = ' [' . $skill_lvl['lvl'] . ']';
    	$skill_cfg = qdm_skill_cfg($skill['id'], $skill_lvl['lvl']);

    	$title = 'OO: ' . $skill_lvl['exp'] . ' / ' . $skill_lvl['to_level'];
    	$title .= "\n" . $skill['descr'] . "\n";

    	$cj = count($skill_cfg);
    	for ($j=0; $j < $cj; $j++) {

    		$skl = $skill_cfg[$j];
    		$title .= $skl['skill_level'] . 'ур. ' . $skl['descr'] . "\n";
    	}

        $name = '<div class="skill_name">' . $skills[$i]['name'] . $skill_level . '</div>';
        $progress = '<div class="skill_exp"><div class="meter animate">
         <span style="width: '.$skill_lvl['progress'].'%"><span></span></span></div></div>';
        $block  = '<div class="skill_block" title="'.htmlescape($title).'">' . $name . $progress . '</div>';
        $html .= $block;
    }
    $html .= '</div>';

    return $html;
}


// Menu
function html_panel(){

	$s = isset($_GET['s']) ? $_GET['s'] : '';
	$res  = '<div class="top_panel">';
	$items = array();
	$items[] = check_menu_item('start', 'index.php', 'Персонаж');
	$items[] = check_menu_item('cfg', '?s=cfg', 'Настройки');
	$items[] = check_menu_item('skills', '?s=skills', 'Умения');
	$items[] = check_menu_item('exit', 'script/fp.php?s=exit', 'Выход');
	$res .= implode(' ', $items);
	$res .= '</div>';
		
	return $res;
}

// add class active
function check_menu_item($get_name, $link, $text){
	
	if( !isset($_GET['s']) ) $_GET['s'] = 'start';
	if( $_GET['s'] == $get_name ) return tpl_but_a($link, $text . '', 'act');
	else                          return tpl_but_a($link, $text . '','inact');
}



function draw_ui($page, $player){

	global $ui;

	// Include template for page
	$file = $i_ui['path'] . '/ft/ft_' . $page . '.php';
	if( file_exists($file) ){
		include_once($file);
		$fnc = 'ft_' . $page;

		// Call main page function
		$fnc($player);
	}

	echo html_panel();
	$fnc  = 'page_' . $_GET['s'];
	$html = $fnc($player);
	echo $html;
}

function page_skills($player){
	echo skills_block();
}

function page_cfg($player){

	global $i_ui;

	if( !empty($player['avatar']) ){ $avatar = '<img src="'.$i_ui['avatars'].$_SESSION['uid'].'.png">'; }
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




function image_resize($file, $ext){

	// $src = imagecreatefromjpeg($file);
	if( $ext == 'jpg' || $ext == 'peg') $src = imagecreatefromjpeg($file);
	elseif( $ext == 'png' ) return false;//$src = imageCreateFromPng($file);
	$max_width = 120;
	$max_height = 120;
	list($width, $height) = getimagesize($file);
	if( $width > $max_width || $height > $max_height ){
		$ratioh = $max_height/$height;
		$ratiow = $max_width/$width;
		$ratio = min($ratioh, $ratiow);
		// New dimensions
		$tn_width = intval($ratio*$width);
		$tn_height = intval($ratio*$height); 

		$tmp = imagecreatetruecolor($tn_width, $tn_height);
		if( $ext == 'png' ){
			imageAlphaBlending($tmp, false);
			imageSaveAlpha($tmp, true);
		}
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

		if( $ext == 'png' ){ imagepng($tmp, $file, 100); }
		else{ imagejpeg($tmp, $file); }
		imagedestroy($src);
		imagedestroy($tmp);
	}

}





?>