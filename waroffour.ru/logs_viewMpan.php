<?php
set_time_limit(0);
foreach($_REQUEST as $key => $var){
    $_REQUEST[$key]=trim(addslashes($_REQUEST[$key]));
}
//Обработка переменных:
if (isset($_REQUEST['name'])){
    $name = $_REQUEST['name'];
    $name = urldecode($name);

}



if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['purp'])) $purp = $_REQUEST['purp'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg))$pg=0;
if (!isset($pg) || $pg<0) $pg=0;
if (isset($_REQUEST['hours'])) $hours = $_REQUEST['hours'];
if (isset($hours)&&!is_numeric($hours))$hours=0;
if (!isset($hours) || $hours<0) $hours=0;
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
    $b['inv'] = whoareyou($countryID);
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


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
//printrus('Модеры ничего не трогаем! ещё в разработке) <br/><br/>');
$text = checked($_GET['IDlogs']);

if($text){
    foreach($text as $row){

        $checked = "<a style='color:#98FB98' href=logs_viewMpan.php?IDlogs=".$row['ID']."> Проверить</a>";
        printrus ("Бой: <b>"
            .$row['countryName']
            ."<a style='color:#FFD700' href=mpan.php?name=".$row['countryName'].">[S]</a>"
            ." </b>напал на <b>"
            .$row['targetName']
            ."<a style='color:#FFD700' href=mpan.php?name=".urlencode($row['targetName']).">[S]</a>"
            .$checked
            ."</b><br><b>"
            .$row['log']
            ."</b><br/>\r\n");
        //          echo urlencode($row['targetName']);
    }
} else {
    printrus("Логов нет<br/>");
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
