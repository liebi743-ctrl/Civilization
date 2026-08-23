<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
include_once("other_inc/header.php");

$countryID = $_SESSION['countryID'];
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

if (!isset($go)){

printrus("Сейчас на карте мира:<br/>\n");
$r = mysql_query("SELECT count(*) as num FROM `wars`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> войн<br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `clans`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> <a href=\"stats.php?go=clans&amp;$ses\">кланов</a><br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `unite`");
$a = mysql_fetch_array($r);
printrus("<b>".round($a['num']/2)."</b> союзов<br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `buildings`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> зданий<br/>\n");
printrus("<a href=\"sites.php?$ses\">клан-сайты</a><br/>\n");
}elseif ($go=='clans'){
printrus("Кланы Войны Четырех:<br/>\n");
//$r = mysql_query("SELECT id,name FROM `clans` WHERE id > 0");
//$r = mysql_query("SELECT id,name FROM `clans`  WHERE id > 0 ORDER BY c_killed DESC LIMIT 30");
$r = mysql_query("SELECT id,name FROM `clans`  WHERE id > 0 ORDER BY c_killed DESC ");
while (($a=mysql_fetch_array($r))!==FALSE){
	$mainflag =0;
      $clanName = $a['name'];
      require_once('other_inc/klans.php');
if(in_array($a['id'],$klan))printrus($znak[$a['id']]);
	$qquery = mysql_query("SELECT `countryID` FROM `uzers` WHERE `clanID` = $a[id]");
	while($data11 = mysql_fetch_assoc($qquery)){
		$sflag = coun_is_die($data11[countryID]);
		if($sflag)
			$mainflag++;
	}
		if($mainflag>0){
			  printrus
		("<img src=\"/img/ico/moder.png\" alt=\"\" /> <a style=\"color:#00FF00;\" href=\"viewclan.php?$ses&amp;cid=".$a['id']."\"><b>$clanName</b></a><br/>
		");
		}
		if($mainflag==0){
				  printrus
		("<img src=\"/img/ico/moder.png\" alt=\"\" /> <a style=\"color:red;\" href=\"viewclan.php?$ses&amp;cid=".$a['id']."\">$clanName</a><br/>
		");
		}
   }

}
function coun_is_die($countryID){
	$query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
	   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
	   WHERE (messages.countryID IS NULL)and(countries.countryID = '".$countryID."')";
	  // $result12  = mysql_fetch_assoc(@MYSQL_QUERY($query));
	$result=mysql_num_rows(MYSQL_QUERY($query));
	if($result){
		return true;
	}else{
		return false;
	}
}
//printrus ("---<br/><a href='game.php?$ses'>&lt;&lt;В игру</a><br/>\r\n");
//printrus ('<b>&#169;</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
