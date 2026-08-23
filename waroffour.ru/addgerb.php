<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_FILES['file'])&& is_uploaded_file($_FILES['file']['tmp_name'])) $filename = $_FILES['file']['tmp_name'];

if (isset($go)){
$error='noerror';
   if(!isset($filename)) $error = 'nofile';
 else{
$size = filesize($filename);
$par = GetImageSize($filename);
if($par[2]!==1&&$par[2]!==2) $error='wrongformat';
 elseif($size>40000) $error = 'tooheavy';
 elseif(($par[0]>100)||($par[1]>100)) $error = 'toolarge';
 }

   }
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
include_once("other_inc/header.php");
/*
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
echo '<head>';
printrus ("<title>Цивилизация. Выбор герба</title>\n");
echo "<style TYPE=\"text/css\">\n";
echo "body{text-align: center; font-family: arial; font-size: 12pt;}\n";
echo "</style>\n";
echo "</head>\n";
echo "<body bgcolor=\"#F7EDCE\">\n";
 */
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

 printrus ("<a href='index.php'>&lt;&lt;Выход</a><br/>\r\n");
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
    printrus ("Вы не состоите ни в каком клане!<br/>\n");
    include_once("other_inc/footer.php");
    die("");
    }

$r = mysql_query("SELECT * FROM `clans` WHERE id='".$clanID."'");
$a = mysql_fetch_array($r);
if ($a==false){
   printrus ("Такого клана не существует! Обратитесь к разработчику<br/>\n");
   include_once("other_inc/footer.php");
exit;
   }
if ($a['founder']!=$_SESSION['userID']){
   printrus ("Вы не являетесь основателем клана!<br/>\n");
include_once("other_inc/footer.php");
exit;
   }


if (!isset($go)){
printrus ("Выберите логотип для вашего клана:<br/>\n");
printrus ("Логотип должен быть размерами не более 100х100 пикселов, весом не более 40кб, формата gif или jpeg<br/>\n");
printrus ("Если у Вашего клана уже есть логотип, он заменяется на новый автоматически<br/>\n");
printrus ("<b>Лого:</b><br/>\n");
printrus ("<form enctype=\"multipart/form-data\" action=\"addgerb.php?$ses\" method=\"post\">\n");
printrus ("<input name=\"file\" type=\"file\" size=\"20\"/><br/>\n");
printrus ("<input name=\"go\" type=\"hidden\" value=\"1\"/>\n");
printrus ("<input type=\"submit\" name=\"go\" value=\"Отправить\"/>\n");
echo "</form>\n";
}else{
if ($error=='noerror'){
if (file_exists("clans/".$clanID."gif")) unlink("clans/".$clanID."gif");
if (file_exists("clans/".$clanID."jpg")) unlink("clans/".$clanID."jpg");
if ($par[2]===1)$ext=".gif"; else $ext=".jpg";
move_uploaded_file($filename,"clans/$clanID".$ext);
printrus ("Логотип изменен!<br/>\n");
}else{
if ($error=='nofile')printrus ("Не задан файл!<br/>\n");
if ($error=='wrongformat')printrus ("Выберите формат gif или jpeg!<br/>\n");
if ($error=='tooheavy')printrus ("Логотип слишком тяжелый! Максимум 5кб<br/>\n");
if ($error=='toolarge')printrus ("Логотип слишком большой! Максимальный размер 60х60 пикселов<br/>\n");
}

}

printrus ("<a href='game.php?$ses'>&lt;В игру</a><br/>\n");
printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");

include_once("other_inc/footer.php");
?>
