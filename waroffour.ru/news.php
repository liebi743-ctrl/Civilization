<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg))$pg=0;
if (!isset($pg))$pg=0;

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
include_once("other_inc/header.php");
$countryID=$_SESSION['countryID'];

 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }


if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
//  printrus ("<br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }


printrus ("<b>НОВОСТИ</b><br/>---<br/>\r\n");
$pg=addslashes($pg);

if(!isset($m)){
mysql_query("UPDATE `uzers` SET forum_news='0' WHERE countryID = '$countryID' LIMIT 1");
$r = mysql_query("SELECT mes,date FROM `news` order by tm desc LIMIT $pg,10");
$i=0;
while (($a=mysql_fetch_array($r))!==FALSE){
      $i++;
      $mes = $a['mes'];
      $date = $a['date'];
      printrus("[$date]<br/>$mes<br/>\n---<br/>\n");
      }
if ($i>=10){
$npg = $pg+9;
printrus("<a href=\"news.php?pg=$npg&amp;$ses\">след.</a><br/>");
}
if ($pg>0){
$npg = max(0,$pg-9);
printrus("<a href=\"news.php?pg=$npg&amp;$ses\">пред.</a><br/>");
}

}


if (isset($m)) printrus ("<a href=\"faq.php?$ses\">FAQ</a><br/>");
//printrus ("---<br/><a href=\"game.php?$ses\">В игру</a><br/>");
//printrus ('---<br/><b>©</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
