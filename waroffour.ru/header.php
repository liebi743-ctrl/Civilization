<?
//Error_Reporting(E_ALL & ~E_NOTICE);
$headtime = getmicrotime();
//header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=86400');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Pragma: no-cache');
header("Cache-Control: no-cache");
header("Content-type:application/xhtml+xml; charset=utf-8");

$title="Онлайн Игра Империя";
$align="left";
print"<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:wicket=\"http://www.w3.org/1999/XSL/Transform\">
<head>
<link rel=\"shortcut icon\" href=\"/favicon.ico\" />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<title>$title</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"http://imperia.mobi/style.css\" />
</head>
<body>";
// mailru
if(isset($_SESSION['mr_uid']))
{
    //global $mail_ru_data;
    //echo $mail_ru_data['header'];
    echo '<link rel="stylesheet" href="img/soc/inc_style_mr.css" type="text/css" /><div class="head">
	<a accesskey="0" href="http://tel.my.mail.ru" class="head-a">Мой мир</a> @
	<a href="http://xhtml.wap.mail.ru/cgi-bin/splash_mail/" class="head-a">Mail.Ru</a>
	</div>';
}
// END Mail.ru output
print "<div class=\"block small event\">";

//
if (isset($_SESSION['auth'])){
// выводим данные по стране
$key1=_PREFIKS.':id'.$countryID;
if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

if ($id_m==TRUE){
$b=$ma;
}else{
$query="select * from `countries` where countryID='".$_SESSION['countryID']."' limit 1";
$result=@MYSQL_QUERY($query);
$b = mysql_fetch_array($result);
}
//
  $f = mysql_query("SELECT * FROM uzers WHERE countryID = '".$_SESSION['countryID']."'");
  $fa = mysql_fetch_array($f);
  //$email = $a['Email']; //email игрока
  $cred = $fa['credits']; //золото игрока
print'<img src="/img/ico/uzer.png" alt="." /> <b>'.$b['countryName'].'</b>, <img src="/img/ico/cr.png" alt="." /> '.$b["money"].' денег, <img src="/img/ico/cr3.png" alt="." /> '.$cred.' золота, <img src="/img/ico/forest.png" alt="." /> '.$b["arbor"].' дерева, <img src="/img/ico/stone.png" alt="." /> '.$b["stone"].' камня, <img src="/img/ico/iron.png" alt="." /> '.$b['iron'].' железа, <img src="/img/ico/oil.png" alt="." /> '.$b["oil"].' нефти, <img src="/img/ico/grain.png" alt="." /> '.$b["grain"].' зерна<br/> ';
}else{print "Империя";}

print "</div>

<div class=\"content\">";

?>