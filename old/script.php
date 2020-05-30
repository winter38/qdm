<?php

include_once('functions.php');
include_once('../lib/functions.php');

qdm_auth(1);
session_start();

//d_echo($_GET);
//d_echo($_SESSION);

if( isset($_GET) && isset($_SESSION['uid'])  ){
    
    $uid = $_SESSION['uid'];
    if( isset($_GET['stat']) && isset($_GET['a']) ){

        switch( $_GET['stat'] ){
            case 'str':
            
                if(     $_GET['a'] == 'p' ){ qdm_add_stat($uid, 'str'); }
                elseif( $_GET['a'] == 'm' ){ qdm_minus_stat($uid, 'str'); }
                break;
                
            case 'dex':
            
                if(     $_GET['a'] == 'p' ){ qdm_add_stat($uid, 'dex'); }
                elseif( $_GET['a'] == 'm' ){ qdm_minus_stat($uid, 'dex'); }
                break;
                
            case 'con':
                if(     $_GET['a'] == 'p' ){ qdm_add_stat($uid, 'con'); }
                elseif( $_GET['a'] == 'm' ){ qdm_minus_stat($uid, 'con'); }
                break;
            
            default: break;
        }
    }


    if( isset($_GET['skill']) && isset($_GET['id']) ){
        $skill_status = qdm_status_skill($uid, $_GET['id']);
        
        // enable / disable skill
        if($skill_status){ qdm_deactivate_skill($uid, $_GET['id']); }
        else{              qdm_activate_skill($uid, $_GET['id']);   }
    }
    
    
}

$link = 'http://warwolf.org/winterwolf/qdm';
Header("Location:$link");

?>