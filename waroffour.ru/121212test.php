<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");

//ID страны чела которому рисуем здания
$countryID='2d93e544344e93bf4405b62b083bc2c566';




mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'altar', space = 200, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'dungeon', space = 200, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'farm', space = 200, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'necropolis', space = 200, hits = 100");


/*
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'citadel', space = 60, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'market', space = 150, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'warhouse', space = 40, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village', space = 100, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'scientificcenter', space = 30, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'fabrika', space = 300, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'magictower', space = 400, hits = 100");
mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'neftevxwka', space = 1000, hits = 100");
 */






//ботинки:
include_once("other_inc/footer.php");


?>