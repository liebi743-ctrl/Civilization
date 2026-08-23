<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
$ref = rand(0,100000);
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['name'])) $name = $_REQUEST['name'];
if (isset($_REQUEST['pref'])) $pref = $_REQUEST['pref'];

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

/*$key=_PREFIKS.':clans'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $clanID = $mem;
    }else{
    $r=mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$countryID'");
    $h=mysql_fetch_array($r);
    if ($h!==FALSE)
    $clanID = $h['clanID'];
    else $clanID=0;
    }*/
    $r=mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$countryID'");
    $h=mysql_fetch_array($r);
    if ($h!==FALSE)
    $clanID = $h['clanID'];
    else $clanID=0;

 if (!isset($clanID)|| $clanID==0){
    printrus("Вы не состоите ни в каком клане!<br/>\n");
//    printrus ("<a href='game.php?$ses'>&lt;В игру</a><br/>\n");
//    printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");

    //футер страницы:
    include_once("other_inc/footer.php");
    die("");
    }

$r = mysql_query("SELECT * FROM `clans` WHERE id='".$clanID."'");
$a = mysql_fetch_array($r);
if ($a==FALSE&&$m=='found'){
   if($pref=='1')$pref='Союз';
   elseif($pref=='2')$pref='Гвардия';
   elseif($pref=='3')$pref='Империя';
   elseif($pref=='4')$pref='Объединение';
   elseif($pref=='5')$pref='Организация';
   elseif($pref=='6')$pref='Альянс';
   else $pref='Клан';
   $name = trim($name);
   $name = ereg_replace(" +"," ",$name);

   if (!isset($name)||$name==''){
      printrus("Вы должны задать имя Вашего клана!<br/>\n");
      }elseif(!cnameisok($name)){
      printrus("Имя клана содержит недопустимые символы!<br/>\n");
      }else{
      if ($t1=='1') $name = translit($name);
      $name = iconv('utf-8','cp1251',$name);
      $cname = $pref." $name";
      $z = mysql_query("SELECT count(*) as num FROM `clans` WHERE `name` = '$cname'");
      $c = mysql_fetch_array($z);
      if ($c['num']!=0){
      printrus("Клан с таким названием уже существует в игре! Выберите другое название.<br/>\n");
         }else{
      mysql_query("INSERT INTO `clans` SET id='".$clanID."', `name` = '$cname', founder='".$_SESSION['userID']."'");
      printrus(date("d.m.Y")." был основан новый клан Империи <u>$cname</u>. Быть может, это событие станет поворотным моментом в истории? Кто знает...<br/>\n");
      $r = mysql_query("SELECT * FROM `clans` WHERE id='".$clanID."'");
      $a = mysql_fetch_array($r);
      }

      }

   }

if ($a==FALSE){
   printrus("Создайте свой клан:<br/>\n");
   printrus("<u>Внимание! Название выбирается навсегда! Вы не сможете изменить его впоследствии!</u><br/>\n");
   printrus("Название: (разрешено использовать те же символы, что и в названии страны)<br/>\n");
printrus ("<form name=\"\" action=\"clan.php?$ses&amp;m=found\" method=\"post\">
<select name=\"pref\">\n");
printrus ("<option value=\"0\">Клан</option>\n");
printrus ("<option value=\"1\">Союз</option>\n");
printrus ("<option value=\"2\">Гвардия</option>\n");
printrus ("<option value=\"3\">Империя</option>\n");
printrus ("<option value=\"4\">Объединение</option>\n");
printrus ("<option value=\"5\">Организация</option>\n");
printrus ("<option value=\"6\">Альянс</option>\n");
printrus ("</select><br/>\n");
   printrus ("<input name=\"name\" maxlength=\"20\" title=\"Text\" value=\"\"/>
   <br/> <input name=\"t1\" type=\"checkbox\" value=\"1\"/>Транслитеровать\n<br/>\n
<br/>\n");
//   printrus ("<input format='*N' name='age' /><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Основать\"/>
</form>
");
//футер страницы:
include_once("other_inc/footer.php");
   die("");
   }
printrus("Ваш клан:<br/>\n");
printrus("<b>{</b><u>".$a['name']."</u><b>}</b><br/>\n");
printrus("<a href=\"chat_clan.php?$ses\">Чат клана</a><br/>\n");

if (file_exists("clans/".$clanID.".gif")){
   print "<img src=\"clans/$clanID.gif?$ref\" alt=\"clanlogo\"/><br/>";
   }elseif(file_exists("clans/".$clanID.".jpg")){
   print "<img src=\"clans/$clanID.jpg?$ref\" alt=\"clanlogo\"/><br/>";
   }elseif(file_exists("clans/".$clanID.".jpeg")){
   print "<img src=\"clans/$clanID.jpeg?$ref\" alt=\"clanlogo\"/><br/>";
   }else{
   printrus("Герб не выбран!");
   }

$z = mysql_query("SELECT * FROM `uzers` WHERE clanID='".$clanID."' and countryID!='".$b['countryID']."'");
if (mysql_num_rows($z)!=0) printrus("В вашем клане состоят:<br/>\n");
else printrus("В вашем клане нет никого, кроме вас! Набирайте людей, если вы основатель=)");
while (($c=mysql_fetch_array($z))!==FALSE){
if ($c['onlineflag']<date(U)-965 || $c['userID']==1) $status = "off";
else $status = "onl";
      if ($a['founder']==$c['userID']){
         printrus (checkCountryID($c['countryID'])."(<u>основатель</u>)[$status]");
  printrus
("<a href=\"messages/writemessage.php?$ses&amp;to=".$c['countryID']."\">+</a>,");
         }
      else{
       printrus (checkCountryID($c['countryID'])."[$status]");
       printrus
("<a href=\"messages/writemessage.php?$ses&amp;to=".$c['countryID']."\">+</a>,");
       }
      }
printrus("<br/>\n");
if ($_SESSION['userID']==$a['founder']){
printrus ("<a href='addgerb.php?$ses'>Изменить герб</a>(только для браузеров с поддержкой xhtml)<br/>\n");
printrus ("<a href='claninfo.php?go=deviz&amp;$ses'>Изменить девиз</a><br/>\n");
printrus ("<a href='claninfo.php?go=info&amp;$ses'>Изменить информацию</a><br/>\n");
printrus ("<a href='addclan.php?m=add&amp;$ses'>Добавить участника</a><br/>\n");
printrus ("<a href='addclan.php?m=del&amp;$ses'>Удалить участника</a><br/>\n");
   }
printrus("Вашим кланом уничтожено <b>".$a['c_killed']."</b> стран!<br/>\n");

if ($a['deviz']!='')printrus("<u>Девиз:</u>".$a['deviz']."<br/>\n");
else printrus("Девиз не задан<br/>\n");
if ($a['info']!='')printrus("<u>Информация:</u><br/>".$a['info']."<br/>\n");
else printrus("Информация не задана<br/>\n");

//printrus ("<a href='game.php?$ses'>&lt;В игру</a><br/>\n");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");

//футер страницы:
include_once("other_inc/footer.php");
?>
