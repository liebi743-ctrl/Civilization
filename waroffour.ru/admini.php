<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
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

 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
$older = array(48,665,963,877,745,1884,2440,3726,1);

 printrus ("<b>Модераторы</b> | <img src=\"/img/ico/onl.png\" alt=\".\" /> <a href=\"online.php?str&amp;$ses\">Онлайн</a><br/>\r\n");
 $a=mysql_query("SELECT * FROM uzers WHERE inv>='2'");
 if(mysql_num_rows($a)>0)
 while( $y = mysql_fetch_array($a)){
 	#if (in_array($y['userID'],$older))$level=1;
#else $level=0;
 $nameModers=mysql_fetch_array(mysql_query("SELECT * FROM countries WHERE countryID='$y[1]'"));
 #if($level==1)
 #$bolt='<img src="medal.gif" alt="logo"/>'; else $bolt='';
 if (!in_array($y['userID'],$older)){
 if($nameModers[1]<>''){
 printrus ("<img src=\"znc/124.gif\" alt=\"\" /> $nameModers[1]");
 if (time()<$y['onlineflag'])printrus(" [onl]<br/>\r\n");
                 else printrus(" [off](".mkTimeStr(time()-$y['onlineflag']).")<br/>\r\n");
  }
  }
 }

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
