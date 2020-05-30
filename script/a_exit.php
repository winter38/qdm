<?php

// Exit from game

session_destroy();
$link = $_SERVER['HTTP_REFERER'];
Header("Location:$link");

?>