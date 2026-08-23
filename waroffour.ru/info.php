<?
 foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['w_level'])) $w_level = $_REQUEST['w_level'];
if (isset($w_level) && !is_numeric($w_level)) $w_level=0;
if ($w_level<0) $w_level=0;
if (isset($_REQUEST['w_type'])) $w_type = $_REQUEST['w_type'];
if (isset($w_type) && !is_numeric($w_type)) $w_type=0;
if ($w_type!=0 && $w_type!=1) $w_type=0;
if (isset($_REQUEST['w_hits'])) $w_hits = $_REQUEST['w_hits'];
if (isset($w_hits) && !is_numeric($w_hits)) $w_hits=100;
if ($w_hits<=0 || $w_hits>100) $w_hits=100;
if (isset($_REQUEST['b_level'])) $b_level = $_REQUEST['b_level'];
if (isset($b_level) && !is_numeric($b_level)) $b_level=1;
if ($b_level<1) $b_level=1;
if (isset($_REQUEST['b_type'])) $b_type = $_REQUEST['b_type'];
if (isset($b_type) && !is_numeric($b_type)) $b_type=0;
if ($b_type!=0 && $b_type!=1) $b_type=0;
if (isset($_REQUEST['b_count'])) $b_count = $_REQUEST['b_count'];
if (isset($b_count) && !is_numeric($b_count)) $b_count=1;
if ($b_count<1) $b_count=1;


//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
include_once("other_inc/header.php");

$countryID = $_SESSION['countryID'];
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }


//******************************************************************************
//проверка на валидность идентификатора:****************************************

 if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 


 
//ботинки:
include_once("other_inc/footer.php");

?>
