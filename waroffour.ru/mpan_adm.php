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
 <do type=\"options\" name=\"mpan_admchat\" label=\"Чат модеров\"><go href=\"mpan_admchat.php?$ses\"/></do>
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

$older4 = array(1,877);//админы
$older = array();//старшие модеры
//$older2=array(179,1093,978,2588,3987,6613,12133,13565);//среднии модеры
$older2=array();//среднии модеры

if (in_array($_SESSION['userID'],$older))$level=1;
else $level=0;
if (in_array($_SESSION['userID'],$older2))$level=2;
else $level=$level;
if (in_array($_SESSION['userID'],$older4))$level=8;
else $level=$level;

$mip = getenv("REMOTE_ADDR");
$msoft = getenv("HTTP_USER_AGENT");
@$open=fopen("mod/mpan_adm.dat","a+");
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
        printrus ("<a href='mpan_adm.php?$ses'>&lt;назад</a><br/>\r\n");
        include_once("other_inc/footer.php");
        die();


	}



}


if (!isset($go)){
printrus
("<a href=\"mpan_admchat.php?$ses\">
Модерский чат</a>
<br/>
");
$e=rand(1111,9999);
$ASS = iconv('utf-8','cp1251',$_REQUEST['name']);
$REQUESTID = iconv('utf-8','cp1251',$_REQUEST[cid]);
printrus("Cтрана:<br/>\n");  //".$_REQUEST['name']."
printrus ("<form name=\"\" action=\"mpan_adm.php?go&amp;$ses\" method=\"post\">
<input name=\"name\" maxlength=\"50\" title=\"Text\" value=\"".($ASS)."\"/><br />

<br/>\n");
unset($_POST['nick']);


    //кнопки модерок
  if ($level==8){


  printrus("<input type=\"submit\" name=\"narisovat\" value=\"Нарисовать\"/><br/>");

  printrus("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/><br/>");

  printrus("*****<br/>");
  }
















}elseif(($_REQUEST['sjech'] or $go == 'sjech') and ($level == 8 or $level == 1)){
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
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
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


	printrus ("<option value=\"11\">Золото</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/>
    </form><br/>
");
    }

     if(!isset($_REQUEST['do'])){
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");
	if($level == 8)printrus ("<option value=\"12\">Войско_Пехи</option>\n");
	if($level == 8)printrus ("<option value=\"13\">Войско_Кони</option>\n");
	if($level == 8)printrus ("<option value=\"14\">Войско_Стрелки</option>\n");
	if($level == 8)printrus ("<option value=\"15\">Войско_Пушки</option>\n");
	if($level == 8)printrus ("<option value=\"16\">Войско_Подрывыв</option>\n");
	if($level == 8)printrus ("<option value=\"17\">Войско_Самы</option>\n");
	if($level == 8)printrus ("<option value=\"18\">Войско_Маги</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/>
    </form><br/>
");
printrus ("<a href=\"mpan_adm.php\"><font color=#00e600>RS</font></a><br/>\n");
    }


     if(!isset($_REQUEST['do'])){
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");
	if($level == 8)printrus ("<option value=\"19\">Шпионаж</option>\n");
	if($level == 8)printrus ("<option value=\"10\">Вор</option>\n");
	if($level == 8)printrus ("<option value=\"20\">Вербовка</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"sjech\" value=\"Сжечь\"/>
    </form><br/>
");
    }


    else{
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
    case 12:
    $l='Войск_Пехов';
    $l2='wariors_free';
    break;
    case 13:
    $l='Войск_Коней';
    $l2='wariors_free_2';
    break;
    case 14:
    $l='Войск_Стрелков';
    $l2='wariors_free_3';
    break;
    case 15:
    $l='Войск_Пушек';
    $l2='wariors_free_4';
    break;
    case 16:
    $l='Войск_Подрывников';
    $l2='wariors_free_5';
    break;
    case 17:
    $l='Войск_Самов';
    $l2='wariors_free_6';
    break;
    case 18:
    $l='Войск_Магов';
    $l2='wariors_free_7';
    break;
    case 11:
    $l='золота';
    $l2='credits';
    break;
    case 19:
    $l='шпион';
    $l2='spy';
    break;
    case 10:
    $l='вор';
    $l2='grabber';
    break;
    case 20:
    $l='вербовка';
    $l2='verb';
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

   }
   }
   }

}




//---------
elseif(($_REQUEST['narisovat'] or $go == 'narisovat') and ($level == 8 or $level == 1)){
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
    if(!isset($_REQUEST['do'])){    	printrus("Выдать ресурсы:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");
    if($level == 8)printrus ("<option value=\"0\">Золото</option>\n");
    if($level == 8)printrus ("<option value=\"11\">Горы</option>\n");
    if($level == 8)printrus ("<option value=\"1\">Деньги</option>\n");
    if($level == 8)printrus ("<option value=\"2\">Железо</option>\n");
    if($level == 8)printrus ("<option value=\"3\">Камень</option>\n");
    if($level == 8)printrus ("<option value=\"4\">Нефть</option>\n");
    if($level == 8)printrus ("<option value=\"5\">Зерно</option>\n");
	if($level == 8)printrus ("<option value=\"6\">Дерево</option>\n");
	if($level == 8)printrus ("<option value=\"7\">Рабочии</option>\n");
	if($level == 8)printrus ("<option value=\"8\">Ученые</option>\n");



    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"нарисовать\"/>
    </form><br/>
");
    }


     if(!isset($_REQUEST['do'])){     	printrus("Выдать войско:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");

	if($level == 8)printrus ("<option value=\"12\">Войско_Пехи</option>\n");
	if($level == 8)printrus ("<option value=\"13\">Войско_Кони</option>\n");
	if($level == 8)printrus ("<option value=\"14\">Войско_Стрелки</option>\n");
	if($level == 8)printrus ("<option value=\"15\">Войско_Пушки</option>\n");
	if($level == 8)printrus ("<option value=\"16\">Войско_Подрывыв</option>\n");
	if($level == 8)printrus ("<option value=\"17\">Войско_Самы</option>\n");
	if($level == 8)printrus ("<option value=\"18\">Войско_Маги</option>\n");


    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"нарисовать\"/>
    </form><br/>
");
    }

if(!isset($_REQUEST['do'])){	printrus("Выдать войскам пораметры Скорость:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");


if($level == 8)printrus ("<option value=\"48\">Скорость_Пехоты</option>\n");
	if($level == 8)printrus ("<option value=\"49\">Скорость_Коней</option>\n");
	if($level == 8)printrus ("<option value=\"50\">Скорость_Стрелков</option>\n");
	if($level == 8)printrus ("<option value=\"51\">Скорость_Пушек</option>\n");
	if($level == 8)printrus ("<option value=\"52\">Скорость_Подрывнеков</option>\n");
	if($level == 8)printrus ("<option value=\"53\">Скорость_Самалетов</option>\n");
	if($level == 8)printrus ("<option value=\"54\">Скорость_Магов</option>\n");



    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"нарисовать\"/>
    </form><br/>
");
    }

     if(!isset($_REQUEST['do'])){     	printrus("Выдать войскам пораметры Силу:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");


if($level == 8)printrus ("<option value=\"55\">Силу_Пехоты</option>\n");
	if($level == 8)printrus ("<option value=\"56\">Силу_Коней</option>\n");
	if($level == 8)printrus ("<option value=\"57\">Силу_Стрелков</option>\n");
	if($level == 8)printrus ("<option value=\"58\">Силу_Пушек</option>\n");
	if($level == 8)printrus ("<option value=\"59\">Силу_Подрывнеков</option>\n");
	if($level == 8)printrus ("<option value=\"60\">Силу_Самалетов</option>\n");
	if($level == 8)printrus ("<option value=\"61\">Силу_Магов</option>\n");



    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"нарисовать\"/>
    </form><br/>
");
    }

    if(!isset($_REQUEST['do'])){    	printrus("Выдать параметры Цитадели:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");


	if($level == 8)printrus ("<option value=\"19\">Шпионаж</option>\n");
	if($level == 8)printrus ("<option value=\"10\">Вор</option>\n");
	if($level == 8)printrus ("<option value=\"20\">Вербовка</option>\n");


    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"нарисовать\"/>
    </form><br/>
");
    }


//Сдесь пишем систему рисования генирала и пораметроы войск!


    if(!isset($_REQUEST['do'])){    	printrus("Выдать параметры Генирала:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");


	if($level == 8)printrus ("<option value=\"45\">Мораль</option>\n");
	if($level == 8)printrus ("<option value=\"46\">Навык</option>\n");
	if($level == 8)printrus ("<option value=\"47\">Опыт</option>\n");


    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"нарисовать\"/>
    </form><br/>
");
    }




   //Сдесь пишем систему сжиганий!
    if(!isset($_REQUEST['do'])){
    printrus("Сжечь Ресурсы:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");
       if($level == 8)printrus ("<option value=\"24\">Горы</option>\n");
    if($level == 8)printrus ("<option value=\"25\">Деньги</option>\n");
    if($level == 8)printrus ("<option value=\"26\">Железо</option>\n");
    if($level == 8)printrus ("<option value=\"27\">Камень</option>\n");
    if($level == 8)printrus ("<option value=\"28\">Нефть</option>\n");
    if($level == 8)printrus ("<option value=\"29\">Зерно</option>\n");
	if($level == 8)printrus ("<option value=\"30\">Дерево</option>\n");
	if($level == 8)printrus ("<option value=\"31\">Рабочии</option>\n");
	if($level == 8)printrus ("<option value=\"32\">Ученые</option>\n");
	if($level == 8)printrus ("<option value=\"33\">наука камень</option>\n");

	printrus ("<option value=\"41\">Золото</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"Сжечь\"/>
    </form><br/>
");
    }

     if(!isset($_REQUEST['do'])){     	printrus("Сжечь Войска :<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");
	if($level == 8)printrus ("<option value=\"34\">Войско_Пехи</option>\n");
	if($level == 8)printrus ("<option value=\"35\">Войско_Кони</option>\n");
	if($level == 8)printrus ("<option value=\"36\">Войско_Стрелки</option>\n");
	if($level == 8)printrus ("<option value=\"37\">Войско_Пушки</option>\n");
	if($level == 8)printrus ("<option value=\"38\">Войско_Подрывыв</option>\n");
	if($level == 8)printrus ("<option value=\"39\">Войско_Самы</option>\n");
	if($level == 8)printrus ("<option value=\"40\">Войско_Маги</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"Сжечь\"/>
    </form><br/>
");
    }

 if(!isset($_REQUEST['do'])){
	printrus("Сжечь войскам пораметры Скорость:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");


if($level == 8)printrus ("<option value=\"65\">Скорость_Пехоты</option>\n");
	if($level == 8)printrus ("<option value=\"66\">Скорость_Коней</option>\n");
	if($level == 8)printrus ("<option value=\"67\">Скорость_Стрелков</option>\n");
	if($level == 8)printrus ("<option value=\"68\">Скорость_Пушек</option>\n");
	if($level == 8)printrus ("<option value=\"69\">Скорость_Подрывнеков</option>\n");
	if($level == 8)printrus ("<option value=\"70\">Скорость_Самалетов</option>\n");
	if($level == 8)printrus ("<option value=\"71\">Скорость_Магов</option>\n");



    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"Сжечь\"/>
    </form><br/>
");
    }

     if(!isset($_REQUEST['do'])){
     	printrus("Сжечь войскам пораметры Силу:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");


if($level == 8)printrus ("<option value=\"72\">Силу_Пехоты</option>\n");
	if($level == 8)printrus ("<option value=\"73\">Силу_Коней</option>\n");
	if($level == 8)printrus ("<option value=\"74\">Силу_Стрелков</option>\n");
	if($level == 8)printrus ("<option value=\"75\">Силу_Пушек</option>\n");
	if($level == 8)printrus ("<option value=\"76\">Силу_Подрывнеков</option>\n");
	if($level == 8)printrus ("<option value=\"77\">Силу_Самалетов</option>\n");
	if($level == 8)printrus ("<option value=\"78\">Силу_Магов</option>\n");



    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"Сжечь\"/>
    </form><br/>
");
    }

     if(!isset($_REQUEST['do'])){
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");
	if($level == 8)printrus ("<option value=\"42\">Шпионаж</option>\n");
	if($level == 8)printrus ("<option value=\"43\">Вор</option>\n");
	if($level == 8)printrus ("<option value=\"44\">Вербовка</option>\n");
    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"Сжечь\"/>
    </form><br/>
");
    }

   if(!isset($_REQUEST['do'])){
    	printrus("Сжечь параметры Генирала:<br/>\n");
    printrus ("<form name=\"\" action=\"mpan_adm.php?do&amp;$ses&amp;go&amp;cid=$cid\" method=\"post\">
<input name=\"cnt\" maxlength=\"50\" title=\"Text\" value=\"\"/>
    <br/>\n");

    printrus ("<select name=\"l\">\n");


	if($level == 8)printrus ("<option value=\"62\">Мораль</option>\n");
	if($level == 8)printrus ("<option value=\"63\">Навык</option>\n");
	if($level == 8)printrus ("<option value=\"64\">Опыт</option>\n");


    printrus ("</select><br/>\n");
    printrus
    ("<input type=\"submit\" name=\"narisovat\" value=\"Сжечь\"/>
    </form><br/>
");
    }





    else{
    $cnt=htmlspecialchars($_REQUEST['cnt']);
    $why=htmlspecialchars($_REQUEST['why']);
    $l=htmlspecialchars($_REQUEST['l']);
    $why=iconv('utf-8','cp1251',$why);
    switch($l):
    case 11:
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
    case 12:
    $l='Войск_Пехов';
    $l2='wariors_free';
    break;
    case 13:
    $l='Войск_Коней';
    $l2='wariors_free_2';
    break;
    case 14:
    $l='Войск_Стрелков';
    $l2='wariors_free_3';
    break;
    case 15:
    $l='Войск_Пушек';
    $l2='wariors_free_4';
    break;
    case 16:
    $l='Войск_Подрывников';
    $l2='wariors_free_5';
    break;
    case 17:
    $l='Войск_Самов';
    $l2='wariors_free_6';
    break;
    case 18:
    $l='Войск_Магов';
    $l2='wariors_free_7';
    break;
    case 0:
    $l='золота';
    $l2='credits';
    break;
    case 19:
    $l='шпион';
    $l2='spy';
    break;
    case 10:
    $l='вор';
    $l2='grabber';
    break;
    case 20:
    $l='вербовка';
    $l2='verb';
    break;


    // рисование пораметров войск и генирала

    case 45:
    $l='Мораль';
    $l4='moral';
    break;
    case 46:
    $l='Навык';
    $l4='study';
    break;
    case 47:
    $l='Опыт';
    $l4='expiriense';
    break;
    case 48:
    $l='Скорость_Пехов';
    $l4='weapon_speed';
    break;
    case 49:
    $l='Скорость_Коней';
    $l4='weapon_speed_2';
    break;
    case 50:
    $l='Скорость_Стрелков';
    $l4='weapon_speed_3';
    break;
    case 51:
    $l='Скорость_Пушек';
    $l4='weapon_speed_4';
    break;
    case 52:
    $l='Скорость_Подрывников';
    $l4='weapon_speed_5';
    break;
    case 53:
    $l='Скорость_Самов';
    $l4='weapon_speed_6';
    break;
    case 54:
    $l='Скорость_Магов';
    $l4='weapon_speed_7';
    break;
    case 55:
    $l='Силу_Пехов';
    $l4='weapon_force';
    break;
    case 56:
    $l='Силу_Коней';
    $l4='weapon_force_2';
    break;
    case 57:
    $l='Силу_Стрелков';
    $l4='weapon_force_3';
    break;
    case 58:
    $l='Силу_Пушек';
    $l4='weapon_force_4';
    break;
    case 59:
    $l='Силу_Подрывников';
    $l4='weapon_force_5';
    break;
    case 60:
    $l='Силу_Самов';
    $l4='weapon_force_6';
    break;
    case 61:
    $l='Силу_Магов';
    $l4='weapon_force_7';
    break;

    //сжигание
      case 24:
    $l='гор';
    $l3='mountains';
    break;
    case 25:
    $l='денег';
    $l3='money';
    break;
    case 26:
    $l='железа';
    $l3='iron';
    break;
    case 27:
    $l='камня';
    $l3='stone';
    break;
    case 28:
    $l='нефти';
    $l2='oil';
    break;
    case 29:
    $l='зерна';
    $l3='grain';
    break;
	case 30:
    $l='дерево';
    $l3='arbor';
    break;
	case 31:
    $l='рабочии';
    $l3='workers';
    break;
	case 32:
    $l='ученые';
    $l3='scientists';
    break;
	case 33:
    $l='наука камень';
    $l3='stone_making';
    break;
    case 34:
    $l='Войск_Пехов';
    $l3='wariors_free';
    break;
    case 35:
    $l='Войск_Коней';
    $l3='wariors_free_2';
    break;
    case 36:
    $l='Войск_Стрелков';
    $l3='wariors_free_3';
    break;
    case 37:
    $l='Войск_Пушек';
    $l3='wariors_free_4';
    break;
    case 38:
    $l='Войск_Подрывников';
    $l3='wariors_free_5';
    break;
    case 39:
    $l='Войск_Самов';
    $l3='wariors_free_6';
    break;
    case 40:
    $l='Войск_Магов';
    $l3='wariors_free_7';
    break;
    case 41:
    $l='золота';
    $l3='credits';
    break;
    case 42:
    $l='шпион';
    $l3='spy';
    break;
    case 43:
    $l='вор';
    $l3='grabber';
    break;
    case 44:
    $l='вербовка';
    $l3='verb';
    break;

    case 62:
    $l='Мораль';
    $l5='moral';
    break;
    case 63:
    $l='Навык';
    $l5='study';
    break;
    case 64:
    $l='Опыт';
    $l5='expiriense';
    break;
    case 65:
    $l='Скорость_Пехов';
    $l5='weapon_speed';
    break;
    case 66:
    $l='Скорость_Коней';
    $l5='weapon_speed_2';
    break;
    case 67:
    $l='Скорость_Стрелков';
    $l5='weapon_speed_3';
    break;
    case 68:
    $l='Скорость_Пушек';
    $l5='weapon_speed_4';
    break;
    case 69:
    $l='Скорость_Подрывников';
    $l5='weapon_speed_5';
    break;
    case 70:
    $l='Скорость_Самов';
    $l5='weapon_speed_6';
    break;
    case 71:
    $l='Скорость_Магов';
    $l5='weapon_speed_7';
    break;
    case 72:
    $l='Силу_Пехов';
    $l5='weapon_force';
    break;
    case 73:
    $l='Силу_Коней';
    $l5='weapon_force_2';
    break;
    case 74:
    $l='Силу_Стрелков';
    $l5='weapon_force_3';
    break;
    case 75:
    $l='Силу_Пушек';
    $l5='weapon_force_4';
    break;
    case 76:
    $l='Силу_Подрывников';
    $l5='weapon_force_5';
    break;
    case 77:
    $l='Силу_Самов';
    $l5='weapon_force_6';
    break;
    case 78:
    $l='Силу_Магов';
    $l5='weapon_force_7';
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

     if($l3 == 'credits')
     {
     mysql_query("UPDATE uzers SET credits = credits - $cnt WHERE countryID = '".$cid."'");
     }
     {
     mysql_query("UPDATE countries SET $l3 = $l3 - $cnt WHERE countryID = '".$cid."'");
     }

    if($l4 == 'credits')
     {
     mysql_query("UPDATE uzers SET credits = credits + $cnt WHERE countryID = '".$cid."'");
     }
     else
     {
     mysql_query("UPDATE countries SET $l4 = $l4 + $cnt WHERE countryID = '".$cid."'");
     }

       {
     mysql_query("UPDATE countries SET $l5 = $l5 - $cnt WHERE countryID = '".$cid."'");
     }
        if($l4 == 'moral')
     {
     mysql_query("UPDATE general SET moral = moral + $cnt WHERE countryID = '".$cid."'");
     }
      if($l4 == 'expiriense')
     {
     mysql_query("UPDATE general SET expiriense = expiriense + $cnt WHERE countryID = '".$cid."'");
     }
      if($l4 == 'study')
     {
     mysql_query("UPDATE general SET study = study + $cnt WHERE countryID = '".$cid."'");
     }
     if($l5 == 'moral')
     {
     mysql_query("UPDATE general SET moral = moral - $cnt WHERE countryID = '".$cid."'");
     }
      if($l5 == 'expiriense')
     {
     mysql_query("UPDATE general SET expiriense = expiriense - $cnt WHERE countryID = '".$cid."'");
     }
      if($l5 == 'study')
     {
     mysql_query("UPDATE general SET study = study - $cnt WHERE countryID = '".$cid."'");
     }
   $e[$l2] = $e[$l2] - $cnt;
    $key=_PREFIKS.':id'.$cid;
        if(($mem=$memcache->get($key))!==FALSE){
        $mem[$l2]=$mem[$l2]+$cnt;
        $memcache->set($key,$mem,false,86400);
          }



   }
   }
   }

}
//------












echo "-------<br/>\n";
//printrus ("<a href=\"game.php?$ses\">В игру</a><br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
?>