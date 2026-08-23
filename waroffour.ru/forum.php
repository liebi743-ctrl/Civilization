<?php

$urls[]="/[cсСцЦс]{1}(.?){1,4}[iіиИ]{1}(.?){1,4}[vвВv]{1}(.?){1,4}[aаАa]{1}(.?){1,4}[хХxх]{1}(.?){1,4}[rРрr]{1}(.?){1,4}[уУuu]{1}/ismu";
$urls[]="/[dдД]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[rрР]{1}(.?){1,4}[zhЖжзЗхХ]{1,2}(.?){1,7}[rРр]{1}(.?){1,4}[уУu]{1}/ismu";
$urls[]="/[cСс]{1}(.?){1,4}[vВв]{1}(.?){1,4}[gГг]{1}(.?){1,4}[aАа]{1}(.?){1,4}[mМм]{1}(.?){1,4}[eЕе]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu";
$urls[]="/[kкК]{1}(.?){1,4}[oоО]{1}(.?){1,4}[lлЛ]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[kКк]{1}(.?){1,4}[tтТ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[4]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[kкК]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu";
$urls[]="/[wВв]{1}(.?){1,4}[aАа]{1}(.?){1,4}[pПпрР]{1}(.?){1,4}[sСс]{1}(.?){1,4}[cСсЦц]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu";
$urls[]="/[vВв]{1}(.?){1,4}[iИи]{1}(.?){1,4}[sСс]{1}(.?){1,4}[iИи]{1}(.?){1,4}[tТт]{1}(.?){1,4}[iИи]{1}(.?){1,4}[kКк]{1}(.?){1,4}[eЕе]{1}(.?){1,4}[oОо]{1}(.?){1,4}[sСс]{1}(.?){1,4}[уУu]{1}/ismu";
$urls[]="/[cСс]{1}(.?){1,4}[iИи]{1}(.?){1,4}[vВв]{1}(.?){1,4}[iИи]{1}(.?){1,4}[lЛл]{1}(.?){1,4}[sСс]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu";
$urls[]="/[vВв]{1}(.?){1,4}[cСсЦц]{1}(.?){1,4}[iИи]{1}(.?){1,4}[vВв]{1}(.?){1,4}[eЕе]{1}(.?){1,7}[rРрr]{1}(.?){1,4}[уУuu]{1}/ismu";


ini_set('display_errors','On');
#--------------------- WAP Lineage -------------------#
#  OLKOM.net                               L2full.ru  #
#             (c) by Trionix, 2008 - 2009             #
#-----------------------------------------------------#


define('IN_CLV',true);
require_once("func/functions_clv.php");
require_once("other_inc/header.php");



if(isset($_GET["movetopic"])) $movetopic=$_GET["movetopic"];
if(isset($_GET["where"])) $where=$_GET["where"];
if(isset($_GET["frd"])) $frd=$_GET["frd"];
if(isset($_POST["zag"])) $zag=$_POST["zag"];
if(isset($_POST["ftype"])) $ftype=$_POST["ftype"];
if(isset($_GET["provtop"])) $provtop=$_GET["provtop"];
if(isset($_GET["fxd"])) $fxd=$_GET["fxd"];
if(isset($_GET['fid'])){$fid=($_GET['fid']);}
if(isset($_GET['id'])){$id=($_GET['id']);}
if(isset($_GET['event'])){$event=($_GET['event']);}
if(isset($_GET['page'])){$page=($_GET['page']);}
//if(isset($_GET['action'])){ header ("Location: kolonia.php?".SID);  exit; }
//if($udata[61]=='on' && isset($event)){ header ("Location: kolonia.php?".SID);  exit; }
//include_once 'uplet/tema.php';
//include_once 'uplet/pers.php';

$config_floodstime='15';              #  Время антифлуда между сообщениями в сек.

if ($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) $browsus = htmlspecialchars(stripslashes($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']));
else $browsus=htmlspecialchars(stripslashes($_SERVER['HTTP_USER_AGENT']));
$brow=strtok($browsus,'(');
$brow=strtok($brow,' ');
$brow=substr($brow,0,22);
$brow=str_replace("http://","", $brow);
if(empty($brow)){$brow='not detected';}

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




if ($fid == 4)
{
$idd=$_SESSION[userID];
mysql_query("UPDATE uzers SET forum_news = 0 WHERE userID='$idd'");
}


function CheckIP ()
{global $config_floodstime;

$flag= false;
$fs= filesize('data/flood.dat');
$f= fopen('data/flood.dat', 'r');
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
$f= fopen('data/flood.dat', 'a+');
flock($f, LOCK_EX);
ftruncate($f, 0);
@fwrite($f, serialize($arr));
fflush($f);
flock($f, LOCK_UN);
fclose($f);
return $flag;
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

$config_forumpost='10';               #  Кол-во отображаемых сообщений на каждой странице в форуме
$config_forumtem='5';                #  Кол-во отображаемых тем на страницу в форуме
$config_topforum='1000';                #  Oставлять последних тем

$date=date_new('d.m');
$time=date_new('H:i');

if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }else{$ip=$_SERVER['REMOTE_ADDR'];}
$ip = htmlspecialchars(stripslashes(addslashes($ip)));
if (isset($_SESSION['userID']) && isset($_SESSION['countryID']))
{
	$f = mysql_query("SELECT * FROM countries WHERE countryID = '".$_SESSION['countryID']."'");
	$fa = mysql_fetch_array($f);
	//$log = iconv('cp1251','utf-8',$fa['countryName']);
//	$log=$fa['countryName'];
	$log=iconv('cp1251','utf-8', $b['countryName']);

}
//if (isset($log))
{
$name=$log;

if($_GET['action']=='tabu'){
echo '<b>Общие правила для пользователей форума игры</b><br/>';
echo '<b>1. Порядок поведения в форуме</b><br/>';
echo 'а). Публикация ссылок на другие сайты запрещена<br/>';
echo 'б). Сообщения, нарушающие настоящие Правила, удаляются. Не следует воспринимать<br/>';
echo 'исчезновение своих сообщений следствием технического сбоя и помещать сообщения еще раз.<br/>';
echo 'в). Не одобряются попытки обратить внимание на низкий уровень знаний какого-либо участника форума.<br/>';
echo 'Все когда-то не знали простых вещей.<br/>';
echo 'г). Правила игры действуют и на форум.<br/><br/>';

echo '<b>2. При создании новых тем необходимо придерживаться следующих правил:</b><br/>';
echo 'а) Название темы должно быть информативным. Заголовки тем типа: "Подскажите",<br/>';
echo '"Есть вопрос" и подобные лишь демонстрируют Ваше неуважение к остальным участникам.<br/>';
echo 'б) Тема должна соответствовать теме раздела, в котором она помещена. Не следует открывать тему в определенном<br/>';
echo 'разделе только потому, что Вы хотите получить быстрый ответ в более посещаемом разделе.<br/>';
echo 'в) Старайтесь не делать грамматических ошибок в сообщениях, сверх меры использовать жаргонные выражения – это создаст<br/>';
echo 'негативное впечатление о вас. Сообщение, содержащее большое колличество грамматических ошибок расценивается как<br/>';
echo 'неуважение к другим участникам форума и может быть наказано баном.<br/><br/>';

echo '<b>3. Ограничения и запреты</b><br/>';
echo 'а). Запрещается устраивать дискуссию на тему несовпадения чьего-то личного мнения с Вашим.<br/>';
echo 'Не следует также обижаться по поводу Вашей неправоты. Если Вы желаете всегда оставаться правым,<br/>';
echo 'просто не участвуйте в дискуссиях.<br/>';
echo 'б). Запрещается,открывать новую тему содержащию продожение старой темы.<br/>';
echo 'в). Запрещается оставлять на форуме сообщения выражающие свои недовольства<br/>';
echo 'к действиям модераторов/администраторов игры.  <br/>';
echo 'г). Запрещено помещение сообщений, содержащих заведомо ложнyю инфоpмацию, клеветy, а также нечестные приемы ведения дискуссий<br/>';
echo 'в виде передергиваний высказываний собеседников.<br/>';
echo 'д). Запрещено использование в сообщениях нецензурных слов, брани, оскорбительных для других участников выражений.<br/><br/>';

echo '<b>4. Копирование материалов форума разрешается после одобрения администрации.</b><br/>';
if($udata[50]=='on'){echo '- - -<br/>';}elseif($udata[50]=='3' || $udata[50]=='4'){echo '<div class="b"><hr/>';}else{echo '<div class="b">';}
echo '<a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a></div>';
include_once "forum/footer.php";exit;
}

if(isset($_GET['action'])){
echo '<div><b>Добавление темы</b><br/>';
if($_SESSION['userID']!='11040' && $fid=='4') {echo '<b><span style="color:#FF0000">В разделе новостей темы может создавать только Администрация!</span></b><br/><a href="forum.php?fid='.$fid.'">Продолжить</a></div>';
include_once "forum/footer.php";exit;}
//if($udata[9]<='4'){echo 'Вы не можете создавать тема на форуме! Разрешено с 5 уровня :)<br/><a href="forum.php">Разделы форума</a><br/>- - -<br/><a href="smiles.php?go=forum">Смайлы</a></div>'; include_once "forum/footer.php";exit;}
if($fid=='1' || $fid=='2' || $fid=='3' || $fid=='4' || $fid=='5' || $fid=='6' || $fid=='7' || $fid=='8' || $fid=='9'){

if($udata[50]=='on'){
echo 'Заголовок:<br/>
<input type="text" name="zag'.time_new().'" maxlength="100" /><br/>
Сообщение:<br/>
<input name="msg'.time_new().'" maxlength="500" title="Введи сообщение" /><br/>
<anchor title="go">Добавить<go href="forum.php?event=addtopic&amp;fid='.$fid.'&amp;'.SID.'" method="post">
<postfield name="zag" value="$(zag'.time_new().')" />
<postfield name="msg" value="$(msg'.time_new().')" />
</go></anchor><br/>';
}else{
echo '<form action="forum.php?event=addtopic&amp;fid='.$fid.'" method="post">';
echo '<div>Заголовок:<br/>';
echo '<input type="text" name="zag" maxlength="100" /><br/>';
echo 'Сообщение:<br/>';
echo '<textarea cols="20" rows="3" name="msg"></textarea><br/>';
echo '<input type="submit" value="Добавить" /></div></form>';}

}else{echo 'Ошибка! Не выбран раздел для создания темы';}
if($udata[50]=='on'){echo '- - -<br/>';}elseif($udata[50]=='3' || $udata[50]=='4'){echo '<hr/>';}else{echo '</div><div class="b">';}
echo '<a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a></div>';
include_once "forum/footer.php";exit;
}

if(isset($event)){
if (isset ($_GET['msg']) or isset ($_GET['name']))
{echo '<div><b><span style="color:#FF0000">Ошибка! Слишком длинное сообщение или тема!</span></b><br/><a href="forum.php?fid='.$fid.'&amp;id='.$id.'">Продолжить</a><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a></div>'; include_once "forum/footer.php";exit;}
if (($event=='addtopic') or ($event=='addanswer'))  {
//if($udata[9]<='4'){echo '<div>Вы не можете участвовать в форуме! Разрешено с 5 уровня :)<br/><a href="forum.php">Разделы форума</a><br/>- - -<br/><a href="smiles.php?go=forum">Смайлы</a></div>'; include_once "forum/footer.php";exit;}

if (CheckIP ()){
echo '<div><b><span style="color:#FF0000">Antiflood<br/>Свои мысли нужно формулировать чётче. Не части! Отправь следующее сообщение через 15 секунд!</span></b><br/><a href="forum.php?fid='.$fid.'&amp;id='.$id.'">Продолжить</a><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a></div>'; include_once "forum/footer.php";exit;}

$zag=check_full($_POST['zag']); $msg=check($_POST['msg']); $fid=$fid;

$j=0;
while(isset($urls[$j])){
$zag = preg_replace($urls[$j], ' waroffour.ru', $zag);
$msg = preg_replace($urls[$j], ' waroffour.ru', $msg);
$j++;
}

/*$msg=preg_replace("/[cсСцЦ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[aаА]{1}(.?){1,4}[хХx]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $msg);
$zag=preg_replace("/[cсСцЦ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[aаА]{1}(.?){1,4}[хХx]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $zag);
$msg = preg_replace("/[dдД]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[rрР]{1}(.?){1,4}[zhЖжзЗхХ]{1,2}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $msg);
$msg = preg_replace("/[kкК]{1}(.?){1,4}[oоО]{1}(.?){1,4}[lлЛ]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[kКк]{1}(.?){1,4}[tтТ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[4]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[kкК]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $msg);
$zag = preg_replace("/[dдД]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[rрР]{1}(.?){1,4}[zhЖжзЗхХ]{1,2}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $zag);
$zag = preg_replace("/[kкК]{1}(.?){1,4}[oоО]{1}(.?){1,4}[lлЛ]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[kКк]{1}(.?){1,4}[tтТ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[4]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[kкК]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $zag);
$msg = preg_replace("/[cСс]{1}(.?){1,4}[vВв]{1}(.?){1,4}[gГг]{1}(.?){1,4}[aАа]{1}(.?){1,4}[mМм]{1}(.?){1,4}[eЕе]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $msg);
$zag = preg_replace("/[cСс]{1}(.?){1,4}[vВв]{1}(.?){1,4}[gГг]{1}(.?){1,4}[aАа]{1}(.?){1,4}[mМм]{1}(.?){1,4}[eЕе]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/ismu", ' waroffour.ru', $zag);
*/
//require_once 'uplet/translit.php';
if(preg_match("/[а-яА-Я]/",$msg)){}else{$msg=str_replace($trans1,$trans2,$msg);}
if ($event=='addtopic'){if(preg_match("/[а-яА-Я]/",$zag)){}else{$zag=str_replace($trans1,$trans2,$zag);}}

if (isset($_POST['page'])) {$page=www3($_POST['page']);}
if ($event=='addanswer') {
//$id=$_POST['id'];
//------------------------ Проверка существования темы --------------------//
$provfile=file('forum/dataforum/'.$id.'.dat');
$provfile = array_reverse($provfile);
$provmas = explode('|',$provfile[0]);

if($provmas[3]!=$zag){
echo '<div><b><span style="color:#FF0000">Ошибка!!!</span></b><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a></div>'; //ПОПЫТКА ВЗЛОМА
include_once "forum/footer.php";exit;}}

$mainlines = file('forum/dataforum/mainforum.dat'); $i=count($mainlines);
do {$i--; $dt=explode('|', $mainlines[$i]);
if ($dt[0]==$fid) {$realfid=$i; if ($dt[1]=='razdel') {
echo '<div><b><span style="color:#FF0000">Ошибка2!!!</span></b><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a><br/>- - -<br/><a href="smiles.php?go=forum">Смайлы</a></div>'; //ПОПЫТКА ВЗЛОМА
include_once "forum/footer.php";exit;}}
} while($i>0);

if (!isset($realfid)) {
echo '<div><b><span style="color:#FF0000">Ошибка3!!!</span></b><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a><br/>- - -<br/><a href="smiles.php?go=forum">Смайлы</a></div>'; //ПОПЫТКА ВЗЛОМА
include_once "forum/footer.php";exit;}

if (($zag=='' || strlen($zag)>'100') && $log!='Lord.GM') {
echo '<div><b><span style="color:#FF0000">Ошибка! Слишком длинное сообщение или тема!</span></b><br/><a href="forum.php?fid='.$fid.'&amp;action">Продолжить</a><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a><br/>- - -<br/><a href="smiles.php?go=forum">Смайлы</a></div>';
include_once "forum/footer.php";exit;}

if (($msg=='' || strlen($msg)>'1200') && $log!='Lord.GM') {
echo '<div><b><span style="color:#FF0000">Ошибка! Слишком длинное сообщение или тема!</span></b><br/><a href="forum.php?fid='.$fid.'&amp;action">Продолжить</a><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a><br/>- - -<br/><a href="smiles.php?go=forum">Смайлы</a></div>';
include_once "forum/footer.php";exit;}

if ($event=='addtopic') {$tt=explode(' ', microtime_new()); $ttt="$tt[1]"+"$tt[0]"; $ttf=str_replace('.', '', $ttt); $id=$ttf;}

$tektime=time_new();
$brow=check($brow);
$name=check($name);

$msg=preg_replace ("|[\r\n]+|si","<br/>",$msg);
$zag=preg_replace ("|[\r\n]+|si","",$zag);
$msg=str_replace(" ","<br/>",$msg);
$msg=str_replace("§","<br/>",$msg);
//$zag=utf_to_win($zag); $zag==wordwrap($zag,60,' ',1); $zag=win_to_utf($zag);
//$msg=utf_to_win($msg); $msg=wordwrap($msg,100,' ',1); $msg=win_to_utf($msg);
$mio="[$brow, $ip]";

$text=$name.'|рус|'.$mio.'|'.$zag.'|'.$msg.'|'.$date.'|'.$time.'|'.$id.'|'.$fid.'|'.$tektime.'|';
$text=stripslashes($text);

$exd=explode('|',$text); $name=$exd[0];
if (strlen($zag)>36) {$zag=substr($zag,0,30); $zag.="..."; $zag=utf_bad($zag);}

$lines=file('forum/dataforum/mainforum.dat');
$dt=explode('|', $lines[$realfid]); $dt[5]++;
if ($event=='addtopic') {$dt[4]++;}

$txtdat=$dt[0].'|'.$dt[1].'|'.$dt[2].'|'.$id.'|'.$dt[4].'|'.$dt[5].'|'.$name.'|'.$date.'|'.$time.'|'.$tektime.'|'.$zag.'|';

$fp=fopen('forum/dataforum/mainforum.dat',"a+");
flock ($fp,LOCK_EX);
ftruncate ($fp,0);
for ($i=0;$i<=(sizeof($lines)-1);$i++) {if ($i==$realfid) {fputs($fp,"$txtdat\r\n");} else {fputs($fp,$lines[$i]);}}
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$fp", 0777);
@chmod('forum/dataforum/mainforum.dat', 0666);
}

if ($event=='addtopic')  {
$fp=fopen('forum/dataforum/topic'.$fid.'.dat',"a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$fp", 0777);
@chmod("forum/dataforum/topic$fid.dat", 0666);
//новый блок авто-удаления старых тем
$dfile=file('forum/dataforum/topic'.$fid.'.dat');
$di = count($dfile);

if ($di>$config_topforum) {
$dudata0 = explode('|',$dfile[0]);
$dudata1 = explode('|',$dfile[1]);

unlink ("forum/dataforum/$dudata0[7].dat");
unlink ("forum/dataforum/$dudata1[7].dat");

$dfp=fopen("forum/dataforum/topic$fid.dat","w");
flock ($dfp,LOCK_EX);
unset($dfile[0]);
unset($dfile[1]);
fputs($dfp, implode("",$dfile));
flock ($dfp,LOCK_UN);
fclose($dfp);
}
///////////////////////////////////////


if ($fid == 4){
mysql_query("UPDATE uzers SET forum_news=1");
}

$fp=fopen("forum/dataforum/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$fp", 0666);
@chmod("forum/dataforum/$id.dat", 0666);

echo '<div><b><span style="color:#FF0000">Тема успешно добавлена!</span></b><br/><a href="forum.php?fid='.$fid.'&amp;id='.$id.'">Продолжить</a></div>';
include_once "forum/footer.php";exit;}

if ($event=="addanswer")  {

$lines2=file("forum/dataforum/$id.dat");
$lines2=array_reverse($lines2);
$ddd=explode("|", $lines2[0]);
if ($ddd[9]=="CLOSED"){
	 echo 'Вы не можете писать в закрытую тему!<br/><br/>';
include_once "forum/footer.php";exit;}

$fp=fopen("forum/dataforum/$id.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
@chmod("$fp", 0666);
//-------------------- Перемещение топиков при обновлении-----------------------------//
$file=file("forum/dataforum/topic$fid.dat");
$i = count($file);

$udata66 = explode("|",$file[0]);

foreach($file as $index => $val){
$udata66 = explode("|",$file[$index]);
$udata2 = explode("|",$text);
if($udata66[7]==$udata2[7]){

$fp=fopen("forum/dataforum/topic$fid.dat","w");
flock ($fp,LOCK_EX);
unset($file[$index]);
fputs($fp, implode("",$file));
flock ($fp,LOCK_UN);
fclose($fp);
}
}
$fp=fopen("forum/dataforum/topic$fid.dat","a+");
flock ($fp,LOCK_EX);
fputs($fp,"$text\r\n");
fflush ($fp);
flock ($fp,LOCK_UN);
fclose($fp);
echo '<div><b><span style="color:#FF0000">Сообщение успешно добавлено!</span></b><br/><a href="forum.php?fid='.$fid.'&amp;id='.$id.'&amp;page='.$page.'">Продолжить</a><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a></div>';
include_once "forum/footer.php";exit;}}}

if (isset($fid)) {
$mainlines=file('forum/dataforum/mainforum.dat');
$i=count($mainlines);

do {$i--; $dt=explode('|', $mainlines[$i]);
if ($dt[0]==$fid) {$frname=$dt[1];}
} while($i >0);

if (isset($id)) {
if (is_file('forum/dataforum/'.$id.'.dat')) {$lines=file('forum/dataforum/'.$id.'.dat'); $dtt=explode('|', $lines[0]); $frtname=$dtt[3]; $frtname.=" ->";} else {$frtname=''; $frname='';}} else {$frtname='';} } else {$frname=''; $frtname='';}

if (!isset($fid) && !isset($id))  {

$lines=file('forum/dataforum/mainforum.dat');
$datasize=sizeof($lines);

$i=count($lines);
$n='0'; $a1="-1"; $u=$i-1;
$itogotem='0'; $itogomsg='0';
do {$a1++; $dt=explode('|', $lines[$a1]);

if ($dt[1]=='razdel') {echo $dt[2];} else {

if (is_file('forum/dataforum/'.$dt[3].'.dat')) { $msgsize=sizeof(file('forum/dataforum/'.$dt[3].'.dat'));

if ($msgsize>$config_forumpost) {for($zi=0; $zi<$msgsize;) {$zii=1+$zi/$config_forumpost; $page=$zi; $zi=$zi+$config_forumpost;}} else {$page=0;}} else {$page=0;}

if ($dt[7]==$date) {$dt[7]='Сегодня';}
if (strlen($dt[10])>0) {$dt[10]='<a href="forum.php?fid='.$dt[0].'&amp;id='.$dt[3].'&amp;page='.$page.'">'.$dt[10].'</a><br/>';
}
echo '<div class="b"><b><a href="forum.php?fid='.$dt[0].'">'.$dt[1].'</a></b> ';
echo ' ('.$dt[4].'/'.$dt[5].')</div><div>';
echo 'Тема: '.$dt[10];
$da=$dt[6];
if(preg_match("/".$dt[6]."/",$moders)){$da='<span style="color:blue">'.$dt[6].'</span>';}
if($dt[6]=='Izvo.GM' || $dt[6]=='Lord.GM'){$da='<span style="color:lime">'.$dt[6].'</span>';}
for($d=0; $d<$cvetnicc; $d++){
$dtc=explode(',',$cvetnic[$d]);
if($dtc[6]==$dt[0]){$da='<span style="color:'.$dtc[1].'">'.$dt[6].'</span>';}}
echo 'Сообщение: '.$da;
echo '('.$dt[7].' / '.$dt[8].')</div>';

$itogotem=$itogotem+$dt[4];
$itogomsg=$itogomsg+$dt[5];
}
} while($a1 < $u);
}

if (isset($fid) && !isset($id)) {

echo '<div><a href="forum.php">Форум</a> | <a href="forum.php?fid='.$fid.'">'.$frname.'</a> | <a href="forum.php?fid='.$fid.'&amp;action">Создать тему</a></div>';
/////
//if ($fid=='1') {echo '<div># <a href="forum.php?fid=1&id=12890339536809"><b>Покупка Монет Удачи в моем регионе!</b></a></div>';}
////
if (is_file("forum/dataforum/topic$fid.dat"))
{
$msglines=file("forum/dataforum/topic$fid.dat");
if (count($msglines)>0) {

$lines=file("forum/dataforum/topic$fid.dat");
$i=count($lines); $n="0";
if (isset($page)) {$page=$page;} else {$page="0";}
if ($page>=$i) {$page=$i-1;}
if ($i-$page-$config_forumtem>=0) {$a1=$i-$page; $u=$a1-$config_forumtem;} else {$a1=$i-$page; $u=0;}
do {$a1--; $dt=explode("|", $lines[$a1]);

$filename=$dt[7];
$msgsize=sizeof(file("forum/dataforum/$filename.dat"));
if (is_file("forum/dataforum/$filename.dat")){

echo '<div class="b">';
#########################
$lin=file("forum/dataforum/$filename.dat");
$lin=array_reverse($lin);
$dc=explode("|", $lin[0]);

if ($dc[9]!="CLOSED"){echo '-&gt; ';} else{echo '# ';}
##########################################
if ( time_new() - $dt[9] < 86400*7 ){
    echo '<b><a href="forum.php?fid='.$fid.'&amp;id='.$dt[7].'">'.$dt[3].'</a></b>  [Cообщений: '.$msgsize.']</div>';
}
else{
    echo '<a href="forum.php?fid='.$fid.'&amp;id='.$dt[7].'">'.$dt[3].'</a> [Cообщений: '.$msgsize.']</div>';
}
//////////////////////////////////////////////////////
//if($msgsize>1){$tots=$msgsize-1;}else{$tots=$msgsize;}
$ba=ceil($msgsize/$config_forumpost);
$ba2=floor(($msgsize-1)/$config_forumpost)*$config_forumpost;

echo'<div>Страницы:';
$asd2=$page+($config_forumpost*5);
for($i=0; $i<$asd2;)
{
if($i<$msgsize && $i>=0){
$ii=floor(1+$i/$config_forumpost);
echo ' <a href="forum.php?fid='.$fid.'&amp;id='.$dt[7].'&amp;page='.$i.'">'.$ii.'</a>';
}
$i=$i+$config_forumpost;}
if($asd2<$msgsize){echo ' ... <a href="forum.php?fid='.$fid.'&amp;id='.$dt[7].'&amp;page='.$ba2.'">'.$ba.'</a>';}

if ($msgsize>=2) {$linesdat=file("forum/dataforum/$filename.dat");
$dtdat=explode("|", $linesdat[$msgsize-1]);
$dt[0]=$dtdat[0];
$dt[1]=$dtdat[1];
$dt[2]=$dtdat[2];
$dt[5]=$dtdat[5];
$dt[6]=$dtdat[6];
}

$da=$dt[0];
if(preg_match("/".$dt[0]."/",$moders)){$da='<span style="color:blue">'.$dt[0].'</span>';}
if($dt[0]=='Izvo.GM' || $dt[0]=='Lord.GM'){$da='<span style="color:lime">'.$dt[0].'</span>';}
for($d=0; $d<$cvetnicc; $d++){
$dtc=explode(',',$cvetnic[$d]);
if($dtc[0]==$dt[0]){$da='<span style="color:'.$dtc[1].'">'.$dt[0].'</span>';}}
if ($dt[5]==$date) {$dt[5]='Сегодня';}
echo '<br/>Сообщение: '.$da.' ('.$dt[5].'/'.$dt[6].')</div>';
}
} while($a1 > $u);

//----------------------------Вывод всех тем форума------------------------//
$lines=file("forum/dataforum/topic$fid.dat");
$a=count($lines);
$ba=ceil($a/$config_forumtem);
$ba2=floor($a/$config_forumtem)*$config_forumtem;

echo'<hr/><div>Страницы:';
$asd=$page-($config_forumtem*2);
$asd2=$page+($config_forumtem*3);

if($asd<$a && $asd>0){echo ' <a href="forum.php?fid='.$fid.'&amp;page=0">1</a> ... ';}

for($i=$asd; $i<$asd2;)
{
if($i<$a && $i>=0){
$ii=floor(1+$i/$config_forumtem);

if ($page==$i) {
echo ' <b>('.$ii.')</b>';
               }
                else {
echo ' <a href="forum.php?fid='.$fid.'&amp;page='.$i.'">'.$ii.'</a>';
                     }}
$i=$i+$config_forumtem;}
if($asd2<$a){echo ' ... <a href="forum.php?fid='.$fid.'&amp;page='.$ba2.'">'.$ba.'</a>';}
echo"</div>";
///////////////////////////////////////////////////////

echo'<hr/><div><a href="forum.php?fid='.$fid.'&amp;action">Создать тему</a></div>';
}}
}
if (isset($fid) && isset($id)) {

if (!is_file("forum/dataforum/$id.dat")) {
//Тема удалена модератором!
	 echo '<div><b><span style="color:#FF0000">Тема была удалена модератором!</span></b><br/><a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a><br/>- - -<br/><a href="smiles.php?go=forum">Смайлы</a></div>';
include_once "forum/footer.php";exit;}

else {
$lines=file("forum/dataforum/$id.dat");
########################
$lines2=file("forum/dataforum/$id.dat");
$lines2=array_reverse($lines2);
$ddd=explode("|", $lines2[0]);
if ($ddd[9]=="CLOSED"){
echo '<b><span style="color:red"> Тема закрыта</span></b><br/>';
}
##################
if (count($lines)>0) {
$lines=file("forum/dataforum/$id.dat");

$lines2=array_reverse($lines);
$ddd=explode("|", $lines2[0]);
$i=count($lines); $n="0"; $tblstyle="row1";
if (isset($page)) {$page=$page;} else {$page="0";}
if ($page>=$i) {$page=(round($i/$config_forumpost))*10;}
if ($i<=$config_forumpost) {$page="0";}
if ($page>=1) {$a1=$page;} else {$a1=0;}
if (($a1+$config_forumpost)<$i) {$u=$a1+$config_forumpost;} else {$u=$i;}

do {$dt=explode('|', $lines[$a1]);
///////////////////////////////////////
$dt[4]=str_replace('.1.','<img src="picaso/smiles/1.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.2.','<img src="picaso/smiles/2.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.3.','<img src="picaso/smiles/3.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.4.','<img src="picaso/smiles/4.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.5.','<img src="picaso/smiles/5.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.6.','<img src="picaso/smiles/6.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.7.','<img src="picaso/smiles/7.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.8.','<img src="picaso/smiles/8.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.9.','<img src="picaso/smiles/9.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.10.','<img src="picaso/smiles/10.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.11.','<img src="picaso/smiles/11.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.12.','<img src="picaso/smiles/12.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.13.','<img src="picaso/smiles/13.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.14.','<img src="picaso/smiles/14.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.15.','<img src="picaso/smiles/15.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.16.','<img src="picaso/smiles/16.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.17.','<img src="picaso/smiles/17.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.18.','<img src="picaso/smiles/18.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.19.','<img src="picaso/smiles/19.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.20.','<img src="picaso/smiles/20.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.21.','<img src="picaso/smiles/21.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.22.','<img src="picaso/smiles/22.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.23.','<img src="picaso/smiles/23.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.24.','<img src="picaso/smiles/24.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.25.','<img src="picaso/smiles/25.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.26.','<img src="picaso/smiles/26.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.27.','<img src="picaso/smiles/27.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.28.','<img src="picaso/smiles/28.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.29.','<img src="picaso/smiles/29.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.30.','<img src="picaso/smiles/30.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.31.','<img src="picaso/smiles/31.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.32.','<img src="picaso/smiles/31.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.33.','<img src="picaso/smiles/33.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.34.','<img src="picaso/smiles/34.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.35.','<img src="picaso/smiles/35.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.36.','<img src="picaso/smiles/36.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.37.','<img src="picaso/smiles/37.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.38.','<img src="picaso/smiles/38.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.39.','<img src="picaso/smiles/39.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.40.','<img src="picaso/smiles/40.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.41.','<img src="picaso/smiles/41.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.42.','<img src="picaso/smiles/42.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.43.','<img src="picaso/smiles/43.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.44.','<img src="picaso/smiles/44.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.45.','<img src="picaso/smiles/45.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.46.','<img src="picaso/smiles/46.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.47.','<img src="picaso/smiles/47.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.48.','<img src="picaso/smiles/48.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.49.','<img src="picaso/smiles/49.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.50.','<img src="picaso/smiles/50.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.51.','<img src="picaso/smiles/51.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.52.','<img src="picaso/smiles/52.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.53.','<img src="picaso/smiles/53.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.54.','<img src="picaso/smiles/54.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.55.','<img src="picaso/smiles/55.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.56.','<img src="picaso/smiles/56.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.57.','<img src="picaso/smiles/57.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.58.','<img src="picaso/smiles/58.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.59.','<img src="picaso/smiles/59.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.60.','<img src="picaso/smiles/60.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.61.','<img src="picaso/smiles/61.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.62.','<img src="picaso/smiles/62.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.63.','<img src="picaso/smiles/63.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.64.','<img src="picaso/smiles/64.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.65.','<img src="picaso/smiles/65.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.66.','<img src="picaso/smiles/66.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.67.','<img src="picaso/smiles/67.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.68.','<img src="picaso/smiles/68.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.69.','<img src="picaso/smiles/69.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.70.','<img src="picaso/smiles/70.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.71.','<img src="picaso/smiles/71.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.72.','<img src="picaso/smiles/72.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.73.','<img src="picaso/smiles/73.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.74.','<img src="picaso/smiles/74.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.75.','<img src="picaso/smiles/75.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.76.','<img src="picaso/smiles/76.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.77.','<img src="picaso/smiles/77.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.78.','<img src="picaso/smiles/78.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.79.','<img src="picaso/smiles/79.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.80.','<img src="picaso/smiles/80.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.81.','<img src="picaso/smiles/81.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.82.','<img src="picaso/smiles/82.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.83.','<img src="picaso/smiles/83.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.84.','<img src="picaso/smiles/84.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.85.','<img src="picaso/smiles/85.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.86.','<img src="picaso/smiles/86.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.87.','<img src="picaso/smiles/87.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.88.','<img src="picaso/smiles/88.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.89.','<img src="picaso/smiles/89.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.90.','<img src="picaso/smiles/90.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.91.','<img src="picaso/smiles/91.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.92.','<img src="picaso/smiles/92.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.93.','<img src="picaso/smiles/93.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.94.','<img src="picaso/smiles/94.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.95.','<img src="picaso/smiles/95.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.96.','<img src="picaso/smiles/96.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.97.','<img src="picaso/smiles/97.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.98.','<img src="picaso/smiles/98.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.99.','<img src="picaso/smiles/99.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.100.','<img src="picaso/smiles/100.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.102.','<img src="picaso/smiles/101.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.103.','<img src="picaso/smiles/102.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.104.','<img src="picaso/smiles/103.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.105.','<img src="picaso/smiles/104.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.106.','<img src="picaso/smiles/105.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.107.','<img src="picaso/smiles/106.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.108.','<img src="picaso/smiles/107.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.109.','<img src="picaso/smiles/108.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.110.','<img src="picaso/smiles/109.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.111.','<img src="picaso/smiles/110.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.112.','<img src="picaso/smiles/111.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.113.','<img src="picaso/smiles/112.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.114.','<img src="picaso/smiles/113.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.115.','<img src="picaso/smiles/114.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.116.','<img src="picaso/smiles/115.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.117.','<img src="picaso/smiles/116.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.118.','<img src="picaso/smiles/117.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.119.','<img src="picaso/smiles/118.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.120.','<img src="picaso/smiles/119.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.121.','<img src="picaso/smiles/120.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.122.','<img src="picaso/smiles/121.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.123.','<img src="picaso/smiles/122.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.124.','<img src="picaso/smiles/123.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.125.','<img src="picaso/smiles/124.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.126.','<img src="picaso/smiles/125.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.127.','<img src="picaso/smiles/126.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.128.','<img src="picaso/smiles/127.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.129.','<img src="picaso/smiles/128.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.130.','<img src="picaso/smiles/129.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.131.','<img src="picaso/smiles/130.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.132.','<img src="picaso/smiles/131.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.133.','<img src="picaso/smiles/132.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.134.','<img src="picaso/smiles/133.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.135.','<img src="picaso/smiles/134.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.136.','<img src="picaso/smiles/135.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.137.','<img src="picaso/smiles/136.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.138.','<img src="picaso/smiles/137.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.139.','<img src="picaso/smiles/138.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.140.','<img src="picaso/smiles/139.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.141.','<img src="picaso/smiles/140.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.142.','<img src="picaso/smiles/141.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.143.','<img src="picaso/smiles/142.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.144.','<img src="picaso/smiles/143.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.145.','<img src="picaso/smiles/144.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.146.','<img src="picaso/smiles/145.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.147.','<img src="picaso/smiles/146.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.148.','<img src="picaso/smiles/147.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.149.','<img src="picaso/smiles/148.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.150.','<img src="picaso/smiles/149.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.151.','<img src="picaso/smiles/150.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.152.','<img src="picaso/smiles/151.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.153.','<img src="picaso/smiles/152.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.154.','<img src="picaso/smiles/153.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.155.','<img src="picaso/smiles/154.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.156.','<img src="picaso/smiles/155.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.157.','<img src="picaso/smiles/156.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.158.','<img src="picaso/smiles/157.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.159.','<img src="picaso/smiles/158.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.160.','<img src="picaso/smiles/160.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.161.','<img src="picaso/smiles/161.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.162.','<img src="picaso/smiles/162.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.163.','<img src="picaso/smiles/163.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.164.','<img src="picaso/smiles/164.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.165.','<img src="picaso/smiles/165.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.166.','<img src="picaso/smiles/166.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.167.','<img src="picaso/smiles/167.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.168.','<img src="picaso/smiles/168.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.169.','<img src="picaso/smiles/169.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.170.','<img src="picaso/smiles/170.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.171.','<img src="picaso/smiles/171.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.172.','<img src="picaso/smiles/172.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.173.','<img src="picaso/smiles/173.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.174.','<img src="picaso/smiles/174.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.175.','<img src="picaso/smiles/175.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.176.','<img src="picaso/smiles/176.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.177.','<img src="picaso/smiles/177.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.178.','<img src="picaso/smiles/178.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.179.','<img src="picaso/smiles/179.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.180.','<img src="picaso/smiles/180.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.181.','<img src="picaso/smiles/181.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.182.','<img src="picaso/smiles/182.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.183.','<img src="picaso/smiles/183.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.184.','<img src="picaso/smiles/184.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.185.','<img src="picaso/smiles/185.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.186.','<img src="picaso/smiles/186.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.187.','<img src="picaso/smiles/187.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.188.','<img src="picaso/smiles/188.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.189.','<img src="picaso/smiles/189.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.190.','<img src="picaso/smiles/190.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.191.','<img src="picaso/smiles/191.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.192.','<img src="picaso/smiles/192.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.193.','<img src="picaso/smiles/193.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.194.','<img src="picaso/smiles/194.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.195.','<img src="picaso/smiles/195.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.196.','<img src="picaso/smiles/196.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.197.','<img src="picaso/smiles/197.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.198.','<img src="picaso/smiles/198.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.199.','<img src="picaso/smiles/199.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.200.','<img src="picaso/smiles/200.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.201.','<img src="picaso/smiles/201.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.202.','<img src="picaso/smiles/202.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.203.','<img src="picaso/smiles/203.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.204.','<img src="picaso/smiles/204.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.205.','<img src="picaso/smiles/205.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.206.','<img src="picaso/smiles/206.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.207.','<img src="picaso/smiles/207.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.208.','<img src="picaso/smiles/208.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.209.','<img src="picaso/smiles/209.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.210.','<img src="picaso/smiles/210.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.211.','<img src="picaso/smiles/211.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.212.','<img src="picaso/smiles/212.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.213.','<img src="picaso/smiles/213.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.214.','<img src="picaso/smiles/214.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.215.','<img src="picaso/smiles/215.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.216.','<img src="picaso/smiles/216.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.217.','<img src="picaso/smiles/217.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.218.','<img src="picaso/smiles/218.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.219.','<img src="picaso/smiles/219.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.220.','<img src="picaso/smiles/220.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.221.','<img src="picaso/smiles/221.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.222.','<img src="picaso/smiles/222.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.223.','<img src="picaso/smiles/223.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.224.','<img src="picaso/smiles/224.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.225.','<img src="picaso/smiles/225.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.226.','<img src="picaso/smiles/226.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.227.','<img src="picaso/smiles/227.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.228.','<img src="picaso/smiles/228.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.229.','<img src="picaso/smiles/229.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.230.','<img src="picaso/smiles/230.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.231.','<img src="picaso/smiles/231.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.232.','<img src="picaso/smiles/232.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.233.','<img src="picaso/smiles/233.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.234.','<img src="picaso/smiles/234.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.235.','<img src="picaso/smiles/235.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.236.','<img src="picaso/smiles/236.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.237.','<img src="picaso/smiles/237.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.238.','<img src="picaso/smiles/238.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.239.','<img src="picaso/smiles/239.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.240.','<img src="picaso/smiles/240.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.241.','<img src="picaso/smiles/241.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.242.','<img src="picaso/smiles/242.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.243.','<img src="picaso/smiles/243.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.244.','<img src="picaso/smiles/244.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.245.','<img src="picaso/smiles/245.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.246.','<img src="picaso/smiles/246.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.247.','<img src="picaso/smiles/247.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.248.','<img src="picaso/smiles/248.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.249.','<img src="picaso/smiles/249.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.250.','<img src="picaso/smiles/250.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.251.','<img src="picaso/smiles/251.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.252.','<img src="picaso/smiles/252.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.253.','<img src="picaso/smiles/253.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.254.','<img src="picaso/smiles/254.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.255.','<img src="picaso/smiles/255.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.256.','<img src="picaso/smiles/256.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.257.','<img src="picaso/smiles/257.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.258.','<img src="picaso/smiles/258.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.259.','<img src="picaso/smiles/259.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.260.','<img src="picaso/smiles/260.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.261.','<img src="picaso/smiles/261.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.262.','<img src="picaso/smiles/262.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.263.','<img src="picaso/smiles/263.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.264.','<img src="picaso/smiles/264.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.265.','<img src="picaso/smiles/265.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.266.','<img src="picaso/smiles/266.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.267.','<img src="picaso/smiles/267.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.268.','<img src="picaso/smiles/268.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.269.','<img src="picaso/smiles/269.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.270.','<img src="picaso/smiles/270.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.271.','<img src="picaso/smiles/271.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.272.','<img src="picaso/smiles/272.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.273.','<img src="picaso/smiles/273.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.274.','<img src="picaso/smiles/274.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.275.','<img src="picaso/smiles/275.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.276.','<img src="picaso/smiles/276.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.277.','<img src="picaso/smiles/277.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.278.','<img src="picaso/smiles/278.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.279.','<img src="picaso/smiles/279.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.280.','<img src="picaso/smiles/280.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.281.','<img src="picaso/smiles/281.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.282.','<img src="picaso/smiles/282.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.283.','<img src="picaso/smiles/283.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.284.','<img src="picaso/smiles/284.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.285.','<img src="picaso/smiles/285.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.286.','<img src="picaso/smiles/286.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.287.','<img src="picaso/smiles/287.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.288.','<img src="picaso/smiles/288.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.289.','<img src="picaso/smiles/289.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.290.','<img src="picaso/smiles/290.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.291.','<img src="picaso/smiles/291.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.292.','<img src="picaso/smiles/292.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.293.','<img src="picaso/smiles/293.gif" alt="0"/>',$dt[4]);
$dt[4]=str_replace('.294.','<img src="picaso/smiles/294.gif" alt="0"/>',$dt[4]);
///////////////////////////////////////
$statwho='<span style="color:red">[Off]</span>';

//$onl=mysql_result(mysql_query("SELECT COUNT(*) FROM `online` WHERE `0` = '$dt[0]'"),0);
$onl=mysql_result(mysql_query("SELECT COUNT(*) FROM uzers WHERE onlineflag>0 AND userID = '".$_SESSION['userID']."'"),0);
if($onl>0){$statwho='<span style="color:#00FF00">[On]</span>';}

$a1++;
if ($tblstyle=='row1') {$tblstyle='row2';} else {$tblstyle='row1';}

if (!isset($m1)) {
echo '<div><a href="forum.php">Форум</a> | <a href="forum.php?fid='.$fid.'">'.$frname.'</a></div>';

$file1=file("forum/dataforum/$id.dat");
$fs=count($file1)-1;
$dd=explode("|", $file1[$fs]);

echo '<div>- <b>'.$dd[3].'</b><hr/></div>';
$m1=1;}

echo'<div class="b">';
$da=$dt[0];
if(preg_match("/".$dt[0]."/",$moders)){$da='<span style="color:blue">'.$dt[0].'</span>';}
if($dt[0]=='Izvo.GM' || $dt[0]=='Lord.GM'){$da='<span style="color:lime">'.$dt[0].'</span>';}
for($d=0; $d<$cvetnicc; $d++){
$dtc=explode(',',$cvetnic[$d]);
if($dtc[0]==$dt[0]){$da='<span style="color:'.$dtc[1].'">'.$dt[0].'</span>';}}
echo '<b>'.$a1.'. <a href="search.php?nick='.$dt[0].'&amp;go=go">'.$da.'</a></b> '.$statwho;

echo'('.$dt[5].'/'.$dt[6].')</div><div>'.$dt[4].'</div>';
} while($a1 < $u);

$lines=file("forum/dataforum/$id.dat");
$a=count($lines);

$ba=ceil($a/$config_forumpost);
$ba2=floor(($a-1)/$config_forumpost)*$config_forumpost;

echo'<hr/><div>Страницы:';
$asd=$page-($config_forumpost*3);
$asd2=$page+($config_forumpost*4);

if($asd<$a && $asd>0){echo ' <a href="forum.php?fid='.$fid.'&amp;id='.$id.'&amp;page=0">1</a> ... ';}

for($i=$asd; $i<$asd2;)
{
if($i<$a && $i>=0){
$ii=floor(1+$i/$config_forumpost);

if ($page==$i) {
echo ' <b>('.$ii.')</b>';
               }
                else {
echo ' <a href="forum.php?fid='.$fid.'&amp;id='.$id.'&amp;page='.$i.'">'.$ii.'</a>';
                     }}
$i=$i+$config_forumpost;}
if($asd2<$a){echo ' ... <a href="forum.php?fid='.$fid.'&amp;id='.$id.'&amp;page='.$ba2.'">'.$ba.'</a>';}
echo '</div>';

$lines2=file("forum/dataforum/$id.dat");
$lines2=array_reverse($lines2);
$ddd=explode("|", $lines2[0]);
if ($ddd[9]!="CLOSED"){

if($udata[50]=='on'){
echo 'Сообщение:<br/><input name="msg'.time_new().'" maxlength="500" title="Введи сообщение" /><br/>
<anchor title="go">Отправить<go href="forum.php?event=addanswer&amp;fid='.$fid.'&amp;page='.$page.'&amp;id='.$id.'&amp;'.SID.'" method="post">
<postfield name="zag" value="'.$ddd[3].'" />
<postfield name="msg" value="$(msg'.time_new().')" />
</go></anchor><br/>';
}else{
echo'<form action="forum.php?event=addanswer&amp;fid='.$fid.'&amp;page='.$page.'&amp;id='.$id.'" method="post"><div>';
echo'<input type="hidden" name="zag" value="'.$ddd[3].'" />';
echo'<b>Сообщение:</b><br/>';
echo'<textarea name="msg" cols="20" rows="3"></textarea><br/>';
echo'<input type="submit" value="Отправить" /></div></form>';}
}
}}
}
if($udata[50]=='on'){echo '- - -<br/>';}elseif($udata[50]=='3' || $udata[50]=='4'){echo '<div class="b"><hr/>';}else{echo '<div class="b">';}
echo '<a href="forum.php?action=tabu">Правила</a><br/><a href="forum.php">Разделы форума</a></div>';
include_once "forum/footer.php";exit;
?>
