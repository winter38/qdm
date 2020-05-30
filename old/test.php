<?php

include_once('../lib/functions.php');

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}


$dir = '/www/rustechc/www/htdocs/files/';
$httacess = '.htaccess';
$file = $dir . $httacess;
$add = "\n<Files \"$filename\">
  Require valid-user
  AuthUserFile $passwordpath
</Files>";
$res = file_get_contents($file);
$res = $res . $add;
$check = file_put_contents($file, $res);


$pass_file_name = 'htpasswd_' . time();
$passwordpath = '/www/rustechc/www/htdocs/files/pwd/' . $pass_file_name;

$pass = generatePassword();

// Encrypt password
$password = crypt($pass, base64_encode($pass));
$login = 'info';
d_echo($password);




?>