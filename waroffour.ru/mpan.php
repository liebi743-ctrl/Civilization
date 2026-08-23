<?php
set_time_limit(0);
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(addslashes($_REQUEST[$key]));
}
//Обработка переменных:
if (isset($_REQUEST['name'])) $name = $_REQUEST['name'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['cid']) && $_REQUEST['cid']!='') $cid = $_REQUEST['cid'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['purp'])) $purp = $_REQUEST['purp'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg))$pg=0;
if (!isset($pg) || $pg<0) $pg=0;
if (isset($_REQUEST['hours'])) $hours = $_REQUEST['hours'];
if (isset($hours)&&!is_numeric($hours))$hours=0;
if (!isset($hours) || $hours<0) $hours=0;
$ref = rand(0,1000000);
//printrus ("<br />$go<br/>\r\n");
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
include_once("other_inc/header.php");/*
$headtime = getmicrotime();
header("Cache-Control: no-cache");
header ("Content-type:text/vnd.wap.wml");

$title="Р¦РёРІРёР»РёР·Р°С†РёСЏ";
$align="left";

print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.2//EN\" \"http://www.wapforum.org/DTD/wml12.dtd\">
<wml><head><meta http-equiv=\"Cache-Control\" content=\"no-cache\" forua=\"true\"/></head>
<card title='$title'>
<do type=\"options\" name=\"game\" label=\"Р’ РёРіСЂСѓ\"><go href=\"game.php?$ses\"/></do>";
printrus("
 <do type=\"options\" name=\"mpanchat\" label=\"Чат модеров\"><go href=\"mpanchat.php?$ses\"/></do>
");
print"
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

 $countryID = $b['countryID'];

 if ($b['inv']!=2){   //||empty(getenv('HTTP_USER_AGENT'))
    printrus ("<b>!</b>Доступ запрещен<b>!</b><br/>\r\n");

//  printrus ("<a href='game.php?$ses'>В игру</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
    }

$older4 = array(1,877,1884);//админы
$older = array(2440);//старшие модеры
$older2=array(48,665,745,963,3726,545);//среднии модеры

if (in_array($_SESSION['userID'],$older))$level=1;
else $level=0;
if (in_array($_SESSION['userID'],$older2))$level=2;
else $level=$level;
if (in_array($_SESSION['userID'],$older4))$level=8;
else $level=$level;

$mip = getenv("REMOTE_ADDR");
$msoft = getenv("HTTP_USER_AGENT");
@$open=fopen("mod/mpan.dat","a+");
@flock ($open,LOCK_EX);
$str = date("d M(H:i)").">".$b['countryName']."(ip:$mip, soft:$msoft)\n\r";
@fwrite ($open,$str);
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

 $country22 = check($name);

  //$country2 = check($country2);

  if ($country22!='') {
          if($t1=='1') $country22 = translit($country22);
          $country22 = iconv('utf-8','cp1251',$country22);
  }
if($aaaa = mysql_fetch_array(mysql_query("SELECT * FROM `countries` WHERE countryName = '$country22' LIMIT 1"))!==FALSE){
      $bbbb = mysql_fetch_array(mysql_query("SELECT * FROM `countries` WHERE countryName = '$country22' LIMIT 1"));
	if($bbbb['countryID']=='f09735cdd4e93841d4d4020aa513a8bc19'){
        printrus ("Страны с названием $country22 нет на карте мира!<br/>\n");
        printrus ("<a href='mpan.php?$ses'>&lt;назад</a><br/>\r\n");
        include_once("other_inc/footer.php");
        die();


	}



}


if (!isset($go)){
printrus
("<a href=\"mpanchat.php?$ses\">
Модерский чат</a>
<br/>
");


$e=rand(1111,9999);
$ASS = iconv('utf-8','cp1251',$_REQUEST['name']);
$REQUESTID = iconv('utf-8','cp1251',$_REQUEST[cid]);
printrus("Cтрана:<br/>\n");  //".$_REQUEST['name']."
printrus ("<form name=\"\" action=\"mpan.php?go&amp;$ses\" method=\"post\">
<input name=\"name\" maxlength=\"50\" title=\"Text\" value=\"".($ASS)."\"/><br />
Если страны нет введите id страны из удалений или из логов бывших соседей!<br />
<input name=\"cid\" maxlength=\"90\" title=\"Text\" value=\"".$REQUESTID."\"/>
<br/>*********<br />*<input name=\"t1\" type=\"checkbox\" value=\"1\"/>трнслт*\n<br />*********
<br/>\n");
unset($_POST['nick']);
  if ($level==1){
  printrus("*****<br/>");
  printrus("<input type=\"submit\" name=\"logsalm\" value=\"Лог рисования \"/><br/>");
  printrus("<input type=\"submit\" name=\"logsjech\" value=\"Лог сжиганий\"/><br/>");
  printrus("<input type=\"submit\" name=\"unblock\" value=\"Разблокировать\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsmag\" value=\"Логи магазина\"/><br/>");
  printrus("<input type=\"submit\" name=\"logswars\" value=\"Логи войн\"/><br/>");
  printrus("<input type=\"submit\" name=\"check\" value=\"Удалить/блокировать\"/><br/>");
  printrus("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsmes\" value=\"Логи общения\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsworks\" value=\"Логи работ\"/><br/>");
  printrus("<input type=\"submit\" name=\"logscit\" value=\"Логи цитадели\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsnz\" value=\" Новое здание \"/><br/>");
  printrus("*****<br/>");
  }
    //кнопки модерок
  if ($level==8){
  printrus("*****<br/>");
  printrus("<input type=\"submit\" name=\"logsbot\" value=\"Бот удалений\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsalm\" value=\"Лог рисования \"/><br/>");
  printrus("<input type=\"submit\" name=\"logsjech\" value=\"Лог сжиганий\"/><br/>");
  printrus("<input type=\"submit\" name=\"unblock\" value=\"Разблокировать\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsmag\" value=\"Логи магазина\"/><br/>");
  printrus("<input type=\"submit\" name=\"logswars\" value=\"Логи войн\"/><br/>");
  printrus("<input type=\"submit\" name=\"check\" value=\"Удалить/блокировать\"/><br/>");
  printrus("<input type=\"submit\" name=\"narisovat\" value=\"Нарисовать\"/><br/>");
  printrus("<input type=\"submit\" name=\"rename\" value=\"Переименовать\"/><br/>");
  printrus("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/><br/>");
  printrus("<a href=\"prv123.php?$ses\">Приваты(секретная информация!)</a><br/>");
  printrus("<input type=\"submit\" name=\"logsmes\" value=\"Логи общения\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsworks\" value=\"Логи работ\"/><br/>");
  printrus("<input type=\"submit\" name=\"logscit\" value=\"Логи цитадели\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsnz\" value=\" Новое здание \"/><br/>");
  printrus("*****<br/>");
  }

  if ($level==2){
  printrus("*****<br/>");
  printrus("<input type=\"submit\" name=\"logsjech\" value=\"Лог сжиганий\"/><br/>");
  printrus("<input type=\"submit\" name=\"unblock\" value=\"Разблокировать\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsmag\" value=\"Логи магазина\"/><br/>");
  printrus("<input type=\"submit\" name=\"logswars\" value=\"Логи войн\"/><br/>");
  printrus("<input type=\"submit\" name=\"check\" value=\"Удалить/блокировать\"/><br/>");
  printrus("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/><br/>");
  printrus("<input type=\"submit\" name=\"logsworks\" value=\"Логи работ\"/><br/>");
  printrus("<input type=\"submit\" name=\"logscit\" value=\"Логи цитадели\"/><br/>");
  printrus("*****<br/>");
  }


printrus("<input type=\"submit\" name=\"clone\" value=\"Поиск клонов\"/><br/>");
printrus("<input type=\"submit\" name=\"countries\" value=\"Страны\"/><br/>");
printrus("<input type=\"submit\" name=\"logs\" value=\"Логи обменов\"/><br/>");
printrus("<input type=\"submit\" name=\"logszah\" value=\"Логи захватов\"/><br/>");
printrus("<input type=\"submit\" name=\"logssos\" value=\"Логи соседей\"/><br/>");
printrus("<input type=\"submit\" name=\"ignor\" value=\"Вынуть из игнора\"/><br/>");
printrus("<input type=\"submit\" name=\"map\" value=\"Карта\"/><br/>");
printrus("</form>");
printrus("<br /><a href=\"mpan.php?$ses&amp;go=rules\"><b>Правила</b></a><br/><a href=\"mpan.php?$ses&amp;go=help\">Помощь</a><br/>");

}elseif($_REQUEST['map'] or $go == 'map'){


if ($pg==0)unset($pg);
$country1 = check($name);

  //$country2 = check($country2);

  if (isset($country1)) {
          if($t1=='1') $country1 = translit($country1);
          $country1 = iconv('utf-8','cp1251',$country1);
  }

  if ((!isset($country1) || $country1 == '')&&!isset($pg)){
  printrus ("Вы должны ввести название страны!<br/>\n");
  printrus ("<a href='mpan.php?$ses'>&lt;назад</a><br/>\r\n");
  }elseif(($a = mysql_fetch_array(mysql_query("SELECT * FROM `countries` WHERE countryName = '$country1' LIMIT 1")))===FALSE&&!isset($pg)){
          printrus ("Страны с названием $country1 нет на карте мира!<br/>\n");
          printrus ("<a href='mpan.php?$ses'>&lt;назад</a><br/>\r\n");
  }else{


  if (!isset($pg)){
  //Высчитываем, сколько стран перед заданной страной
  $query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)and(countries.reggedTime<'".$a['reggedTime']."')";
  $result = mysql_query($query);
  echo mysql_error();
  $c = mysql_fetch_array($result);
  $num = $c['num'];
  $pg = $num-5;
  }
  if ($pg<0)$pg=0;

  $query="SELECT countryName,ip,soft FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL) order by reggedTime asc LIMIT ".$pg.",10";
  $r = mysql_query($query);
  echo mysql_error();
  $npg = $pg-9;
  if ($pg>0) printrus ("<a href='mpan.php?go=map&amp;pg=$npg&amp;$ses'>&lt;&lt;запад</a> ");
  while(($a2=mysql_fetch_array($r))!==FALSE){
  if ($a2['countryName']!=$a['countryName'])printrus($a2['countryName']."(ip=".$a2['ip'].",soft=".$a2['soft']."), ");
  else printrus('<u>'.$a2['countryName']."</u>(ip=".$a2['ip'].",soft=".$a2['soft']."), ");
  echo "<br/><br/>";
  }
  $npg = $pg+9;
  printrus ("<a href='mpan.php?go=map&amp;pg=$npg&amp;$ses'>&gt;&gt;восток</a><br/>-------<br/>\r\n");

  printrus ("<a href='mpan.php?$ses'>еще...</a><br/>\r\n");
  }




}elseif ($_REQUEST['check']){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   $a = mysql_fetch_array($r);
   $cid = $a['countryID'];
   //Смотрим, проиграла ли страна
   $zz = mysql_query("SELECT count(*) as num FROM `messages` WHERE countryID = '$cid' and `from` = 'loose'");
   $aa = mysql_fetch_array($zz);
   if ($aa['num']>0) printrus("<u>Страна уже мертва. Нет необходимости убивать еще раз.</u><br/>");
   $zz = mysql_query("SELECT count(*) as num FROM `wars` WHERE targetID = '$cid'");
   $aa = mysql_fetch_array($zz);
   if ($aa['num']>0) printrus("<u>В этой стране есть вторжения. Возможно, ее скоро захватят</u><br/>");

   $reggedTime = $a['reggedTime'];
   $r1 = mysql_query("SELECT * FROM `uzers` WHERE countryID='$cid' LIMIT 1");
   $a1 = mysql_fetch_array($r1);
   $userID = $a1['userID'];
   if ($a1['inv']==-1 && $a1['blocked']>time()) printrus("<u>Страна уже заблокирована. Необходимости удалять или блокировать нет</u><br/>");
   printrus("Вы уверены?");
   printrus('ID=('.$userID.')<br/>');
   if ($_SESSION['userID']!=20005) printrus
("<a href=\"mpan.php?$ses&amp;go=kill&amp;cid=$cid\">Убить!</a><br/>
");
if ($_SESSION['userID']!=20005)printrus
("<a href=\"mpan.php?$ses&amp;go=block&amp;cid=$cid\">Блокировать доступ</a><br/>
");
printrus("(если не уверены)<br/>\n\r");

   $r2 = mysql_query("SELECT * FROM `uzers` WHERE userID>($userID-6) LIMIT 10");
   printrus("10 соседних зарегенных юзеров (юзернейм данной страны подчеркнут):<br/>\n");
    while(($a2=mysql_fetch_array($r2))!==FALSE){
    $username = $a2['username'];
    $ip = $a2['ip'];
    $soft = $a2['soft'];
    $telnum = $a2['telnum'];
    //$cname = checkCountryID($a2['countryID']);
    $key=_PREFIKS.':id'.$a2['countryID'];
    if (($mem=$memcache->get($key))!==FALSE){
       $inf = $mem;
       }else{
       $z = mysql_query("SELECT * FROM `countries` WHERE countryID = '".$a2['countryID']."' LIMIT 1");
       $inf = mysql_fetch_array($z);
       }
    $cname = $inf['countryName'];
    $reg = $inf['reggedTime'];
    $razn = mkTimeStr(max($reggedTime-$reg,$reg-$reggedTime));
    if ($a2['countryID']!=$cid)printrus("Username: $username (страна $cname), ip: $ip, soft: $soft, number: $telnum, разн. вр. $razn<br/>\n");
     else printrus("Username: <u>$username</u>, ip: $ip, soft: $soft, number: $telnum<br/>\n");
    echo "<br/>";
    }



   }

}elseif($_REQUEST['kill'] or $go == 'kill'){
printrus("Вы уверены что хотите убить эту страну?<br/>\n");
printrus("Причина (здесь напишите страны-клоны, либо обмены-сливы и т.п.):<br/>\n");
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=verkill&amp;cid=$cid\" method=\"post\">
<input name=\"purp\" maxlength=\"1500\" title=\"Text\" value=\"\"/>
<br/>\n");
printrus
("<input type=\"submit\" value=\"да!\"/>
</form><br/>
");
}elseif($go=='block'){
printrus("Вы уверены что хотите заблокировать доступ этой стране?<br/>\n");
printrus("Причина (здесь напишите страны-клоны, либо обмены-сливы и т.п.):<br/>\n");
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=verblock&amp;cid=$cid\" method=\"post\">
<input name=\"purp\" maxlength=\"1500\" title=\"Text\" value=\"\"/>
<br/>\n");
printrus("Время блока (в часах, максимум неделя, по умолчанию неделя):<br/>\n");
printrus("<input format='*N' name='hours' /><br/>");
printrus
("<input type=\"submit\" value=\"да!\"/>
</form><br/>
");
}elseif($go=='verkill'){
$cname = checkCountryID($cid);
$r= mysql_query("SELECT userID,inv FROM `uzers` WHERE countryID = '$cid'");
$a=mysql_fetch_array($r);
$userID = $a['userID'];
if ($a['inv']==2 and $level!=8){printrus("Нельзя удалить/блокировать модера!<br/>\n");
printrus ("<a href='mpan.php?$ses'>Назад</a><br/>\r\n");
include_once("other_inc/footer.php");
die("");
}else{
printrus("Вы убили страну $cname!<br/>\n");
sendMessage($cid,'fullMessage',"Модер <u>".$b['countryName']."</u> убил вашу страну за нарушение правил. Причину вы можете посмотреть на главной странице в графе удаления.");
looser($cid);
//Если были сохранения, удаляем их
//mysql_query("");

//Пишем в базу причину удаления и название страны
$purp=htmlspecialchars(iconv('utf-8','cp1251',$purp));
mysql_query("INSERT INTO `purposes` SET cname='$cname', why='$purp(ID=$cid)',who='".$b['countryName']."',tm='".time()."'");

@$open=fopen("mod/mpan.dat","a+");
@flock ($open,LOCK_EX);
$str = date("d M(H:i)").">".$b['countryName']."(ip:$mip, soft:$msoft) убивает страну $cname(userID=$userID)\n\r";
@fwrite ($open,$str);
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
}
}elseif($go=='verblock'){
$cname = checkCountryID($cid);
$r= mysql_query("SELECT userID,inv FROM `uzers` WHERE countryID = '$cid'");
$a=mysql_fetch_array($r);
$userID = $a['userID'];
if ($a['inv']==2 and $level!=8){
printrus("Нельзя удалить/блокировать модера!<br/>\n");
printrus ("<a href='mpan.php?$ses'>Назад</a><br/>\r\n");
include_once("other_inc/footer.php");
die("");
}else{
$hours = round($hours);
if ($hours==0 || $hours>24*7) $hours = 24*7;

printrus("Вы блокировали доступ стране $cname!<br/>\n");

mysql_query("UPDATE `uzers` SET inv=-1, blocked = '".(time()+$hours*3600)."' WHERE userID='$userID' LIMIT 1");
$key=_PREFIKS.':id'.$cid;
if(($mem=$memcache->get($key))!==FALSE){
        $mem['inv']=-1;
        $mem['blocked']=time()+$hours*3600;
        $memcache->set($key,$mem,false,86400);
}
//Пишем в базу причину удаления и название страны
$purp=htmlspecialchars(iconv('utf-8','cp1251',$purp));
mysql_query("INSERT INTO `blocks` SET cid='$userID', why='$purp',who='".$b['countryName']."',tm='".time()."'");

@$open=fopen("mod/mpan.dat","a+");
@flock ($open,LOCK_EX);
$str = date("d M(H:i)").">".$b['countryName']."(ip:$mip, soft:$msoft) блокировал страну $cname(userID=$userID)\n\r";
@fwrite ($open,$str);
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
}
}elseif($_REQUEST['countries']){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");

if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   $a=mysql_fetch_array($r);
   printrus("Страны, с которых заходил юзер:<br/>\n");
   $cid = $a['countryID'];
   $r = mysql_query("SELECT cnts,username FROM `uzers` WHERE countryID = '$cid' LIMIT 1");
   $a = mysql_fetch_array($r);
   if ($a['username']=='Kotyarka'||$a['username']=='renegat')$a['cnts']='';
   $s = str_replace(".",",",$a['cnts']);
   printrus($s."<br/>\n");

   }


}elseif($_REQUEST['clone']){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   $r3 = mysql_query("SELECT * FROM `uzers` WHERE countryID = '$cid' LIMIT 1");
   $a3=mysql_fetch_array($r3);
   $ip=$a3['ip'];
   $ip=explode('.',$ip); $ip=$ip[0].'.'.$ip[1].'.'.$ip[2].'.';
   $ip2=$a['ip'];
   $ip2=explode('.',$ip2); $ip2=$ip2[0].'.'.$ip2[1].'.'.$ip2[2].'.';
    printrus("Возможные клоны по ip: ( учитывается ip при регистрации профиля и ip последней авторизации.)<br/>\n");
   $query="select countries.countryName,countries.ip,countries.countryID,countries.reggedTime from countries left join uzers ON
   uzers.countryID=countries.countryID and ((uzers.ip not like '$ip%') and (uzers.ip not like '$ip2%')
    and (countries.ip not like '$ip%') and (countries.ip not like '$ip2%'))
   where uzers.countryID is null";
   $r = mysql_query($query);

   printrus("<p>\n");
   while(($r2 = mysql_fetch_array($r))!==false){
   if($a['reggedTime']>$r2[3])$txt='разница старта '.mkTimeStr($a['reggedTime']-$r2[3]); else $txt='разница старта '.mkTimeStr($r2[3]-$a['reggedTime']);
   if ($a['reggedTime']>$r2[3])
  $query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)and(countries.reggedTime>'".$r2[3]."')and(countries.reggedTime<'".$a['reggedTime']."')";
  else $query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)and(countries.reggedTime>'".$a['reggedTime']."')and(countries.reggedTime<'".$r2[3]."')";
  $result = mysql_query($query);
   $c = mysql_fetch_array($result);
   if(neighbour_exists($a['countryID'],$r2[2]))$text='Эта страна является соседом!';else $text="по карте <b><i>".$c['num']."</i></b> стран";
   printrus("<u><i><a href=\"mpan.php?name=".$r2[0]."$nus&amp;$ses\">".$r2[0]."</a></i></u> ( <i>last ip <b>".$r2[1]."</b></i>)[".$text."][".$txt."],<br />\n");
   }
   printrus("</p>\n");




   }


}elseif($_REQUEST['ignor']){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   $a=mysql_fetch_array($r);
   printrus("Со страны $name снят игнор в ассамблее!<br/>\n");
   $cid = $a['countryID'];
   mysql_query("UPDATE `uzers` SET inv=0 WHERE countryID = '$cid' LIMIT 1");
   $key = _PREFIKS.':id'.$cid;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem['inv']=0;
      $memcache->set($key,$mem,false,86400);
      }
   }


}elseif($_REQUEST['unblock']){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   $a=mysql_fetch_array($r);
   printrus("Со страны $name снят блок!<br/>\n");
   $cid = $a['countryID'];
   mysql_query("UPDATE `uzers` SET inv=0, blocked=0 WHERE countryID = '$cid' LIMIT 1");
   $key = _PREFIKS.':id'.$cid;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem['inv']=0;
      $mem['blocked']=0;
      $memcache->set($key,$mem,false,86400);
      }
//Получим id юзера
$r= mysql_query("SELECT userID FROM `uzers` WHERE countryID = '$cid'");
$a=mysql_fetch_array($r);
$userID = $a['userID'];
   mysql_query("DELETE FROM `blocks` WHERE cid='$userID'");
   }


}elseif($_REQUEST['logs'] or $go == 'logs'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/$cid")){
      printrus ("<b>!</b>По этой стране нет логов<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logs&amp;cid=$cid&amp;pg=$npg\">далее..</a>
<br/>
");
         }

      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logs&amp;cid=$cid&amp;pg=$npg\">назад..</a>
<br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logs&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif($_REQUEST['logsjech'] or $go == 'logsjech'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/sg$cid")){
      printrus ("<b>!</b>По этой стране нет логов сжиганий<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/sg$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logsjech&amp;cid=$cid&amp;pg=$npg\">далее..</a>
<br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logsjech&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logsjech&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif($_REQUEST['logsbot'] or $go == 'logsbot'){


   if (!file_exists(_ROOT."/logs/dellbot.dat")){
   printrus ("<b>!</b>Лог пуст<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/dellbot.dat");
      for ($i=$pg;$i<count($logs)&&$i<$pg+100;$i++){
          printrus($logs[$i]);
          }
      if ($i<count($logs)){
      $npg=$pg+99;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logsbot&amp;cid=$cid&amp;pg=$npg\">далее..</a>
<br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-99);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logsbot&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logsbot&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"14\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }


    //лог алмазов
}elseif($_REQUEST['logsalm'] or $go == 'logsalm'){


   if (!file_exists(_ROOT."/logs/alm2")){
      printrus ("<b>!</b>По этой стране нет логов алмазов<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/alm2");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logsalm&amp;cid=$cid&amp;pg=$npg\">далее..</a>
<br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logsalm&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logsalm&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }



}elseif($_REQUEST['sjech'] or $go == 'sjech'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   }
    $do=$REQUEST['do'];
   //Сдесь пишем систему сжиганий!
    if(!isset($_REQUEST['do'])){
    printrus("Сколько будем сжигать?:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");
    printrus("За что сжигаем:<br/>\n");
    printrus ("<input name=\"why\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");
    printrus ("<select name=\"l\">\n");
    printrus ("<option value=\"0\">Горы</option>\n");
    printrus ("<option value=\"1\">Деньги</option>\n");
    printrus ("<option value=\"2\">Железо</option>\n");
    printrus ("<option value=\"3\">Камень</option>\n");
    printrus ("<option value=\"4\">Нефть</option>\n");
	printrus ("<option value=\"5\">Зерно</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/>
    </form><br/>
");
    }else{
    $cnt=htmlspecialchars($_REQUEST['cnt']);
    $why=htmlspecialchars($_REQUEST['why']);
    $l=htmlspecialchars($_REQUEST['l']);
    $why=iconv('utf-8','cp1251',$why);
    switch($l):
    case 0:
    $l='гор';
    $l2='mountains';
    break;
    case 1:
    $l='денег';
    $l2='money';
    break;
    case 2:
    $l='железа';
    $l2='iron';
    break;
    case 3:
    $l='камня';
    $l2='stone';
    break;
    case 4:
    $l='нефти';
    $l2='oil';
    break;
	case 5:
    $l='зерно';
    $l2='grain';
    break;
    endswitch;
    $key1=_PREFIKS.':id'.$cid;
    if (($maa=$memcache->get($key1))!==FALSE) $id_ma = TRUE; else $id_ma = FALSE;

    if ($id_ma==TRUE){
    $e=$maa;
    }else{
    $query="select * from `countries` where countryID='$cid' limit 1";
    $result=@MYSQL_QUERY($query);
    $e = mysql_fetch_array($result);
    }

    $error=($e[$l2]<$cnt)?'У государства <u>'.$e['countryName'].'</u> нет столько '.$l.'!<br />':'';
    $error=($cnt<1)?'Нельзя сжечь мньше 1 '.$l.'!<br />':$error;
    $error=($why=='')?'Вы не написали причину для сжигания '.$l.'!<br />':$error;
    if($error!=''){
     printrus("$error");
     }else{
    printrus("
    Вы сожгли $cnt $l гос-ву <u>".$e['countryName']."</u>!<br />");


    mysql_query("UPDATE countries SET $l2 = $l2 - $cnt WHERE countryID = '".$cid."'");
   $e[$l2] = $e[$l2] - $cnt;
    $key=_PREFIKS.':id'.$cid;
        if(($mem=$memcache->get($key))!==FALSE){
        $mem[$l2]=$mem[$l2]-$cnt;
        $memcache->set($key,$mem,false,86400);
          }
      sendMessage($cid,"fullMessage","Модер <u>".$b['countryName']."</u> сжёг Вам <b>$cnt</b> $l за: $why.");

   @$open=fopen(_ROOT."/logs/sg$cid","a+");
   @flock ($open,LOCK_EX);
   $str = date("H:i j.m:").">Модер <u>".$b['countryName']."</u> сжёг стране <u>".$e['countryName']."</u> $cnt $l за: $why\n\r";
   @fwrite ($open,$str);
   @fflush($open);
   @flock ($open,LOCK_UN);
   @fclose($open);
   }
   }
   }

}




//---------
elseif($_REQUEST['narisovat'] and ($level == 8 or $level == 1)){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   }
    $do=$REQUEST['do'];
   //Сдесь пишем систему рисования!
    if(!isset($_REQUEST['do'])){
    printrus("Сколько будем рисовать?:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");
    printrus("За что рисуем:<br/>\n");
    printrus ("<input name=\"why\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");
    printrus ("<select name=\"l\">\n");
    if($level == 8)printrus ("<option value=\"0\">Горы</option>\n");
    if($level == 8)printrus ("<option value=\"1\">Деньги</option>\n");
    if($level == 8)printrus ("<option value=\"2\">Железо</option>\n");
    if($level == 8)printrus ("<option value=\"3\">Камень</option>\n");
    if($level == 8)printrus ("<option value=\"4\">Нефть</option>\n");
    if($level == 8)printrus ("<option value=\"5\">Зерно</option>\n");
	if($level == 8)printrus ("<option value=\"6\">Дерево</option>\n");
	if($level == 8)printrus ("<option value=\"7\">Рабочии</option>\n");
	if($level == 8)printrus ("<option value=\"8\">Ученые</option>\n");
	if($level == 8)printrus ("<option value=\"9\">наука камень</option>\n");
	if($level == 8)printrus ("<option value=\"10\">Вор</option>\n");
	 if($level == 1)printrus ("<option value=\"0\">Горы</option>\n");
    if($level == 1)printrus ("<option value=\"1\">Деньги</option>\n");
    if($level == 1)printrus ("<option value=\"2\">Железо</option>\n");
    if($level == 1)printrus ("<option value=\"3\">Камень</option>\n");
    if($level == 1)printrus ("<option value=\"4\">Нефть</option>\n");
    if($level == 1)printrus ("<option value=\"5\">Зерно</option>\n");
	if($level == 1)printrus ("<option value=\"6\">Дерево</option>\n");
	if($level == 1)printrus ("<option value=\"7\">Рабочии</option>\n");
	if($level == 1)printrus ("<option value=\"8\">Ученые</option>\n");
	if($level == 1)printrus ("<option value=\"9\">наука камень</option>\n");
	if($level == 1)printrus ("<option value=\"10\">Вор</option>\n");
	printrus ("<option value=\"11\">Алмазы</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"нарисовать\"/>
    </form><br/>
");
    }else{
    $cnt=htmlspecialchars($_REQUEST['cnt']);
    $why=htmlspecialchars($_REQUEST['why']);
    $l=htmlspecialchars($_REQUEST['l']);
    $why=iconv('utf-8','cp1251',$why);
    switch($l):
    case 0:
    $l='гор';
    $l2='mountains';
    break;
    case 1:
    $l='денег';
    $l2='money';
    break;
    case 2:
    $l='железа';
    $l2='iron';
    break;
    case 3:
    $l='камня';
    $l2='stone';
    break;
    case 4:
    $l='нефти';
    $l2='oil';
    case 5:
    $l='зерна';
    $l2='grain';
    break;
	case 6:
    $l='дерево';
    $l2='arbor';
    break;
	case 7:
    $l='рабочии';
    $l2='workers';
    break;
	case 8:
    $l='ученые';
    $l2='scientists';
    break;
	case 9:
    $l='наука камень';
    $l2='stone_making';
    break;
	case 10:
    $l='вор';
    $l2='grabber';
    break;
    case 11:
    $l='Алмазов';
    $l2='credits';
    break;
    endswitch;
    $key1=_PREFIKS.':id'.$cid;
    if (($maa=$memcache->get($key1))!==FALSE) $id_ma = TRUE; else $id_ma = FALSE;

    if ($id_ma==TRUE){
    $e=$maa;
    }else{
    $query="select * from `countries` where countryID='$cid' limit 1";
    $result=@MYSQL_QUERY($query);
    $e = mysql_fetch_array($result);
    }

    $error=($cnt<1)?'Нельзя нарисовать мньше 1 '.$l.'!<br />':$error;
    if($error!=''){
     printrus("$error");
     }else{
    printrus("
    Вы нарисовали $cnt $l гос-ву <u>".$e['countryName']."</u>!<br />");


     if($l2 == 'credits')
     {
     mysql_query("UPDATE uzers SET credits = credits + $cnt WHERE countryID = '".$cid."'");
     }
     else
     {
     mysql_query("UPDATE countries SET $l2 = $l2 + $cnt WHERE countryID = '".$cid."'");
     }
   $e[$l2] = $e[$l2] - $cnt;
    $key=_PREFIKS.':id'.$cid;
        if(($mem=$memcache->get($key))!==FALSE){
        $mem[$l2]=$mem[$l2]+$cnt;
        $memcache->set($key,$mem,false,86400);
          }
      sendMessage($cid,"fullMessage","Модер <u>".$b['countryName']."</u> нарисовал Вам <b>$cnt</b> $l за: $why.");

   @$open=fopen(_ROOT."/logs/alm2","a+");
   @flock ($open,LOCK_EX);
   $str = date_new("H:i j.m:").">Модер <u>".$b['countryName']."</u> нарисовал стране <u>".$e['countryName']."</u> $cnt $l за: $why\n\r";
   @fwrite ($open,$str);
   @fflush($open);
   @flock ($open,LOCK_UN);
   @fclose($open);
   }
   }
   }

}
//------







elseif($_REQUEST['logscit'] or $go == 'logscit'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/cit$cid")){
      printrus ("<b>!</b>По этой стране нет логов цитадели<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/cit$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>___________________________________________<br><br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logscit&amp;cid=$cid&amp;pg=$npg\">далее..</a>
<br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logscit&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logscit&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif($_REQUEST['logsworks'] or $go == 'logsworks'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/works$cid")){
      printrus ("<b>!</b>По этой стране нет логов работ<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/works$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logsworks&amp;cid=$cid&amp;pg=$npg\">далее..</a><br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logsworks&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logsworks&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif(($_REQUEST['logsmes'] or $go == 'logsmes') and ($level == 8 or $level == 1)){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   $r1 = mysql_query("SELECT * FROM `uzers` WHERE countryID='$cid' LIMIT 1");
   $a1 = mysql_fetch_array($r1);
   if (!file_exists(_ROOT."/logs/mes$cid") or ($level == 1 and (in_array($a1['userID'],$older) or in_array($a1['userID'],$older4)))){
      printrus ("<b>!</b>По этой стране нет логов общения<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/mes$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logsmes&amp;cid=$cid&amp;pg=$npg\">далее..</a><br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logsmes&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logsmes&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif($_REQUEST['logszah'] or $go == 'logszah'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/zah$cid")){
      printrus ("<b>!</b>По этой стране нет логов захватов<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/zah$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>___________________________________________<br><br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logszah&amp;cid=$cid&amp;pg=$npg\">далее..</a><br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logszah&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logszah&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif($_REQUEST['logswars'] or $go == 'logswars'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/war$cid")){
      printrus ("<b>!</b>По этой стране нет логов войн<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/war$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus(''.$logs[$i].'<br />');
          if($i<1)break;
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logswars&amp;cid=$cid&amp;pg=$npg\">далее..</a><br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logswars&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logswars&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif($_REQUEST['logssos'] or $go == 'logssos'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/sos$cid")){
      printrus ("<b>!</b>По этой стране нет логов соседей<b>!</b><br/>\r\n");
      }else{
      printrus("Все соседи, когда-либо бывшие у гос-ва (сосед пишется в лог только после уничтожения, так что живых соседей здесь нет):<br/>\n");
      $logs=file(_ROOT."/logs/sos$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logssos&amp;cid=$cid&amp;pg=$npg\">далее..</a><br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logssos&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logssos&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}

elseif($_REQUEST['logsnz'] or $go == 'logsnz'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/nz$cid")){
      printrus ("<b>!</b>По этой стране нет логов здания<b>!</b><br/>\r\n");
      }else{
      $logs=file(_ROOT."/logs/nz$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br/>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logsnz&amp;cid=$cid&amp;pg=$npg\">далее..</a><br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logsnz&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logsnz&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");
unset($logs);
      }

   }

}elseif($_REQUEST['logsmag'] or $go == 'logsmag'){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
if (!isset($cid))$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
else $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$cid' LIMIT 1");
if (mysql_num_rows($r)==0 && !isset($_REQUEST[id]) && !isset($cid)){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   if (!isset($cid)){
   $a=mysql_fetch_array($r);
   $cid = $a['countryID'];
   if($_REQUEST[id]<>'')$cid=$_REQUEST[id];
   }
   if (!file_exists(_ROOT."/logs/magaz$cid")){
      printrus ("<b>!</b>По этой стране нет логов магазина<b>!</b><br/>\r\n");
      }else{
      printrus("Все операции в магазине:<br/>\n");
      $logs=file(_ROOT."/logs/magaz$cid");
      $vl=count($logs)-($pg+1);
      for ($i=$vl;$i>$vl-($pg+10);$i--){
          printrus($logs[$i]."<br>");
          }
      if ($i>0){
      $npg=$pg+9;
      printrus
("<a href=\"mpan.php?$ses&amp;go=logsmag&amp;cid=$cid&amp;pg=$npg\">далее..</a><br/>
");
         }
      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"mpan.php?$ses&amp;go=logsmag&amp;cid=$cid&amp;pg=$npg\">назад..</a><br/>
");
         }
printrus ("<form name=\"\" action=\"mpan.php?$ses&amp;go=logsmag&amp;cid=$cid\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>\n");
printrus (" к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pg\" title=\"Page\"/></form> записи (из ".count($logs).")<br/>");;
unset($logs);
      }

   }
}else if ($go=='rules'){
printrus("
<b><u>Правила  для должностных лиц (модераторов)</u></b><br/><br/>
<b>1. Модератор должен</b><br/>
1.1. Следить за выполнением пользователями правил в игре; <br/>
1.2. Все должностные действия, предупреждения, игноры, вывод в чат сообщений об удалении или иных наказаниях стран выполнять только со страны, где находится  Модер-панель <b> (модерской страны) </b>; <br/>
1.3. При нахождении в чате с модерской страны принимать заявки пользователей, в случае невозможности выполнения функций по проверкам выходить в чат с обычных стран, либо использовать приватное общение в чате, за исключением случаев когда необходимо дать игнор; <br/>
1.4. Объявлять результаты проверок в чате, объявлять поставленный игнор; <br/>
1.5. С момента наказания страны <b>в течение 15 минут</b> находиться в чате и быть готовым к объяснению причины наказания пользователю, за исключением случаев, когда подобные нарушения уже совершались данным пользователем; <br/>
1.6. Отвечать на вопросы пользователей связанные с игрой, разъяснять правила игры; <br/>
1.7. Упреждать  будущие нарушения; <br/>
1.8. Не допускать рекламы других сайтов; <br/>
1.9. По всем сомнительным, спорным и не ясным вопросам по проверкам обращаться к старшему модератору. <br/>
1.10. Стараться чаще посещать игру и выполнять возложенные на него должностные обязанности. <br/>
1.11. Стараться использовать одно постоянное, или схожие названия своей модерской страны. <br/><br/>
<b>2. Модератору запрещено</b><br/>
2.1. Во время игры или выполнения должностных обязанностей нарушать правила игры; <br/>
2.2. Наказывать страны пользователей не в соответствии с правилами; <br/>
2.3. Разглашать модерские функции и критерии сжиганий пользователям; <br/>
2.4. Использовать полученную информацию при проверках стран в своих интересах; <br/>
2.5. Разглашать каким либо образом параметры страны пользователя, которые предусмотрены как скрытые для игроков; <br/>
2.6. Удалять или блокировать модерскую страну другого модератора; <br/>
2.7. Проверять соседей, за исключением ситуаций при заявках с подозрением на баги игры, использовании багов пользователями; <br/>
2.8. Принимать заявки на сжигания в приват; <br/>
2.9. Снимать игнор или блокировку страны пользователя, которая получена от другого равного по должности модератора или старшего модератора; <br/>
2.10. Производить корректировки по сжиганиям, досжигания в странах, у которых уже произведены сжигания другим модератором или старшим модератором; <br/>
2.11. Удалять пустынные/заброшенные территории или не игровые страны пользователей без оснований. <br/><br/>
<b>3. Правила сжиганий при отсутствии сопротивления</b><br/>
3.1. <u>Воровство ресурсов (по каждому факту кражи отдельно, Первые две кражи):</u> <br/>
<b>3.1.1. Если шпионаж обворованной страны меньше  воровства укравшего на  0 -  10%</b><br/>
Украденные ресурсы оставлять: 100%<br/>
<b>3.1.2. Если шпионаж обворованной страны меньше  воровства укравшего  на 11% - 30%</b><br/>
Украденные ресурсы оставлять половину<br/>
<b>3.1.3. Если шпионаж обворованной страны меньше  воровства укравшего  на 31% - 50%</b><br/>
Украденные ресурсы оставлять 25%<br/>
<b>3.1.4. Если шпионаж обворованной страны меньше  воровства укравшего  на 51% - 100%</b><br/>
Украденные ресурсы не оставлять <br/>
Считать параметры: шпионаж и воровство до кражи. <br/><br/>
<u>Общие условия</u><br/>
3.1.5. Во всех случаях при отсутствии сопротивления <b>после второй кражи</b> ресурсы, полученные от последующих краж в общей сумме <b>за 12 часов</b> сжигаются до  ресурсов пустынной территории:  8000 денег,   1050 камня,  800 железа,  0 нефти. <br/>
3.1.6. Не сжигаются незначительные кражи (начиная с третьей), общая сумма  которых с одной и той же страны <b>за 12часов</b> не превышает всех ресурсов пустынной территории: 8000 денег,   1050 камня,  800 железа,  0 нефти (Лимит); <br/>
3.1.7. Первой считается кража (одной определенной страны), если до этого не воровал эту же страну  12часов и дольше. После двух краж +12 часов счет ресурсов для лимита начинается заново. <br/>
3.1.8. При выявлении краж налога, сжигается ресурс купленный на налог/деньги <b>95%</b>.<br/>
3.1.9. Не учитываются пустынные/заброшенные территории и не игровые страны (без логов цитадели, обменов, войн, захватов и работ, не снявшие налогов) <br/><br/>
3.2. <u>Вербовка Армии:</u> <br/>
<b>3.2.1.Границы и условия те же что и при воровстве</b> (аналогично: <b> пунктам: 3.1.1. -3.1.4</b>) <br/>
3.2.2. Сжигать за завербованные войска деньгами из расчета: <br/>
Деньги: Пехотинец  5; Кавалерист: 20;Стрелок: 40; Пушка: 150; Подрывник: 50; Самолет: 200; Маг: 100. <br/>
Либо любым ценным ресурсом на выбор пользователя по <b>минимальным рыночным ценам</b>. <br/><br/>
<u>Общие условия</u><br/>
3.2.3. Во всех случаях при отсутствии сопротивления после второй вербовки войско, полученное от последующих вербовок в общей сумме<b> за 12 часов</b>, сжигается по стоимости (п.3.2.2.) до <b>12000 денег</b> (Лимит). <br/>
3.2.4. Начиная с третьей не сжигаются незначительные вербовки, общая стоимость (п.3.2.2.) войск  которых с одной и той же страны <b>за 12часов</b> не превышает <b>12000</b> денег (Лимит); <br/>
3.2.5. Первой считается вербовка армии (у одной определенной страны), если до этого не вербовал армию этой же страны  12часов и дольше. После двух вербовок +12 часов счет стоимости армии для лимита начинается заново. <br/><br/>
3.3. <u>Захват страны</u>:  <br/>
Оставлять: 8000 денег,   1050 камня,  800 железа,  0 нефти,  1000 гор<br/>
Ресурс с разрушения Цитадели и Рынка учитывается и прибавляется к ресурсу полученному при захвате. <br/><br/>
<b>Если какого то ресурса недостает в захвате и какого то излишек, то необходимо считать по минимальным рыночным ценам и производить взаимозачет, а разницу сжигать излишним ресурсом. </b> <br/><br/>
<b>4. Сопротивление. Сопротивлением является: </b><br/>
 4.1. <u>Нападение, отражение атаки</u>. <br/>
При этом: Страна, сопротивляющаяся должна использовать не менее 33% своего потенциала. <br/>
Войска на стене, в охране зданий или же свободные войска при захвате – не считать отражением атаки или сопротивлением; <br/>
4.2. <u>Атака цитаделью</u>. <br/>
Снижение шпионажа агрессора более чем на 5 единиц является 100% сопротивлением. <br/>
Грабеж агрессора является  сопротивлением. <br/>
Ущерб оценивает модератор<br/>
4.3. Помощь сопротивляющемуся союзнику. <br/>
Атака вторженца на территории союзника, война с агрессором на территории союзника агрессора, передача ресурсов (Займа более 33% установленных лимитов). <br/>
4.4. <u>Сопротивление  учитывается, если оно произошло в течение 12 часов с момента первой кражи или вербовки, или же было менее 12 часов назад до первой кражи или вербовки. Если ущерб одному  от сопротивления другого значителен(снимался налог, добывались горы), то интервал увеличивается до 24часов</u>. <br/>
При сопротивлении горы, получаемые при захвате с территории страны не сжигаются. <br/>
При сопротивлении ресурсы/войска с краж/вербовки не сжигаются. <br/>
Модератор сам должен оценить степень сопротивления, <b>учесть  ущерб победителя при войне</b>, атаке цитаделью, стоимость потерь сниженного шпионажа, снятый налог и срубленные горы. <br/><br/>
<b>5. Слабое сопротивление</b><br/>
5.1. Это сопротивление, при котором используется менее 33% потенциала страны, при условии, что атака цитаделью не успешна против победителя и не дан заем сопротивляющемуся союзнику более 33% лимита займа. <br/>
5.2. При слабом сопротивлении сжигаются горы не ниже 3000. <br/>
5.3. При слабом сопротивлении ресурсы/войска с <b>первой кражи/вербовки</b> не сжигаются, если воровство/вербовка агрессора: 85-100%, а шпионаж жертвы не ниже 65%. <br/>
(При многократных повторениях данных ситуаций у одной страны всё сжигается по условиям <b>пунктов 3.1.1. -3.1.4.; и далее по общим условиям</b>) <br/>
Вторая и последующие кражи/вербовки сжигаются по условиям <b>пунктов 3.1.1. -3.1.4.; и далее по общим условиям</b> <br/>
5.4. Если воровство/вербовка агрессора и шпионаж жертвы не соответствуют условиям <b>пункта 5.3</b>, то все кражи/вербовки сжигаются по условиям <b>пунктов 3.1.1. -3.1.4. и общим условиям</b><br/><br/>
<b>Если слабое сопротивление всё же нанесло значительные потери агрессору, то модератор должен оценить ущерб и сжечь соответственно меньше. </b> <br/><br/>
5.5. При выявлении краж налога, сжигается ресурс купленный на налог/деньги <b>85%</b>.<br/><br/>
<b>Все условия сжиганий запрещено разглашать пользователям. </b> <br/><br/>
<b>6. Старший модератор: </b> <br/>
6.1.Выполняет в соответствии и контролирует выполнение модераторами данных правил; <br/>6.2.Может корректировать сжигания произведенные модераторами (в течении 12 часов); <br/>
6.3.Может снимать игнор, блокировку данную на страну пользователя модератором, если считает, что данные действия должностного лица не соответствуют правилам игры; <br/>
6.4.Разбирает и решает проблемные вопросы по проверкам стран пользователей, может перепроверить сомнительные ситуации и действия пользователей вызывающие подозрения; <br/>
6.5. За модератора исполнителя может разъяснить причину наказания пользователю; <br/>
6.6.Может проверять соседние страны. <br/><br/>
<b>7. От Администрации: </b> <br/>
7.1. При выявлении нарушений, модератор должен исходить из позиции «спасти страну пользователя от удаления» путём сжиганий, предупреждений и т.п., в разумных пределах. Делать отметки в логах сжиганий по нестандартным ситуациям, для информирования других модераторов по данной стране. Проявлять к новичкам в игре особое внимание. <br/>
7.2. Если пользователь систематически нарушает правила или же стремится обмануть модератора, то позиция п.7.1 на него не должна распространяться; <br/>
7.3. Убедительная просьба: должностных лиц просим по чаще посещать игру, выполнять свои функции. При отсутствии модератора более <b>7 дней</b> без уважительной причины, которую тот должен сказать старшему модератору непосредственно, модератор снимается с должности. <br/>
");
printrus ("<br/><a href=\"mpan.php?$ses\">ок</a><br/>\n");
}else if ($go=='help'){
printrus("<u>Как правильно определять клонов</u><br/>\n");
printrus("Сначала проверьте подозрительное гос-во по логам. Если это гос-во меняло небольшое кол-во своих
ресурсов (обычно меняют 1 зерна) на большое кол-во ресурсов других гос-в много раз, это почти 100%
клон, либо нечестная игра. На всякий случай можете проверить гос-ва, с которыми производился обмен,
на клоны - посмотрите их софт и ip адрес. Также если вы нажали на \"проверить на клоны\", и вокруг
гос-ва много юзеров с тем же ip и soft, это тоже почти 100% клоны. НО! Если вы хоть немного не уверены,
клоны это или нет, НЕ УБИВАЙТЕ гос-во, а обратитесь к администрации, у них есть более полная информация
о странах.<br/>
<u>Логи захватов</u><br/>
nalog-налог с одного чел-ка, napr-напряжение, land-земля, mountains-горы, forest-лес, money-деньги, arbor-древесина, stone-камень, grain-зерно, iron-железо, workers-своб.рабоч., scientists-своб.ученые, sciencelvl-уровень науки, spyT/sabT/grabT/verbT - время последнего шпионажа/сабот./грабежа/вербовки (если 0, то никогда не было - очень подозрительно), wariors_atall-всего воинов, wariors_free-свободных воинов, weap_force-сила оружия, weap_speed-скорость атаки.<br/>\n");
printrus ("<a href=\"mpan.php?$ses\">ок</a><br/>\n");
}else if ($_REQUEST['rename']){
if ($t1=='1') $name=translit($name);
$name = iconv('utf-8','cp1251',$name);
$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
if (mysql_num_rows($r)!=0){
   printrus ("<b>!</b>Страна с таким названием уже есть на карте мира<b>!</b><br/>\r\n");
   }elseif(!cnameisok(iconv('cp1251','utf-8',$name))){
   printrus ("<b>!</b>В названии страны использованы недопустимые символы<b>!</b><br/>\r\n");
   }else{
   printrus("Ваша страна переименована в <u>$name</u>!<br/>\n");
   mysql_query("UPDATE `countries` SET countryName='$name' WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $key = _PREFIKS.':id'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem['countryName']=$name;
      $memcache->set($key,$mem,false,86400);
      }
   }


printrus ("<a href=\"mpan.php?$ses\">ок</a><br/>\n");
}


echo "-------<br/>\n";
//printrus ("<a href=\"game.php?$ses\">В игру</a><br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
?>