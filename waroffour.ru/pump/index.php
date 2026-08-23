<?



setcookie ("civilla", "");
setcookie ("cl", "");
setcookie ("clvps", "");
setcookie ("clvus", "");

/*
print "<pre>";
print_r($_GET);
print_r($_SESSION);
print "</pre>";
*/

unset($_SESSION['auth']);
unset($_SESSION['countryID']);
unset($_SESSION['userID']);





//print_r($_SERVER);

//die();

require ("../../config.php");
$dblink=@mysql_pconnect(_HOSTNAME,_USERNAME,_DBPASS) or (mySQLconnectERROR($ip,_HOSTNAME) and die("1"));
mysql_query('SET NAMES cp1251');
@mysql_select_db(_DBNAME,$dblink) or (mySQLselect_dbERROR($ip,_DBNAME) and die("2")) ;


if ($_GET['action'] == 'GetAppOnline')
	{
	
	define('IN_CLV',true);
	//подключаем скрипты
	include_once("func/functions_clv.php");
	
	$online=mysql_fetch_array(mysql_query("SELECT count('userID') as num FROM uzers WHERE onlineFlag>UNIX_TIMESTAMP()"));
	print('<?xml version="1.0" encoding="windows-1251"?>
	<response><online>'.$online['num'].'</online></response>');
	die();
	}
	
if ($_GET['action'] == 'PaymentAdd' OR $_GET['action'] == 'PaymentOk')
	{
	
	if ( $_GET[coin] == 150 )
		$_GET[coin] = $_GET[coin] + 15;
	
	if ( $_GET[coin] == 750 )
		$_GET[coin] = $_GET[coin] + 113;
	
	if ( $_GET[coin] == 1500 )
		$_GET[coin] = $_GET[coin] + 450;
	
	
	define('IN_CLV',true);
	//подключаем скрипты
	include_once("func/functions_clv.php");
	mysql_query("INSERT INTO pumpit_pay_log SET query='$_SERVER[REQUEST_URI]'");
	$username=mysql_fetch_array(mysql_query("SELECT username FROM pumpit WHERE login2=$_GET[login]"));
	//print ("SELECT username FROM pumpit WHERE login2=$_GET[login]");
	mysql_query("UPDATE `uzers` SET credits = credits + $_GET[coin] WHERE username='$username[0]' LIMIT 1");
	//print "UPDATE `uzers` SET credits = credits + $_GET[coin] WHERE username='$username[0]' LIMIT 1";
	//$online=mysql_fetch_array(mysql_query("SELECT count('userID') as num FROM uzers WHERE onlineFlag>UNIX_TIMESTAMP()"));
	print('OK');
	die();
	}	
	


mysql_query("INSERT INTO log SET a='$_SERVER[REQUEST_URI]'");

define("PUMPIT_API_URL",     "http://pumpit.ru/riba_api?");
define("PUMPIT_KEY_BILLING", "09mVsXAYRFO4rWJlw");
define("PUMPIT_KEY_API",     "SmWpBuMUaceGrK8Gi");
define("PUMPIT_APP_ID",      "12");

//http://imperia.7234930502.pumpit.ru/pump?action=DoLogin&app_id=12&login=311&p_sid=lYSMhpZbrwxAN320p&sig=dd5911b5faf2f443e8ef20d6ccc3cc39





if ($_GET['p_sid'] == '' OR $_REQUEST['p_sid'] == '' )
header("Location: http://$_SERVER[HTTP_X_PARTNER]/play_app?app_id=12");

$realsid=$_GET['p_sid'];
if ($realsid == '')
$realsid=$_REQUEST['p_sid'];



$query = array(
     'app_id' => PUMPIT_APP_ID,
     'p_sid'  => $_GET['p_sid'],
     'action' => "GetMyProfile",
     'sig'    => "12345"
);
$url = GoToPumpit($query);


//$url="http://pumpit.ru/riba_api?p_sid=j5ctGG7DFpf4W0xAV&action=GetWidgets&app_id=1&sig=08f2e9aeaef6aa0a2fd72417fdb93498";
//print $url;
$rez=file_get_contents($url);

/*
print "<br/>---<br/>";
print $rez;
print "<br/>---<br/>";
print strlen($rez);
*/

//достаем ник
$nick2=explode('nick":"', $rez);
$nick2=explode('","login', $nick2[1]);
$nick2=$nick2[0];

$nick=explode('login":', $rez);
$nick=explode('}', $nick[1]);
$nick=$nick[0];




$query = array(
     'app_id' => PUMPIT_APP_ID,
     'p_sid'  => $_GET['p_sid'],
     'action' => "GetWidgets",
     'sig'    => "12345"
);
$url = GoToPumpit($query);


//$url="http://pumpit.ru/riba_api?p_sid=j5ctGG7DFpf4W0xAV&action=GetWidgets&app_id=1&sig=08f2e9aeaef6aa0a2fd72417fdb93498";
//print $url;
$rez=file_get_contents($url);

$footer=explode('"footer":"', $rez);
$footer=explode('","header":', $footer[1]);
$footer=$footer[0];

$header=explode('"header":"', $rez);
$header=explode('"}', $header[1]);
$header=$header[0];

$header=iconv('utf-8', 'cp1251',$header);
$footer=iconv('utf-8', 'cp1251',$footer);




// Функция формирования QUERY_STRING c подписью 
function GoToPumpit($query, $billing=false) {
     // Формируем подпись запроса
     $sig = getSig($query, $billing);
      //echo "SIG: $sig"."\n";

     $url = PUMPIT_API_URL;
     // Собираем URL с сортировкой по ключам
     ksort($query);
     foreach ($query as $key=>$value){
         // Исключаем параметр sig
         if (strtolower($key)!='sig'){
             $url .= urlencode($key)."=".urlencode($value)."&";
         }
     }
     $url .= "sig=".$sig;
      //echo "URL: $url"."\n";
	  return $url;
}

// Функция формирования подписи
function getSig($query, $billing=false) {
     $str = "";
     // Собираем строку для подписи с сортировкой по ключам
     ksort($query);
     foreach ($query as $key=>$value){
         // Исключаем параметр sig
         if (strtolower($key)!='sig'){
             $str .= $key."=".$value;
         }
     }
     // echo "String for sign: $str"."\n";
     $appkey = ($billing) ? PUMPIT_KEY_BILLING : PUMPIT_KEY_API;
     return md5($str.$appkey);
}






$ps = strpos($_SERVER[HTTP_HOST], 'pumpit');

//if ($ps <> 0)
//print "pumpit";

//print_r($_SESSION);





//Widgets
//print ("INSERT INTO pumpit_data SET login='$nick', header='$header', footer='$footer'");
mysql_query("INSERT INTO pumpit_data SET login='$nick', header='$header', footer='$footer'");
//die();





$key = "this is a secret key";
$input = "Let us meet at 9 o'clock at the secret place.";

$enc_login = bin2hex( mcrypt_ecb (MCRYPT_3DES, "z7gfc8lknZps", $nick. '#' .$_GET['login'], MCRYPT_ENCRYPT) );

$q=mysql_query("SELECT * FROM pumpit WHERE login='$nick'");
//print ("SELECT * FROM pumpit WHERE login='$_GET[login]'");
$cc=mysql_num_rows($q);

//die("cc d $cc	$_GET[login]");

if ($cc == 1){
$all=mysql_fetch_array($q);
$_SESSION['p_sid']=$_GET['p_sid'];
header("Location: http://$_SERVER[HTTP_HOST]/enter.php?sawform=1&sid=$_GET[sid]&username=$all[username]&password=$all[password]");
die();
}

session_name("clv");
session_start();

/*
print_r($_GET);
print_r($_REQUEST);

print "Location: http://$_SERVER[HTTP_HOST]/reg_p.php?pumpit_login=$enc_login&p_sid=$realsid&pumpit_login2=$_GET[login]";

die();
*/


/*
$a1=("Location: http://imperia.pumpit.mmska.ru/reg_p.php?pumpit_login=1bdffd0abad8e46fc4fcce14b1eb6e3a&p_sid=wCcEAEAAELv*o8sg&pumpit_login2=4331982");
$a2=("Location: http://$_SERVER[HTTP_HOST]/reg_p.php?pumpit_login=$enc_login&p_sid=$realsid&pumpit_login2=$_GET[login]");
$a3='';
if ($a1 == $a2)
{
$a3=$a2;
}
else{
header($a2);
}
*/

$to=("Location: http://$_SERVER[HTTP_HOST]/reg_p.php?pumpit_login=$enc_login&p_sid=$realsid&pumpit_login2=$_GET[login]");
header($to);
die();



print "$a1<br/>$a2"; 
$l1=md5($a1);
$l2=md5($a2);
print "<br/>$l1<br/>$l2"; 

die();
header("Location: http://$_SERVER[HTTP_HOST]/reg_p.php?pumpit_login=$enc_login&p_sid=$realsid&pumpit_login2=$_GET[login]");
die();

define("PUMPIT_KEY_BILLING", "09mVsXAYRFO4rWJlw");
define("PUMPIT_KEY_API",     "SmWpBuMUaceGrK8Gi");
$appkey = ($billing) ? PUMPIT_KEY_BILLING : PUMPIT_KEY_API;
$appkey=md5($appkey);

//die($appkey);

$url="http://pumpit.ru/riba_api?p_sid=j5ctGG7DFpf4W0xAV&action=GetWidgets&app_id=1&sig=08f2e9aeaef6aa0a2fd72417fdb93498";
print $url;
$rez=file_get_contents($url);
print "<br/>---<br/>";
print $rez;
print "<br/>---<br/>";
print strlen($rez);


die();




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
fputs($fp, time_new()."|".$brow."|".$ip."|\r\n");
flock($fp,LOCK_UN);
fclose($fp);
chmod ('data/partner/'.$partner.'_site.dat', 0666);
}
}}
//
printrus("<div class=\"block\">

<img src=\"/imperia.png\" alt=\"o\" />
</div>

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
 $r = our_query($query);
 $a = mysql_fetch_array($r);
 $num = $a['num'];
 $query="select count(*) as num from uzers";
 $r = our_query($query);
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
