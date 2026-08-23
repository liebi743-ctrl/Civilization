<?
$ref = rand(0,100000);
//Обработка переменных:
if (isset($_REQUEST['cid'])) $cid = $_REQUEST['cid'];

//==============================================================================
//подключаем скрипты, там, и еще всякая фигня:)=================================

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
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
  $tm = time();
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600), lastsessid = '$ses' WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u>");

  print "<br/>\r\n";
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='index.php'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");
  die("");
 }

 $countryID = $b['countryID'];
 $clanID = $cid;

 if (!isset($clanID)|| $clanID==0){
    printrus("Нет такого клана!<br/>\n");
    //футер страницы:
include_once("other_inc/footer.php");
    die("");
    }

$r = mysql_query("SELECT * FROM `clans` WHERE id='".$clanID."'");
$a = mysql_fetch_array($r);
if ($a==FALSE){
printrus("Нет такого клана!<br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
die("");
}


//printrus("Клан:<br/>\n");
printrus("<b>{</b><u>".$a['name']."</u><b>}</b><br/>\n");

if (file_exists("clans/".$clanID.".gif")){
   print "<img src=\"clans/$clanID.gif?$ref\" alt=\"clanlogo\"/><br/>";
   }elseif(file_exists("clans/".$clanID.".jpg")){
   print "<img src=\"clans/$clanID.jpg?$ref\" alt=\"clanlogo\"/><br/>";
   }elseif(file_exists("clans/".$clanID.".jpeg")){
   print "<img src=\"clans/$clanID.jpeg?$ref\" alt=\"clanlogo\"/><br/>";
   }

$z = mysql_query("SELECT * FROM `uzers` WHERE clanID='".$clanID."' and countryID!='".$b['countryID']."'");
if (mysql_num_rows($z)!=0) printrus("В клане состоят:<br/>\n");
while (($c=mysql_fetch_array($z))!==FALSE){
	$s_flag = coun_is_die($c['countryID']);
      if ($a['founder']==$c['userID']){
		if($s_flag){
			printrus ("<p style=\"color:#00FF00;display:inline;\">".checkCountryID($c['countryID'])."</p>(<u>основатель</u>), ");
		}else{
			printrus ("<s style=\"color:red\">".checkCountryID($c['countryID'])."</s>(<u>основатель</u>), ");
		}
         }
      else{
	  if($s_flag){
			printrus ("<p style=\"color:#00FF00;display:inline;\">".checkCountryID($c['countryID'])."</p>, ");
	   }else{
			printrus ("<s style=\"color:red\">".checkCountryID($c['countryID'])."</s>, ");
	   }
       }
      }
printrus("<br/>\n");
printrus("Кланом уничтожено <b>".$a['c_killed']."</b> стран!<br/>\n");

if ($a['deviz']!='')printrus("<u>Девиз:</u>".$a['deviz']."<br/>\n");
if ($a['info']!='')printrus("<u>Информация:</u><br/>".$a['info']."<br/>\n");

//printrus ("<a href='game.php?$ses'>&lt;В игру</a><br/>\n");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");
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
//футер страницы:
include_once("other_inc/footer.php");
?>
