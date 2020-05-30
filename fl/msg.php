<?php


function msg_fill(){

    $msg['hit'] = array();
    $msg['miss'] = array();
    $msg['crit'] = array();
        
    $m = &$msg['hit'];
    $m[] = 'Да, name1, такой удар сделает честь даже печально знаменитым Братьям Гекко! О, какой удар на dmg! Теперь вампирам придется слизывать эту кровь с пола.';
    $m[] = 'name1 наносит удар противнику на dmg';
    $m[] = 'name1 грубо избивает своего протвника. name2 теряет dmg';
    $m[] = 'name1 использует свое оружие не по назначению. name2 теряет dmg';
    $m[] = 'name1 корчит страшные рожицы. name2 в страхе теряет dmg';
    $m[] = 'name1 ловко поражает name2 на dmg';
    $m[] = 'name1 неловко поражает name2 на dmg';
    $m[] = 'name1 ласкает name2, отчего тот получает dmg';
    $m[] = 'name2 не ожидвший атаки с права получет dmg от name1';
    $m[] = 'name1 проводит успешную атаку. name2 получает dmg';
    $m[] = 'name2 налетает на оружие противника и получает урон - dmg. name1 в принципе не против';
    $m[] = 'name1 смог отыскать брешь в защите противника и проливает кровь name2 dmg';
    $m[] = 'Удар ушел в стенеку. И снова удар - стенка. И вновь стенка. Да дайте ему наконец оружие в руки и отберите голову name2. Кажется name2 теряет кровь dmg';
    $m[] = 'name1 показывает непристойные жесты. name2 сгорает от стыда на dmg';
    $m[] = 'name1 с радостью срывает злость на противнике. Злость наносит name2 dmg';
    $m[] = 'name1 давит своим авторитетом name2 и наносит dmg';
    $m[] = 'name1 обманул противника, притворившись метртвым. Когда name2 подошел посмотреть, то получил dmg';
    $m[] = 'Прыжок, удар, финт, уворот, контратака, атака - удар с плеча, полуоборот и снова атака. План для name1 план окзался слишком сложным, поэтому он просто ударил name2 на dmg';
    
    
    $m = &$msg['miss'];
    $m[] = 'name1 решает почесать нос и забывает ударить name2. Бывает...';
    $m[] = 'name1 читает лог боя...';
    $m[] = 'name1 подкидывает монетку и не нападает, аргументируя, что все равно бы промахнулся...';
    $m[] = 'name1 плохо выкинул кубик...';
    $m[] = 'name1 проклинает рандом...';
    $m[] = 'name1 задумался...';
    $m[] = 'name1 споткнулся...';
    $m[] = 'name1 следит за name2, такие пируеты грех не посмотреть...';
    $m[] = 'name1 забыл что нужно делать.';
    $m[] = 'name1 запутался в финтах name2 и просто махнул оружием в воздухе - все равно не попал бы.';
    $m[] = 'name1 вложил слишком много сил в удар и name2 легко ушел от удара';
    $m[] = 'name1 застал противника в расплох, но name2 прокинул спасбросок и смог избежать удара';
    $m[] = 'Удар name1 прошелся вскольз по броне name2';
    $m[] = 'name1 всем видом показывает, что дает фору противнику, пропуская ход. Просто гордость не дает признаться о своем промахе';
    $m[] = 'Удар name1 снова проходит в миллиметре от жизненно важной части противника. Name1 всем видом показывает, что в следующий раз достатнет';
    
    $m = &$msg['crit'];
    $m[] = 'Ёкодзуна отрывает голову своему сопернику! А нет, это был всего лишь name1. name2 теряет dmg';
    $m[] = 'И сам Тайсон завидует такому укусу! name1 ловким ударом лишает name2 обоих ушей и кончика носа. name2 пришел счет на dmg';
    $m[] = 'name1 четвертует противника! (В смысле, отрезает руку и еще кусочек). name2 теряет dmg';
    $m[] = 'name1 не просто комок шерсти с зубами. Это очень опасный комок шерсти, - подумал name2 истекая кровью на dmg';
    $m[] = 'Говорят словом можно ранить, а вот name1 явно пытается убить name2 словрем. Противник теряет dmg';
    $m[] = 'name2 получает от name1 пощечину на dmg, кувалдой...';
    $m[] = 'name2 лезет в душу name1, подскальзывается и больно бьетеся головой об землю на dmg';
    $m[] = 'name1 практикует на name2 не летальное оружие с летальным исходом на dmg';
    $m[] = 'name1 заваевывает руку и сердце name2. name2 задыхается от восторга на dmg';
    $m[] = 'name1 наносит крититический удар пером в пятку. name2 получет dmg и задыхается от хохота';
    $m[] = 'name1 показывает name2 запрещенные приемы на dmg';
    $m[] = 'name1 проклиная все на свете выбрасывет свое оружие и удчно попадает в name2, dmg';

    $m = &$msg[S_SECOND_BREATH];
    $m[] = 'name1 открывает <span class="skill">второе дыхание</span> и востанваливает hp';
    $m[] = 'name1 присел отдохнуть. <span class="skill">второе дыхание</span> востанваливает hp';
    $m[] = 'name1 почистил зубы и открыл <span class="skill">второе дыхание</span>, востанваливает hp';
    $m[] = 'name1 устраивает пикник на обочине, <span class="skill">второе дыхание</span> востанваливает hp';

    $m = &$msg[S_INTIMIDATE];
    $m[] = 'name1 осклалился потирая орижие. name2 <span class="skill">испугались</span> name1 явно не желая нападать на name1 и получают effect';

    $m = &$msg['no_intimidate'];
    $m[] = 'name1 пытается напугать противников, но него никто не обратил внимания';
    

    $m = &$msg['grp'];
    $m[] = 'name1 слаженно дерутся в команде и получают врмеменно bonus';
    $m[] = 'name1 прикрывают друг друга, bonus';

    return $msg;
}

function msg_log(&$header, &$params){

    // d_echo($params);

    // d_echo($params, 'g');

    $msg = array();
    $msg = msg_fill($msg);

    $players = $header['pls'];
    $p1 = $players[$params['p1']];
    $p2 = $players[$params['p2']];
    
    $int = $params['dmg'];
    if( $params['crit'] ) $int = '<b>' . $int . '</b>';
    $wep = '<div class="weps wep_' . $p1['weapon'] . '"></div>';
    $txt_dmg = $wep . '<span class="log_round_dmg"> -' .  $int  . '</span> ';
    $txt_dmg .= '[<span class="log_round_hp_left">' . $params['p2_hp'] . '</span>/<span class="log_round_max_hp">' . $params['p2_max_hp'] . '</span>]';
    
    $name = '<span class="player_name">'.$p1['name'].'</span>';
    $name2 = '<span class="player_name">'.$p2['name'].'</span>';
    
    $hit = $wep . '<span class="hit_hp">%s</span>';
    $crit = $wep .'<span class="crit_hp">%s</span>';

    $search = array();
    $search[] = 'dmg';
    $search[] = 'name1';
    $search[] = 'name2';
    
    
    $replace = array();
    $replace[] = $txt_dmg;
    $replace[] = $name;
    $replace[] = $name2;


    if( $params['crit'] ){
        $res = str_replace($search, $replace, $msg['crit'][$params['msg']]);
    }
    elseif( $params['dmg'] > 0 ){
        $res = str_replace($search, $replace, $msg['hit'][$params['msg']]);
    }
    else{
        $res = str_replace($search, $replace, $msg['miss'][$params['msg']]);
    }

    // BUG - hp of second player - need first!
    // Test - TODO convert to auto find, replace
    if( isset($params['skill'][S_SECOND_BREATH]) ){

        // d_echo($params['skill'][S_SECOND_BREATH]);

        $search[] = 'hp';
        $str = '<span class="log_round_max_hp">+' . $params['skill'][S_SECOND_BREATH]['msg_val'] . '</span> ';
        $str .= '[<span class="log_round_hp_left">' . $p1['hp'] . '</span>/<span class="log_round_max_hp">' . $p1['max_hp'] . '</span>]. <br>';
        $replace[] = $str;
        
        $msg = str_replace($search, $replace, $msg['skill'][S_SECOND_BREATH][$params['skill'][S_SECOND_BREATH]['msg']]);
        //d_echo($msg); die();
        $res =  $msg . $res;
    }

    return $res;
}


function msg_log_grp(&$header, &$params){

    // d_echo($params);

    $msg = array();
    $names = '';
    $msg = msg_fill($msg);



    $players = $header['players'];

    $ci = count($params['players']);
    for( $i = 0; $i < $ci; $i++ ){ 
        if( $i !== 0 ) $names .= ', ';
        $names .= '<span class="player_name">'.$players[$params['players'][$i]]['name'].'</span>';
    }

    // d_echo($params, 'r');

    $bonus = '<span class="grp_bonus">' . implode(', ', $params['bonus']) .'</span>';

    $search = array();
    $search[] = 'name1';
    $search[] = 'bonus';
    
    
    $replace = array();
    $replace[] = $names;
    $replace[] = $bonus;


    $res = str_replace($search, $replace, $msg['grp'][$params['msg']]);
    return $res;
}

// квесты
/*
Полноватый мужик бросает в твою сторону мешочек с деньгами с фразой "Одолей противника". Толпа расхрдится пропуская накаченного бойца, который движеться в твою стророну.
Скрыться в толпе, словно обращались не к тебе.
Качек вызывающее и оглядываетяся по сторонам, но все отводят от него взгляд. Он поднимает мешечек с деньгами и пересчитывает. Ты замечаешь, что в мешочке одни медяки.
Принять вызовов и показать что такое настоящая драка


*/
?>