<?php
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();
$countryID=$_SESSION['countryID'];
$b=CountryInfo($countryID);
//шапка:
include_once("other_inc/header.php");

$sql="SELECT countryID,countryName
  FROM countries LEFT JOIN messages
    ON countries.countryID=messages.countryID and messages.`from` != 'loose'
  and reggedTime<".$b['reggedTime']." and(countries.countryID!='".$countryID."')
  ORDER BY reggedTime DESC LIMIT 2";
$r = mysql_query($sql);
 while (($a=mysql_fetch_array($r))!==FALSE){
  printrus($a["countryName"]);


 }


printrus ($num.'<br />---<br/>');

//ботинки:
include_once("other_inc/footer.php");
?>