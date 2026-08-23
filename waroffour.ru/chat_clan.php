<?php
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['msg'])) $msg = $_REQUEST['msg'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['prvt'])) $prvt = $_REQUEST['prvt'];
//if (isset($_REQUEST['clv'])) $clv = $_REQUEST['clv'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg))$pg=0;
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['vl'])) $vl = $_REQUEST['vl'];
if (isset($_REQUEST['bvl'])) $bvl = $_REQUEST['bvl'];
$ref = rand(0,1000000);

function check($str,$hsc=1){
$str=strtr($str,array(chr("0")=>"",chr("1")=>"",chr("2")=>"",chr("3")=>"",chr("4")=>"",chr("5")=>"",chr("6")=>"",chr("7")=>"",chr("8")=>"",chr("9")=>"",chr("10")=>"",chr("11")=>"",chr("12")=>"",chr("13")=>"",chr("14")=>"",chr("15")=>"",chr("16")=>"",chr("17")=>"",chr("18")=>"",chr("19")=>"",chr("20")=>"",chr("21")=>"",chr("22")=>"",chr("23")=>"",chr("24")=>"",chr("25")=>"",chr("26")=>"",chr("27")=>"",chr("28")=>"",chr("29")=>"",chr("30")=>"",chr("31")=>"","Р?"=>"И","вЂ¦"=>" ","вЂ©-"=>" ","вЂњ"=>" ","вЂќ"=>" ","вЂ©"=>" ","вЂ“"=>"-","\n"=>" ","$"=>"$$"));
if($hsc==1)$str = HtmlSpecialChars($str);
$str = ereg_replace(" +"," ",$str);
$str = trim($str);
return $str;
}


//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
$countryID = $_SESSION['countryID'];
//шапка:
include_once("other_inc/header.php");
stopgame($_SESSION['countryID']);/*
$headtime = getmicrotime();
header("Cache-Control: no-cache");
header ("Content-type:text/vnd.wap.wml");

$title="Р¦РёРІРёР»РёР·Р°С†РёСЏ";
$align="left";

print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.2//EN\" \"http://www.wapforum.org/DTD/wml12.dtd\">
<wml><head><meta http-equiv=\"Cache-Control\" content=\"no-cache\" forua=\"true\"/></head>
<card title='$title'>
<do type=\"options\" name=\"game\" label=\"Р’ РёРіСЂСѓ\"><go href=\"game.php?$ses\"/></do>
<do type=\"options\" name=\"refresh\" label=\"РћР±РЅРѕРІРёС‚СЊ\"><go href=\"chat_clan.php?$ses\"/></do>
<p align='$align'>

";  */

//$obn = 1167166226+60*25;
//$left = mkTimeStr(max(0,$obn-time()));
//printrus ("До обнуления осталось: $left<br/>\n");

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
 /*
 if ((getenv("HTTP_USER_AGENT")=="SIE-C60/27 Profile/MIDP-1.0 Configuration/CLDC-1.0 UP.Browser/6.1.0.7.3 (GUI) MMP/1.0" && getenv("REMOTE_ADDR")=='212.120.166.251')||(getenv("HTTP_USER_AGENT")=="Nokia2650/1.0 (6.18) Profile/MIDP-1.0 Configuration/CLDC-1.0" && getenv("REMOTE_ADDR")=="212.120.166.251")) $b['inv']=1;
 if ($b['countryName']==''){
@$open=fopen("mod/test.dat","a+");
@flock ($open,LOCK_EX);
$str = date("H:i ->")."ID=$countryID, userID=".$_SESSION['userID'].", SESSIONID=".$ses."\n\r";
@fwrite ($open,$str);
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
    }
*/

//******************************************************************************
//проверка на валидность идентификатора:****************************************
 if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u>(".date("H:i").")");
  print "<br/>\r\n";
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='index.php'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 $key=_PREFIKS.':clans'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $clanID = $mem;
    }else{
    $r=mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$countryID'");
    $h=mysql_fetch_array($r);
    if ($h!==FALSE)
    $clanID = $h['clanID'];
    else $clanID=0;
    }

 if (!isset($clanID)|| $clanID==0){
    printrus("Вы не состоите ни в каком клане!<br/>\n");
    die("");
    }

 $countryID = $b['countryID'];


//$obn = 1156205795+13*3600;
//$left = mkTimeStr(max(0,$obn-time()));
//printrus ("До обнуления осталось: $left<br/>\n");
//else printrus ("Шуточка админа! Гг. Кто поверил, признавайтесь:)<br/>\n");

printrus ("<a href=\"chat_clan.php?$ses\">Обновить</a><br/>\n");

if (!isset($pg))$pg=0;
if (!is_numeric($pg))$pg=0;
if (isset($pg)) $pg=$pg*10-10;
if ($pg<0)$pg=0;
$pg = addslashes($pg);

if (isset($go)){
      //$yname = addslashes(htmlspecialchars($yname));
      //if (!isset($prvt) || $prvt=='') $prvt = '*'; else $prvt = iconv('utf-8','cp1251',$prvt);
      $msg = str_replace("$",'',$msg);
      setlocale(LC_CTYPE, 'ru_RU.CP1251');
      if ($t1=='1') $msg=translit($msg);
      if ($countryID!='8b0cc67eee7d8fe63920432c2993535766')$message = iconv('utf-8','cp1251',check($msg));
      else $message = iconv('utf-8','cp1251',$msg);
      if ($countryID!='8b0cc67eee7d8fe63920432c2993535766')$message = preg_replace("/([а-яa-z0-9\.\-]{3,25})+(\.(su|ru|ua|kz|com|net|biz|info|lt|org|il|be|uа|сom|cоm|coм|соm|сoм|cом|nеt|neт|nет|infо|оrg|bе|It))/i", 'imperia.mobi',$message);
      $message = str_replace("мну ",'меня ',$message);
      $message = str_replace(" мну",' меня',$message);
      $message = str_replace("мню ",'меня ',$message);
      $message = str_replace(" мню",' меня',$message);
      //$message = str_replace("dizzy",'dizzy, мой любимый,',$message);
      //$message = str_replace("диззй",'dizzy, мой любимый,',$message);
      //$message = str_replace("диззи",'dizzy, мой любимый,',$message);
      //$message = str_replace("диз",'dizzy, мой любимый,',$message);
      //$message = str_replace("diz",'dizzy, мой любимый,',$message);
      if ($countryID=='82dafb2522221782657111f37bc85ad796') $message = str_replace(".jjot.",'<img src="http://wap.wab.ru/mafia/smilean/jjot.gif" alt="no"/>',$message);
      $yname = $b['countryName'];
      $date = date("[H:i]");
      $idd = getmicrotime();
      $r = mysql_query("SELECT message FROM guestbook_clans WHERE nick = '".$yname."' order by id desc LIMIT 1");
      $a = mysql_fetch_array($r);
      if ($message!='' && $a['message']!=$message){
      if (isset($prvt))mysql_query("INSERT into guestbook_clans SET id = '".$idd."', clanid = '".$clanID."', nick = '".$yname."', message = '".$message."', date = '".$date."', inv = '".$b['inv']."', countryID = '".$b['countryID']."', tocountryID = '".$prvt."'");
      else mysql_query("INSERT into guestbook_clans SET id = '".$idd."', clanid = '".$clanID."', nick = '".$yname."', message = '".$message."', date = '".$date."', inv = '".$b['inv']."', countryID = '".$b['countryID']."'");
      }
      printrus ("Ваше сообщение добавлено!<br/>");

        }

//$obn = 1146565578+15*60;
//$left = mkTimeStr(max(0,$obn-time()));
//printrus ("До обнуления осталось: $left<br/>\n");

printrus ("<u>Сообщение:</u><br/>");
if (isset($vl)) $vlnm = checkCountryID($vl);
printrus ("<form name=\"\" action=\"chat_clan.php?go=add&amp;$ses\" method=\"post\">
<input name=\"msg\" maxlength=\"700\" title=\"Text\" value=\"$vlnm\"/>");
printrus("
<br/><input name=\"t1\" type=\"checkbox\" value=\"1\"/>Транслитеровать\n<br/>\n");
if (isset($vl)){printrus("
<input name=\"prvt\" type=\"checkbox\" value=\"$vl\"/>Приват\n<br/>\n");
}
printrus ("<input type=\"submit\" value=\"Написать\"/></form>\n");

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
        mysql_query("DELETE FROM `guestbook_clans` WHERE countryID = '$bc'");
        $key=_PREFIKS.':id'.$bc;
        if (($mem=$memcache->get($key))!==FALSE){
           $mem['inv'] = 1;
           $memcache->set($key,$mem,false,86400);
           }

        if (mysql_affected_rows()!=0)printrus("<br/>$bvl в игноре!<br/>\n");
        else printrus("Ошибка!<br/>\n");
        }else printrus("Модера нельзя отправить в игнор!<br/>\n");

        }

if (!isset($vl)){
echo "<br/>\n";
$r = mysql_query("SELECT count(*) as num FROM guestbook_clans WHERE clanID = '".$clanID."'");
$a = mysql_fetch_array($r);
$num = $a['num'];
$p_q = ($num+9)/10;
$pn = round(($pg+10)/10);
if ($num>0) printrus ("<u>Стр. $pn</u><br/>");

echo "----<br/>";
//Выводим сообщения
//$r = mysql_query("SELECT countryID,tocountryID,nick,message,date,inv FROM guestbook WHERE ((inv != 1)or(nick = '".$b['countryName']."'))and(tocountryID='".$b['countryID']."' or tocountryID='' or countryID = '".$b['countryID']."')   ORDER BY id desc LIMIT $pg,10");
if ($countryID!='d36e893965437fbd00bac28e01a2c37573' || getenv("REMOTE_ADDR")!='213.152.157.125')$r = mysql_query("SELECT countryID,tocountryID,nick,message,date,inv FROM guestbook_clans WHERE ((inv != 1)or(nick = '".$b['countryName']."'))and(tocountryID='".$b['countryID']."' or tocountryID='' or countryID = '".$b['countryID']."') and clanID = '".$clanID."' ORDER BY id desc LIMIT $pg,10");
else $r = mysql_query("SELECT countryID,tocountryID,nick,message,date,inv FROM guestbook_clans WHERE ((inv != 1)or(nick = '".$b['countryName']."')) and clanID = '".$clanID."' ORDER BY id desc LIMIT $pg,10");
echo " ".mysql_error()." ";
while (($a=mysql_fetch_array($r))!==FALSE){
        $name = stripslashes($a['nick']);
        $message = $a['message'];
        $date = $a['date'];
        if ($a['tocountryID']!='') print "<b>(P!)</b>";
        if ($b['inv']!=2) if ($a['inv']!=2)printrus ("$date&gt;$name:");
                                 else printrus ("$date&gt;<u>$name</u>:");
        else {
              $nu = iconv('cp1251','utf-8',$name);
              print ("<a href=\"chat_clan.php?$ses&amp;bvl=$nu\">+</a>\n");
              if ($a['inv']!=2)printrus ("$date&gt;$name:");
              else printrus ("$date&gt;<u>$name</u>:");
                }
        print "<a href=\"chat_clan.php?$ses&amp;vl=".$a['countryID']."\">&gt;</a><br />\n";
        $nu = iconv('cp1251','utf-8',$name);
        //echo "<postfield name=\"vl\" value=\"$nu\"/>\n";
        printrus ("$message<br/>");
        echo "----<br/>";
        }
printrus ("<form name=\"\" action=\"chat_clan.php?$ses\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>
к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pn\" title=\"Page\"/>стр. (из $p_q)<br/>
</form>\n");



$pg = $pn + 1;
echo "<a href=\"chat_clan.php?pg=$pg&amp;$ses\">&gt;&gt;&gt;</a>";
}else{

$r = mysql_query("SELECT about,imya,datereg,counts FROM `uzers` WHERE countryID = '$vl' LIMIT 1");
$a = mysql_fetch_array($r);
printrus("<br/>Дата регистрации: ".$a['datereg'].'<br/>');
printrus("Имя: ".$a['imya'].'<br/>');
printrus("О себе: ".$a['about'].'<br/>');
printrus("Уничтожено стран: ".$a['counts']);
        }

echo "<br/>-------<br/>\n";
//printrus ("<a href=\"chat2.php?$ses\">Ученый совет</a><br/>\n");
//printrus ("<a href=\"game.php?$ses\">В игру</a><br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
?>