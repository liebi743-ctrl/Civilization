<?
define('IN_CLV',true);
//подключаем скрипты
include_once("func/functions_clv.php");
//шапка:
include_once("other_inc/header.php");
// кроем доступ через .htaccess
if (isset($_GET['erro']))
	{
	$erro = $_GET['erro'];
	if($erro==403){printrus("Если Вы видите данное сообщение, значит Администрация добавляет в игру что-то новое :)<br/>Попробуйте зайти через несколько секунд.<br/><a href=\"index.php\">Обновить</a><br/>");}
}
//
if(isset($_SESSION['auth'])){
	header('Location: game.php');
exit;
}
if(isset($_SESSION['o_uid']) || isset($_SESSION['mr_uid'])){header ("Location: reg.php");}
// партнеры
if($_SERVER['HTTP_HOST']=='imperia.wapos.ru'){$_GET['site']='wapos.ru';}
if(isset($_GET['site']) && empty($_SESSION['site'])){
if(preg_match ("/([<\/>\|])/i", $_GET['site'])){}
else{$_SESSION['site']=$_GET['site'];
$fp=fopen("data/site.dat","a+");
flock($fp,LOCK_EX);
fputs($fp, "$_SESSION[site]\r\n");
flock($fp,LOCK_UN);
fclose($fp);

if($_SESSION['site']==$_SESSION['site']){
if(isset($_SERVER ["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])){ $ip=$_SERVER["HTTP_X_FORWARDED_FOR"];}
if(isset($_SERVER ["HTTP_X_FWD_IP_ADDR"]) && !empty($_SERVER["HTTP_X_FWD_IP_ADDR"])){ $ip=$_SERVER["HTTP_X_FWD_IP_ADDR"];}
if(isset($_SERVER["HTTP_VIA"]) && !empty($_SERVER["HTTP_VIA"])){ $ip=$_SERVER["HTTP_VIA"];}
if(isset($_SERVER ["HTTP_PROXY_CONNECTION"]) && !empty ($_SERVER["HTTP_PROXY_CON NECTION"])){ $ip=$_SERVER["HTTP_PROXY_CON NECTION"];}
if(getenv("REMOTE_ADDR")){ $ip = getenv("REMOTE_ADDR");}
$partner=str_replace('.', '', $_SESSION['site']);

$ip=htmlspecialchars(stripslashes($ip));
if(!empty($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])){$brow=$_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];}elseif(!empty($_SERVER['HTTP_X_OPERAMINI_PHONE'])){
$brow=$_SERVER['HTTP_X_OPERAMINI_PHONE'];}else{
$brow=htmlspecialchars(stripslashes(getenv('HTTP_USER_AGENT')));}
$brow=str_replace("|", "", $brow);

$fp=fopen("data/partner/".$partner."_site.dat","a+");
flock($fp,LOCK_EX);
fputs($fp, time()."|".$brow."|".$ip."|\r\n");
flock($fp,LOCK_UN);
fclose($fp);
chmod ('data/partner/'.$partner.'_site.dat', 0666);
}
}}
//
printrus("<div class=\"block\">

<img src=\"/imperia.png\" alt=\"o\" />
</div>
<img src=\"/new.jpg\" alt=\"o\" /> <img src=\"/new.jpg\" alt=\"o\" /> <img src=\"/new.jpg\" alt=\"o\" /> <img src=\"/new.jpg\" alt=\"o\" /> <img src=\"/new.jpg\" alt=\"o\" /> <img src=\"/new.jpg\" alt=\"o\" />



<a href=\"news2.php\">Новости</a><br/>\n
<a href='reg.php'>Регистрация</a><br />-------<br/>\r\n
<form name=\"\" action=\"enter.php\" method=\"POST\">
Логин:<br/>
<input name=\"sawform\" type=\"hidden\" value=\"\"/>
<input name=\"username\" type=\"text\" value=\"\"/><br/>
Пароль:<br/>
<input name=\"password\" type=\"text\" value=\"\"/><br />
<input type=\"submit\" value=\"Вход\"/>

</form>
<a href='forgot.php'>Забыли пароль?</a><br/>
---<br/>
<a href=\"ladder/stats.php\">Статистика</a><br/>
<a href='ladder/'>Лидеры</a><br/>
");
$query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num = $a['num'];
 $query="select count(*) as num from uzers";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num2 = $a['num'];
 print iconv('cp1251','utf-8',"Всего регистраций: <b>$num2</b><br/>\r\n");
 print iconv('cp1251','utf-8',"Стран на карте мира: <b>$num</b><br/>\r\n");
 print iconv('cp1251','utf-8',"Онлайн: <b>".online("c")."</b><br/>\r\n");
  $mxon=file(_ROOT.'/liders/maxon.dat');
 print iconv('cp1251','utf-8',"Макс.Онлайн: <b>".(trim($mxon[0]))."</b><br/>\r\n");
printrus('');








//ботинки:
include_once("other_inc/footer.php");
//print "<br/>[0 sec]</p></card></wml>";

?>
