<?php
if ($_GET['pas'] != 't67gh52cZv')
	die('403.');

set_time_limit(0);
error_reporting(0);
define('IN_CLV',true);
//==============================================================================
//подключаем скрипты
include_once("func/functions_clv.php");
mem_connect();

//==============================================================================
//Рабочая часть скрипта=========================================================
include_once("other_inc/header.php");

//удаляем старый лог
$file="".$_SERVER['DOCUMENT_ROOT']."/logs/dellbot.dat";
unlink($file);

//создаём новый лог
$logs='- Запуск бота удалений.<br />';
$open=fopen($_SERVER['DOCUMENT_ROOT'].'/logs/dellbot.dat',"w+");
@flock ($open,LOCK_EX);
@fwrite($open,date("[d-m-Y H:i] ").$logs."\n");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query="SELECT * FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
$result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

$num1=0; $num2=0;
while(($a=mysql_fetch_array($result))!==FALSE){
$countryID=$a[0];
$country=$a[1];
$q="select countryID from `wars` where targetID='$countryID'";
$r=@MYSQL_QUERY($q) or (mySQLqueryERROR($q) and die(""));
$attCount=@mysql_num_rows($r);
if ($attCount>0){$war = FALSE;}else{$war = TRUE;}

$kk = mysql_query("SELECT userID,ip,username FROM `uzers` WHERE countryID = '$countryID' LIMIT 1");
$gg = mysql_fetch_array($kk);

/*если стране от 37 до 73 часа И нет вторжений И нет генерала И страна созданая игрой а не играком, то удаляем полностью её из базы вместе с профилем*/
  if(($a['reggedTime']+60*60*37)<time() and ($a['reggedTime']+60*60*73)>time() and $war == TRUE and !general_info($countryID) and $gg['ip'] == 'sysreg')
  {  looser($countryID);
  $query1="delete from `countries` where countryID='$countryID'";
  $result1=@MYSQL_QUERY($query1);
  $query2="delete from `uzers` where countryID='$countryID'";
  $result2=@MYSQL_QUERY($query2);

  $dell_logs=''.date("[d-m-Y H:i] ").'<u>'.$country.'</u> - [userID='.$gg['userID'].', countryID='.$countryID.', username='.$gg['username'].'],<br />';
  //Пишем в лог все страны которые удалил бот:
  $open=fopen($_SERVER['DOCUMENT_ROOT'].'/logs/dellbot.dat',"a+");
  @flock ($open,LOCK_EX);
  @fwrite($open,$dell_logs."\n");
  @fflush($open);
  @flock ($open,LOCK_UN);
  @fclose($open);
  printrus("".$dell_logs."<br/>");
  $num2++;
  }
$num1++;
}

$dell_log="<br />Всего было проверено стран: <b>".$num1."</b>, из них было удалено: <b>".$num2."</b><br/>";
$open=fopen($_SERVER['DOCUMENT_ROOT'].'/logs/dellbot.dat',"a+");
@flock ($open,LOCK_EX);
@fwrite($open,$dell_log."\n");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

printrus("".$dell_log."<br/>");

include_once("other_inc/footer.php");
?>