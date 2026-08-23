<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['page_num'])) $page_num = $_REQUEST['page_num'];
if (isset($page_num) && !is_numeric($page_num)) $page_num=0;

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("../other_inc/header.php");
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
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<b>Почта</b><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='../unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("../other_inc/footer.php");

  die("");
 }

 $countryID = $_SESSION['countryID'];


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

 $key2=_PREFIKS.':messages'.$countryID;
 if (($mess=$memcache->get($key2))) $ms_m=TRUE; else $ms_m=FALSE;

 if ($ms_m==TRUE){
    $mesCount = count($mess);
    }else{
 $query="select count(*) as num from messages where countryID='".$countryID."'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $mesCount = $a['num'];
 }

 if(empty($page_num) || $page_num<0 || $page_num>$mesCount ||!is_numeric($page_num)){
  $page_num=0;
 }

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Проверяем наличие сообщений:::::::::::::::::::::::::::::::::::::::::::::::::::

 if($mesCount<=0){
  printrus ("<b>Сообщения:</b><br/>\r\n");
  printrus ("<b>Нет входящх сообщений!</b><br/>\r\n");
  print "---<br/>\r\n";
  printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//  printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");

  //футер страницы:
  include_once("../other_inc/footer.php");

  die("");
 }

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::   $mesCount
//Выводим сообщения:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 $MessagesOnPage=5;

 if ($ms_m==TRUE){
    for ($i=(count($mess)-$page_num-1);$i>=0&&$i>(count($mess)-($page_num+1+$MessagesOnPage));$i--) {
        // Теоретически теперь не должно выводиться пустые сообщения (if)
      //  if($mess[$i]['message'] != ""){
            printrus(mkTimeStr(time()-$mess[$i]['tm'])." назад: ");
            exec_message($countryID,$mess[$i],0,"..");
        //    }
        }
    }else{
 $result = mysql_query("SELECT * FROM messages where countryID='".$countryID."' LIMIT $page_num,$MessagesOnPage");
 printrus ("<b>Сообщения:</b><br/>\r\n");
 printrus ("Всего: <b>$mesCount</b><br/>\r\n");
 $mesCount--;

 $removed_messages=0;
 while (($a=mysql_fetch_array($result))!==FALSE){
         $removed_messages=$removed_messages+exec_message($countryID,$a,0,"..");
         }
 }


// print "".bar($mesCount+1,$page_num+1)."<br/>";
 $pages=round($mesCount/$MessagesOnPage+0.5);
 printrus ("Страниц: <b>$pages</b><br/>\r\n");

  if($page_num>0){
  print "
<a href=\"view.php?$ses&amp;page_num=".max(0,$page_num-$MessagesOnPage)."\">&lt;&lt;</a><br/>
";
 }

 if($page_num<=($mesCount-$MessagesOnPage)){
  print "<a href=\"view.php?$ses&amp;page_num=".($page_num+$MessagesOnPage-$removed_messages)."\">&gt;&gt;</a><br/>
";

 }


//=============================================================================//Конец скрипту================================================================print "<br/>::::::::::<br/>\r\n";
printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");
?>
