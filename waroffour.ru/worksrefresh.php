<?php
error_reporting(0);
$ip = getenv("REMOTE_ADDR");
echo $ip;

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

//==============================================================================
//Рабочая часть скрипта=========================================================

 $start = time();
 $query="SELECT * FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 while(($a=mysql_fetch_array($result))!==FALSE){
  $countryID=$a[0];

  worksRefresh($countryID);
  }
  $finished = time();
  echo ($finished-$start);
?>