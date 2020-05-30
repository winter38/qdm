<?php

$player = qdm_player($_SESSION['uid']);
$stamina = qdm_stamina($player);

$res = json_encode($stamina);
echo $res;
?>