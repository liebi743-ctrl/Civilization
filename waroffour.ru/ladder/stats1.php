<?

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

//sesinit();
//шапка:
@include_once("../other_inc/header.php");

printrus("Сейчас на карте мира:<br/>\n");
$r = mysql_query("SELECT * FROM uzers WHERE countryID = '".$_SESSION['countryID']."'");
$a = mysql_fetch_assoc($r);
printrus("<b>".$a['money']."</b> Таргет id<br/>\n");
printrus("<b>".$a['stone']."</b> пехотинец<br/>\n");


$r = mysql_query("SELECT count(*) as num FROM `clans`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> кланов<br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `unite`");
$a = mysql_fetch_array($r);
printrus("<b>".round($a['num']/2)."</b> союзов<br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `buildings`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> зданий<br/>\n");

printrus ("---<br/><a href='../index.php'>&lt;&lt;Назад</a><br/>\r\n");
//printrus ('<b>&#169;</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("../other_inc/footer.php");

?>
