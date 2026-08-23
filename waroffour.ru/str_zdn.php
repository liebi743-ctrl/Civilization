<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");

//ID страны чела которому рисуем здания
$countryID='a6742608bdbe78da67a1243258d773a240';


mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village', space = 100, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'citadel', space = 60, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'market', space = 150, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'warhouse', space = 40, hits = 100");



//ботинки:
include_once("other_inc/footer.php");


?>