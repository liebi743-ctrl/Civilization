<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");


 $scientiststo=500;
$work_time=max(360*24*2,round(3600*24*2/$scientiststo*300));

printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");


//ботинки:
include_once("other_inc/footer.php");


?>