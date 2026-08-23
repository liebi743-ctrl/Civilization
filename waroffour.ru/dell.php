<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
if (isset($_REQUEST['send'])) $yes = $_REQUEST['send'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['name'])) $name = htmlspecialchars(addslashes($_REQUEST['name']));
//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
include_once("other_inc/header.php");



printrus ("<u>За что удалили?</u><br/>\r\n");
if(!isset($yes)){printrus("Cтрана:<br/>\n");
printrus ("<form name=\"\" action=\"dell.php?send&amp;$ses\" method=\"post\">
<input name=\"name\" maxlength=\"50\" title=\"Text\" value=\"\"/>
<br/><input name=\"t1\" type=\"checkbox\" value=\"1\"/> трнслт
<br/>\n");
printrus
("<input type=\"submit\" value=\"Смотреть\"/></form><br/>
");
} else { if($t1=="1") $name = translit($name);
 $name = iconv('utf-8','cp1251',$name);
 if (!isset($name) || $name == ''){
  printrus ("Вы должны ввести название страны!<br/>\n");
 }elseif(($a = mysql_fetch_array(mysql_query("SELECT * FROM `purposes` WHERE cname = '$name' LIMIT 1")))===FALSE){
          printrus ("Страны с названием <u>$name</u> нет в статистике!<br/>\n");
  }else{
   printrus ("
   Страну <u>$name</u> удалил модер <u>$a[2]</u>.
    Причина: <br/>\n$a[1]<br/>\n
   Страна удалена ".mkTimeStr(date(U)-$a[3])." назад.<br/>\n");

  }

}
#!EMAIL_isBAD($mail)$mail='';
//$name = iconv('utf-8','cp1251',$name);
if (!isset($m))printrus ("---<br/><a href=\"game.php?$ses\">В игру</a><br/>");
else printrus ("---<br/><a href=\"reg.php\">к регистрации</a><br/>");
//printrus ('---<br/><b>©</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
