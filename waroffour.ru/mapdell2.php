<?
ini_set("max_execution_time", "6000");
set_time_limit(0);
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
$countryID=$_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================



$query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num = $a['num'];
printrus('Всего стран: '.$a['num'].'<br />');

/*$query="SELECT count(*) as num FROM `countries` where (countryName RLIKE '^Пустынные территории [a-z?][0-9+]' and countryName!='Пустынные территории E1' and countryName NOT RLIKE '^Пустынные территории [ad]') or (countryName RLIKE '^[a-z?][0-9+]' and countryName!='E1' and countryName NOT RLIKE '^[ad]')";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num = $a['num'];
printrus('Всего клонов: '.$a['num'].'<br />');*/
//$query2="SELECT countryName,countryID FROM `countries` where (countryName RLIKE '^Пустынные территории [a-z?][0-9+]' and countryName!='Пустынные территории E1' and countryName NOT RLIKE '^Пустынные территории [ad]') or (countryName RLIKE '^[a-z?][0-9+]' and countryName!='E1' and countryName NOT RLIKE '^[ad]')";
$query2="SELECT countries.countryName,countries.countryID FROM `countries`
LEFT JOIN `wars` ON wars.targetID = countries.countryID
LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose'
where wars.targetID is null  and messages.countryID IS NULL and (
(countries.countryName RLIKE '^Пустынные территории [a-z?][0-9+]' and
countries.countryName!='Пустынные территории E1' and
countries.countryName NOT RLIKE '^Пустынные территории [ad]')
or (countries.countryName RLIKE '^[a-z?][0-9+]' and
countries.countryName!='E1' and countries.countryName NOT RLIKE '^[ad]')) limit 200";
$hd=0;
//echo'array(';
/*$r2 = mysql_query($query2);
 while (($a2=mysql_fetch_array($r2))!==FALSE){



 $hd++;


     //printrus("'".$a2[1]."',<br />");
     //looser($a2[1]);
     //usleep(5000);
 }
    */

 //echo");";
//printrus('Удаляется клонов по :'.$hd.'<br />');




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
