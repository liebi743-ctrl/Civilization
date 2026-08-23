<?
$urls[]="/[c—с]{1}(.?){1,4}[v¬в]{1}(.?){1,4}[g√г]{1}(.?){1,4}[aја]{1}(.?){1,4}[mћм]{1}(.?){1,4}[e≈е]{1}(.?){1,4}[r–р]{1}(.?){1,4}[у”u]{1}/is";
$urls[]="/[c—с]{1}(.?){1,4}[i»и]{1}(.?){1,4}[v¬в]{1}(.?){1,4}[i»и]{1}(.?){1,4}[lЋл]{1}(.?){1,4}[s—с]{1}(.?){1,4}[r–р]{1}(.?){1,4}[у”u]{1}/is";

foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//ќбработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['to'])) $to = $_REQUEST['to'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['message'])) $message = $_REQUEST['message'];

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
//–абоча€ часть скрипта========================================================= \

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
  printrus ("<b>[".$b['countryName']."]</b><br/>\r\n");
 }else{
  printrus ("<b>!</b>¬џ Ќ≈ ј¬“ќ–»«ќ¬јЌџ!<b>!</b><br/>\r\n");

  printrus ("<a href='../unlogin.php?$ses'>√лавна€</a><br/>\r\n");
  //футер страницы:
  include_once("../other_inc/footer.php");

  die("");
 }

 $toID=$to;
 $countryID = $_SESSION['countryID'];

 $key=_PREFIKS.':clans'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $clanID = $mem;
    }else{
    $r=mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$countryID'");
    $h=mysql_fetch_array($r);
    if ($h!==FALSE)
    $clanID = $h['clanID'];
    else $clanID=0;
    }
 $query="select count(*) as num from countries where countryID = '$toID'";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num2 = $a['num'];


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
//–исуем вс€кие цыферки-ссылочки разные*****************************************

 //$query="select * from messages where countryID='$countryID'";
 //$result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 //$mesCount=@mysql_numrows($result);

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//ѕровер€ем а сосед ли он, и есть ли у мен€ ратуша(цитадель)::::::::::::::::::::
if ($b['inv']==-1 && $b['blocked']>time()){header('Location: http://imperia.mobi/game.php?$ses');}


$oldgame=time()-$b['reggedTime'];
if($oldgame>17999){
 if((!$myname=checkCountryID($countryID)  || !$to_name=checkCountryID($toID) || !building_exists($b['countryID'],"ratusha") || !building_exists($b['countryID'],"citadel"))&&$clanID==0 || $num2==0){
  printrus ("<u>Ќаписать сообщение</u><br/>\r\n");
  printrus ("<u>¬ы не можете писать сообщение этой стране!</u><br/>\r\n");
  print "---<br/>\r\n";
  printrus
("
<a href='../game.php?$ses'>Ќазад</a>
<br/>
");
//  printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;¬ыход</a><br/>\r\n");

  //футер страницы:
  include_once("../other_inc/footer.php");

  die("");
 }

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//¬ыводим сообщени€:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 printrus ("<u>Ќаписать сообщение</u><br/>\r\n");
 if(empty($m) || empty($message)){
  printrus ("—ообщение:\r\n");
  printrus ("<form name=\"\" action=\"writemessage.php?$ses&amp;to=$to&amp;m=send\" method=\"post\">
<input type='text' name='message' /><br/>
  <input name=\"t1\" type=\"checkbox\" value=\"1\"/>“ранслитеровать\n<br/>\n");
   printrus
("<input type=\"submit\" value=\"ќтправить&gt;&gt;\"/>
</form>
<br/>
");
/* }elseif(!VALUE_isOK($message)){
  print "¬ сообщении используютс€ запрещенные символы!<br/>\r\n";      */
 }elseif($m=='send'){
  if ($t1=='1') $message = translit($message);

  $message = iconv('utf-8','cp1251',htmlspecialchars($message));
  $j=0;
  while(isset($urls[$j])){
  $message = preg_replace($urls[$j], '(хмм...)', $message);
  $j++;
  }
  /*$message = preg_replace("/([а-€a-z0-9\.\-]{3,25})+([\.\, ]{1,3}+(su|ru|ua|kz|com|net|biz|info|lt|org|il|be|uа|сom|cоm|coм|mobi|соm|сoм|cом|nеt|neт|nет|infо|оrg|bе|ру|рф|It))/i", 'imperia.mobi',$message);
  $message = preg_replace("/[cс—ц÷]{1}(.?){1,4}[iи»]{1}(.?){1,4}[vв¬]{1}(.?){1,4}[aај]{1}(.?){1,4}[х’x]{1}(.?){1,4}[r–р]{1}(.?){1,4}[у”u]{1}/is", ' imperia.mobi', $message);
  $message = preg_replace("/[dдƒ]{1}(.?){1,4}[eе≈]{1}(.?){1,4}[rр–]{1}(.?){1,4}[zh∆жз«х’]{1,2}(.?){1,4}[r–р]{1}(.?){1,4}[у”u]{1}/is", ' imperia.mobi', $message);
  $message = preg_replace("/[kк ]{1}(.?){1,4}[oоќ]{1}(.?){1,4}[lлЋ]{1}(.?){1,4}[eе≈]{1}(.?){1,4}[k к]{1}(.?){1,4}[tт“]{1}(.?){1,4}[iи»]{1}(.?){1,4}[vв¬]{1}(.?){1,4}[4]{1}(.?){1,4}[iи»]{1}(.?){1,4}[kк ]{1}(.?){1,4}[r–р]{1}(.?){1,4}[у”u]{1}/is", ' imperia.mobi', $message);
  $message = preg_replace("/[c—с]{1}(.?){1,4}[v¬в]{1}(.?){1,4}[g√г]{1}(.?){1,4}[aја]{1}(.?){1,4}[mћм]{1}(.?){1,4}[e≈е]{1}(.?){1,4}[r–р]{1}(.?){1,4}[у”u]{1}/is", ' imperia.mobi', $message);
 *//* preg_match("/[cс—]{1}(.*)i(.*)v(.*)[aај]{1}(.*)[х’x]{1}(.*)[r–р]{1}(.*)[у”u]{1}/i", $message, $out);

  if(count($out)>0)$message = str_replace($out[0], ' imperia.mobi',$message); */
  //$message = iconv('utf-8','cp1251',htmlspecialchars($message));
  sendMessage($toID,$b['countryID'],$message);

  //ѕишем в лог работ:
 @$open=fopen("../logs/mes".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."{".checkCountryID($toID)."}".$message."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
  //ѕишем в лог работ:
 @$open=fopen("../logs/mes".$toID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."<b>ќ“-></b>{".checkCountryID($countryID)."}".$message."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  printrus ("—ообщение отправлено!<br/>\r\n");
 }
}else{
  printrus ("¬ы не можете отправл€ть сообщени€ другим странам еще ".mkTimeStr((17999-$oldgame))."<br/>\r\n");

}

//==============================================================================
// онец скрипту=================================================================
print "---<br/>\r\n";
printrus
("
<a href='../game.php?$ses'>Ќазад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;¬ыход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");
?>
