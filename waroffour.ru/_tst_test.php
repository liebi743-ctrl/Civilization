<?
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//worksRefresh($_SESSION['countryID']);

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
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }
$userID=41;
$countryID='7ef7715651dc41b61be6dea61a2994b047';
#$countryID2='superKlon';
$r=mysql_query("SELECT * FROM `countries` WHERE countryID = '".$countryID."' LIMIT 1");
$b=mysql_fetch_array($r);
//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
//Удаляем предыдущее сохранение
mysql_query("DELETE FROM `buildings_save` WHERE countryID = '".$countryID."'");

mysql_query("DELETE FROM `countries_save` WHERE countryID = '".$countryID."'");

mysql_query("DELETE FROM `general_save` WHERE countryID = '".$countryID."'");

mysql_query("DELETE FROM `works_save` WHERE countryID = '".$countryID."'");

//Сохраняем здания
mysql_query("INSERT INTO `buildings_save` (SELECT * FROM `buildings` WHERE countryID = '".$countryID."')");
//Меняем времена
mysql_query("UPDATE `buildings_save` SET var1 = ".time()." - var1 WHERE countryID = '".$countryID."' and building = 'neftevxwka' LIMIT 1");
//Сохраняем основные параметры страны:
mysql_query("INSERT INTO `countries_save` (SELECT * FROM `countries` WHERE countryID = '".$countryID."' LIMIT 1)");
//Меняем в сохранении необходимые времена
mysql_query("UPDATE `countries_save` SET reggedTime = ".(time()-$b['reggedTime']).", lastNal = ".(time()-$b['lastNal']).", lastWar = ".(time()-$b['lastWar'])." WHERE countryID = '".$countryID."' LIMIT 1");
//Сохраняем генерала
mysql_query("INSERT INTO `general_save` (SELECT * FROM `general` WHERE countryID = '".$countryID."' LIMIT 1)");
//Сохраняем работы
mysql_query("INSERT INTO `works_save` (SELECT * FROM `works` WHERE countryID = '".$countryID."')");
//Меняем времена
mysql_query("UPDATE `works_save` SET started = ".time()." - started, finished = finished - ".time()." WHERE countryID = '".$countryID."'");


mysql_query("INSERT INTO `saves` SET userID = '".$userID."', countryID = '$countryID', lastSave = '".time()."'");

//mysql_query("UPDATE `uzers` SET credits = credits - 50, spent = spent + 50 WHERE userID = '$userID' LIMIT 1");

printrus("Ваша страна успешно сохранена!<br/>");
//==============================================================================
//Конец скрипту=================================================================
print "---<br/>\r\n";
printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
?>
