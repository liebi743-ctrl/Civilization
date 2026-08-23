<?
session_start();

$ps = strpos($_SERVER[HTTP_HOST], 'pumpit');
if ($ps <> 0)
$GLOBALS['pump_redir']=1;


define('IN_CLV',true);
//подключаем скрипты
include_once("func/functions_clv.php");
//шапка:
include_once("other_inc/header.php");

//printrus("<span style='color:#6FCD72'>Ведётся очистка карты</span><br/>");


// кроем доступ через .htaccess
if (isset($_GET['erro']))
	{
	$erro = $_GET['erro'];
	if($erro==403){printrus("Если Вы видите данное сообщение, значит Администрация добавляет в игру что-то новое :)<br/>Попробуйте зайти через несколько секунд.<br/><a href=\"index.php\">Обновить</a><br/>");}
}

if(preg_match('/(i-social|voina)/i', $_SERVER[HTTP_HOST]))
	{
printrus ("Уважаемые игроки, игра 'Титаны' нарушила условия договора, в связи с чем была отключена до разбирательства.
 Предлагаем и рекомендуем посетить не менее захватывающую и увлекательную игру ''.
 О включении 'Титанов', мы оповестим вас дальнейшим уведомлением.
 Желаем приятного времяпровождения.");
}
/*
if(isset($_SESSION['auth'])){
	header('Location: game.php');
exit;
}
if(isset($_SESSION['o_uid']) || isset($_SESSION['mr_uid'])){header ("Location: reg.php");}
if($_SERVER[HTTP_HOST] == 'imperia.mgates.ru'){header ("Location: game.php");}
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
//<a href=\"news2.php\">Новости</a><br/>\n
*/
printrus("<div class=\"a\">");
printrus("<div class=\"block\">

<img src=\"/img/pic/logo2.png\" alt=\"\" />
</div>");
 $query="select count(*) as num from uzers WHERE ip!='sysreg'";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num2 = $a['num'];
  print iconv('cp1251','utf-8',"<span style=\"font-family:Georgia\">Онлайн: <b>".online("c")."</b>, всего регистраций: <b>$num2</b></span><br/><br/>");
// print iconv('cp1251','utf-8',"Онлайн: <b>".online("c")."</b><br/>\r\n");
printrus ("<div align=\"center\" class=\"list\"><a href='reg.php'>Начать Игру</a></div>
<form name=\"\" action=\"enter.php?sawform\" method=\"get\">
Логин:<br/>
<input class=\"txt\" name=\"sawform\" type=\"hidden\" value=\"\"/>
<input class=\"txt\" name=\"username\" type=\"text\" value=\"\"/><br/>
Пароль:<br/>
<input class=\"txt\" name=\"password\" type=\"text\" value=\"\"/><br />
<input type=\"submit\" value=\"Войти в игру\"/>
</form>");

printrus("<br/><div align=\"center\" class=\"list\">
<a href='forgot.php'>Забыли пароль?</a>
<a href=\"ladder/stats.php\">Статистика</a>
<a href='ladder/'>Лидеры</a></div>
");
/*$query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num = $a['num'];*/
// print iconv('cp1251','utf-8',"Всего регистраций: <b>$num2</b><br/>\r\n");
//  $mxon=file(_ROOT.'/liders/maxon.dat');
// print iconv('cp1251','utf-8',"Макс.Онлайн: <b>".(trim($mxon[0]))."</b><br/>\r\n");
printrus('</div>');








//ботинки:
include_once("other_inc/footer.php");
//print "<br/>[0 sec]</p></card></wml>";

?>
