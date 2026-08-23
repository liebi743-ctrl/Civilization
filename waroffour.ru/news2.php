<?
//Error_Reporting(E_ALL & ~E_NOTICE);
//ini_set('display_errors','1');
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

//шапка:
include_once("other_inc/header.php");


printrus ("<u>НОВОСТИ</u><br/>---<br/>\r\n");
$pg=addslashes($pg);

if(!isset($m)){
$r = mysql_query("SELECT mes,date FROM `news` order by tm desc LIMIT $pg,10");
$i=0;
while (($a=mysql_fetch_array($r))!==FALSE){
      $i++;
      $mes = $a['mes'];
      $date = $a['date'];
      printrus("[$date]&gt;$mes<br/>\n---<br/>\n");
      }
if ($i>=10){
$npg = $pg+9;
printrus("<a href=\"news2.php?pg=$npg&amp;$ses\">след.</a><br/>");
}
if ($pg>0){
$npg = max(0,$pg-9);
printrus("<a href=\"news2.php?pg=$npg&amp;$ses\">пред.</a><br/>");
}

}


//printrus ("---<br/><a href=\"index.php?$ses\">В игру</a><br/>");
//printrus ('---<br/><b>©</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
