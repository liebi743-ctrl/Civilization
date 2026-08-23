<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['name'])) $name = $_REQUEST['name'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];

//==============================================================================
//подключаем скрипты, там, и еще всякая фигня:)=================================

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

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
  $tm = time();
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600), lastsessid = '$ses' WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u>");

  print "<br/>\r\n";
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='index.php'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 $countryID = $b['countryID'];

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
    //футер страницы:
    include_once("other_inc/footer.php");
    die("");
    }

$r = mysql_query("SELECT * FROM `clans` WHERE id='".$clanID."'");
$a = mysql_fetch_array($r);
if ($a==false){
   printrus("Такого клана не существует! Обратитесь к разработчику<br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
exit;
   }
if ($a['founder']!=$_SESSION['userID']){
   printrus("Вы не являетесь основателем клана!<br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
exit;
   }

if (!isset($go)){

if ($m=='add'){
printrus("Cтрана:<br/>\n");
printrus ("<form name=\"\" action=\"addclan.php?$ses&amp;m=found&amp;go=1&amp;m=$m\" method=\"post\">
<input name=\"name\" maxlength=\"30\" title=\"Text\" value=\"\"/>
<br/><input name=\"t1\" type=\"checkbox\" value=\"1\"/>Транслитеровать\n<br/>\n");

printrus
("<input type=\"submit\" value=\"Призвать в клан\"/>
</form><br/>
");

   }elseif($m=='del'){

   printrus("Cтрана:<br/>\n");
printrus ("<form name=\"\" action=\"addclan.php?$ses&amp;m=found&amp;go=1&amp;m=$m\" method=\"post\">
<input name=\"name\" maxlength=\"30\" title=\"Text\" value=\"\"/>
<br/><input name=\"t1\" type=\"checkbox\" value=\"1\"/>Транслитеровать\n<br/>\n");

printrus
("<input type=\"submit\" value=\"Выгнать из клана\"/>
</form><br/>
");

   }

   }else{
   if ($t1=='1') $name = translit($name);
   $name = iconv('utf-8','cp1251',$name);
   $r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
   if (mysql_num_rows($r)==0){
      printrus("Такой страны нет на карте мира!<br/>\n");
      }else{
      $c=mysql_fetch_array($r);
      $ncid = $c['countryID'];
      if ($ncid==$countryID){
      printrus("Вы не можете выгнать или призвать себя в клан!<br/>\n");
      }elseif ($m=='add'){
      $z = mysql_query("SELECT count(*) as num FROM `uzers` WHERE clanID='".$clanID."'");
      $s = mysql_fetch_array($z);
      if ($s['num']<12){
      printrus("Предложение о вступлении в клан отправлено стране $name<br/>\n");
      sendMessage($ncid,'offerClan',$clanID);//Отправляем предложение о вступлении в клан
      }else{
      printrus("В клане не может быть более 12-ти человек!<br/>\n");
      }

      }else{
      $r2 = mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$ncid' LIMIT 1");
      $a2 = mysql_fetch_array($r2);
      if ($a2['clanID']!=$clanID){
      printrus("Эта страна не состоит в вашем клане!<br/>");
      }else{
      printrus("Вы выгнали из клана страну $name!<br/>\n");
      mysql_query("UPDATE `uzers` SET clanID=0 WHERE countryID='$ncid' LIMIT 1");
      sendMessage($ncid,'fullMessage',"Вас выгнали из <u>".$a['name']."</u>!");
      $key=_PREFIKS.':clans'.$ncid;
      if (($mem=$memcache->get($key))!==FALSE){
         $mem=0;
         $memcache->set($key,$mem,false,86400);
         }
      /*
      //Снимаем войска страны с осады/защиты замка, если есть:
      $r = mysql_query("SELECT * FROM `zamok_defence` WHERE countryID = '$ncid'");
      $wrs = $wrs_2 = $wrs_3 = $wrs_4 = $wrs_5 = $wrs_6 = $wrs_7 = $wrs_8 = 0;
      while (($a=mysql_fetch_array($r))!==FALSE){
      $wrs += $a['wariors'];
      $wrs_2 += $a['wariors_2'];
      $wrs_3 += $a['wariors_3'];
      $wrs_4 += $a['wariors_4'];
      $wrs_5 += $a['wariors_5'];
      $wrs_6 += $a['wariors_6'];
      $wrs_7 += $a['wariors_7'];
      $wrs_8 += $a['wariors_8'];
      }
      mysql_query("DELETE FROM `zamok_defence` WHERE countryID = '$ncid'");
      if ($wrs+$wrs_2+$wrs_3+$wrs_4+$wrs_5+$wrs_6+$wrs_7+$wrs_8>0){
      mysql_query("UPDATE `countries` SET wariors_free = wariors_free + $wrs, wariors_free_2 = wariors_free_2 + $wrs_2,
      wariors_free_3 = wariors_free_3 + $wrs_3, wariors_free_4 = wariors_free_4 + $wrs_4,
      wariors_free_5 = wariors_free_5 + $wrs_5, wariors_free_6 = wariors_free_6 + $wrs_6,
      wariors_free_7 = wariors_free_7 + $wrs_7, wariors_free_8 = wariors_free_8 + $wrs_8
      WHERE countryID = '$countryID' LIMIT 1");
      $b['wariors_free'] = $b['wariors_free'] + $wrs;
      $b['wariors_free_2'] = $b['wariors_free_2'] + $wrs_2;
      $b['wariors_free_3'] = $b['wariors_free_3'] + $wrs_3;
      $b['wariors_free_4'] = $b['wariors_free_4'] + $wrs_4;
      $b['wariors_free_5'] = $b['wariors_free_5'] + $wrs_5;
      $b['wariors_free_6'] = $b['wariors_free_6'] + $wrs_6;
      $b['wariors_free_7'] = $b['wariors_free_7'] + $wrs_7;
      $b['wariors_free_8'] = $b['wariors_free_8'] + $wrs_8;
      if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
      }
      //Снимаем войска страны с атаки замка, если есть:
      $r = mysql_query("SELECT * FROM `zamok_attack` WHERE countryID = '$ncid'");
      $wrs = $wrs_2 = $wrs_3 = $wrs_4 = $wrs_5 = $wrs_6 = $wrs_7 = $wrs_8 = 0;
      while (($a=mysql_fetch_array($r))!==FALSE){
      $wrs += $a['wariors'];
      $wrs_2 += $a['wariors_2'];
      $wrs_3 += $a['wariors_3'];
      $wrs_4 += $a['wariors_4'];
      $wrs_5 += $a['wariors_5'];
      $wrs_6 += $a['wariors_6'];
      $wrs_7 += $a['wariors_7'];
      $wrs_8 += $a['wariors_8'];
      }
      mysql_query("DELETE FROM `zamok_attack` WHERE countryID = '$ncid'");
      if ($wrs+$wrs_2+$wrs_3+$wrs_4+$wrs_5+$wrs_6+$wrs_7+$wrs_8>0){
      mysql_query("UPDATE `countries` SET wariors_free = wariors_free + $wrs, wariors_free_2 = wariors_free_2 + $wrs_2,
      wariors_free_3 = wariors_free_3 + $wrs_3, wariors_free_4 = wariors_free_4 + $wrs_4,
      wariors_free_5 = wariors_free_5 + $wrs_5, wariors_free_6 = wariors_free_6 + $wrs_6,
      wariors_free_7 = wariors_free_7 + $wrs_7, wariors_free_8 = wariors_free_8 + $wrs_8
      WHERE countryID = '$countryID' LIMIT 1");
      $b['wariors_free'] = $b['wariors_free'] + $wrs;
      $b['wariors_free_2'] = $b['wariors_free_2'] + $wrs_2;
      $b['wariors_free_3'] = $b['wariors_free_3'] + $wrs_3;
      $b['wariors_free_4'] = $b['wariors_free_4'] + $wrs_4;
      $b['wariors_free_5'] = $b['wariors_free_5'] + $wrs_5;
      $b['wariors_free_6'] = $b['wariors_free_6'] + $wrs_6;
      $b['wariors_free_7'] = $b['wariors_free_7'] + $wrs_7;
      $b['wariors_free_8'] = $b['wariors_free_8'] + $wrs_8;
      if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
      }
       */
      }

      }

      }

   }

//printrus ("<a href='game.php?$ses'>&lt;В игру</a><br/>\n");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");

//футер страницы:
include_once("other_inc/footer.php");
?>
