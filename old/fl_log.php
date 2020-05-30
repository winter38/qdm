<?php

qdm_auth(1);

// log_header()
//   
// parameters:
//   $log          - array - battale log
//   $players_conf - array - players
// return:
//   - 
 
//   -
// dependencies:
//   -
function log_header(&$log, $players_conf){
    
    $log['header'] = array();
    $ci = count($players_conf);
    
    for( $i = 0; $i < $ci; $i++ ){
    
        $log['header'][$i]['armor']  = $players_conf[$i]['armor'];
        $log['header'][$i]['weapon'] = $players_conf[$i]['weapon'];
        $log['header'][$i]['hp']     = $players_conf[$i]['max_hp'];
        $log['header'][$i]['id']     = $players_conf[$i]['id'];
    }

    
   

    
} // log_header


?>