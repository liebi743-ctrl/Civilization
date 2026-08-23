<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");


 $scientiststo=500;
$work_time=max(3600*2*2,round(360*24*2/$scientiststo*300));

echo "Исследование займет ".mkTimeStr($work_time)."<br/>";


//ботинки:
include_once("other_inc/footer.php");


?>