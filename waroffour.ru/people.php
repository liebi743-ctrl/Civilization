<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];

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
//  printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Население</u>\r\n");

 if (!isset($m)){
 $people=countPeople($b['countryID']);
 printrus ("(<b>$people</b>)<br/>\r\n");
 $workers=$b['workers'];
 $scientists=$b['scientists'];
 $wariors_free=$b['wariors_free'];
 $wariors_free_2=$b['wariors_free_2'];
 $wariors_free_3=$b['wariors_free_3'];
 $wariors_free_4=$b['wariors_free_4'];
 $wariors_free_5=$b['wariors_free_5'];
 $wariors_free_6=$b['wariors_free_6'];
 $wariors_free_7=$b['wariors_free_7'];
 $wariors_free_8=$b['wariors_free_8'];
 printrus ("Свободные рабочие: <b>$workers</b> <img src=\"/img/ico/workers.png\"/><br/>\r\n");
 printrus ("Свободные ученые: <b>$scientists</b> <img src=\"/img/ico/scientists.png\"/><br/>\r\n");

 printrus ("<u>Свободные войска</u>:<br/>\r\n");

$wariors=array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8);
$str='';
for($i=0;$i<=7;$i++){
if ($wariors[$i]>0) $str .= '<a href="people.php?m=unit&amp;n='.$i.'&amp;'.$ses.'">'.get_unit_name($i).'</a>: <b>'.$wariors[$i].'</b>,<br/>';
}
printrus($str);

 $buildings = returnBuildings($countryID);
 $w_b=$w_b_2=$w_b_3=$w_b_4=$w_b_5=$w_b_6=$w_b_7=$w_b_8=0;
 for ($i=0;$i<count($buildings);$i++){
 $w_b += $buildings[$i]['guard'];
 $w_b_2 += $buildings[$i]['guard_2'];
 $w_b_3 += $buildings[$i]['guard_3'];
 $w_b_4 += $buildings[$i]['guard_4'];
 $w_b_5 += $buildings[$i]['guard_5'];
 $w_b_6 += $buildings[$i]['guard_6'];
 $w_b_7 += $buildings[$i]['guard_7'];
 $w_b_8 += $buildings[$i]['guard_8'];
 }
 printrus ("<u>Войска в охране зданий</u>:<br/>".print_voisko(array($w_b,$w_b_2,$w_b_3,$w_b_4,$w_b_5,$w_b_6,$w_b_7,$w_b_8))."\r\n");

 $atwork=0;
 $key = _PREFIKS.':works'.$countryID;
 if(($a=$memcache->get($key))!==FALSE){
         for ($i=0;$i<count($a);$i++) $atwork += $a[$i]['peopleatwork'];
         }else{
 $query="select sum(peopleatwork) as num from works where countryID='$countryID'";
 $r=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a=mysql_fetch_array($r);
 $atwork = $a['num'];
 }
 printrus ("<u>На работах и исследованиях</u>: <b>$atwork</b> рабочих и ученых<br/>\r\n");
 }else{
 if ($n!=1&&$n!=2&&$n!=3&&$n!=4&&$n!=5&&$n!=6&&$n!=7)$n=0;
 $text = file_get_contents("units/$n.txt");
 printrus("<br/><img src=\"units/$n.gif\" alt=\"$n\"/><br/>$text<br/>\r\n");
 require($_SERVER['DOCUMENT_ROOT'].'/units.php');
 printrus("Жизнь: ".$units[$n]['life'].'<br/>');
 printrus("Повреждения: ".$units[$n]['dmg'].'<br/>');
 printrus("Коэффициенты повреждения:<br/>");
 for($i=0;$i<8;$i++){
 printrus(get_unit_name_im($i).':'.$units[$n]['koef'][$i].'<br/>');
 }
 printrus("Стоимость: ".res_print($units[$n]['cost'][0],$units[$n]['cost'][2],$units[$n]['cost'][1],$units[$n]['cost'][3],$units[$n]['cost'][4],$units[$n]['cost'][5]).'<br/>');

 printrus
("
<a href='people.php?$ses'>Ок</a>
<br/>
");
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