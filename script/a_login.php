<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
ini_set('log_errors', 0);

check_login($_POST['login'], $_POST['password']);

// d_print_pre($_POST);
// d_print_pre($_SESSION);

?>