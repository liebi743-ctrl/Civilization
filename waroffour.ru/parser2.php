<?php
//define('IN_CLV',true);
//include_once("func/functions_clv.php");
$query = mysql_query("SELECT * from `general` WHERE countryID = '7a95328b96cb46a58a564d29fab8d91f97'") or die("112");
var_dump($countIdArray = mysql_fetch_array($query, MYSQL_NUM));
?>
