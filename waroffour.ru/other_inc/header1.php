<?



if ($GLOBALS['pump_redir'] == 1)
{
header("Location: http://$_SERVER[HTTP_HOST]/pump/");
die();
}

$ps = strpos($_SERVER[HTTP_HOST], 'pumpit');
$pumpit=$ps;


if ($ps <> 0)
if ($_SESSION['p_sid'] == '' AND $_REQUEST['p_sid'] == '')
{
if ($_SERVER['SCRIPT_NAME'] <> '/reg_p.php' OR 1==1){
header("Location: http://$_SERVER[HTTP_X_PARTNER]/play_app?app_id=12");
}
else{
//$_GET['username']=htmlspecialchars('fdf');
//$_REQUEST['username']=htmlspecialchars('fdf');
}
}

/*
if(!isset($_SESSION['auth']) AND $pumpit <> 0){
header("Location: http://$_SERVER[HTTP_HOST]/pump/");
die();
}
*/

//Error_Reporting(E_ALL & ~E_NOTICE);
$headtime = getmicrotime();
//header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=86400');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Pragma: no-cache');
header("Cache-Control: no-cache");
//header("Content-type:application/xhtml+xml; charset=utf-8");
header("Content-Type: text/html; charset=utf-8");

$title="Онлайн Игра Война Четырех";
$align="left";
printrus ('<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">');
printrus ("<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:wicket=\"http://www.w3.org/1999/XSL/Transform\">
<head>
<link rel=\"shortcut icon\" href=\"/favicon.ico\" />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<meta name=\"unitpay-verification\" content=\"4eff0720836a198b6174eecf02cbfd\" />
<title>$title</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://waroffour.ru/style.css\" />
</head>
<body>");










if ($ps <> 0)
{

//print_r ($_SESSION);
	$psid=$_SESSION['p_sid'];
	if ($psid == '')
	$psid=$_REQUEST['p_sid'];

	$mtt=time();
	if ( ($_SESSION['pumpit_header']=='' OR $_SESSION['pumpit_last']+3600*24 < $mtt ) AND ( $psid <> '' ) )
	{




	$query = array(
     'app_id' => PUMPIT_APP_ID,
     'p_sid'  => $psid,
     'action' => "GetWidgets",
     'sig'    => "12345"
	);
	$url = GoToPumpit($query);
	//print $url;

	//$url="http://pumpit.ru/riba_api?p_sid=j5ctGG7DFpf4W0xAV&action=GetWidgets&app_id=1&sig=08f2e9aeaef6aa0a2fd72417fdb93498";
	//print $url;
	$rez=file_get_contents($url);
	//print $rez;

	$footer=explode('"footer":"', $rez);
	$footer=explode('","header":', $footer[1]);
	$footer=$footer[0];

	$header=explode('"header":"', $rez);
	$header=explode('"}', $header[1]);
	$header=$header[0];

	//$header=iconv('utf-8', 'cp1251',$header);
	//$footer=iconv('utf-8', 'cp1251',$footer);

	$header=str_replace('\"', '"', $header);
	$footer=str_replace('\"', '"', $footer);

	$header=str_replace(';', '&amp;', $header);
	$footer=str_replace(';', '&amp;', $footer);

	$header=str_replace('&', '&amp;', $header);
	$footer=str_replace('&', '&amp;', $footer);

	$_SESSION['pumpit_header']=$header;
	$_SESSION['pumpit_footer']=$footer;

	//$_SESSION['pumpit_header']=iconv('cp1251', 'utf-8', $pumpit_data[header]);
	//$_SESSION['pumpit_footer']=iconv('cp1251', 'utf-8', $pumpit_data[footer]);
	$_SESSION['pumpit_last']=$mtt;
	}


print $_SESSION['pumpit_header'];
//print "<br/><br/><br/><br/><br/>";
}

function mobile_detect()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $ipod = strpos($user_agent,"iPod");
    $iphone = strpos($user_agent,"iPhone");
    $android = strpos($user_agent,"Android");
    $symb = strpos($user_agent,"Symbian");
    $winphone = strpos($user_agent,"WindowsPhone");
    $wp7 = strpos($user_agent,"WP7");
    $wp8 = strpos($user_agent,"WP8");
    $operam = strpos($user_agent,"Opera M");
    $palm = strpos($user_agent,"webOS");
    $berry = strpos($user_agent,"BlackBerry");
    $mobile = strpos($user_agent,"Mobile");
    $htc = strpos($user_agent,"HTC_");
    $fennec = strpos($user_agent,"Fennec/");

    if ($ipod || $iphone || $android || $symb || $winphone || $wp7 || $wp8 || $operam || $palm || $berry || $mobile || $htc || $fennec)
    {
        return true;
    }
    else
    {
        return false;
    }
}

if ( $_SERVER[HTTP_HOST] != 'waroffour.mgates.ru' && !isset($_SESSION['o_uid']) )
{

	if  (!mobile_detect())
{
	//printrus('<noindex><div id="amsb"></div><script type="text/javascript" src="//am15.net/sb.php?s=57511"></script><script type="text/javascript" src="//am15.net/cu.php?s=57511"></script></noindex>');
}
}




if ( $_SERVER[HTTP_HOST] == 'waroffour.mgates.ru' )
{
ini_set('zlib.output_compression', '0');
}else{
ini_set('zlib.output_compression', '1');
}
//mgates
require 'mgates_header.php';




// mailru
if(isset($_SESSION['mr_uid']))
{
    //global $mail_ru_data;
    //echo $mail_ru_data['header'];
    printrus ('<link rel="stylesheet" href="../img/soc/inc_style_mr.css" type="text/css" /><div class="head">
	<a accesskey="0" href="http://tel.my.mail.ru" class="head-a">Мой мир</a> @
	<a href="http://xhtml.wap.mail.ru/cgi-bin/splash_mail/" class="head-a">Mail.Ru</a>
	</div>');
}
// END Mail.ru output
if(isset($_SESSION['o_uid']))
{
    //global $soc_seti_add_data;
    //echo $soc_seti_add_data['header'];
    printrus('<div style="background-color:#ed812b;text-align:center;font-family:arial,helvetica,sans-serif;">
 <a href="http://m.odnoklassniki.ru" style="display:block;font-size:large;padding:.5em 0;color:#fff;text-decoration:none;">одноклассники</a>
</div>');
}
// END Odnoklasniki output
//printrus ("<div class=\"block small event\">");
//
if (isset($_SESSION['auth'])){
// выводим данные по стране
$query="select * from `countries` where countryID='".$_SESSION['countryID']."' limit 1";
$result=@MYSQL_QUERY($query);
$b = mysql_fetch_array($result);
/*if($b['status'] == 'kill' and $_SERVER['PHP_SELF'] != '/profile.php'){header("Location: game.php?$ses");}*/
  $f = mysql_query("SELECT * FROM `general` WHERE countryID = '".$_SESSION['countryID']."'");
  $fa = mysql_fetch_array($f);


  //$email = $a['Email']; //email игрока
  /*$cred = $fa['credits']; //алмазы игрока
printrus ("<div class=\"block small event\">");
  printrus('<img src="/img/ico/uzer.png" alt="." /> <b>'.$b['countryName'].'</b> ['.$infor.'], <img src="/img/ico/cr.png" alt="." /> '.$b["money"].' денег, <img src="/img/ico/cr3.png" alt="." /> '.$cred.' алмазы, <img src="/img/ico/forest.png" alt="." /> '.$b["arbor"].' дерева, <img src="/img/ico/stone.png" alt="." /> '.$b["stone"].' камня, <img src="/img/ico/iron.png" alt="." /> '.$b['iron'].' железа, <img src="/img/ico/oil.png" alt="." /> '.$b["oil"].' нефти, <img src="/img/ico/grain.png" alt="." /> '.$b["grain"].' зерна<br/> ');*/
printrus ("</div>");
//printrus("<span style='color:#6FCD72'>Карта очищена</span><br/>");
}else{
printrus ("<div class=\"event\">");
printrus ("<h1>Война Четырех</h1>");
printrus ("</div>");
}

//print "</div>

printrus ("<div class=\"content\">");
  // </font>

$idd=$_SESSION[userID];
$fn=mysql_fetch_array(mysql_query("SELECT forum_news FROM uzers WHERE userID='$idd'"));
if ($fn[0] == 1 AND $_GET[fid] <> 4 AND $_SERVER[PHP_SELF] <> '/game.php')
printrus ('<img src="/img/ico/news.png" alt="" /> <a href="/news.php?fid=4">Новости!</a> <b>+1</b><br/><br/>');


?>