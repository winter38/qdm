<?php
session_start();
include_once('../lib/functions.php');

if( isset($_SESSION['taro']) ){

    $cards = $_SESSION['taro'];  //perenesli mp3 na flash
    
    $ci = count($cards);

    // We want to get random card
    $rand_number = mt_rand(0, $ci-1);

    // d_echo('random number');
    // d_echo($rand_number);

    $card_description = $cards[$rand_number];
    $card_i = '<img src="img_cards/taro/'.$card_description.'.jpg">';

    echo('img_cards/taro/'.$card_description.'.jpg');
    
    // $cards[$rand_number] - here is random card
    // $card = $cards[$rand_number];
    unset($cards[$rand_number]);

    // resort
    $cards = array_values($cards);

    $_SESSION['taro'] = $cards; //perenesli mp3 s flash ns comp

}
else {

      // we have array

      $cards = array();

      // fill $cards is empty - fill it with cards

      // by next
      $cards[] = 'fool';
      $cards[] = 'magician';
      $cards[] = 'high_pristess';
      $cards[] = 'empress';
      $cards[] = 'emperor';
      $cards[] = 'pope';
      $cards[] = 'lovers';
      $cards[] = 'chariot';
      $cards[] = 'justice';
      $cards[] = 'hermit';
      $cards[] = 'wheel_of_fortune';
      $cards[] = 'force';
      $cards[] = 'hanged_man';
      $cards[] = 'death';
      $cards[] = 'temperance';
      $cards[] = 'devil';
      $cards[] = 'tower';
      $cards[] = 'star';
      $cards[] = 'moon';
      $cards[] = 'sun';
      $cards[] = 'judgement';
      $cards[] = 'world';

      // d_echo('cards');
      // d_echo($cards);
      
      $_SESSION['taro'] = $cards;
      
};
// Geting random card --------------------------------------------------------->
// may be cycle

//for ($i = 1; $i <= 7; $i++) {

//     $ci = count($cards);
//
//     // We want to get random card
//     $rand_number = mt_rand(0, $ci-1);
//
//     // d_echo('random number');
//     // d_echo($rand_number);
//
//     $card_description = $cards[$rand_number];
//     $card_i = '<img src="img_cards/taro/'.$card_description.'.jpg">';
//
//     echo('img_cards/taro/'.$card_description.'.jpg');
//
//     // $cards[$rand_number] - here is random card
//     $card = $cards[$rand_number];
//     unset($cards[$rand_number]);
//
//     // resort
//     $cards = array_values($cards);

    // d_echo('left cards');
    // d_echo($cards);

//};
// ---------------------------------------------------------------------------->


?>