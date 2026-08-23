<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['text'])) $text = $_REQUEST['text'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];

function check($str){
$str=strtr($str,array(chr("0")=>"",chr("1")=>"",chr("2")=>"",chr("3")=>"",chr("4")=>"",chr("5")=>"",chr("6")=>"",chr("7")=>"",chr("8")=>"",chr("9")=>"",chr("10")=>"",chr("11")=>"",chr("12")=>"",chr("13")=>"",chr("14")=>"",chr("15")=>"",chr("16")=>"",chr("17")=>"",chr("18")=>"",chr("19")=>"",chr("20")=>"",chr("21")=>"",chr("22")=>"",chr("23")=>"",chr("24")=>"",chr("25")=>"",chr("26")=>"",chr("27")=>"",chr("28")=>"",chr("29")=>"",chr("30")=>"",chr("31")=>"","Р?"=>"И","вЂ¦"=>" ","вЂ©-"=>" ","вЂњ"=>" ","вЂќ"=>" ","вЂ©"=>" ","вЂ“"=>"-","\n"=>" ","$"=>"$$"));
$str = HtmlSpecialChars($str);
$str = ereg_replace(" +"," ",$str);
$str = trim($str);
return $str;
}

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
   printrus
("<a href=\"claninfo.php?$ses&amp;go=deviz\">Девиз</a><br/>
");
   printrus
("<a href=\"claninfo.php?$ses&amp;go=info\">Описание клана</a><br/>
");
   printrus
("
<a href='loadgerb.php?$ses'>Загрузить герб</a>(только для браузеров с поддержкой xhtml)<br/>
");

   }elseif($go=='deviz'){
   if (!isset($m)){
     printrus("Изменить девиз:<br/>\n");
     $deviz = iconv('cp1251','utf-8',$a['deviz']);
     echo "<form name=\"\" action=\"claninfo.php?$ses&amp;go=deviz&amp;m=change\" method=\"post\">
<input name=\"text\" maxlength=\"255\" title=\"Text\" value=\"$deviz\"/><br/>\n";
     printrus
("<input type=\"submit\" value=\"Изменить\"/>
</form><br/>
");
     }else{
     $newd = iconv('utf-8','cp1251',check($text));
     mysql_query("UPDATE `clans` SET deviz = '$newd' WHERE id = '".$clanID."'");
     echo mysql_error();
     printrus("Девиз изменен!<br/>\n");
     printrus ("<a href='clan.php?$ses'>Ок</a><br/>\n");
     }

   }elseif($go=='info'){
   if (!isset($m)){
     printrus("Изменить описание:<br/>\n");
     $info = iconv('cp1251','utf-8',$a['info']);
     echo "<form name=\"\" action=\"claninfo.php?$ses&amp;go=info&amp;m=change\" method=\"post\">
<input name=\"text\" maxlength=\"400\" title=\"Text\" value=\"$info\"/><br/>\n";
     printrus
("<input type=\"submit\" value=\"Изменить\"/>
</form><br/>
");
     }else{
     $newi = substr(iconv('utf-8','cp1251',check($text)),0,700);
     mysql_query("UPDATE `clans` SET info = '$newi' WHERE id = '".$clanID."'");
     echo mysql_error();
     printrus ("Описание изменено!<br/>\n");
     printrus ("<a href='clan.php?$ses'>Ок</a><br/>\n");
     }

   }

//printrus ("<a href='game.php?$ses'>&lt;В игру</a><br/>\n");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");

//футер страницы:
include_once("other_inc/footer.php");
?>
