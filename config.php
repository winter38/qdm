<?php


// $INFO['sql_driver']			=	'mysql';
// $INFO['sql_host']			=	'109.173.124.21';
// $INFO['sql_database']			=	'winter';
// $INFO['sql_user']			=	'winter';
// $INFO['sql_pass']			=	'tgnsnm2012';
// $mysql_connect = mysql_pconnect($INFO['sql_host'], $INFO['sql_user'], $INFO['sql_pass']);
// $BD = mysql_select_db('winter', $mysql_connect);
// mysql_query("SET NAMES utf8;");
ini_set('display_errors',1);
error_reporting(E_ERROR);
ini_set('log_errors', 0);




/** Имя базы данных для WordPress */
define('DB_NAME', 'winter');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль пользователя MySQL */
define('DB_PASSWORD', '');

/** Адрес сервера MySQL */
define('DB_HOST', '127.0.0.1');
/** Кодировка базы данных при создании таблиц. */

define('DB_CHARSET', 'utf8');
/** Схема сопоставления. Не меняйте, если не уверены. */
$connect = 1;
if( $connect ){
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, 3306);
    $db->query("SET NAMES UTF8"); // tell that we work with utf-8
}

$ui = array();
$ui['path']     = __DIR__;
$ui['cards']    = '/home/u44987/warwolfru/www/winterwolf/cards';
$ui['fonts']    = '/home/u44987/warwolfru/www/winterwolf/lib/game/fonts';
$ui['cads_img'] = '/cards/img_cards/';
$ui['avatars']  = 'visual/avatars/';
$ui['trader']   = 'visual/trader/';
$ui['items']  = 'visual/items/';
$ui['skills']   = 'visual/skills/';
$ui['host'] = 'http://warwolf.org/winterwolf/qdm';
$ui['host'] = 'localhost/qdm';

if( !function_exists('d_html_escape') ){
    
    function d_html_escape($mixed){
        
        if( is_array($mixed) ){
            $keys = array_keys($mixed);
            $ci = count($keys);
            for( $i = 0; $i < $ci; $i++ ){
                $mixed[$keys[$i]] = d_html_escape($mixed[$keys[$i]]);
            }
            return $mixed;
        }
        
        // escape some symbols with predefined entities
        return ( is_string($mixed) ) ? htmlspecialchars($mixed) : $mixed;;
    } // d_html_escape
}



if( !function_exists('d_echo') ){

    function d_echo($mixed, $mode = '', $die = false){
        
        $trace = 1; // trace file and line where this fnc is called

        if( $mixed === NULL || is_bool($mixed) || $mixed === '' ) $mode .= 'd';
        
        $bold   = ( strpos($mode, 'b') !== false );
        $red    = ( strpos($mode, 'r') !== false );
        $green  = ( strpos($mode, 'g') !== false );
        
        $style = '';
        if( $bold )  $style .= 'font-weight: bolder; font-size: 120%;';
        if( $red )   $style .= 'color: red;';
        if( $green ) $style .= 'color: green;';
        
        if( !isset($_SESSION['echo']) || (isset($_SESSION['echo']) && $_SESSION['echo']) ){
            echo '<pre style="' . $style . '">';
            
            // escape HTML
            if( strpos($mode, 'h') !== false ) $mixed = d_html_escape($mixed); 
            
            // print
            if( strpos($mode, 'd') !== false ) var_dump($mixed); else print_r($mixed);
            
            echo '</pre>';
            
            // line
            if( strpos($mode, 'l') !== false ) d_echo('----------');
            
            if( $die == true ){ die(); } // stop executin of script
        }
        
        
        if( $trace ){
            $tmp = debug_backtrace();// debug_print_backtrace();
            $place = '<b>Traced</b> ' . $tmp[0]['file'] . ' (line :' . $tmp[0]['line'] . ')';
            echo '<pre style="font-size: 10px; font-family: verdana">';
            print_r($place);
            echo '</pre>';
        }
        
        
    } // d_echo   
}


if( !function_exists('d_mem') ){
    
    function d_mem(){
        
        $mem = memory_get_usage();
        $mem = $mem / 1024;
        $mem = sprintf('Memory used: %0.3f KB', $mem);
        d_echo($mem);
        
        $mem = memory_get_peak_usage();
        $mem = $mem / 1024;
        $mem = sprintf('Memory peak used: %0.3f KB', $mem);
        d_echo($mem);
        
        return true;
    } // d_mem
}


function inc_fl_lib($libs){

    $res = false;

    global $ui;
    if( is_array($libs) ){
        $ci = count($libs);
        for( $i = 0; $i < $ci; $i++ ){ 
            include_once($i_ui['path'] . '/fl/'. $libs[$i]);
        }
    }
    else $res = include_once($ui['path'] . '/fl/'. $libs);

    return $res;
}

    
?>