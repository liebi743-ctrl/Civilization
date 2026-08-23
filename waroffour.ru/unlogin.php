<?php

if (isset($_REQUEST['clv'])) $clv = $_REQUEST['clv'];

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
@include_once("other_inc/header.php");

global $memcache;

$countryID = $_SESSION['countryID'];

 $key1=_PREFIKS.':id'.$countryID;
 if ($ma=$memcache->get($key1)) $id_m = TRUE; else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }

$tm = date(U) - 1200;

mysql_query("UPDATE uzers SET onlineflag = $tm WHERE countryID = '".$b['countryID']."'");
session_destroy();

$key=_PREFIKS.':messages'.$b['countryID'];
$memcache->delete($key);
$key=_PREFIKS.':id'.$b['countryID'];
$memcache->delete($key);
$key=_PREFIKS.':works'.$b['countryID'];
$memcache->delete($key);
$key=_PREFIKS.':market'.$b['countryID'];
$memcache->delete($key);
$key=_PREFIKS.':buildings'.$b['countryID'];
$memcache->delete($key);
$key=_PREFIKS.':wars'.$b['countryID'];
$memcache->delete($key);
$key=_PREFIKS.':general'.$b['countryID'];
$memcache->delete($key);
$key=_PREFIKS.':neighs'.$b['countryID'];
$memcache->delete($key);

printrus("Спасибо за игру! Заходите снова! Помните - ваши противники не дремлют!<br/>
<a href=\"http://"._MAINSITE."\">Ок</a><br/>
");

@include_once("other_inc/footer.php")
?>
