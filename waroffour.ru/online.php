<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['cid']) && $_REQUEST['cid']!='') $cid = $_REQUEST['cid'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['d'])) $d = $_REQUEST['d'];
if (isset($_REQUEST['o'])) $pd = $_REQUEST['o'];
if (isset($_REQUEST['nm'])) $nm = $_REQUEST['nm'];
if (isset($_REQUEST['to'])) $to = $_REQUEST['to'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($_REQUEST['message'])) $message = $_REQUEST['message'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

if (in_array($_SESSION['userID'],$dc))$level=1;
else $level=0;
//==============================================================================
//Рабочая часть скрипта========================================================= \

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
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+7200) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='../unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("../other_inc/footer.php");

  die("");
 }

$older4 = array(1,877,1884);//админы
$older = array( );//старшие модеры
$older2=array(963);//среднии модеры

if (in_array($_SESSION['userID'],$older))$level=1;
else $level=0;
if (in_array($_SESSION['userID'],$older2))$level=2;
else $level=$level;
if (in_array($_SESSION['userID'],$older4))$level=8;
else $level=$level;


  if(($go=='killblock' or $_REQUEST['killblock']) and $level == 8)
  {
  $hours = 300; /*На сколько часов блокирум*/
  $purp='Приговор исполнен и обжалованию не подлежит!';
    if($d == 1)
    {
    $sid=$_POST['formbox'];
    $n = count($sid);
      if(!empty($n)){
      printrus("<u>$n cтранам выдан бан/блок на $hours часов</u>:<br/>\n");
        for($i=0; $i < $n; $i++)
        {
        $cid=$sid[$i];
        $cname = checkCountryID($cid);
        $r= mysql_query("SELECT userID FROM `uzers` WHERE countryID = '$cid'");
        $a=mysql_fetch_array($r);
        $userID = $a['userID'];
        printrus("$cname<br/>\n");
        mysql_query("UPDATE `uzers` SET inv=-1, blocked = '".(time()+$hours*3600)."' WHERE userID='$userID' LIMIT 1");
        $key=_PREFIKS.':id'.$cid;
          if(($mem=$memcache->get($key))!==FALSE){
          $mem['inv']=-1;
          $mem['blocked']=time()+$hours*3600;
          $memcache->set($key,$mem,false,86400);
          }

        mysql_query("INSERT INTO `blocks` SET cid='$userID', why='$purp',who='".$b['countryName']."',tm='".time()."'");
        sendMessage($sid,'fullMessage',"Модер <u>".$b['countryName']."</u> убил вашу страну за нарушение правил. Причину вы можете посмотреть на главной странице в графе удаления.");
        looser($cid);
        //Пишем в базу причину удаления и название страны
        mysql_query("INSERT INTO `purposes` SET cname='$cname', why='$purp(ID=$sid)',who='".$b['countryName']."',tm='".time()."'");

        @$open=fopen("mod/mpan.dat","a+");
        @flock ($open,LOCK_EX);
        $str = date("d M(H:i)").">".$b['countryName']."(ip:$mip, soft:$msoft) убивает/блокирует страну $cname(userID=$userID)\n\r";
        @fwrite ($open,$str);
        @fflush($open);
        @flock ($open,LOCK_UN);
        @fclose($open);
        }
      }
      else{printrus("Вы не выбрали страны!<br/>");}
    }
    else
    {
    $cname = checkCountryID($cid);
    $r= mysql_query("SELECT userID FROM `uzers` WHERE countryID = '$cid'");
    $a=mysql_fetch_array($r);
    $userID = $a['userID'];

    printrus("Стране <u>$cname</u> выдан бан/блок на $hours часов!<br/>\n");

    mysql_query("UPDATE `uzers` SET inv=-1, blocked = '".(time()+$hours*3600)."' WHERE userID='$userID' LIMIT 1");
    $key=_PREFIKS.':id'.$cid;
     if(($mem=$memcache->get($key))!==FALSE){
        $mem['inv']=-1;
        $mem['blocked']=time()+$hours*3600;
        $memcache->set($key,$mem,false,86400);
     }

    mysql_query("INSERT INTO `blocks` SET cid='$userID', why='$purp',who='".$b['countryName']."',tm='".time()."'");
    sendMessage($cid,'fullMessage',"Модер <u>".$b['countryName']."</u> убил вашу страну за нарушение правил. Причину вы можете посмотреть на главной странице в графе удаления.");
    looser($cid);
    //Пишем в базу причину удаления и название страны
    mysql_query("INSERT INTO `purposes` SET cname='$cname', why='$purp(ID=$cid)',who='".$b['countryName']."',tm='".time()."'");

    @$open=fopen("mod/mpan.dat","a+");
    @flock ($open,LOCK_EX);
    $str = date("d M(H:i)").">".$b['countryName']."(ip:$mip, soft:$msoft) убивает/блокирует страну $cname(userID=$userID)\n\r";
    @fwrite ($open,$str);
    @fflush($open);
    @flock ($open,LOCK_UN);
    @fclose($open);
    }
  }
  elseif(($go=='block' or $_REQUEST['block']) and $level == 8)
  {
    if($d == 2){
    $sid=$_POST['formbox']; $hours=round($_POST['hours']); $purp=$_POST['purp'];
    $n = count($sid);
      if(!empty($n)){
      printrus("<u>$n cтранам выдан блок на $hours часов</u>:<br/>\n");
        for($i=0; $i < $n; $i++)
        {
        $cid=$sid[$i];
        $cname = checkCountryID($cid);
        $r= mysql_query("SELECT userID FROM `uzers` WHERE countryID = '$cid'");
        $a=mysql_fetch_array($r);
        $userID = $a['userID'];
        printrus("$cname <br/>\n");
        mysql_query("UPDATE `uzers` SET inv=-1, blocked = '".(time()+$hours*3600)."' WHERE userID='$userID' LIMIT 1");
        $key=_PREFIKS.':id'.$cid;
          if(($mem=$memcache->get($key))!==FALSE){
          $mem['inv']=-1;
          $mem['blocked']=time()+$hours*3600;
          $memcache->set($key,$mem,false,86400);
          }

        //Пишем в базу причину блока и название страны
        $purp=htmlspecialchars(iconv('utf-8','cp1251',$purp));
        mysql_query("INSERT INTO `blocks` SET cid='$userID', why='$purp',who='".$b['countryName']."',tm='".time()."'");

        @$open=fopen("mod/mpan.dat","a+");
        @flock ($open,LOCK_EX);
        $str = date("d M(H:i)").">".$b['countryName']."(ip:$mip, soft:$msoft) блокирует страну $cname(userID=$userID)\n\r";
        @fwrite ($open,$str);
        @fflush($open);
        @flock ($open,LOCK_UN);
        @fclose($open);
        }
      }else{printrus("Вы не выбрали страны!<br/>");}
    }
    else
    {
    $cid=$_POST['formbox'];
    $n = count($cid); if ($pg<0){$pg=0;}
    if(!empty($n)){
    printrus("Причина:<br/>\n");
    printrus ("<form name=\"\" action=\"online.php?m=md&amp;pg=$pg&amp;$ses&amp;d=2\" method=\"post\">
    <input name=\"purp\" maxlength=\"1500\" title=\"Text\" value=\"\"/><br/>\n");
    printrus("Время блока (в часах):<br/>\n");
    printrus("<input format='*N' name='hours' /><br/>");
    for($i=0; $i < $n; $i++){printrus("<input type=\"hidden\" name=\"formbox[]\" value=\"$cid[$i]\">");}
    printrus("<input type=\"submit\" name=\"block\" value=\"Блокировать\"/></form><br/>");}
    else{printrus("Вы не выбрали страны!<br/>");}
    }
  }

 switch($m):
 default:
  if($level != 0){printrus ("<b>Онлайн</b> | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='moders.php?$ses'>Модераторы</a> | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='admini.php?$ses'>Админы</a>| <img src=\"/img/ico/map.png\" alt=\".\" /> <a href='online.php?m=md&amp;$ses'>Карта мира МД</a> | <img src=\"/img/ico/search.png\" alt=\".\" /> <a href='online.php?m=seerch&amp;$ses'>Поиск</a><br/>\r\n");}
  else{printrus ("<b>Онлайн</b>  | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='admini.php?$ses'>Админы</a> | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='moders.php?$ses'>Модераторы</a> | <img src=\"/img/ico/search.png\" alt=\".\" /> <a href='online.php?m=seerch&amp;$ses'>Поиск</a><br/>\r\n");}
 if(!isset($nm))$nm=0;
 $now = time();
 $query="SELECT * FROM uzers WHERE onlineFlag>$now limit $nm,8";
 $r = mysql_query($query);
 while(($a = mysql_fetch_array($r))!==false){
 	$query="SELECT * FROM countries WHERE countryID='".$a['countryID']."' limit 1";
     $g = mysql_query($query);
     $t = mysql_fetch_array($g);

 if($a['race'] == 1 and $a['inv']!=2){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"r1\">".$t['countryName']."</a>";}
 elseif($a['race'] == 2 and $a['inv']!=2){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"r2\">".$t['countryName']."</a>";}
 elseif($a['race'] == 3 and $a['inv']!=2){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"r3\">".$t['countryName']."</a>";}
 elseif($a['race'] == 4 and $a['inv']!=2){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"r4\">".$t['countryName']."</a>";}
 elseif($a['inv']==2 and $a['userID']==1){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"admin\"><img src=\"http://waroffour.ru/znc/drag11111.png\"></a>";}
 elseif($a['inv']==2 and $a['userID']==37){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"admin\"><img src=\"http://waroffour.ru/znc/lisy051.png\"></a>";}
 elseif($a['inv']==2 and $a['userID']==877){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"r2\">фурия</a>";}
 elseif($a['inv']==2 and $a['userID']!=1 and $a['userID']!=66 and $a['userID']!=37){$name="<a href=\"online.php?m=about&amp;to=".$a['countryID']."&amp;$ses\" class=\"admin\">".$t['countryName']."</a>";}

   if($level == 8){
   printrus("<img src=\"/img/ico/user.png\" alt=\"\" /> ".$name." [<a href=\"mpan.php?name=".$t['countryName']."&amp;$ses\">S</a>]
   [<a href=\"mpan_adm.php?name=".$t['countryName']."&amp;$ses&go=narisovat\"><font color=#f7f21a>RS</font></a>]
   [<a href=\"online.php?$ses&amp;go=killblock&amp;cid=".$a['countryID']."\">Блок/Бан</a>]<br/>\n");
   }
   elseif($level >= 1 and $level < 8)
   {
   printrus("<img src=\"/img/ico/user.png\" alt=\"\" /> ".$name." [<a href=\"mpan.php?name=".$t['countryName']."&amp;$ses\">S</a>] [<a href=\"mpan.php?$ses&amp;go=block&amp;cid=".$a['countryID']."\">Блок</a>][<a href=\"mpan.php?$ses&amp;go=kill&amp;cid=".$a['countryID']."\">Бан</a>]<br/>\n");
   }
   else
   {
   printrus("<img src=\"/img/ico/user.png\" alt=\"\" /> ".$name."<br/>\n");
   }
 }
 printrus("---<br/>\n<a href=\"online.php?nm=".($nm+8)."&amp;$ses\">Далее</a><br/>\n");

 break;

 case 'seerch':
 printrus ("<b>Поиск</b> | <img src=\"/img/ico/onl.png\" alt=\".\" /> <a href=\"online.php?str&amp;$ses\">Онлайн</a> | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='admini.php?$ses'>Админы</a> | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='moders.php?$ses'>Модераторы</a><br/>\r\n");
 printrus("Поиск по названию страны:<br/>");
 printrus('<form name="seerch" action="online.php?m=result&amp;$ses" method="post">
           <input name="name" type="text" value=""/><br/>
           <input type="submit" value="Поиск"/>
</form>');


 break;


 case 'result':
 $name=$_REQUEST['name'];
 $name = iconv('utf-8','cp1251',$name);
$r = mysql_query("SELECT * FROM `countries` WHERE countryName = '$name' LIMIT 1");
if (mysql_num_rows($r)==0){
   printrus ("<b>!</b>Такой страны нет на карте мира<b>!</b><br/>\r\n");
   }else{
   	$t = mysql_fetch_array($r);
   $cid = $t['countryID'];
   	$query="SELECT * FROM uzers WHERE countryID='".$cid."' limit 1";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
   printrus("<br/>Страна: [".$t['countryName'].']<br/>');
 printrus("<br/>Дата регистрации: ".$a['datereg'].'<br/>');
 printrus("Имя: ".$a['imya'].'<br/>');
 printrus("О себе: ".$a['about'].'<br/>');
 printrus("Уничтожено стран: ".$a['counts']."<br/>\n");
 printrus
("<a href=\"../messages/writemessage.php?to=$cid&amp;$ses\">Написать сообщение</a><br/>
");


   }

 break;

 //Тут будет инфа о юзере
 case 'about':
 $query="SELECT * FROM uzers WHERE countryID='".$to."' limit 1";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $query="SELECT * FROM countries WHERE countryID='".$to."' limit 1";
 $g = mysql_query($query);
 $t = mysql_fetch_array($g);
 printrus("<br/>Страна: [".$t['countryName'].']<br/>');
 printrus("<br/>Дата регистрации: ".$a['datereg'].'<br/>');
 printrus("Имя: ".$a['imya'].'<br/>');
 printrus("О себе: ".$a['about'].'<br/>');
 printrus("Уничтожено стран: ".$a['counts']."<br/>\n");
 printrus
("<a href=\"../messages/writemessage.php?to=$to&amp;$ses\">Написать сообщение</a><br/>
");
 break;

 //Тут будет карта МД
 case 'md':
printrus ("<a href='online.php?$ses'>Онлайн</a> | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='moders.php?$ses'>Модераторы</a> | <img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='admini.php?$ses'>Админы</a> | <img src=\"/img/ico/map.png\" alt=\".\" /> <b>Карта мира МД</b> | <img src=\"/img/ico/search.png\" alt=\".\" /> <a href='online.php?m=seerch&amp;$ses'>Поиск</a><br/><br />\r\n");
  if($level != 0)
  {
  if (!isset($pg)){$pg = 0;}
  if ($pg<0)$pg=0;
  printrus ("<a href='online.php?m=md&amp;pg=0&amp;$ses'>В начало карты (запад)</a><br />");
  $query="SELECT * FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL) and status='10' order by reggedTime asc LIMIT ".$pg.",30";
  $r = mysql_query($query);
  echo mysql_error();
  $npg = $pg-29;
  if ($pg>0) printrus ("<a href='online.php?m=md&amp;pg=$npg&amp;$ses'>На запад</a><br /><br />");
  printrus("<form action=\"online.php?m=md&amp;$ses&amp;pg=$pg&amp;d=1\" method=\"post\">");
  printrus("<input type=\"checkbox\" name=\"sel_all\" onChange=\"for (i in this.form.elements) this.form.elements[i].checked = this.checked\"> выбрать все<br />\r\n");

    while(($a=mysql_fetch_array($r))!==FALSE){
    $d = mysql_query("SELECT * FROM `countries` WHERE countryID = '".$a[0]."' LIMIT 1");
    $s = mysql_fetch_array($d);
    $r2 = mysql_query("SELECT onlineflag,ip FROM `uzers` WHERE countryID = '".$a[0]."' LIMIT 1");
    $a2 = mysql_fetch_array($r2);
    if (time()<$a2['onlineflag']){$onl="[onl]";}else{$onl="[off]";}

      if($level == 8)
      {
      if($a2['ip'] == 'sysreg'){printrus("<input type=\"checkbox\" name=\"formbox[]\" value=\"".$s['countryID']."\" /> <a href=\"online.php?m=about&amp;to=".$s['countryID']."&amp;$ses\" class=\"smd2\"> ".$a['countryName']."</a> $onl Возраст: ".mkTimeStr(time()-$s['reggedTime'])." [<a href=\"mpan.php?name=".$a['countryName']."&amp;$ses\">S</a>]
      [<a href=\"mpan_adm.php?name=".$a['countryName']."&amp;$ses&go=narisovat\"><font color=#f7f21a>RS</font></a>]
       [<a href=\"online.php?m=md&amp;$ses&amp;go=killblock&amp;cid=".$s['countryID']."\">Блок/Бан</a>]<br/><br />\r\n");}else{printrus("<input type=\"checkbox\" name=\"formbox[]\" value=\"".$s['countryID']."\" /> <a href=\"online.php?m=about&amp;to=".$s['countryID']."&amp;$ses\" class=\"smd\"> ".$a['countryName']."</a> $onl Возраст: ".mkTimeStr(time()-$s['reggedTime'])." [<a href=\"mpan.php?name=".$a['countryName']."&amp;$ses\">S</a>]
         [<a href=\"mpan_adm.php?name=".$a['countryName']."&amp;$ses&go=narisovat\"><font color=#f7f21a>RS</font></a>]
        [<a href=\"online.php?m=md&amp;$ses&amp;go=killblock&amp;cid=".$s['countryID']."\">Блок/Бан</a>]<br/><br />\r\n");}

      }
      else
      {
      if($a2['ip'] == 'sysreg'){printrus("<a href=\"online.php?m=about&amp;to=".$s['countryID']."&amp;$ses\" class=\"smd2\">".$a['countryName']."</a> $onl Возраст: ".mkTimeStr(time()-$s['reggedTime'])." [<a href=\"mpan.php?name=".$a['countryName']."&amp;$ses\">S</a>]
       [<a href=\"mpan.php?$ses&amp;go=block&amp;cid=".$s['countryID']."\">Блок</a>][<a href=\"mpan.php?$ses&amp;go=kill&amp;cid=".$s['countryID']."\">Бан</a>]<br/><br />\r\n");}else{printrus("<a href=\"online.php?m=about&amp;to=".$s['countryID']."&amp;$ses\" class=\"smd\">".$a['countryName']."</a> $onl Возраст: ".mkTimeStr(time()-$s['reggedTime'])." [<a href=\"mpan.php?name=".$a['countryName']."&amp;$ses\">S</a>] [<a href=\"mpan.php?$ses&amp;go=block&amp;cid=".$s['countryID']."\">Блок</a>][<a href=\"mpan.php?$ses&amp;go=kill&amp;cid=".$s['countryID']."\">Бан</a>]<br/><br />\r\n");}
      }
    }
  $npg = $pg+29;
  printrus ("<input type=\"submit\" name=\"killblock\" value=\"Блок/Бан\"> <input type=\"submit\" name=\"block\" value=\"Блок\"></form><br/>\r\n");
  printrus ("<a href='online.php?m=md&amp;pg=$npg&amp;$ses'>На восток</a><br />");
  $query2=mysql_query("SELECT countryName FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)");
  $r2 = mysql_num_rows($query2);
  $vst=$r2-29;
  printrus ("<a href='online.php?m=md&amp;pg=$vst&amp;$ses'>В конец карты (восток)</a><br /><br />");
  }
 break;
 endswitch;


//==============================================================================
//Конец скрипту=================================================================
print "---<br/>\r\n";
printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
?>
