<?php
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['msg'])) $msg = $_REQUEST['msg'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['p'])) $p = $_REQUEST['p'];
if ($p!='Grrr5XXxsBbBe134cYV7')exit;
$ref = rand(0,1000000);

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

if (isset($_REQUEST['obnul'])){

mysql_query("TRUNCATE TABLE `artefakt`");
mysql_query("TRUNCATE TABLE `blocks`");
mysql_query("TRUNCATE TABLE `buildings`");
mysql_query("TRUNCATE TABLE `clans`");
mysql_query("TRUNCATE TABLE `colonies`");
mysql_query("TRUNCATE TABLE `countries`");
mysql_query("TRUNCATE TABLE `general`");
mysql_query("TRUNCATE TABLE `guestbook`");
mysql_query("TRUNCATE TABLE `guestbook2`");
mysql_query("TRUNCATE TABLE `guestbook_clans`");
mysql_query("TRUNCATE TABLE `market`");
mysql_query("TRUNCATE TABLE `messages`");
mysql_query("TRUNCATE TABLE `neighbours`");
mysql_query("TRUNCATE TABLE `otkrytiya`");
mysql_query("TRUNCATE TABLE `purposes`");
mysql_query("TRUNCATE TABLE `regs`");
mysql_query("TRUNCATE TABLE `unite`");
mysql_query("TRUNCATE TABLE `wars`");
mysql_query("TRUNCATE TABLE `wars_col`");
mysql_query("TRUNCATE TABLE `works`");
mysql_query("UPDATE `uzers` SET onlineflag=0");

}

//шапка:
$headtime = getmicrotime();
header("Cache-Control: no-cache");
header ("Content-type:text/vnd.wap.wml");

$title="Р¦РёРІРёР»РёР·Р°С†РёСЏ";
$align="left";

print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.2//EN\" \"http://www.wapforum.org/DTD/wml12.dtd\">
<wml><head><meta http-equiv=\"Cache-Control\" content=\"no-cache\" forua=\"true\"/></head>
<card title='$title'>
<p align='$align'>
<small>
";


if (isset($go)){
      $msg = str_replace("$",'',$msg);
      $msg = iconv('utf-8','cp1251',$msg);
      $r = mysql_query("SELECT * FROM `uzers` WHERE username='".addslashes($msg)."' LIMIT 1");
      $a = mysql_fetch_array($r);
      if ($a!==FALSE){
      if (isset($_REQUEST['on'])){
      mysql_query("UPDATE `uzers` SET inv=2 WHERE userID=".$a['userID']." LIMIT 1");
      $key = _PREFIKS.':id'.$a['countryID'];
      if (($mem=$memcache->get($key))!==FALSE){
      $mem['inv']=2;
      $memcache->set($key,$mem,false,86400);
      }
      printrus ($a['username']." назначен модером!<br/>");
      }else{
      mysql_query("UPDATE `uzers` SET inv=0 WHERE userID=".$a['userID']." LIMIT 1");
      $key = _PREFIKS.':id'.$a['countryID'];
      if (($mem=$memcache->get($key))!==FALSE){
      $mem['inv']=0;
      $memcache->set($key,$mem,false,86400);
      }
      printrus ($a['username']." снят с модерства!<br/>");
      }
      }else{
      	printrus("Нет такого пользователя!<br/>");
      }

        }

printrus ("<u>Админка:</u><br/>");
printrus ("Drag:<br/>");
echo "</small><input name=\"msg$ref\" maxlength=\"30\" title=\"Text\"/><small><br/>\n";
printrus ("<anchor title=\"send\">Назначить модером<go href=\"admm.php?go=add&amp;on&amp;\" method=\"post\">\n");
echo "<postfield name=\"msg\" value=\"$(msg$ref)\"/>\n";
echo "<postfield name=\"p\" value=\"$p\"/>\n";
echo "</go></anchor><br/>\n";

printrus ("<anchor title=\"send\">Снять с модерства<go href=\"admm.php?go=add&amp;off&amp;\" method=\"post\">\n");
echo "<postfield name=\"msg\" value=\"$(msg$ref)\"/>\n";
echo "<postfield name=\"p\" value=\"$p\"/>\n";
echo "</go></anchor><br/>\n";
echo '----<br/>';
//printrus ('<a href="addnews.php?p=gav">Админка новостей</a><br/>');

//футер страницы:
//include_once("other_inc/footer.php");

$gtime = round(getmicrotime() - $headtime,4);
print "<br/>[$gtime sec]</small></p></card></wml>";

?>
