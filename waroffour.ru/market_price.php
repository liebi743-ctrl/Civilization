<?php

define('IN_CLV',true);
//==============================================================================
//подключаем скрипты
include_once("func/functions_clv.php");

//Высчитывание средних рыночных цен
$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'stone'");
$a = mysql_fetch_array($r);
$avg_stone = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'iron'");
$a = mysql_fetch_array($r);
$avg_iron = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'arbor'");
$a = mysql_fetch_array($r);
$avg_arbor = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'grain'");
$a = mysql_fetch_array($r);
$avg_grain = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'oil'");
$a = mysql_fetch_array($r);
$avg_oil = $a['num'];

//Пишем в лог работ:
$open=fopen(_ROOT."/liders/market.dat","w+");
@flock ($open,LOCK_EX);
@fwrite($open,round($avg_stone,2)."\n".round($avg_iron,2)."\n".round($avg_arbor,2)."\n".round($avg_grain,2)."\n".round($avg_oil,2));
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

?>