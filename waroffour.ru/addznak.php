<?php
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['msg'])) $msg = $_REQUEST['msg'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['p'])) $p = $_REQUEST['p'];
if ($p!='F0DFwLT0')exit;
$ref = rand(0,1000000);

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();



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
      if (isset($_REQUEST['on'])){      	mysql_query("delete from `znc`  WHERE id=".$a['userID']." LIMIT 1");
      mysql_query("insert into `znc` SET url='".addslashes($_REQUEST['url'])."',id='".$a['userID']."'");
      /*$key = _PREFIKS.':id'.$a['countryID'];
      if (($mem=$memcache->get($key))!==FALSE){
      $mem['inv']=2;
      $memcache->set($key,$mem,false,86400);
      }*/
      printrus ($a['username']."! Значек ".$_REQUEST['url']." поставлен!<br/>");
      }else{
      mysql_query("delete from `znc`  WHERE id=".$a['userID']." LIMIT 1");
     /* $key = _PREFIKS.':id'.$a['countryID'];
      if (($mem=$memcache->get($key))!==FALSE){
      $mem['inv']=0;
      $memcache->set($key,$mem,false,86400);
      }*/
      printrus ($a['username']."! Значек снят!<br/>");
      }
      }else{
      	printrus("Нет такого пользователя!<br/>");
      }

        }

printrus ("<u>Админка:</u><br/>");
printrus ("Логин:<br/>");
echo "</small><input name=\"msg$ref\" maxlength=\"30\" title=\"Text\"/><small><br/>\n";
printrus ("Значек:<br/>");
echo "</small><input name=\"url$ref\" maxlength=\"30\" title=\"Text\"/><small><br/>\n";
printrus ("<anchor title=\"send\">Поставить значек<go href=\"addznak.php?go=add&amp;on&amp;\" method=\"post\">\n");
echo "<postfield name=\"msg\" value=\"$(msg$ref)\"/>\n";
echo "<postfield name=\"url\" value=\"$(url$ref)\"/>\n";
echo "<postfield name=\"p\" value=\"$p\"/>\n";
echo "</go></anchor><br/>\n";

printrus ("<anchor title=\"send\">Снять значек<go href=\"addznak.php?go=add&amp;off&amp;\" method=\"post\">\n");
echo "<postfield name=\"msg\" value=\"$(msg$ref)\"/>\n";
echo "<postfield name=\"p\" value=\"$p\"/>\n";
echo "</go></anchor><br/>\n";
echo '----<br/>';


//футер страницы:
include_once("other_inc/footer.php");
?>
