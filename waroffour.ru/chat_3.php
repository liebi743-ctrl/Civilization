<?php
/*Правила для запрета определенного домена*/
$urls[]="/[cсСцЦс]{1}(.?){1,4}[iіиИ]{1}(.?){1,4}[vвВv]{1}(.?){1,4}[aаАa]{1}(.?){1,4}[хХxх]{1}(.?){1,4}[rРрr]{1}(.?){1,4}[уУuu]{1}/is";
//$urls[]="/[cCсСцЦ]{1}(.?){1,4}[iIиИ]{1}(.?){1,4}[vVвВ]{1}(.?){1,4}[aAаА]{1,2}(.?){1,4}[sSсС]{1}(.?){1,4}[uUуУ]{1}/is";
$urls[]="/[cСс]{1}(.?){1,4}[vВв]{1}(.?){1,4}[gГг]{1}(.?){1,4}[aАа]{1}(.?){1,4}[mМм]{1}(.?){1,4}[eЕе]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is";
//$urls[]="/[kкК]{1}(.?){1,4}[oоО]{1}(.?){1,4}[lлЛ]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[kКк]{1}(.?){1,4}[tтТ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[4]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[kкК]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is";
//$urls[]="/[wВв]{1}(.?){1,4}[aАа]{1}(.?){1,4}[pПпрР]{1}(.?){1,4}[sСс]{1}(.?){1,4}[cСсЦц]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is";
//$urls[]="/[vВв]{1}(.?){1,4}[iИи]{1}(.?){1,4}[sСс]{1}(.?){1,4}[iИи]{1}(.?){1,4}[tТт]{1}(.?){1,4}[iИи]{1}(.?){1,4}[kКк]{1}(.?){1,4}[eЕе]{1}(.?){1,4}[oОо]{1}(.?){1,4}[sСс]{1}(.?){1,4}[уУu]{1}/is";
//$urls[]="/[cСс]{1}(.?){1,4}[iИи]{1}(.?){1,4}[vВв]{1}(.?){1,4}[iИи]{1}(.?){1,4}[lЛл]{1}(.?){1,4}[sСс]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is";
//$urls[]="/[vВв]{1}(.?){1,4}[cСсЦц]{1}(.?){1,4}[iИи]{1}(.?){1,4}[vВв]{1}(.?){1,4}[eЕе]{1}(.?){1,7}[rРрr]{1}(.?){1,4}[уУuu]{1}/is";

if (isset($_REQUEST['msg'])) $msg = $_REQUEST['msg'];
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(addslashes(HtmlSpecialChars($_REQUEST[$key])));  //htmlspecialchars(
}
$obnull=mktime(0, 0, 0, 12, 31, 2012)-time();// часы.минуты.секунды.месяц.день.год
//Обработка переменных:
//if (isset($_REQUEST['msg'])) $msg = $_REQUEST['msg'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['prvt'])) $prvt = $_REQUEST['prvt'];
//if (isset($_REQUEST['clv'])) $clv = $_REQUEST['clv'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg))$pg=0;
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['vl'])) $vl = $_REQUEST['vl'];
if (isset($_REQUEST['bvl'])) $bvl = $_REQUEST['bvl'];
if (isset($_REQUEST['ids'])) $ids = $_REQUEST['ids'];
if (isset($_REQUEST['post'])) $post = $_REQUEST['post'];
if (isset($_REQUEST['red'])) $red = $_REQUEST['red'];
if(isset($_REQUEST[pw])){$pw='pw&amp;';}
$ref = rand(0,1000000);

function check($str,$hsc=1){
$str=strtr($str,array(chr("0")=>"",chr("1")=>"",chr("2")=>"",chr("3")=>"",chr("4")=>"",chr("5")=>"",chr("6")=>"",chr("7")=>"",chr("8")=>"",chr("9")=>"",chr("10")=>"",chr("11")=>"",chr("12")=>"",chr("13")=>"",chr("14")=>"",chr("15")=>"",chr("16")=>"",chr("17")=>"",chr("18")=>"",chr("19")=>"",chr("20")=>"",chr("21")=>"",chr("22")=>"",chr("23")=>"",chr("24")=>"",chr("25")=>"",chr("26")=>"",chr("27")=>"",chr("28")=>"",chr("29")=>"",chr("30")=>"",chr("31")=>"","Р?"=>"И","вЂ¦"=>" ","вЂ©-"=>" ","вЂњ"=>" ","вЂќ"=>" ","вЂ©"=>" ","вЂ“"=>"-","\n"=>" ","$"=>"$$"));
if($hsc==1)$str = HtmlSpecialChars(addslashes($str));
$str = ereg_replace(" +"," ",$str);
$str = trim($str);
return $str;
}
function smiles($message){//



      $message2=explode(':',$message);
      if(is_readable(_ROOT.'/img/'.$message2[1].'.gif') and $message2[1]!='index')
      $message = str_replace(":".$message2[1].":",'<img src="img/'.$message2[1].'.gif" alt="logo"/>',$message);
      #$message = str_replace(":mods1:",'<img src="img/mentpoganiy.gif" alt="logo"/>',$message);
     /* $message = str_replace(":cvetok:",'<img src="img/ax.gif" alt="logo"/>',$message);
      $message = str_replace(":hb1:",'<img src="img/v1.gif" alt="logo"/>',$message);
      $message = str_replace(":hb2:",'<img src="img/v2.gif" alt="logo"/>',$message);
      #$message = str_replace(":pusy:",'<img src="img/BIGgirl.gif" alt="logo"/>',$message);
      $message = str_replace(":spider:",'<img src="img/a015.gif" alt="logo"/>',$message);
      $message = str_replace(":smoke:",'<img src="img/smoke.gif" alt="logo"/>',$message);
      $message = str_replace(":ruso:",'<img src="img/russian.gif" alt="logo"/>',$message);
      $message = str_replace(":ignors:",'<img src="img/ign.gif" alt="logo"/>',$message);
      $message = str_replace(":lok:",'<img src="img/jouke.gif" alt="logo"/>',$message);
      $message = str_replace(":lok2:",'<img src="img/ups.gif" alt="logo"/>',$message);
      $message = str_replace(":lovesite:",'<img src="img/love_site.gif" alt="logo"/>',$message);
      $message = str_replace(":sex:",'<img src="img/kul.gif" alt="logo"/>',$message);
      $message = str_replace(":hi:",'<img src="img/welcome.gif" alt="logo"/>',$message);
      $message = str_replace(":hana:",'<img src="img/hana.gif" alt="logo"/>',$message);
      $message = str_replace(":sssr:",'<img src="img/sssr.gif" alt="logo"/>',$message);
      */

return $message;
}
//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
$banip=trim(getIp2());
$ipban=explode('.',$banip);
$ip=$ipban[0].'.'.$ipban[1].'.'.$ipban[2];
//if($ip=='85.115.248' || $ip=='208.89.214') exit('Обычный БАН гг...');
mem_connect();

sesinit();
online("c");
$countryID = $_SESSION['countryID'];
if (isset($_REQUEST['sml'])) $_SESSION['sml'] = $_REQUEST['sml'];
$gmmm = mysql_query("SELECT * FROM `uzers` WHERE countryID = '$countryID'") or die();
$ggf = mysql_fetch_array($gmmm);
//if($ggf['datereg']=='')die();
//строка выша закоменчена gf т.к чат не срабатывает в спейсис





 /*****************************************************************************************************************************************/
 /*****************************************************************************************************************************************/




 //СКОЛЬКО СТРАН НА КАРТЕ МИРА??????
 /*$query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num = $a['num']; */
//шапка:
include_once("other_inc/header.php");

$older4 = array(1,66);//админы
$older = array(37);//старшие модеры
$older2=array();//среднии модеры

if (in_array($_SESSION['userID'],$older))$level=1;
else $level=0;
if (in_array($_SESSION['userID'],$older2))$level=2;
else $level=$level;
if (in_array($_SESSION['userID'],$older4))$level=8;
else $level=$level;

$old=array();
$old = array(106786,100247,3402,49285,120071);
$raf=array(3);
$girl=array(107288);
$zakon=array(127);/*
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.2//EN\" \"http://www.wapforum.org/DTD/wml12.dtd\">
<wml><head><meta http-equiv=\"Cache-Control\" content=\"no-cache\" forua=\"true\"/></head>
<card title='$title'>
<do type=\"options\" name=\"game\" label=\"Р’ РёРіСЂСѓ\"><go href=\"game.php?$ses\"/></do> ";
if($_SESSION['sml']!='off')
printrus("<do type=\"options\" name=\"smilesoff\" label=\"Выкл.смайлы\"><go href=\"chat_3.php?".$pw."sml=off&amp;$ses\"/></do> ");
else
printrus("<do type=\"options\" name=\"smileson\" label=\"Вкл.смайлы\"><go href=\"chat_3.php?".$pw."sml=on&amp;$ses\"/></do> ");
printrus("<do type=\"options\" name=\"give\" label=\"Проверки\"><go href=\"chat_3.php?".$pw."prov&amp;$ses\"/></do> ");
printrus("<do type=\"options\" name=\"smiles\" label=\"Смайлы\"><go href=\"chat_3.php?".$pw."str&amp;$ses\"/></do> ");
print"<do type=\"options\" name=\"game2\" label=\"РЎРѕРІРµС‚\"><go href=\"chat2.php?$ses\"/></do>
<do type=\"options\" name=\"refresh\" label=\"РћР±РЅРѕРІРёС‚СЊ\"><go href=\"chat_3.php?".$pw."$ses\"/></do>
<p align='$align'>
<small>
"; */

//worksRefresh($_SESSION['countryID']);

//==============================================================================
//Рабочая часть скрипта=========================================================

//global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }
 //if ((getenv("HTTP_USER_AGENT")=="SIE-C60/27 Profile/MIDP-1.0 Configuration/CLDC-1.0 UP.Browser/6.1.0.7.3 (GUI) MMP/1.0" && getenv("REMOTE_ADDR")=='212.120.166.251')||(getenv("HTTP_USER_AGENT")=="Nokia2650/1.0 (6.18) Profile/MIDP-1.0 Configuration/CLDC-1.0" && getenv("REMOTE_ADDR")=="212.120.166.251")) $b['inv']=1;
if($b['status'] == 1 and $_SERVER['PHP_SELF'] != '/profile.php'){header("Location: game.php?$ses");}
//******************************************************************************
//проверка на валидность идентификатора:****************************************
 if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
//  printrus ("<u>[".$b['countryName']."]</u>(".date("H:i").")");
//  print "<br/>\r\n";
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='index.php'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 function seeSmile(){
 	global $ses,$ip;
$directory = 'img';
$array = array('.', '..'); //массив со значениями, которые нужно исключить из результатов сканирования папки
$contents = array_diff(scandir($directory), $array);
if($_GET[str]<1)$_GET[str]=0;
elseif($_GET[str]>=1)$_GET[str]=ceil($_GET[str]);
else $_GET[str]=0;
$y=ceil($_GET[str]);
$end=$y+10;

printrus ("<a href=\"chat_3.php?".$pw."$pw$ses\">Обновить</a><br/>");
foreach($contents as $element)
{
++$i;
if($y>=$i)continue;if($end<=$i)break;
list($name, $format)=explode('.',$element);
echo '<img src="../img/'.$name.'.'.$format.'"/> (<i><b>:'.$name.':</b></i>),<br />';


}

printrus("<a href=\"chat_3.php?".$pw."str=".$i."&amp;$ses\">Дальше</a>");

}
 if(isset($_GET[str])){
 seeSmile();

 include_once("other_inc/footer.php");

  die("");

 }if(isset($_GET[prov])){
 printrus('Для того чтобы подать заявку для проверки напишите сообщение в асамблее(соблюдайте все знаки): <br /><b>!?!ник модера которому хотите отправить,сообщение</b>');

 include_once("other_inc/footer.php");

  die("");

 }
 $countryID = $b['countryID'];
printrus ("<a href=\"chat_3.php?".$pw."$ses\">Обновить</a><br/>\n");
//$obl=mktime(21, 0, 0, 1, 8, 2016)-time();// часы.минуты.секунды.месяц.день.год
//if($obl<=0)printrus("<img src=\"img/jouke.gif\" alt=\"logo\"/><br />");else printrus("Обнул через: ".mkTimeStr($obl)."<br />");
if (!isset($pg))$pg=0;
if (!is_numeric($pg))$pg=0;
if (isset($pg)) $pg=$pg*10-10;
if ($pg<0)$pg=0;
$pg = addslashes($pg);
if($obnull>0)
printrus ("<span style=\"color:red\">До Нового года осталось ".mkTimeStr( max(0,$obnull))."!</span><br/>");

if (isset($go)){
$vlnm1 = checkCountryID($_GET['vl1']);
$tex1="$vlnm1";$tex2 = iconv('cp1251','utf-8',$tex1);$text3="$msg";$text4="$tex2 $text3";
      $msg = str_replace("$",'',$text4);
      setlocale(LC_CTYPE, 'ru_RU.CP1251');
      if ($t1=='1') $msg=translit($msg);
      $msg2=" {Drag нубяра выходи уже!}";
      $message = iconv('utf-8','cp1251',check($msg));

      $message = preg_replace("/([А-Яа-яa-z0-9\.\-]{3,25})+([\.\, ]{1,3}+(s u|su|ru|ua|kz|com|net|biz|info|lt|org|il|be|uа|сom|cоm|coм|mobi|соm|сoм|cом|nеt|neт|nет|infо|оrg|bе|It))/i", 'waroffour.ru',$message);
      //$message = preg_replace("/[cсС]{1}(.*)i(.*)v(.*)[aаА]{1}(.*)[хХx]{1}(.*)[rРр]{1}(.*)[уУu]{1}/i", ' waroffour.ru', $message);
      //$message = preg_replace("/[цЦ]{1}(.*)[иИ]{1}(.*)[вВ]{1}(.*)[аАa]{1}(.*)[хХx]{1}(.*)[rРр]{1}(.*)[уУu]{1}/i", ' waroffour.ru', $message);c v g a m e . r u
      /*$message = preg_replace("/[cсСцЦ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[aаА]{1}(.?){1,4}[хХx]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is", ' waroffour.ru', $message);
      $message = preg_replace("/[dдД]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[rрР]{1}(.?){1,4}[zhЖжзЗхХ]{1,2}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is", ' waroffour.ru', $message);
      $message = preg_replace("/[cСс]{1}(.?){1,4}[vВв]{1}(.?){1,4}[gГг]{1}(.?){1,4}[aАа]{1}(.?){1,4}[mМм]{1}(.?){1,4}[eЕе]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is", ' waroffour.ru', $message);
      $message = preg_replace("/[kкК]{1}(.?){1,4}[oоО]{1}(.?){1,4}[lлЛ]{1}(.?){1,4}[eеЕ]{1}(.?){1,4}[kКк]{1}(.?){1,4}[tтТ]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[vвВ]{1}(.?){1,4}[4]{1}(.?){1,4}[iиИ]{1}(.?){1,4}[kкК]{1}(.?){1,4}[rРр]{1}(.?){1,4}[уУu]{1}/is", ' waroffour.ru', $message);
      */$j=0;
      while(isset($urls[$j])){
      $message = preg_replace($urls[$j], ' waroffour.ru', $message);
      $j++;
      }     //[urls]http://www.youtube.com/watch?v=iuJuuEjmDsQ[urls=Джордж, ты сраный ковбой]
      $message = preg_replace("/\[urls](.*?)\[urls=(.*?)]/is", '<a href="$1" target="_blank" style="color: #FF0000">$2</a>', $message);
      $message = preg_replace("/\[t-color](.*?)\[t-color=(.*?)]/is", '<span style="color:$2;">$1</span>', $message);
      $message = preg_replace("/\[c](.*?)\[c=(.*?)]/is", 'Хъюстон, у нас проблема...', $message);
      $message = preg_replace("/\[h](.*?)\[h]/is", '<a href="http://waroffour.ru/faq.php?m=ratusha&amp;n=helper">\1</a>', $message);
      $message = str_replace(":zakonnub:",'<img src="img/mentpoganiy.gif" alt="logo"/>',$message);
      #$message = str_replace(":pizdec:",'<img src="img/ax.gif" alt="logo"/>',$message);
      #$message = str_replace(":hb1:",'<img src="img/v1.gif" alt="logo"/>',$message);
      #$message = str_replace(":hb2:",'<img src="img/v2.gif" alt="logo"/>',$message);
      $message = str_replace(":pusy:",'<img src="img/BIGgirl.gif" alt="logo"/>',$message);
      //$message = str_replace(".",' ',$message);
      $message = str_replace(":blin:",'<img src="img/m1906.gif" alt="logo"/>',$message);
      $message = str_replace(":titi:",'<img src="img/t1523.gif" alt="logo"/>',$message);
      #$message = str_replace(":spider:",'<img src="img/a015.gif" alt="logo"/>',$message);
      #$message = str_replace(":smoke:",'<img src="img/smoke.gif" alt="logo"/>',$message);
      #$message = str_replace(":ruso:",'<img src="img/russian.gif" alt="logo"/>',$message);
      #$message = str_replace(":ignors:",'<img src="img/ign.gif" alt="logo"/>',$message);
      #$message = str_replace(":lok:",'<img src="img/jouke.gif" alt="logo"/>',$message);
      #$message = str_replace(":lok2:",'<img src="img/ups.gif" alt="logo"/>',$message);
      #$message = str_replace(":losi:",'<img src="img/love_site.gif" alt="logo"/>',$message);
      #$message = str_replace(":trax:",'<img src="img/kul.gif" alt="logo"/>',$message);

      $message = preg_replace('#\[4](.*?)\[4]#si', '<u>\1</u>', $message);

      $message = preg_replace('#\[q](.*?)\[q]#si', '<b>\1</b>', $message);

      $yname = $b['countryName'];
      $date = date("[H:i]");
      $idd = getmicrotime();
      $r = mysql_query("SELECT message FROM guestbook_mult WHERE nick = '".$yname."' order by id desc LIMIT 1");
      $a = mysql_fetch_array($r);

      if(!$myname=checkCountryID($countryID))$message='';
      if($_REQUEST[t3]==1 && $message!='')
      $message='<u>'.$message.'</u>';
      if($_REQUEST[t2]==1 && $message!='')
      $message='<b>'.$message.'</b>';
      $message = str_replace("\\\\\\",'',$message);
      if ($message!='' && $a['message']!=$message){
////тута
      if (isset($prvt))mysql_query("INSERT into guestbook_mult SET id = '".$idd."', nick = '".$yname."', message = '".$message."', date = '".$date."', inv = '".$b['inv']."', countryID = '".$b['countryID']."', tocountryID = '".$prvt."', usid = '".$_SESSION['userID']."', tonick = '".$tex2."'");
      else mysql_query("INSERT into guestbook_mult SET id = '".$idd."', nick = '".$yname."', message = '".$message."', date = '".$date."', inv = '".$b['inv']."', countryID = '".$b['countryID']."', usid = '".$_SESSION['userID']."', tonick = '".$tex2."'");
      }
      $prv=explode("!?!",$message);
      if($prv[1]<>''){
      	list($mdy,$txt)=explode(",",$prv[1]);
      if($mdy<>'' && $txt<>''){
      //$md=iconv('utf-8','cp1251',$md);
      $rqss="SELECT countryID FROM `countries` WHERE countryName = '$mdy' LIMIT 1";
      $gosee=mysql_fetch_array(mysql_query($rqss));
      if($gosee[0]<>''){
      $rgs="select * from uzers where countryID='".$gosee['countryID']."' and inv='2'";$tu2=mysql_query($rgs); $tu=mysql_fetch_array($tu2);
      if($tu['countryID']<>''){
      sendMessage($tu['countryID'],$countryID,$txt);
      printrus('Заявка принята.');
      }
      }
      }
      }
      printrus ("Ваше сообщение добавлено!<br/>");


        }
if(!isset($_REQUEST[pw])){
print iconv('cp1251','utf-8',"<ul class=\"navs\"><li><a href=\"online.php?str&amp;$ses\">Онлайн <span class=\"green\">(".online("c").")</span></a></li></ul>");
$query="select count(*) as num from messages where countryID='".$b["countryID"]."'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $mesCount=$a['num'];

 if($mesCount>10){
printrus
("<ul class=\"navs\"><li><a href='messages/view.php?$ses'>
Почта <span class=\"white\">($mesCount)</span></a>
</li></ul>

");
 }elseif($mesCount>1||$mesCount==0){
  printrus
("<ul class=\"navs\"><li><a href='messages/view.php?$ses'>
Почта <span class=\"white\">($mesCount)</span></a>
</li></ul>

");
 }elseif($mesCount==1){
  $query="select * from messages where countryID='".$b['countryID']."' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $a = mysql_fetch_array($result);
  exec_message($b['countryID'],$a,0);
 }

$vlnm = checkCountryID($vl);

if ($vl==TRUE){$hto="Сообщение для <u>$vlnm</u><br/>";}else{$hto="<u>Сообщение</u>:";}

printrus("<a href=\"chat_3.php?pw&amp;$ses\">Приват</a> | ");}
printrus("<a href=\"chat_3.php?".$pw."str&amp;$ses\">Смайлы</a> | ");
printrus ("<a href=\"chat2.php?$ses\">У | С | </a>\n");
printrus ("<a href=\"chat.php?$ses\">чат | </a>\n");

if($pw==TRUE){printrus("<a href='game.php?$ses'>Страна</a> | <a href='chat_3.php?$ses'>Чат</a><br/>");}else{printrus("<a href='game.php?$ses'>Страна</a><br/>");}
printrus ("$hto");


  if (isset($post)){
    if(preg_match('/^[0-9.]+$/', $post)){

    $r = mysql_query("SELECT * FROM guestbook_mult WHERE id='$post' LIMIT 1");
    $a=mysql_fetch_array($r);
      if($a!==FALSE){
      $name = $a['nick'];
      $message = $a['message'];
      $msg = str_replace("$",'',$msg);
      setlocale(LC_CTYPE, 'ru_RU.CP1251');
      if ($t1=='1') $msg=translit($msg);
      $message2 = iconv('utf-8','cp1251',check($msg));
        if($red == 'yes' and $message2!='')
        {
          if(($ggf['inv'] == 2 and $level == 8) or ($a['countryID'] == $countryID)){

          $message2 = preg_replace("/([А-Яа-яa-z0-9\.\-]{3,25})+([\.\, ]{1,3}+(su|ru|ua|kz|com|net|biz|info|lt|org|il|be|uа|сom|cоm|coм|mobi|соm|сoм|cом|nеt|neт|nет|infо|оrg|bе|It))/i", 'waroffour.ru',$message2);
          $j=0;
           while(isset($urls[$j])){
           $message2 = preg_replace($urls[$j], ' waroffour.ru', $message2);
           $j++;
           }
          mysql_query("UPDATE `guestbook_mult` SET `message`='".$message2."' WHERE id='$post'");
          printrus("Сообщение отредактировано!<br />");}
        }
        else
        {
          if(($ggf['inv'] == 2 and $level == 8) or ($a['countryID'] == $countryID))
          {
          printrus("<form name=\"\" action=\"chat_3.php?".$pw."post=$post&amp;red=yes&amp;$ses\" method=\"post\">");
          printrus ("<textarea cols=\"30\" rows=\"5\" name=\"msg\" type=\"text\" value=\"\">$message</textarea>");
          printrus("<br /><input type=\"submit\" value=\"Готово\"/><br/></form>");
          include_once("other_inc/footer.php");
          exit();
          }
        }
      }
    }
  }

if (isset($vl)) $vlnm = checkCountryID($vl);
printrus("<form name=\"\" action=\"chat_3.php?".$pw."go=add&amp;$ses&vl1=$vl\" method=\"post\">");
printrus ("<input name=\"msg\" maxlength=\"700\" title=\"Text\" value=\"\"/>");
printrus("
<br/><input name=\"t1\" type=\"checkbox\" value=\"1\"/>трнслт\n\n
");
printrus("
<input name=\"t2\" type=\"checkbox\" value=\"1\"/>жирный\n\n
");
printrus("
<input name=\"t3\" type=\"checkbox\" value=\"1\"/>подчеркнуть\n<br /><br/>\n
");
if (isset($vl)){

if ($pw==TRUE){printrus("<br /><input name=\"prvt\" type=\"checkbox\" value=\"$vl\" checked />Приват\n<br/><br />\n");}

else{printrus("<br /><input name=\"prvt\" type=\"checkbox\" value=\"$vl\"/>Приват\n<br/><br />\n");}

}

printrus("<input type=\"submit\" value=\"Написать\"/><br/><br/>
</form>");
printrus("<a href=\"muzik_video_chat.php?amp;$ses\"><font color='#EE7621'>Музыкальные видео клипы</font></a><br/><br />\n");
printrus("<a href=\"muzik_chat.php?amp;$ses\"><font color='#EE7621'>Чат mp3</font></a><br/><br />\n");
printrus("<a href=\"video_chat.php?amp;$ses\"><font color='#EE7621'>Фильм Шлагбаум Улан-Удэ, 2013г.</font></a><br/><br />\n");
printrus("<a href=\"video_chat1.php?amp;$ses\"><font color='#EE7621'>Полнометражный фильм Дети 90-х(8-серий) г.Чита</font></a><br/><br />\n");



printrus ("<br /><a href=\"chat_3.php?".$pw."$ses\">Обновить</a><br/>\n");
if (isset($bvl)&&$b['inv']!=2)exit;

if (isset($bvl)){
        $bvl = iconv('utf-8','cp1251',$bvl);
        $r = mysql_query("SELECT countryID FROM `countries` WHERE countryName = '$bvl'");
        $a = mysql_fetch_array($r);
        $bc = $a['countryID'];
        $g = mysql_query("SELECT inv FROM `uzers` WHERE countryID = '$bc'");
        $gg = mysql_fetch_array($g);
        if ($gg['inv']!=2){
        mysql_query("UPDATE `uzers` SET inv = 1 WHERE countryID = '$bc'");
        //Удаляем сообщения заигноренного из чата
        mysql_query("DELETE FROM `guestbook_mult` WHERE countryID = '$bc'");
        $key=_PREFIKS.':id'.$bc;
        if (($mem=$memcache->get($key))!==FALSE){
           $mem['inv'] = 1;
           $memcache->set($key,$mem,false,86400);
           }

        if (mysql_affected_rows()!=0){
        printrus("<br/>$bvl в игноре!<br/>\n");
        }
        else printrus("Ошибка!<br/>\n");
        }else printrus("Модера нельзя отправить в игнор!<br/>\n");

        }

  if (isset($ids) and $ggf['inv'] == 2){
    if(preg_match('/^[0-9.]+$/', $ids)){
    mysql_query("DELETE FROM `guestbook_mult` WHERE id = '$ids'");

     if (mysql_affected_rows()!=0){
     printrus("<br/>Сообщение удалено!<br/>\n");}
     else printrus("<br />Ошибка! нет такого сообщения!<br/>\n");
    }
  }


if (!isset($vl)){
echo "<br/>\n";
$r = mysql_query("SELECT count(*) as num FROM guestbook_mult");
$a = mysql_fetch_array($r);
$num = $a['num'];
$p_q = ($num+9)/10;
$pn = round(($pg+10)/10);
if ($num>0) printrus ("<u>Стр. $pn</u><br/>");

echo "----<br/>";
if(isset($_REQUEST[pw])){
$r = mysql_query("SELECT countryID,tocountryID,nick,message,date,inv,usid,tonick FROM guestbook_mult WHERE ((inv != 1)or(nick = '".$b['countryName']."'))and(tocountryID='".$b['countryID']."' or countryID = '".$b['countryID']."')and(tocountryID!='')   ORDER BY id desc LIMIT $pg,10");
}
else{

//Выводим сообщения
$r = mysql_query("SELECT id,countryID,tocountryID,nick,message,date,inv,usid,tonick FROM guestbook_mult WHERE ((inv != 1)or(nick = '".$b['countryName']."'))and(tocountryID='".$b['countryID']."' or tocountryID='' or countryID = '".$b['countryID']."')   ORDER BY id desc LIMIT $pg,10"); }
echo " ".mysql_error()." ";
while (($a=mysql_fetch_array($r))!==FALSE){
$gmmm2 = mysql_query("SELECT * FROM `uzers` WHERE countryID = '$a[countryID]'") or die();
$ggf2 = mysql_fetch_array($gmmm2);
        $name = stripslashes($a['nick']);
        $message = $a['message'];
        $message11=$a['tonick'];
        $date = $a['date'];
        $medal = '';


if($ggf2['race'] == 1 and $a['inv']!=2){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"r1\">".$name."</a>";}
elseif($ggf2['race'] == 2 and $a['inv']!=2){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"r2\">".$name."</a>";}
elseif($ggf2['race'] == 3 and $a['inv']!=2){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"r3\">".$name."</a>";}
elseif($ggf2['race'] == 4 and $a['inv']!=2){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"r4\">".$name."</a>";}
elseif($a['inv']==2 and $a['usid']==1){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"admin\"><img src=\"http://waroffour.ru/znc/drag11111.png\"></a>";}
elseif($a['inv']==2 and $a['usid']==37){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"admin\"><img src=\"http://waroffour.ru/znc/lisy051.png\"></a>";}
elseif($a['inv']==2 and $a['usid']==66){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"sem\"><b>::: sem :::</b></a>";}
elseif($a['inv']==2 and $a['usid']!=1 and $a['usid']!=66 and $a['usid']!=37){$name2="<a href=\"chat_3.php?".$pw."vl=".$a['countryID']."&amp;$ses\" class=\"admin\">".$name."</a>";}


        if($_SESSION['sml']!='off'){
        	$asd="select * from znc where id='".$a['usid']."' limit 1";
        	$gf= mysql_query($asd);
        	$mn= mysql_fetch_array($gf);
        if ($mn['url']!='')  //../znc/medal.gif
        $medal = "<img src=\"../znc/".$mn['url'].".gif\" alt=\"medal\"/>";
        if ($a['usid']==66){$medal = "<img src=\"http://civaz.ru/img/znk/198.png\" alt=\"medal\"/>";}
        }
        print $medal;
        #print $raf;
        if ($a['tocountryID']!='') print "<b>(P!)</b>";
        if ($b['inv']!=2) {
        printrus ("$date&gt;$name2:");
        }
        else
        {
        $nus = iconv('cp1251','utf-8',$name);
        print ("<a href=\"chat_3.php?".$pw."bvl=$nus&amp;$ses\">+</a>\n");
        if($level != 0){$del_mess="<a href=\"chat_3.php?".$pw."ids=".$a['id']."&amp;$ses\">[x]</a>";}else{$del_mess="";}
        printrus ("$date&gt;$name2:");
        print "[<a href=\"mpan.php?name=$nus&amp;$ses\">S</a>]\n";UNSET($nus);
        }
        if(($ggf['inv'] == 2 and $level == 8) or ($a['countryID'] == $countryID)){$red_mess="<a href=\"chat_3.php?".$pw."post=".$a['id']."&amp;$ses\">[ред]</a>";}else{$red_mess="";}
        $nu = iconv('cp1251','utf-8',$name);
        printrus( "<br/>\n");
        if($_SESSION['sml']!='off')
        $message =smiles($message);

////вывод смс выделеных хх
$message =chs($message);
$mmm=$message;
$nname=$b['countryName'];
$nname2=iconv('cp1251','utf-8',$nname);
if ($nname2==$message11){$mmm="<font color='#EE7621'>$message</font>";}

$name_v=iconv('cp1251','utf-8',$name);
if (($nname2==$name_v) AND ($message11!="")){$mmm="<font color='#63B8FF'>$message</font>";}


        printrus ("$mmm $del_mess $red_mess<br/>");
        echo "----<br/>";
        }
printrus ("<form name=\"\" action=\"chat_3.php?".$pw."$ses\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>
к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pn\" title=\"Page\"/>стр. (из $p_q)<br/>
</form>\n");


$pg = $pn + 1;
echo "<a href=\"chat_3.php?".$pw."pg=$pg&amp;$ses\">&gt;&gt;&gt;</a>";
}else{

$r = mysql_query("SELECT about,imya,datereg,counts,userID FROM `uzers` WHERE countryID = '$vl' LIMIT 1");
$a = mysql_fetch_array($r);

printrus("<br/>Дата регистрации: ".$a['datereg'].'<br/>');
printrus("Имя: ".$a['imya'].'<br/>');
printrus("О себе: ".$a['about'].'<br/>');
printrus("Уничтожено стран: ".$a['counts']);
printrus("<br/><a href=\"../messages/writemessage.php?to=$vl&amp;$ses\">Написать сообщение</a>");
        }

echo "<br/>-------<br/>\n";
printrus("<a href=\"chat_3.php?".$pw."str&amp;$ses\">Смайлы</a><br />");
if($_SESSION['sml']!='off')
printrus("<a href=\"chat_3.php?".$pw."sml=off&amp;$ses\">Выкл.смайлы</a><br />");
else
printrus("<a href=\"chat_3.php?".$pw."sml=on&amp;$ses\">Вкл.смайлы</a><br />");
printrus ("<a href=\"chat2.php?$ses\">Ученый совет</a><br/>\n");
//printrus ("<a href=\"game.php?$ses\">В игру</a><br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
?>
