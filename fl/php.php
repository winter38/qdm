<?php

// We will manage errors by ourself!
set_error_handler('i_err_handler');
register_shutdown_function('i_shutdown');



// i_err_handler()
//   User defined php-errors handler, allows to register notices, warnings etc.
// parameters:
//   $errno   - error type
//   $errstr  - error message
//   $errfile - file name
//   $errline - line
// return:
//   NULL

//   - The following error types cannot be handled with a user
//     defined function: E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING,
//     and most of E_STRICT raised in the file where set_error_handler() is called;
//   - E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING & E_STRICT
//     are processed thanks to c_shutdown() function.
function i_err_handler($errno, $errstr, $errfile, $errline){

    switch( $errno ){
        case E_ERROR:             $errno = 'E_ERROR';             break;
        case E_WARNING:           $errno = 'E_WARNING';           break;
        case E_PARSE:             $errno = 'E_PARSE';             break;
        case E_NOTICE:            $errno = 'E_NOTICE';            break;
        case E_CORE_ERROR:        $errno = 'E_CORE_ERROR';        break;
        case E_CORE_WARNING:      $errno = 'E_CORE_WARNING';      break;
        case E_COMPILE_ERROR:     $errno = 'E_COMPILE_ERROR';     break;
        case E_COMPILE_WARNING:   $errno = 'E_COMPILE_WARNING';   break;
        case E_USER_ERROR:        $errno = 'E_USER_ERROR';        break;
        case E_USER_WARNING:      $errno = 'E_USER_WARNING';      break;
        case E_USER_NOTICE:       $errno = 'E_USER_NOTICE';       break;
        case E_STRICT:            $errno = 'E_STRICT';            break;
        case E_RECOVERABLE_ERROR: $errno = 'E_RECOVERABLE_ERROR'; break;
        case E_DEPRECATED:        $errno = 'E_DEPRECATED';        break;
        case E_USER_DEPRECATED:   $errno = 'E_USER_DEPRECATED';   break;
        default:                  $errno = 'UNKNOWN';             break;
    } // switch

    $msg = sprintf('Type="%s"; Description="%s"; File="%s"; Line="%s"',
                   $errno, $errstr, basename($errfile), $errline
           );
    d_echo($msg);
} // i_err_handler


// i_shutdown()
//   Function that is called at the end of php-script.
// parameters:
//   -
// return:
//   NULL

//   - it works even if "white screen" occured;
//   - this function gives apportunity to call c_err_handler() for errors that cannot be
//     processed by c_err_handler() automatically.
function i_shutdown(){

    $err = error_get_last(); // get last error

    if( isset($err) ){ // if not NULL (if error discovered)

        switch( $err['type'] ){ // if error, that will not be "registered" by c_err_handler() without c_shutdown()
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_CORE_WARNING:
            case E_COMPILE_ERROR:
            case E_COMPILE_WARNING:
            case E_STRICT:
                i_err_handler($err['type'], $err['message'], $err['file'], $err['line']);
                break;
            default: break;
        } // switch
    }
} // i_shutdown

?>