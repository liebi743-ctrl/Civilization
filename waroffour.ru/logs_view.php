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
    printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
}else{
    printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

    printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
    //футер страницы:
    include_once("other_inc/footer.php");

    die("");
}


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

//Запрет доступа к скрипту
/*
if ($b[1] != 'glokt' AND $b[1] != 'SoulGame'){
    printrus ("<b>!</b>Эта часть игры находится в разработке, зайдите позже.<b>!</b><br/>\r\n");

    printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
    //футер страницы:
    include_once("other_inc/footer.php");

    die("");
}


if($_GET['action'] == 'review'){
	 printrus ("<b>!</b>Отправка захвата на проверку находится в разработке, зайдите позже.<b>!</b><br/>\r\n");

    printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
    //футер страницы:
    include_once("other_inc/footer.php");

    die("");
}
*/

if($_GET['action'] == 'view') $log = viewlogs();
if($_GET['action'] == 'review') review($_GET['ID']);
if($_GET['action'] == 'countLogs7') print countLogs();


printrus ("<u>Мои захваты</u><br/>\r\n");
if($log){

    foreach($log as $row){
        printrus ("Захват ".$row['targetName'].$row['check']."<br><b>".$row['log']."</b></br>\r\n");
    }
} else {
    printrus("</b>У вас нет захватов<b>!</b><br/>\r\n");
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
