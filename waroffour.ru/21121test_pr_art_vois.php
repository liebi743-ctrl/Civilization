<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");


 $x=1;
  $att_params['weapon_speed'][6]=100;
  $att_params['weapon_speed'][6]*=1.15*$x;
  printrus("".$att_params['weapon_speed'][6]."");


//ботинки:
include_once("other_inc/footer.php");


?>