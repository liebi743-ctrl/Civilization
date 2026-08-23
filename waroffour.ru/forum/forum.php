<?php
#--------------------- WAP Lineage -------------------#
#  OLKOM.net                               L2full.ru  #
#             (c) by Trionix, 2008 - 2009             #
#-----------------------------------------------------#
define('IN_CLV',true); 
require_once("../func/functions_clv.php"); 
require_once("../other_inc/header.php");
//include_once("../uplet/antixak.php");
//include_once("../uplet/sess.php");
//include_once ('../_db_helpers_reg.php');
if(isset($_GET["movetopic"])) $movetopic=$_GET["movetopic"];
if(isset($_GET["where"])) $where=$_GET["where"];
if(isset($_GET["frd"])) $frd=$_GET["frd"];
if(isset($_POST["zag"])) $zag=$_POST["zag"];
if(isset($_POST["msg"])) $msg=$_POST["msg"];
if(isset($_POST["ftype"])) $ftype=$_POST["ftype"];
if(isset($_GET["provtop"])) $provtop=$_GET["provtop"];
if(isset($_GET["fxd"])) $fxd=$_GET["fxd"];
if(isset($_GET["newtema"])) $newtema=$_GET["newtema"];
if(isset($_GET['fid'])){$fid=($_GET['fid']);}
if(isset($_GET['id'])){$id=($_GET['id']);}
if(isset($_GET['event'])){$event=($_GET['event']);}
if(isset($_GET['page'])){$page=($_GET['page']);}
if(isset($_GET["arr"])){$arr=($_GET["arr"]);}
if(isset($_GET["m1"])){$page=($_GET["m1"]);}
if(isset($_GET["rd"])){$page=($_GET["rd"]);}
if(isset($_GET["xd"])) $xd=$_GET["xd"];
if(isset($_GET["topicrd"])){$topicrd=($_GET["topicrd"]);}
if(isset($_GET["topicxd"])){$topicxd=($_GET["topicxd"]);}
if(isset($_POST["log"])){$log=($_POST["log"]);}
if(isset($_POST["mio"])){$mio=($_POST["mio"]);}
if(isset($_POST["date"])){$date=($_POST["date"]);}
if(isset($_POST["time"])){$time=($_POST["time"]);}
if(isset($_POST["tektime"])){$tektime=($_POST["tektime"]);}
if(isset($_POST["id"])){$id=($_POST["id"]);}

/*
if ($fid == 4)
{
$id=$_SESSION[userID];
mysql_query("UPDATE uzers SET forum_news = 0 WHERE userID='$id'");
}*/

//////////////////  BEGIN PROFILE  ////////////////////
/*
if (isset($_SESSION['log']) && isset($_SESSION['pas']))
{
	$log = www($_SESSION['log']);

	if (_db_user_exists($log))
	{
        $udata = _db_select_user_data($log);
		$indatalog=trim($udata[0]);
		$indatapas=trim($udata[1]);

		if ($indatalog==$_SESSION['log'] && $indatapas==md5($_SESSION['pas']) && $_SESSION['log']!="" && md5($_SESSION['pas'])!="")
		{
			if(getenv("HTTP_X_FORWARDED_FOR")){$agent=getenv("HTTP_X_FORWARDED_FOR");}else{if(getenv("REMOTE_ADDR")) $agent=getenv("REMOTE_ADDR");}
			$agent=www1($agent);
			$ugent=www1(getenv('HTTP_USER_AGENT'));
			//if($_SESSION['ip']!='no'){if($_SESSION['ip']!=$agent){ header ("Location: ../index.php?error_aca&".SID);  ;exit;}}
			//- - - - - - - - - - - - - - - - - - - - - - - - - -//

			////////////////////// БЛОК ///////////////////////////
			if($udata[58]=="on"){ header ("Location: ../kolonia.php?".SID);  ;exit; }
            ////////////////////// БАН ////////////////////////////
			if($udata[59]=="on"){ header ("Location: ../kolonia.php?".SID);  ;exit; }
            /////////////////// СРОК СЕССИИ ///////////////////////
			$time = time_new();
			if(($_SESSION['my_time']+3600)<$time && $_SESSION['my_time']>0)
				{
				session_unset();
				session_destroy();
				header ("Location: ../index.php?error_ac"); ;exit;
				}
			//- - - - - - - - - - - - - - - - - - - - - - - - - -//
			}else{ header ("Location: ../index.php?error");  ;exit; }
		}else{ header ("Location: ../index.php?error");  ;exit; }
	}else{ header ("Location: ../index.php?error_ac");  ;exit; }
*/
if (isset($_SESSION['userID']) && isset($_SESSION['countryID']))
{
	$f = mysql_query("SELECT * FROM uzers WHERE countryID = '".$_SESSION['countryID']."'");
	$fa = mysql_fetch_array($f);
	$log = ($fa['username']);
}
$config_floodstime = "45";              #  Время антифлуда между сообщениями в сек.

if ($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) $browsus = htmlspecialchars(stripslashes($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']));
else $browsus=htmlspecialchars(stripslashes($_SERVER['HTTP_USER_AGENT']));
$brow=strtok($browsus,'(');
$brow=strtok($brow,' ');
$brow=substr($brow,0,22);
$brow=str_replace("http://","", $brow);
if(empty($brow)){$brow='not detected';}

function CheckIP ()
{global $config_floodstime;

$flag= false;
$fs= filesize('../data/flood.dat');
$f= fopen('../data/flood.dat', 'r');
flock($f, LOCK_SH);
$arr= @unserialize(fread($f, $fs));
flock($f, LOCK_UN);
fclose($f);
$IP= $_SERVER['REMOTE_ADDR'];
$IP=htmlspecialchars(stripslashes($IP));
$t= time_new();
if (isset($arr)) {
foreach ($arr as $k=>$v)
if ($v<$t) unset($arr[$k]);
} else $arr= array ();
if (!isset($arr[$IP])) {
$arr[$IP]= $t + $config_floodstime;
$flag= false;
} else {
$arr[$IP]= $t + $config_floodstime;
$flag= true;
}
$f= fopen('../data/flood.dat', 'a+');
flock($f, LOCK_EX);
ftruncate($f, 0);
@fwrite($f, serialize($arr));
fflush($f);
flock($f, LOCK_UN);
fclose($f);
return $flag;
}

function utf_bad($str) {
$ret = '';
for ($i = 0;$i < strlen($str);) {
$tmp = $str{$i++};
$ch = ord($tmp);
if ($ch > 0x7F) {
if ($ch < 0xC0) continue;
elseif ($ch < 0xE0) $di = 1;
elseif ($ch < 0xF0) $di = 2;
elseif ($ch < 0xF8) $di = 3;
elseif ($ch < 0xFC) $di = 4;
elseif ($ch < 0xFE) $di = 5;
else continue;

for ($j = 0;$j < $di;$j++) {
$tmp .= $ch = $str{$i + $j};
$ch = ord($ch);
if ($ch < 0x80 || $ch > 0xBF) continue 2;
}
$i += $di;
}
$ret .= $tmp;
}
return $ret;
}

function check($message){
$message=str_replace("|","I",$message);
$message=str_replace("||","I",$message);
$message=htmlspecialchars($message);
$message=str_replace("'","&#39;",$message);
$message=str_replace("\"","&#34;",$message);
$message=str_replace("/\\\$/","&#36;",$message);
$message=str_replace("$","&#36;",$message);
$message=str_replace("\\","&#92;", $message);
$message=str_replace("@","&#64;", $message);
$message=str_replace("`","", $message);
$message=str_replace("^","", $message);
$message=str_replace("%","&#37;", $message);
$message=str_replace(":","&#58;",$message);
$message=preg_replace("/&#58;/",":",$message,2);
/*
$message=preg_replace('/(j|J)(s|S)?/i',"***",$message);
$message=preg_replace('/(s|S)(c|C)(r|R)(i|I)(p|P)(t|T)?/i',"***",$message);
$message=preg_replace('/(i|I)(m|M)(g|G)?/i',"***",$message);
$message=preg_replace('/(s|S)(r|R)(c|C)?/i',"***",$message); $message=preg_replace('/(a|A)(l|L)(e|E)(r|R)(t|T)?/i',"***",$message);
*/
$message=stripslashes(trim($message));
return $message;  }

function utf_to_win($str){
$str=strtr($str,array("Р°"=>"а","Р±"=>"б","РІ"=>"в","Рі"=>"г","Рґ"=>"д","Рµ"=>"е","С‘"=>"ё","Р¶"=>"ж","Р·"=>"з","Рё"=>"и","Р№"=>"й","Рє"=>"к","Р»"=>"л","Рј"=>"м","РЅ"=>"н","Рѕ"=>"о","Рї"=>"п","СЂ"=>"р","СЃ"=>"с","С‚"=>"т","Сѓ"=>"у","С„"=>"ф","С…"=>"х","С†"=>"ц","С‡"=>"ч","С€"=>"ш","С‰"=>"щ","СЉ"=>"ъ","С‹"=>"ы","СЊ"=>"ь","СЌ"=>"э","СЋ"=>"ю","СЏ"=>"я",
"Рђ"=>"А","Р‘"=>"Б","Р’"=>"В","Р“"=>"Г","Р”"=>"Д","Р•"=>"Е","РЃ"=>"Ё","Р–"=>"Ж","Р—"=>"З","Р"=>"И","Р™"=>"Й","Рљ"=>"К","Р›"=>"Л","Рњ"=>"М","Рќ"=>"Н","Рћ"=>"О","Рџ"=>"П","Р "=>"Р","РЎ"=>"С","Рў"=>"Т","РЈ"=>"У","Р¤"=>"Ф","РҐ"=>"Х","Р¦"=>"Ц","Р§"=>"Ч","РЁ"=>"Ш","Р©"=>"Щ","РЄ"=>"Ъ","Р«"=>"Ы","Р¬"=>"Ь","Р­"=>"Э","Р®"=>"Ю","РЇ"=>"Я"));
 return $str;
}

function win_to_utf($str){
$str=strtr($str,array("а"=>"Р°","б"=>"Р±","в"=>"РІ","г"=>"Рі","д"=>"Рґ","е"=>"Рµ","ё"=>"С‘","ж"=>"Р¶","з"=>"Р·","и"=>"Рё","й"=>"Р№","к"=>"Рє","л"=>"Р»","м"=>"Рј","н"=>"РЅ","о"=>"Рѕ","п"=>"Рї","р"=>"СЂ","с"=>"СЃ","т"=>"С‚","у"=>"Сѓ","ф"=>"С„","х"=>"С…","ц"=>"С†","ч"=>"С‡","ш"=>"С€","щ"=>"С‰","ъ"=>"СЉ","ы"=>"С‹","ь"=>"СЊ","э"=>"СЌ","ю"=>"СЋ","я"=>"СЏ",
"А"=>"Рђ","Б"=>"Р‘","В"=>"Р’","Г"=>"Р“","Д"=>"Р”","Е"=>"Р•","Ё"=>"РЃ","Ж"=>"Р–","З"=>"Р—","И"=>"Р","Й"=>"Р™","К"=>"Рљ","Л"=>"Р›","М"=>"Рњ","Н"=>"Рќ","О"=>"Рћ","П"=>"Рџ","Р"=>"Р ","С"=>"РЎ","Т"=>"Рў","У"=>"РЈ","Ф"=>"Р¤","Х"=>"РҐ","Ц"=>"Р¦","Ч"=>"Р§","Ш"=>"РЁ","Щ"=>"Р©","Ъ"=>"РЄ","Ы"=>"Р«","Ь"=>"Р¬","Э"=>"Р­","Ю"=>"Р®","Я"=>"РЇ"));
 return $str;
}

function rus_utf_tolower($str){
$str=strtr($str,array("Рђ"=>"Р°","Р‘"=>"Р±","Р’"=>"РІ","Р“"=>"Рі","Р”"=>"Рґ","Р•"=>"Рµ","РЃ"=>"С‘","Р–"=>"Р¶","Р—"=>"Р·","Р"=>"Рё","Р™"=>"Р№","Рљ"=>"Рє","Р›"=>"Р»","Рњ"=>"Рј","Рќ"=>"РЅ","Рћ"=>"Рѕ","Рџ"=>"Рї","Р "=>"СЂ","РЎ"=>"СЃ","Рў"=>"С‚","РЈ"=>"Сѓ","Р¤"=>"С„","РҐ"=>"С…","Р¦"=>"С†","Р§"=>"С‡","РЁ"=>"С€","Р©"=>"С‰","РЄ"=>"СЉ","Р«"=>"С‹","Р¬"=>"СЊ","Р­"=>"СЌ","Р®"=>"СЋ","РЇ"=>"СЏ",
"A"=>"a","B"=>"b","C"=>"c","D"=>"d","E"=>"e","I"=>"i","F"=>"f","G"=>"g","H"=>"h","J"=>"j","K"=>"k","L"=>"l","M"=>"m","N"=>"n","O"=>"o","P"=>"p","Q"=>"q","R"=>"r","S"=>"s","T"=>"t","U"=>"u","V"=>"v","W"=>"w","X"=>"x","Y"=>"y","Z"=>"z"));
 return $str;
}

function check_full($message){
$message=str_replace("|","I",$message);
$message=str_replace("||","I",$message);
$message=str_replace("&","",$message);
$message=str_replace("\"","",$message);
$message=str_replace(">","",$message);
$message=str_replace("<","",$message);
$message=htmlspecialchars($message);
$message=str_replace("'","",$message);
$message=str_replace("\"","",$message);
$message=str_replace("/\\\$/","",$message);
$message=str_replace("$","",$message);
$message=str_replace("\\","", $message);
$message=str_replace("@","", $message);
$message=str_replace("`","", $message);
$message=str_replace("%","", $message);
$message=str_replace("^","", $message);
$message=stripslashes(trim($message));
return $message;  }

$config_forumpost = "10";               #  Кол-во отображаемых сообщений на каждой странице в форуме
$config_forumtem = "10";                #  Кол-во отображаемых тем на страницу в форуме
$config_topforum = "10";                #  Oставлять последних тем

$date=date_new("d.m");
$time=date_new("H:i");
/*	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo '<link rel="shortcut icon" href="../favicon.ico"><title>L2full.ru - '.$log.'</title>';
	echo '<style type="text/css">';
	echo 'a:link,a:active,a:visited {color: #6E7B8B; text-decoration: underline;}';
	echo 'a:hover {color: #333366; text-decoration: none;}';
	echo 'body {background-color: #EFF5FC; color: #000000;}';
	echo 'div {font-size: 11px; margin: 3px 3px 3px 3px; padding: 3px 3px 3px 3px; font-family: "Courier New", Courier, monospace;}';
	echo 'img {border: 0; margin: 0;}';
	echo 'textarea {width: 70%; font-size: 10pt; font-weight: bold;}';
	echo 'table {font-size: 13px; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;}';
	echo 'h4 {margin: 0; text-decoration: underline;}';
	echo '.a,.c {background-color: #6FA9F3; color: #FFFFFF; font-size: 11px;';
	echo 'margin: 0px; padding: 4px 4px 4px 4px; vertical-align: middle;}';
	echo '.b {background-color: #A0C8FB; margin-top: 0px; padding: 4px 4px 4px 4px; vertical-align: middle;}';
	echo '.c a:link, .c a:visited{ color: #FFFFFF; text-decoration: none;}';
	echo '.c a:hover{text-decoration: underline;}';
	echo '.d {background-color: #CCE1FC; color: #FFFFFF; font-size: 11px; text-align: center;}';
	echo '</style>';
	echo '<meta name="keywords" content="L2full.ru,онлайн,игра,lineage,wap,бесплатно,играть">';
	echo '<meta name="description" content="L2full.Ru - Онлайн Мир Lineage II (wap)- Онлайн игра всех времен и народов на экране твоего телефона.">';
	echo '</head><body bgcolor="#000000">';
	echo '<!--Powered by Share-->';
	echo '<div class="e">';*/
/*
header("Content-type:text/html; charset=utf-8");
	echo '<!--Powered by Share-->';
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo '<link rel="shortcut icon" href="../favicon.ico"><title>L2full.ru - '.$log.'</title>';
	echo '<style type="text/css">';
echo '* {margin : 0; padding : 0; }
body,td,th {font-size: 12px; color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #000000;}
a, a:active, a:visited {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; text-decoration: none; color: #FFDF8C;}
.wt {color: #dadada; font-size: 12px;}
a:hover {color: #FFFFFF; text-decoration: underline;}
.lt1 {background-image: url(../lt1.gif); background-repeat: no-repeat; background-position: right top;}
.centertd {background-color: #1d1c1a;}
.t1 {height: 48px; text-align: center; background-image: url(../picaso/t/t1.gif); background-repeat: repeat-x; background-position: top;}
.rt1 {text-align: center; background-image: url(../rt1.gif); background-repeat: no-repeat; background-position: left top;}
.l {width: 19px; background-image: url(../picaso/t/l.jpg); background-repeat: repeat-y; background-position: right;}
.r {width: 19px; background-image: url(../picaso/t/r.jpg); background-repeat: repeat-y; background-position: left;}
.lb {width: 19px; height: 22px; background-image: url(../lb.gif); background-repeat: no-repeat; background-position: right top;}
.bb {height: 22px; background-image: url(../picaso/t/b.gif); background-repeat: repeat-x; background-position: top;}
.rb {width: 19px; height: 22px; background-image: url(../picaso/t/rb.gif); background-repeat: no-repeat; background-position: left top;}
div { margin: 1px 0px 1px 0px; padding: 1px 1px 1px 1px; font-size: 12px;}
.a {text-align: center;}
table {width: 100%; border-collapse: collapse;}
hr {padding:0;margin:6px 0;height:0;background-color:#666666;border-top:none;border-bottom:#666666 solid 1px;}';

	echo '</style>';
	echo '<meta name="keywords" content="L2full.ru,онлайн,игра,lineage,wap,бесплатно,играть">';
	echo '<meta name="description" content="L2full.Ru - Онлайн Мир Lineage II (wap)- Онлайн игра всех времен и народов на экране твоего телефона.">';
	echo '</head><body>';
*/	
//echo '</div>';
/////////////////////////////////////////////////////////////////////

//if ($indatalog==$_SESSION['log'] && $indatapas==md5($_SESSION['pas']) && $_SESSION['log']!="" && md5($_SESSION['pas'])!="")
{
$file=@file("../gros/moders.dat");
$total=count($file);
for($w=0; $w<$total; $w++){
$data=explode("|",$file[$w]);
//if(($data[0]==$log && $data[1]<="5") || $log=="Konsultant2pay")
{
$date=date_new("d.m");
$time=date_new("H:i");

//----------------------------- Пересчет статистики ------------------------//
if(isset($event)) {if ($event =="revolushion") {
$lines = file("dataforum/mainforum.dat");
$countmf=count($lines)-1;
$i="-1";$u=$countmf-1;$k="0";

do {$i++; $dt=explode("|", $lines[$i]);
if ($dt[1]!="razdel") {
$fid=$dt[0];
if ((is_file("dataforum/topic$fid.dat")) && (sizeof("dataforum/topic$fid.dat")>0))
{
$fl=file("dataforum/topic$fid.dat");
$kolvotem=count($fl);
$kolvomsg="0";
for ($itf=0; $itf<$kolvotem; $itf++)
{$forumdt = explode("|", $fl[$itf]);

$cd=$forumdt[7];
$msgfile=file("dataforum/$cd.dat");
$countmsg=count($msgfile); $kolvomsg=$kolvomsg+$countmsg;}
if ($kolvotem=="0") {$dt[8]="";}
$lines[$i]=$dt[0].'|'.$dt[1].'|'.$dt[2].'|'.$dt[3].'|'.$kolvotem.'|'.$kolvomsg.'|'.$dt[6].'|'.$dt[7].'|'.$dt[8].'|'.$dt[9].'|'.$dt[10].'|';
}else{
$kolvotem="0";
$kolvomsg="0";
$lines[$i]=$dt[0].'|'.$dt[1].'|'.$dt[2].'|'.$dt[3].'|'.$kolvotem.'|'.$kolvomsg.'|'.$dt[6].'|'.$dt[7].'|'.$dt[8].'||'.$dt[10].'|';
}
}
else {$lines[$i]=$dt[0].'|'.$dt[1].'|'.$dt[2].'|';}
} while($i < $countmf);

$file=file("dataforum/mainforum.dat");
$fp=fopen("dataforum/mainforum.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) {fputs($fp,"$lines[$i]\r\n");}
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Всё успешно пересчитано<br/>';
echo '<a href="forum.php">Продолжить</a><br/>';
include_once"down.php";
exit; }}

//------------------------ Cдвиг топиков -------------------------------//
if(isset($movetopic)) { if ($movetopic!="") {
$move1=$movetopic;
if ($where=="0") {$where="-1";}
$move2=$move1-$where;
$file=file("dataforum/mainforum.dat"); $imax=sizeof($file);
if (($move2>=$imax) or ($move2<"0")) {
echo 'Нельзя туда двигать!<br/>';
echo '<a href="forum.php">Продолжить</a><br/>';
include_once"down.php";
exit;}
$data1=$file[$move1]; $data2=$file[$move2];

$fp=fopen("dataforum/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($i=0; $i<$imax; $i++) {if ($move1==$i) {fputs($fp,$data2);} else  {if ($move2==$i) {fputs($fp,$data1);} else {fputs($fp,$file[$i]);}}}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Раздел успешно сдвинут!<br/><a href="forum.php">Продолжить</a><br/>';
//Раздел успешно сдвинут!
include_once"down.php";
exit;}}

//------------------------ Подтверждение удаления топиков -------------------------------//
if(isset($provtop)) {
echo 'Вы действительно хотите удалить топик?<br/>';
echo 'Прежде чем удалить его необходимо удалить все темы внутри вручную<br/>';
echo '<a href="forum.php?fxd='.$provtop.'">Удалить</a><br/>';
echo '<a href="forum.php">Вернуться назад</a><br/>';
include_once"down.php";
exit;
}

//------------------------ Удаление топиков -------------------------------//
if(isset($fxd)) { if ($fxd!="") {
$file=file("dataforum/mainforum.dat");
$fp=fopen("dataforum/mainforum.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) { if ($i==$fxd) {unset($file[$i]);} }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Раздел успешно удален!<br/><a href="forum.php">Продолжить</a><br/>';
//Раздел успешно удален!
include_once"down.php";
exit; }}

//----------------------- Удаление тем --------------------------------//
if (isset($xd)) { if ($xd!="") {
$file=file("dataforum/topic$fid.dat");

$dt = explode("|", $file[$xd]);

$delf=preg_replace ("|[\r\n]+|si","",$dt[7]);
unlink ("dataforum/$delf.dat");

$fp=fopen("dataforum/topic$fid.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) { if ($i==$xd) {unset($file[$i]);} }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Тема успешно удалена!<br/><a href="forum.php?fid='.$fid.'">Продолжить</a><br/>';
//Тема успешно удалена!
include_once"down.php";
exit; }}

//----------------------- Удаление сообщений --------------------------------//
if (isset($topicxd)) { if ($topicxd!="") {
$topicxd=$topicxd-1;
$file=file("dataforum/$id.dat");

if (count($file)==1) {
echo ' В ТЕМЕ должно остаться хотябы одно сообщение! <br/>';
echo '<a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;page='.$page.'">Продолжить</a><br/>';  
include_once"down.php";
exit;}

$fp=fopen("dataforum/$id.dat","w");
flock ($fp,LOCK_EX);
for ($i=0;$i< sizeof($file);$i++) { if ($i==$topicxd) {unset($file[$i]);} }
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Сообщение успешно удалено!<br/><a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;page='.$page.'">Продолжить</a><br/>';
//Сообщение успешно удалено!
include_once"down.php";
exit; }}

//----------------------- Добавление разделов --------------------------------//
if(isset($event)) {
if ($event =="addmainforum") {
if ($zag == "") {
echo '<b>Вернись назад и введи заголовок!</b><br/>';
echo '<a href="forum.php">Продолжить</a><br/>';
include_once"down.php";
exit;}

$nextnum="1";
if (is_file("dataforum/mainforum.dat")) {
$lines=file("dataforum/mainforum.dat");
$imax = count($lines); $i=0;
do {$dt = explode("|", $lines[$i]);
if ($nextnum<$dt[0]) {$nextnum=$dt[0];} $i++;
}
while($i < $imax); $nextnum++; }

$msg=check($msg);
$zag=check($zag);

if ($ftype == "") {
$txtmf=$nextnum.'|'.$zag.'|'.$msg.'||0|0||'.$date.'|'.$time.'|||';
} else {
$txtmf=$nextnum.'|'.$ftype.'|'.$zag.'|';
}
$txtmf=preg_replace ("|[\r\n]+|si","",$txtmf);

$fp=fopen("dataforum/mainforum.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$txtmf\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Раздел успешно добавлен!<br/><a href="forum.php">Продолжить</a><br/>';
//Раздел успешно добавлен!
include_once"down.php";
exit; }

//----------------------- Переименование раздела --------------------------------//
if ($event =="frdmainforum") {

if ($zag == "") {
echo '<b>Вернись назад и введи заголовок!</b><br/>';
echo '<a href="forum.php">Продолжить</a><br/>';
include_once"down.php";
exit;}

$msg=check($msg);
$zag=check($zag);
$zag=preg_replace ("|[\r\n]+|si","",$zag);
$msg=preg_replace ("|[\r\n]+|si","",$msg);
if ($ftype == "")
{
$txtmf=$nextnum.'|'.$zag.'|'.$msg.'|'.$idtemka.'|'.$kt.'|'.$km.'|'.$namem.'|'.$datem.'|'.$timem.'|'.$timetk.'|'.$temka.'|';}
else {$txtmf=$nextnum.'|'.$ftype.'|'.$zag.'|';}

$file=file("dataforum/mainforum.dat");
$fp=fopen("dataforum/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($i=0;$i< sizeof($file);$i++) {if ($frd!=$i) {fputs($fp,$file[$i]);} else {fputs($fp,"$txtmf\r\n");}}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Раздел успешно переименован!<br/><a href="forum.php">Продолжить</a><br/>';
//Раздел успешно переименован
include_once"down.php";
exit; }

//----------------------- Закрытие тем --------------------------------//
if ($event=="zakr")  {
$mio="[$brow, $ip]";
$zag=utf_bad($zag);
$text=$log.'|рус|'.$mio.'|'.$zag.'|Тема закрыта для обсуждения!|'.$date.'|'.$time.'|'.$id.'|'.$fid.'|CLOSED|';

$text=stripslashes($text);
$fp=fopen("dataforum/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
echo 'Тема закрыта для обсуждения!<br/><a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'">Продолжить</a><br/>';

//Тема закрыта для обсуждения!
include_once"down.php";
exit;}
//-------------------------- Открытие тем ----------------------------//
if ($event=="otkr")  {

$file=file("dataforum/$id.dat");
$file=array_reverse($file);
$fp=fopen("dataforum/$id.dat","w");
flock ($fp,LOCK_EX);

unset($file[0]);
$file=array_reverse($file);
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Тема снова открыта!<br/><a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'">Продолжить</a><br/>';
//Тема снова открыта
include_once"down.php";
exit;}

//------------------------ Переименование темы -------------------------------//
if ($event=="rdtema") {

$zag=check($zag);

if ($zag == "") {
echo '<b>Вернись назад и введи ТЕМУ!</b><br/>';
echo '<a href="forum.php?fid='.$fid.'&amp;rd='.$rd.'">Продолжить</a><br/>';
include_once"down.php";
exit;}

$txtmf=$name.'|рус|'.$email.'|'.$zag.'|'.$msg.'|'.$datem.'|'.$timem.'|'.$id.'||'.$timetk.'|';

$file=file("dataforum/topic$fid.dat");
$fp=fopen("dataforum/topic$fid.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($i=0;$i< sizeof($file);$i++) { if ($rd!=$i) {fputs($fp,$file[$i]);} else {fputs($fp,"$txtmf\r\n");} }
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

###############################################
$lines = file("dataforum/mainforum.dat");
$i3=count($lines);
do {$i3--; $dd = explode("|", $lines[$i3]);
if ($dd[0]==$fid) {$realfid=$i3; }
} while($i3>0);
$dd = explode("|", $lines[$realfid]);
if ($id==$dd[3]){

$txtdat=$dd[0].'|'.$dd[1].'|'.$dd[2].'|'.$dd[3].'|'.$dd[4].'|'.$dd[5].'|'.$dd[6].'|'.$dd[7].'|'.$dd[8].'|'.$dd[9].'|'.$zag.'|';

$fp2=fopen("dataforum/mainforum.dat","a+");
flock ($fp2,LOCK_EX);
ftruncate ($fp2,0);
for ($i2=0;$i2<=(sizeof($lines)-1);$i2++) {if ($i2==$realfid) {fputs($fp2,"$txtdat\r\n");} else {fputs($fp2,$lines[$i2]);}}
fflush ($fp2);
flock ($fp2,LOCK_UN);
fclose($fp2);
}
####################################################
$file1=file("dataforum/$id.dat");
$fs=count($file1)-1; $i1="-1";
$dt = explode("|", $file1[$fs]);

$text1=$dt[0].'||'.$dt[2].'|'.$zag.'|'.$dt[4].'|'.$dt[5].'|'.$dt[6].'|'.$id.'||'.$dt[7].'|';

$text1=preg_replace ("|[\r\n]+|si","",$text1);

$fp1=fopen("dataforum/$id.dat","a+");
flock ($fp1,LOCK_EX);
ftruncate ($fp1,0);

do {$i1++; if ($i1==$fs) {fputs($fp1,"$text1\r\n");} else {fputs($fp1,$file1[$i1]);} } while($i1 < $fs);
fflush ($fp1);
flock ($fp1,LOCK_UN);
fclose($fp1);

#########################################################
echo 'Тема успешно изменена!<br/><a href="forum.php?fid='.$fid.'">Продолжить</a><br/>';
//Тема успешно изменена!
include_once"down.php";
exit; }

//-------------------------------------------------------//
}
if(isset($event)){

if (($event=="addtopic") or ($event=="addanswer")) {

if (!isset($fid)) { echo'<b>Ошибка скрипта или попытка взлома!</b>';
include_once"down.php";
exit;}

$mainlines = file("dataforum/mainforum.dat"); $i=count($mainlines);
do {$i--; $dt = explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$realfid=$i; if ($dt[1]=="razdel") {
echo 'Попытка взлома, Идите нахуй!';
include_once"down.php"; exit;}}

} while($i>0);

if (strlen($msg) > 1200 || strlen($msg) < 1) {
echo '<b>сообщение пустое или слишком длинное.</b><br/>';
echo '<a href="forum.php?newtema=add&amp;fid='.$fid.'">Повторить</a><br/>';
include_once"down.php";
exit;}

if (strlen($zag) > 150 || strlen($zag) < 5 ) {
echo '<b>заголовок пустой или слишком длинный!</b><br/>';
echo '<a href="forum.php?newtema=add&amp;fid='.$fid.'">Повторить</a><br/>';
include_once"down.php";
exit;}

if ($event=="addtopic") {
$tt=explode(' ', microtime_new());
$ttt="$tt[1]"+"$tt[0]";
$ttf=str_replace(".", "", $ttt);
$id = $ttf;}

$tektime=time_new();
//$mio="[$brow, $ip]";

$log=check($log);
$mio=check($mio);
$zag=check($zag);
$msg=check($msg);
$date=check($date);
$time=check($time);
$id=check($id);
$tektime=check($tektime);

$msg=preg_replace ("|[\r\n]+|si","<br/>",$msg);
//$text=$name.'|рус|'.$mio.'|'.$zag.'|<font color="skyblue">'.$msg.'</font>|'.$date.'|'.$time.'|'.$id.'|'.$fid.'|'.$tektime.'|';
$text=$name.'|рус|'.$mio.'|'.$zag.'|'.$msg.'|'.$date.'|'.$time.'|'.$id.'|'.$fid.'|'.$tektime.'|';
$text=preg_replace ("|[\r\n]+|si","",$text);

if(isset($topicrd)) {

$file=file("dataforum/$id.dat");
$fs=count($file)-1;
$i="-1";

$fp=fopen("dataforum/$id.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
do {$i++; if ($i==$topicrd) {fputs($fp,"$text\r\n");} else {fputs($fp,$file[$i]);} } while($i < $fs);
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Сообщение успешно изменено!<br/><a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;page='.$page.'">Продолжить</a><br/>';
include_once"down.php";
exit; }

if (strlen($zag)>30) {$zag=substr($zag,0,30); $zag.="...";}
$zag=utf_bad($zag);

$lines = file("dataforum/mainforum.dat");
$dt = explode("|", $lines[$realfid]);
if ($event=="addtopic") {$dt[4]++;} $dt[5]++;
$txtdat=$dt[0].'|'.$dt[1].'|'.$dt[2].'|'.$id.'|'.$dt[4].'|'.$dt[5].'|'.$name.'|'.$date.'|'.$time.'|'.$tektime.'|'.$zag.'|';

$fp=fopen("dataforum/mainforum.dat","a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($i=0;$i<=(sizeof($lines)-1);$i++) {
if ($i==$realfid) {fputs($fp,"$txtdat\r\n");} else {fputs($fp,$lines[$i]);}}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
}

//------------------------ Добавление новой темы ---------------------------------//
if ($event =="addtopic") {
$fp=fopen("dataforum/topic$fid.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);


$fp=fopen("dataforum/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);



if ($fid == 4){
mysql_query("UPDATE uzers SET forum_news=1");
}


echo 'Тема успешно добавлена!<br/><a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'">Продолжить</a><br/>';
include_once"down.php";
exit; }

if ($event=="addanswer") {
$fp=fopen("dataforum/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);

echo 'Сообщение успешно добавлено!<br/><a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;page='.$page.'">Продолжить</a><br/>';
include_once"down.php";
exit;}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($fid)) {
$mainlines = file("dataforum/mainforum.dat");
$i=count($mainlines);

if (!ctype_digit($fid)) {
echo '<h3>ОШИБКА!</h3>';
include_once"down.php";
exit;}

do {$i--; $rdt = explode("|", $mainlines[$i]);
$dt = explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$i=0;}
} while($i > "1");

$frname=$dt[1];
$frname.=' -';

if (isset($id)) {if (is_file("dataforum/$id.dat")) {$lines = file("dataforum/$id.dat"); $dt = explode("|", $lines[0]); $frtname=$dt[3]; $frtname.=" -";} else {$frtname=""; $frname="";}} else {$frtname="";} } else {$frname=""; $frtname="";}

echo '<a href="forum.php?event=revolushion"><b>Пересчитать</b></a><br/>';
echo '<a href="forum.php">Форум</a>';

if (!isset($_GET['event'])) {
if (!isset($_GET['fid'])) {

echo '<br/><hr/>';

$addform='<hr/><form action="forum.php?event=addmainforum" method="post">Добавление Раздела<br/><br/><b>Заголовок:</b><br/><input type="text" name="zag" /><br/><input type="hidden" name="ftype" value="" /><input type="submit" value="Добавить" /><br/></form>';

if (!is_file("dataforum/mainforum.dat")) {
echo '<h3>Разделы не созданы - добавьте раздел.</h3>'.$addform;
include_once"down.php";
exit;}

$lines = file("dataforum/mainforum.dat");
$datasize = sizeof($lines);
if ($datasize==0) {
echo '<h3>Разделы не созданы - добавьте раздел.</h3>'.$addform;
include_once"down.php";
exit;}

$i=count($lines);
$n="0"; $a1="-1"; $u=$i-1;
$fid="0"; $itogotem="0"; $itogomsg="0";
do {$a1++; $dt = explode("|", $lines[$a1]);
$fid=$dt[0];
if ($dt[1]=='razdel') {
echo $dt[2];}

else {
if ($dt[7]==$date) {$dt[7]='Сегодня';}
echo '<div><a href="forum.php?fid='.$fid.'">'.$dt[1].'</a>';
echo '('.$dt[4].'/'.$dt[5].')';

echo '<br/><a href="forum.php?movetopic='.$a1.'&amp;where=1">Вверх</a>';
echo ' <a href="forum.php?movetopic='.$a1.'&amp;where=0">Вниз</a>';
echo ' <a href="forum.php?frd='.$a1.'">Edit</a>';
echo ' <a href="forum.php?provtop='.$a1.'">Del</a><br/>';

echo '</div>Тема: <a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$dt[3].'">'.$dt[10].'</a><br/>';

echo 'Посл. сообщение: <b>'.$dt[6].'</b> ('.$dt[7].' - '.$dt[8].')';

$itogotem=$itogotem+$dt[4]; $itogomsg=$itogomsg+$dt[5]; }
} while($a1 < $u);

//------------------------ Форма редактирования раздела ---------------------------------//
if (isset($frd)) {
if ($frd!="") {

$lines = file("dataforum/mainforum.dat");
$dt = explode("|", $lines[$frd]);

echo '<hr/><form action="forum.php?event=frdmainforum" method="post">';
echo '<br/>Редактирование Форума';
echo '<input type="hidden" name="nextnum" value="'.$dt[0].'" />';

if ($dt[1]=='razdel') {
echo '<input type="hidden" name="ftype" value="razdel" />';
echo '<input type="text" value="'.$dt[2].'" name="zag" />';}

else {
echo '<input type="hidden" name="ftype" value="" /><br/>';
echo '<input type="text" value="'.$dt[1].'" name="zag" />';

echo '<input type="hidden" name="idtemka" value="'.$dt[3].'" />';
echo '<input type="hidden" name="kt" value="'.$dt[4].'" />';
echo '<input type="hidden" name="km" value="'.$dt[5].'" />';
echo '<input type="hidden" name="namem" value="'.$dt[6].'" />';
echo '<input type="hidden" name="datem" value="'.$dt[7].'" />';
echo '<input type="hidden" name="timem" value="'.$dt[8].'" />';
echo '<input type="hidden" name="timetk" value="'.$dt[9].'" />';
echo '<input type="hidden" name="temka" value="'.$dt[10].'" />';
}

echo '<input type="hidden" name="frd" value="'.$frd.'" />';
echo '<input type="submit" value="Изменить" /></form>';

}} else { echo $addform;}

echo'<hr/>Тем: <b>'.$itogotem.'</b><br/>Постов: <b>'.$itogomsg.'</b>';

} else {

$fid=(int)$fid;
$forums = file("dataforum/mainforum.dat");
###################################################

$iz=count($forums);

$az1='-1';
$ux=$iz-1;

do {$az1++;
$yy=explode("|", $forums[$az1]);
if ($yy[0]==$fid){$raz=$yy[1];}} while($az1 < $ux);
####################################################

echo '<a href="forum.php">'.$fname.'</a> | ';
echo '<a href="forum.php?fid='.$fid.'">'.$raz.'</a> | ';
echo '<a href="forum.php?fid='.$fid.'&amp;newtema=add">Новая тема</a><br/><hr/>';

if (is_file("dataforum/topic$fid.dat")) {
$msglines=file("dataforum/topic$fid.dat");

if (count($msglines)>0) {

$lines=file("dataforum/topic$fid.dat");
$i=count($lines); $n="0";
if (!isset($page)) {$page="0";}

if ($page>=$i) {$page=$i-1;}
if ($i-$page-$config_forumtem>=0) {$a1=$i-$page; $u=$a1-$config_forumtem;} else {$a1=$i-$page; $u=0;}

do {$a1--; $dt=explode("|", $lines[$a1]);

$filename=$dt[7];
if (is_file("dataforum/$filename.dat")) {
$msgsize = sizeof(file("dataforum/$filename.dat"));}

$datatek=file("dataforum/$filename.dat");
$pos=$msgsize-1;
$dtt = explode("|", $datatek[$pos]);

/////////////////
if ($dtt[9]!="CLOSED"){
echo '<div>>>';
}else{
echo '<div>#';
}
echo '<b><a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$dt[7].'">'.$dt[3].'</a></b>';
echo ' [Сообщений: '.$msgsize.']';
echo '<br/><a href="forum.php?fid='.$fid.'&amp;xd='.$a1.'">DEL</a> ';
echo '<a href="forum.php?fid='.$fid.'&amp;rd='.$a1.'">EDIT</a></div>';


//--------------- Правильный пост. вывод для тем (превью) ---------------------//
if($msgsize>1){$tots=$msgsize-1;}else{$tots=$msgsize;}
$ba=ceil($tots/$config_forumpost);
$ba2=floor($tots/$config_forumpost)*$config_forumpost;

echo'Страницы:';

$asd2=$page+($config_forumpost*5);

for($i=0; $i<$asd2;)
{
if($i<$tots && $i>=0){
$ii=floor(1+$i/$config_forumpost);

echo ' <a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$dt[7].'&amp;page='.$i.'">'.$ii.'</a>';
}

$i=$i+$config_forumpost;}
if($asd2<$tots){echo ' ... <a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$dt[7].'&amp;page='.$ba2.'">'.$ba.'</a>';}
//---------------------------------------------------------------------//
if ($msgsize>=2) {
$linesdat=file("dataforum/$filename.dat");
$dtdat=explode("|", $linesdat[$msgsize-1]);
$dt[0]=$dtdat[0];
$dt[1]=$dtdat[1];
$dt[2]=$dtdat[2];
$dt[5]=$dtdat[5];
$dt[6]=$dtdat[6];}

if ($dt[5]==$date) {$dt[5]='Сегодня';}
echo '<br/>Посл. сообщение: '.$dt[0].' ('.$dt[5].'/'.$dt[6].')<br/>';
} while($a1 > $u);

//----------------------- Правильный пост. вывод для тем --------------------------------//
$lines=file("dataforum/topic$fid.dat");
$a=count($lines);
$ba=ceil($a/$config_forumtem);
$ba2=floor($a/$config_forumtem)*$config_forumtem;
echo '<br/>';

echo'<hr/>Страницы:';
$asd="$page-($config_forumtem*2)";
$asd2=$page+($config_forumtem*3);

if($asd<$a && $asd>0){echo ' <a href="forum.php?fid='.$fid.'&amp;page=0">1</a> ... ';}

for($i=$asd; $i<$asd2;)
{
if($i<$a && $i>=0){
$ii=floor(1+$i/$config_forumtem);

if ($page==$i) {
echo ' <b>'.$ii.'</b>';
               }
                else {
echo ' <a href="forum.php?fid='.$fid.'&amp;page='.$i.'">'.$ii.'</a>';
                     }}
$i=$i+$config_forumtem;}
if($asd2<$a){echo ' ... <a href="forum.php?fid='.$fid.'&amp;page='.$ba2.'&amp;log='.$log.'&amp;pas='.$pas.'">'.$ba.'</a>';}

}else{echo '<br/>';}
}
//---------------------------- Редактирование  и Добавление Темы --------------------------------//
if (isset($_GET['rd'])) {
if ($_GET['rd'] !="")  {
$rd=$_GET['rd'];
$dt=explode("|", $lines[$rd]);

echo '<hr/>Редактирование Темы<br/><b>Тема:</b><br/>';
echo '<form action="forum.php?fid='.$fid.'&amp;event=rdtema" method="post">';
echo '<input type="text" name="zag" value="'.$dt[3].'" />';
echo '<input type="hidden" name="rd" value="'.$rd.'" />';
echo '<input type="hidden" name="name" value="'.$dt[0].'" />';
echo '<input type="hidden" name="email" value="'.$dt[2].'" />';
echo '<input type="hidden" name="msg" value="'.$dt[4].'" />';
echo '<input type="hidden" name="datem" value="'.$dt[5].'" />';
echo '<input type="hidden" name="timem" value="'.$dt[6].'" />';
echo '<input type="hidden" name="id" value="'.$dt[7].'" />';
echo '<input type="hidden" name="timetk" value="'.$dt[9].'" /><br/>';
echo '<input type="submit" value="Изменить" /></form>';

}}else  {
	
//--------------------- Форма добавления новой темы ----------------------//
if($newtema==add){
echo '<hr/>Добавление темы<br/>';
echo '<form action="forum.php?event=addtopic&amp;fid='.$fid.'" method="post">';

echo '<b>Заголовок темы:</b><br/>';
echo '<input type="text" name="zag" maxlength="30" /><br/>';
echo '<b>Сообщение:</b><br/>';
echo '<textarea cols="25" rows="3" name="msg"></textarea><br/>';
echo '<input type="hidden" name="name" value="'.$log.'" />';
echo '<br/><input type="submit" value="Добавить" /></form><br/>';
}
}}

}else{
if ($event=="topic"){

if ($id == "") { echo ' ошибка :-(';  include_once"down.php"; exit;}
if ($fid == "") { echo ' ошибка :-(';   include_once"down.php";  exit;}

$mainlines = file("dataforum/mainforum.dat");
$i=count($mainlines);

do {$i--; $rdt = explode("|", $mainlines[$i]);
$dt = explode("|", $mainlines[$i]);
if ($dt[0]==$fid) {$i=0;}

} while($i > "1");
$frname=$dt[1];

if (!is_file("dataforum/$id.dat")) {
//Тема удалена модератором!
header ("Location: forum.php?fid=$fid&isset=delthemes&".SID);
exit;
}else {
$lines = file("dataforum/$id.dat");
if (count($lines)>0) {

$lines = file("dataforum/$id.dat");
$i=count($lines);
$n="0";

if (!isset($page)){$page="0";}

if ($page>=$i) {$page=(round($i/$config_forumpost))*10;}
if ($i<=$config_forumpost) {$page="0";}
if ($page>=1) {$a1=$page;} else {$a1=0;}
if (($a1+$config_forumpost)<$i) {$u=$a1+$config_forumpost;} else {$u=$i;}

do {$dt = explode("|", $lines[$a1]);

$dt[4]=preg_replace("/((https?|ftp):\/\/[[:alnum:]_=\/-]+(\\.[[:alnum:]_=\/-]+)*(\/[[:alnum:]+&._=\/%]*(\\?[[:alnum:]?+&_=\/%]*)?)?)/i", "<a href='\\1'>\\1</a>", $dt[4]);

$a1++;

if (!isset($m1)) {

$filem=file("dataforum/$id.dat");
$fg=count($filem)-1;
$dg=explode("|", $filem[$fg]);
$forums = file("dataforum/mainforum.dat");
##########################################################
$iz=count($forums);
$az1="-1"; $ux=$iz-1;
do {$az1++;
$yy=explode("|", $forums[$az1]);
if ($yy[0]==$fid){$raz=$yy[1];}} while($az1 < $ux);
#############################################################
echo '<a href="forum.php">'.$fname.'</a> | ';
echo '<a href="forum.php?fid='.$fid.'">'.$raz.'</a> | ';
echo '<a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$dt[7].'">'.$dg[3].'</a><br/>';
$m1='1';
###############################
$lines2=file("dataforum/$id.dat");

$lines2=array_reverse($lines2);
$ddd=explode("|", $lines2[0]);

if ($ddd[9]!="CLOSED"){

echo '<hr/>>> ';
echo '<b><a href="forum.php?event=zakr&amp;zag='.$dt[3].'&amp;fid='.$fid.'&amp;id='.$id.'">Закрыть тему!</a></b>';
}else{
echo '<b><font color="red">Тема закрыта</font></b><br/>';

echo '<hr/>> ';
echo '<b><a href="forum.php?event=otkr&amp;fid='.$fid.'&amp;id='.$id.'">Открыть тему!</a></b>';}}
##################################
echo '<div>'.$a1.'. ';
echo '<b><a href="../search.php?nick='.$dt[0].'&amp;go=go">'.$dt[0].'</a></b> ';
echo '('.$dt[5].'/'.$dt[6].')<br/>';
echo '<a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;topicrd='.$a1.'&amp;page='.$page.'">[Edit]</a>';
echo '<a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;topicxd='.$a1.'">[Del]</a></div>';
echo $dt[4].'<br/>';

} while($a1 < $u);

//----------------------- Постраничный вывод внутри темы -----------------//
$lines = file("dataforum/$id.dat");
$a=count($lines);
$tots=$a-1;
$ba=ceil($tots/$config_forumpost);
$ba2=floor($tots/$config_forumpost)*$config_forumpost;

echo '<br/><hr/>Страницы:';
$asd="$page-($config_forumpost*3)";
$asd2=$page+($config_forumpost*4);

if($asd<$tots && $asd>0){echo ' <a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;page=0">1</a> ... ';}

for($i=$asd; $i<$asd2;)
{
if($i<$tots && $i>=0){
$ii=floor(1+$i/$config_forumpost);

if ($page==$i) {
echo ' <b>'.$ii.'</b>';
               }
                else {
echo ' <a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;page='.$i.'">'.$ii.'</a>';
                     }}

$i=$i+$config_forumpost;}
if($asd2<$tots){echo ' ... <a href="forum.php?event=topic&amp;fid='.$fid.'&amp;id='.$id.'&amp;page='.$ba2.'">'.$ba.'</a>';}
///////////////////////////////////////////////////
if (isset($topicrd)) {
$topicrd=$topicrd-1;
$lines = file("dataforum/$id.dat");
$dt = explode("|", $lines[$topicrd]);

$dt[4]=str_replace('<img src="../images/smiles/',':',$dt[4]);
$dt[4]=str_replace('.gif" alt="">','',$dt[4]);
$dt[4]=str_replace ("<br/>","\r\n",$dt[4]);
$dt[4]=str_replace ("<br />","\r\n",$dt[4]);

echo '<hr/><form action="forum.php?event=addanswer&amp;fid='.$fid.'&amp;topicrd='.$topicrd.'&amp;page='.$page.'" method="post">';
echo 'Редактирование сообщения<br/>';
echo '<br/><b>Сообщение:</b><br/>';
echo '<textarea name="msg" cols="25" rows="3">'.$dt[4].'</textarea>';
echo '<input type="hidden" name="name" value="'.$dt[0].'" />';
echo '<input type="hidden" name="id" value="'.$dt[7].'" />';
echo '<input type="hidden" name="zag" value="'.$dt[3].'" />';
echo '<input type="hidden" name="fdate" value="'.$dt[5].'" />';
echo '<input type="hidden" name="ftime" value="'.$dt[6].'" />';
echo '<input type="hidden" name="fnomer" value="'.$topicrd.'" />';
echo '<input type="hidden" name="timetk" value="'.$dt[9].'" />';
echo '<input type="hidden" name="page" value="'.$page.'" /><br/><br/>';
echo '<input type="submit" value="Изменить" /></form>';
} else  {
echo '<hr/><b>Сообщение:</b><br/>';
echo '<form action="forum.php?event=addanswer&amp;fid='.$fid.'" method="post">';
echo '<input type="hidden" name="id" value="'.$dt[7].'" />';
echo '<input type="hidden" name="page" value="'.$page.'" />';
echo '<input type="hidden" name="zag" value="'.$dt[3].'" />';
echo '<input type="hidden" name="name" value="'.$log.'" />';
echo '<textarea name="msg" cols="25" rows="3"></textarea><br/><br/>';
echo '<input type="submit" value="Отправить" /></form>';
}
}}}

}
echo'<br/><br/><a href="../forum.php">В форум</a><br/>';
echo'<a href="../main.php">На главную</a><br/><hr/>';
include_once"down.php";
exit;}}
}
echo '<b>Страница не найдена!</b>';
include_once"down.php";
exit;
?>
