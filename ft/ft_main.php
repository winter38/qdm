<?php


function ft_main(&$player){

	global $ui;

  $player_init = qdm_cfq_user();
  $player = array_merge($player_init, $player);
  qdm_fill_skills($player);
  

	// TMP
	$script = '<script>
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
  $(function(){
      qdm_stamina.init();
  });
	</script>
	';

	if( !empty($player['avatar']) ){ $avatar = '<img src="'.$ui['avatars'].$_SESSION['uid'].'.png">'; }
	else{ $avatar = ''; }


	$one_battle = '';
	$exp    = calc_level($player['exp']);
	$level  = $exp['lvl'];
	$filter = 'WHERE class = 0';
	$skills = qdm_skills($filter);


	$html_skills = '';
	$ci = count($skills);
	for( $i = 0; $i < $ci; $i++ ){
	    $html_skills.= $skills[$i]['descr'] . '<div><a class="skill" title="' . $skills[$i]['descr'] . '" href="script.php?skill=s&id=' . $skills[$i]['id'] . '">';
		$html_skills.= $skills[$i]['name']  .'</a></div>';
	}

	$active_skill_html = '';
  $log_detail = '';

  $miner = '';
  if( isset($player['skills'][S_PROF_MINER]) ){
      $miner = '<a href="script/fp.php?s=mining">Добыть руду</a>';
  }

	// Deleay for vs fights in indicator --------------------------------->
  $stamina = qdm_stamina($player);
	// ------------------------------------------------------------------->
	//d_echo($delta);

	$html = $script .'

    <div class="data">
      <table><tr><td valign="top" class="ch_td">
        <table class="player_info">
          <tr>
          	<td title="Выносливость '.$stamina['cur'].'/'.$stamina['max'].'" rowspan="5" style="width: 8px" class="js_stamina_title">
          		<div class="meter meter_vertival_div"><div class="meter_vertical"><span style="margin-top: '.$stamina['left'].'px" class="js_stamina"><span></span></span></div></div>
          	</td>
          </tr>
          <tr>
          	<td></td>
            <td class="avatar" rowspan="1"><div class="avatar_div">' . $avatar . '</div></td>
            <td>
            	<div class="ch_i_block_r">
	            	<div class="ch_i name">'.$player['name'].' [' . $level . '] </div>
	            	<div class="ch_i_delim"></div>
	            	<div class="meter animate" style="width:auto"><span style="width: '.$exp['progress'].'%"><span></span></span></div>
	            	<div style="text-align:center; font-size: 10px;">ОО:<b>'.$exp['exp'].'/'.$exp['to_level'].'</b></div>
	            	<div class="ch_i_delim"></div>
	            	<div class="ch_i">Боевой ранг <b>[0]</b></div>
	            	<div class="meter animate" style="width:auto"><span style="width: 1%"><span></span></span></div>
	            	<div class="ch_i_delim"></div>
	            	<div class="ch_i">Проффесия <b>[999]</b></div>
	            	<div class="meter animate" style="width:auto"><span style="width: 1%"><span></span></span></div>
	            	<div class="ch_i_delim"></div>
	           	</div>
            </td>
          </tr>
          <tr>
          	<td></td>
            <td class="label">Боев</td>
            <td class="value"><div class="btl_count">'.$player['btl_count'].'</div></td>
          </tr>
          <tr>
          	<td></td>
            <td>Побед</td>
            <td class="value"><div class="win">'.$player['win'].'</div></td>
          </tr>
          <tr>
          	<td></td>
            <td>Монет</td>
            <td class="value"><div class="gold_earned"><div class="gold"></div>'.$player['gold'].'</div></td>
          </tr>

        </table>
        <table class="player_info">
          <tr>
            <td>Свободных очков</td>
            <td class="value"><div class="points">'.$player['pts_stat'].'</div></td>
          </tr>
          <tr>
            <td>Сила</td>
            <td class="value">
            	<div class="str">'.$player['str'].'</div>
            	<a class="stat_minus" href="script/fp.php?a=m&stat=str&s=stat"></a>
            	<a class="stat_pluss" href="script/fp.php?a=p&stat=str&s=stat"></a>
            </td>
          </tr>
          <tr>
            <td>Ловкость</td>
            <td class="value">
            	<div class="dex">'.$player['dex'].'</div>
            	<a class="stat_minus" href="script/fp.php?a=m&stat=dex&s=stat"></a>
            	<a class="stat_pluss" href="script/fp.php?a=p&stat=dex&s=stat"></a>
           	</td>
          </tr>
          <tr>
            <td>Телосложение</td>
            <td class="value">
            	<div class="con">'.$player['con'].'</div>
            	<a class="stat_minus" href="script/fp.php?a=m&stat=con&s=stat"></a>
            	<a class="stat_pluss" href="script/fp.php?a=p&stat=con&s=stat"></a>
            </td>
          </tr>
          <tr>
            <td>Свободных умений</td>
            <td class="value"><div class="skills_left">'.$player['pts_skill'].'</div></div></td>
          </tr>
          <tr>
            <td colspan="2" class="skill_list">'.$one_battle.'</td>
          </tr>
          <tr>
            <td colspan="2">
            '.$miner.'
            </td>
          </tr>
          <tr>
            <td colspan="2">
            </td>
          </tr>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td colspan="2" style="height:10px"></td>
          </tr>
        </table>
        <table class="player_info">
          <tr>
            <td colspan="2" style="text-align:center"><b class="log_header">Лог</b></td>
          </tr>
          <tr>
            <td colspan="2">'.$log_detail.'</td>
          </tr>
          <tr>
            <td style="height:10px" colspan="2"></td>
          </tr>
        </table>
      </td><td valign="top">
      </td></tr></table>
    </div>';


	$html .= skills_act_block();
	$html .= html_arena();
	$html .= last_log();

	return $html;
}





?>