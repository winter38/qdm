<?php


include_once('../lib/functions.php');
include_once('functions.php');
include_once('functions_battle.php');
include_once('config.php');
include_once('msg.php');

qdm_auth(1);


function log_to_html($log){

    // count players
    $ci = count($log['header']);
    $players = array();
    $winners = array();
    $npc = array();
    for( $i = 0; $i < $ci; $i++ ){
        
        if( $log['header'][$i]['player'] ){
            $players[$log['header'][$i]['id']] = player_info($log['header'][$i]['id']);
            if( $log['header'][$i]['exp']['win'] ){
                $winners[] = $players[$log['header'][$i]['id']]['name'];
            }
        }
        else{
            $npc[$log['header'][$i]['id']] = npc_info($log['header'][$i]['id']);
            if( $log['header'][$i]['exp']['win'] ){
                $winners[] = $players[$log['header'][$i]['id']]['name'];
            }
        }
    
    }
    
    $ci = count($log['body']);
    $res = '';
    for( $i = 0; $i < $ci; $i++ ){
        
        // round log
        $round = '<div class="round">';
        $cj = count($log['body'][$i]);
        for( $j = 0; $j < $cj; $j++ ){

            $params = $log['body'][$i][$j];
            $id = $log['body'][$i][$j]['atk'];
            if( $log['body'][$i][$j]['atk_player'] ){
                $round .= '<div class="msg_block">' . msg_log($params, $players[$id]['name']) . '</div>';
            }
            else{
                $round .= '<div class="msg_block">' . msg_log($params, $npc[$id]['name']) . '</div>';
            }
        }
        $round .= '</div>';
        $res .= $round;
    }
    $res .= '<div class="round"><div class="msg_block"><span class="player_name">' . $winners[0] . '</span> побеждает. </div></div>';
    
    return $res;
}




?>