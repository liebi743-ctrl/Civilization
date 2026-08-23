<?

if (getenv('HTTP_USER_AGENT')=='http://Anonymouse.org/ (Unix)') exit("Чао..");
if(getenv('REMOTE_ADDR')=='213.87.76.52') exit;
//Обработка переменных:
//if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if(isset($_GET['clv']))$dddd="?clv=".$_GET['clv'];

//==============================================================================
//подключаем скрипты, там, и еще всякая фигня:)=================================

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//if(isset($_SESSION['dies']))header("Location: profile.php$dddd");
//шапка:
include_once("other_inc/header.php");




$_SESSION['cheat']=0;
 /*
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.2//EN\" \"http://www.wapforum.org/DTD/wml12.dtd\">
<wml><head><meta http-equiv=\"Cache-Control\" content=\"no-cache\" forua=\"true\"/></head>
<card title='$title'>
<do type=\"options\" name=\"stats\" label=\"РЎС‚Р°С‚РёСЃС‚РёРєР°\"><go href=\"stats.php?$ses\"/></do>
<do type=\"options\" name=\"rules\" label=\"РџСЂР°РІРёР»Р°\"><go href=\"rules.php?$ses\"/></do>
<do type=\"options\" name=\"refresh\" label=\"РћР±РЅРѕРІРёС‚СЊ\"><go href=\"game.php?$ses\"/></do>
<do type=\"options\" name=\"calc\" label=\"РљР°Р»СЊРєСѓР»СЏС‚РѕСЂ\"><go href=\"calc.php?$ses\"/></do>
<do type=\"options\" name=\"ass\" label=\"РђСЃСЃР°РјР±Р»РµСЏ\"><go href=\"chat.php?$ses\"/></do>
<do type=\"options\" name=\"exit\" label=\"Р’С‹С…РѕРґ\"><go href=\"unlogin.php?$ses\"/></do>
<p align='$align'>
<small>
";*/

$countryID = $_SESSION['countryID'];
worksRefresh($_SESSION['countryID']);

//==============================================================================
//Рабочая часть скрипта=========================================================

//printrus("С Днем Победы!<br/>");
//print "</small><img src=\"georg.gif\" alt=\"lenta\"/><small><br/>";

$b=CountryInfo($countryID);
isAuthed();
$us=UzersInfo($countryID);
//Проверка на блокировку
 if ($b['inv']==-1 && $b['blocked']>time()){
    $r=mysql_query("SELECT * FROM `blocks` WHERE cid='".$_SESSION['userID']."' LIMIT 1");
    $a=mysql_fetch_array($r);
    printrus ("Модер <u>".$a['who']."</u> блокировал вам доступ к игре. Причина:<br/>".$a['why']."<br/>\r\n");
    session_destroy();
    printrus ("<ul class=\"navs\"><li><a href='index.php'><img src=\"/img/ico/point.png\" class=\"menu\" alt=\"\" />Главная</a></li></ul>");
    //футер страницы:
    include_once("other_inc/footer.php");
    exit;
 }

 $countryID = $b['countryID'];
 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;

//printrus("<a href=\"news.php?$ses\">Новости*</a>[<span class=\"title\">new</span>]<br/>\n");
$r = mysql_query("SELECT * FROM news order by tm desc");
  $n = mysql_fetch_array($r);
  $dta=date('d.m.y', $n['tm']);
  $time=date('H:i', $n['tm']);
  //printrus("<ul class=\"navs\"><li><a href=\"forum.php?fid=4&amp;$ses\"><img src=\"/img/ico/news.png\" alt=\"\" />Новости</a></li></ul>");
  //printrus("<a href=\"rules.php?$ses\">Правила</a><br/>\n");
  //printrus("<a href=\"faq.php?$ses\">Помощь</a><br/>\n");
  //  printrus("<a href=\"stats.php?$ses\">Статистика</a><br/>\n");
  //printrus("<a href=\"calc.php?$ses\">Калькулятор стенобиток</a><br/>\n");
/*$query8="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $r8 = mysql_query($query8);
 $a8 = mysql_fetch_array($r8);
 $num = $a8['num'];*/

  printrus("<ul class=\"navs\"><li><a href=\"map.php?$ses\"><img src=\"/img/ico/map.png\" class=\"menu\" alt=\"\" />Карта мира</a></li></ul><br/>\n");
//  printrus ("<img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='moders.php?$ses'>Модераторы</a><br/><br/>");

  print iconv('cp1251','utf-8',"<ul class=\"navs\"><li><a href=\"online.php?str&amp;$ses\"><img src=\"/img/ico/onl.png\" class=\"menu\" alt=\"\" />Онлайн <span class=\"green\">(".online("c").")</span></a></li></ul>");
  //
  $cl = mysql_query("SELECT count(*) as num FROM `clans`");
  $cla = mysql_fetch_array($cl);
  printrus("<ul class=\"navs\"><li><a href=\"stats.php?go=clans&amp;$ses\"><img src=\"/img/ico/uzers.png\" class=\"menu\" alt=\"\" />Кланы <span class=\"low\">(".$cla['num'].")</span></a></li></ul>");
  //                    $_SESSION['userID']
  printrus ("<ul class=\"navs\"><li><a href='liders.php?$ses'><img src=\"/img/ico/rating.png\" class=\"menu\" alt=\"\" />Лидеры</a></li></ul><br/>");
  if($us['forum_news']>0){printrus("<ul class=\"navs\"><li><a href=\"news.php?fid=4&amp;$ses\"><img src=\"/img/ico/news.png\" alt=\"\" /><font color='#EE7621'>Новости <font color='#FF4040'>+".$us['forum_news']."</font></font></a><br /></li></ul>");}
  else{printrus("<ul class=\"navs\"><li><a href=\"news.php?fid=4&amp;$ses\"><img src=\"/img/ico/news.png\" alt=\"\" /><font color='#EE7621'>Новости</font></a><br /></li></ul>");}
/*
 printrus ("<a href=\"chat_3.php?$ses\"><font color='#EE7621'>Набор модераторов</font><br /><font color='#FF4040'>Заходим, оставляем свое резюме, <br />все модераторы получат реферальный код который им может принести реальные деньги, <br />отбор строгий.<br />+ за хорошую работу золото в игре Империя каждый день.</font></a><br/><br/>\n");
  */
   //printrus ("Предлагаете убрать при старте пустышек? Пишите в чат какие по названиям.<br/>\r\n");
  /*

 // printrus (" Тестите, если нужно построить пишите Админу. Здания построим.!<br/><br/>\r\n");
 // $obl=mktime(21, 0, 0, 2, 12, 2016)-time();// часы.минуты.секунды.месяц.день.год


   if($obl<=0)printrus("<img src=\"img/fy.gif\" alt=\"logo\"/><br />");else printrus("<font color='#EE7621'><a href=\"faq.php?m=video_vse_o_igre&amp;$ses\">Вся видео помощь по игре</a><br/>\n Заходим смотрим )?<font color='#FF4040'><br /><br /><br /></font></font>

 <font color='#EE7621'><br />Осталось до обнуления</font> <font color='#FF4040'>".mkTimeStr($obl)."</font><br /><br />");
  */
/*
 //Возраст страны
 $timecnt=time()-$b['reggedTime'];
 //printrus("Кто в контру будет? 46.158.151.253 заходите)<br />");
 printrus("<br/><span class=\"low\">Возраст страны: ".mkTimeStr($timecnt)."</span><br/>\r\n");*/
//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Мараторий ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 $mar = $b['reggedTime']+10800;
 if(time()<=$mar){
  $lft = $mar - time();
  printrus ("<u>Неприкосновенность</u><br/>\r\n");
  printrus ("Осталось ".mkTimeStr($lft)."<br/>\r\n");
  print "-----<br/>\r\n";
 }

 if ($b['moratory']<time()){
 if ($nightmar==TRUE){
    if (date("G")+0>=$b['mrt']) $tleft = 3600*6-((date("G")-$b['mrt'])*3600+date("i")*60+date("s"));
    if (date("G")+0<$b['mrt']) $tleft = (($b['mrt']+6)%24-1-date("G"))*3600+(59-date("i"))*60+59-date("s");
  printrus ("<font color='#EE7621'><u>Ночной мораторий</font></u><br/>\r\n");
  printrus ("<font color='#EE7621'>Осталось</font> <font color='#FF4040'>".mkTimeStr($tleft)."</font><br/>\r\n");
  print "-----<br/>\r\n";
    }
}else{
printrus("<font color='#EE7621'><u>Купленный мораторий:</font></u><br/>\r\n");
$tleft = $b['moratory']-time();
printrus ("<font color='#EE7621'>Осталось</font> <font color='#FF4040'>".mkTimeStr($tleft)."</font><br/>\r\n");
print "-----<br/>\r\n";
}



//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//войны:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $a=$mem;
    $warCount=count($mem);
    }else{

 $query="select targetID from `wars` where countryID='".$b["countryID"]."'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $warCount=@mysql_num_rows($result);
 $a=array();
 while (($s=mysql_fetch_array($result))!==FALSE){
 array_push($a,$s);
 }

 }

 if($warCount>0){
  printrus ("<u>Войны:</u><br/>\r\n");

  //$i=0;
  //while (($a=mysql_fetch_array($result))!==FALSE){
  for ($i=0;$i<count($a);$i++){
   $targetID=$a[$i]["targetID"];
   if($target=checkCountryID($targetID))
    printrus
("<img src=\"/img/ico/att.gif\" class=\"menu\" alt=\"\" /> <a href=\"war.php?$ses&amp;target=$targetID\">$target</a>
");
   if($i!=$warCount-1) print "|";
   //$i++;
  }
  print "<br/>-----<br/>\r\n";
 }


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//вторжения:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 $query="select countryID from `wars` where targetID='".$b["countryID"]."'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $attCount=@mysql_num_rows($result);
 $i=0;
 if($attCount>0){
  printrus ("<u>Вторжения:</u><br/>\r\n");

  while (($a=mysql_fetch_array($result))!==FALSE){
   $attackerID=$a["countryID"];
   if($attacker=checkCountryID($attackerID))
    printrus
("<img src=\"/img/ico/att.gif\" class=\"menu\" alt=\"\" /> <a href=\"attacks.php?$ses&amp;attacker=$attackerID\">$attacker</a>
");
   if($i!=$attCount-1) print "|";
   $i++;

  }

  print "<br/>-----<br/>\r\n";
 }


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//сообщения:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 $key=_PREFIKS.':messages'.$countryID;
 $mes_m=FALSE;
 if (($mem=$memcache->get($key))!==FALSE){
    $mes_m=TRUE;
    $count=0;
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='loose') {$count=1;$a=$mem[$i];break;}
    }else{

 $query="select * from `messages` where `countryID`='".$b["countryID"]."' and `from`='loose' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $count=@mysql_num_rows($result);
 $a = mysql_fetch_array($result);
 }

 if($count>0){

  if ($mes_m!=TRUE){
  $mem=array();
  $query="select * from `messages` where `countryID`='".$b["countryID"]."' and `from`!='loose'";
  $r = mysql_query($query);
  while (($s=mysql_fetch_array($r))!==FALSE){
  array_push($mem,$s);
  }

  }

  for ($i=(count($mem)-1);$i>=0;$i--){
  if ($mem[$i]['from']!='loose')exec_message($b['countryID'],$mem[$i],0);
          }

  exec_message($b['countryID'],$a,0);
 }

 //Выбираем из базы, т.к. считаем только непрочитанные сообщения
 $query="select count(*) as num from messages where countryID='".$b["countryID"]."'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $mesCount=$a['num'];

 if($mesCount>10){
  printrus
("<ul class=\"navs\"><li><a href='messages/view.php?$ses'>
<img src=\"/img/ico/message.png\" class=\"menu\" alt=\"\" />Почта <span class=\"white\">($mesCount)</span></a>
</li></ul>
-----<br/>
");
 }elseif($mesCount>1||$mesCount==0){
  printrus
("<ul class=\"navs\"><li><a href='messages/view.php?$ses'>
<img src=\"/img/ico/message.png\" class=\"menu\" alt=\"\" />Почта <span class=\"white\">($mesCount)</span></a>
</li></ul>
-----<br/>
");
 }elseif($mesCount==1){
  $query="select * from messages where countryID='".$b['countryID']."' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $a = mysql_fetch_array($result);
  exec_message($b['countryID'],$a,0);
 }

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Строящиеся здания:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 $result=returnProcess($b['countryID'],"building");
 if ($result!=FALSE)$buildings=count($result); else $buildings=0;

 if($buildings>0){

  for ($i=0;$i<count($result);$i++){
   $building=$result[$i]["what"];
   $started=$result[$i]["started"];
   $finished=$result[$i]["finished"];
   $var1=$result[$i]["var1"];
   $var2=$result[$i]["var2"];
   $percent=getWorkPercent($started,$finished,date("U"));

   printrus
("<b></b><ul class=\"navs\"><li><a href=\"works.php?kind=building&amp;what=$building&amp;$ses\"><img src=\"/img/ico/$building.png\" class=\"menu\" alt=\"\" />".printBuilding($building)." <span class=\"white\">(<b>$percent</b>%)</span></a>
<b></b>
</li></ul>
");
  }
 }

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Здания::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 $uz=UzersInfo($b['countryID']);
 $result=returnBuildings($b['countryID']);
 $buildings=count($result);

 if($buildings>0){
  for ($i=0;$i<count($result);$i++){
   $building=$result[$i]["building"];
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $repCount=0;
      for ($j=0;$j<count($mem);$j++) if ($mem[$j]['kind']=='repairing'&&$mem[$j]['what']==$building){$repCount=1;$started=$mem[$j]['started'];$finished=$mem[$j]['finished'];break;}
      }else{

   $query="select started,finished from works where countryID='".$b['countryID']."' and kind='repairing' and what='$building' LIMIT 1";
   $result_=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $repCount=@mysql_num_rows($result_);
   $started=@mysql_result($result_,0,"started");
   $finished=@mysql_result($result_,0,"finished");
   }

   if($repCount<=0){
    $guard=mkWarning($result[$i]["guard"]+$result[$i]['guard_2']+$result[$i]['guard_3']+$result[$i]['guard_4']+$result[$i]['guard_5']+$result[$i]['guard_6']+$result[$i]['guard_7']+$result[$i]['guard_8']);
    printrus
("<ul class=\"navs\"><li><a href='buildings/$building.php?$ses'>
<img src=\"/img/ico/$building.png\" class=\"menu\" alt=\"\" />".printBuilding($building)." <span class=\"white\">[$guard]</span></a>
</li></ul>
");
   }else{
    //$started=@mysql_result($result_,0,"started");
    //$finished=@mysql_result($result_,0,"finished");
    $percent=getWorkPercent($started,$finished,date("U"));

    printrus
("<b>(</b><ul class=\"navs\"><li><a href='buildings/$building.php?$ses'>
<img src=\"/img/ico/build.png\" class=\"menu\" alt=\"\" />".printBuilding($building)." <span class=\"white\">[<b>$percent</b>%]</span></a>
<b>)</b></li></ul>
");
   }
  }
 }
 $bldstring='';
 for ($i=0;$i<count($result);$i++){
          $bldstring.=$result[$i]['building'];
          }

 $result=returnProcess($b['countryID'],"building");
 for ($i=0;$i<count($result);$i++){
          $bldstring.=$result[$i]['what'];
          }
 $num = 0;
 if (strpos($bldstring,'barracks')!==FALSE || strpos($bldstring,'warhouse')!==FALSE) $num++;
 if (strpos($bldstring,'scientificcenter')!==FALSE || strpos($bldstring,'university')!==FALSE) $num++;
 if (strpos($bldstring,'citadel')!==FALSE || strpos($bldstring,'ratusha')!==FALSE) $num++;
 if (strpos($bldstring,'market')!==FALSE || strpos($bldstring,'keeping')!==FALSE) $num++;
 if (strpos($bldstring,'fabrika')!==FALSE || strpos($bldstring,'zavod')!==FALSE) $num++;
 if (strpos($bldstring,'magictower')!==FALSE || strpos($bldstring,'gorodmagov')!==FALSE) $num++;
 if (strpos($bldstring,'village')!==FALSE) $num++;
 if (strpos($bldstring,'wall')!==FALSE) $num++;
 if (strpos($bldstring,'neftevxwka')!==FALSE) $num++;
 if ($uz['race'] == 1 and strpos($bldstring,'altar')!==FALSE) $num++;
 if ($uz['race'] == 2 and strpos($bldstring,'farm')!==FALSE) $num++;
 if ($uz['race'] == 3 and strpos($bldstring,'necropolis')!==FALSE) $num++;
 if ($uz['race'] == 4 and strpos($bldstring,'dungeon')!==FALSE) $num++;

 if($num<10){
  printrus
("<ul class=\"navs\"><li><a href='buildings.php?$ses'>
<img src=\"/img/ico/built.png\" class=\"menu\" alt=\"\" />Построить...</a>
</li></ul>
");
 }

 print "-----<br/>";


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//деньги::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//if (_SHOP=="off")printrus ("<ul class=\"navs\"><li><a href='bonus.php?$ses'><img src=\"/img/ico/cr3.png\" class=\"menu\" alt=\"\" />Купить алмазы <span class=\"red\">(Акция)</span></a></li></ul>");
if (_SHOP=="off")printrus ("<ul class=\"navs\"><li><a href='bonus.php?$ses'><img src=\"/img/ico/cr3.png\" class=\"menu\" alt=\"\" />Сохранить страну</a></li></ul>");


// printrus ("Деньги (".$b['money'].")<br/>");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//население:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 //$people=$b['workers']+$b['scientists']+$b['wariors_atall']+$b['wariors_atall_2']+$b['wariors_atall_3'];

 printrus
("<ul class=\"navs\"><li><a href='people.php?$ses'>
<img src=\"/img/ico/uzers.png\" class=\"menu\" alt=\"\" />Население</a>
</li></ul>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//земелька::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 $AllLand=mkWarning($b['land']+$b['mountains']+$b['forest']);
 $FreeLand=mkWarning(countFreeLand($b['countryID']));

 printrus
("<ul class=\"navs\"><li><a href='land.php?$ses'>
<img src=\"/img/ico/grain3.png\" class=\"menu\" alt=\"\" />Земля <span class=\"white\">($FreeLand/$AllLand)</span></a>
</li></ul>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если нет хранилища или рынка, пишем о ресурсах сдесь::::::::::::::::::::::::::

 $key=_PREFIKS.':buildings'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $bld_is=0;
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='market'||$mem[$i]['building']=='keeping') {$bld_is=1;break;}
    }else{

 $query="select * from `buildings` where countryID='$countryID' and (building='market' or building='keeping') limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $bld_is=mysql_num_rows($result);
 }

 if($bld_is<=0){
  printrus
("<ul class=\"navs\"><li><a href='resources.php?$ses'>
<img src=\"/img/ico/resources.png\" class=\"menu\" alt=\"\" />Ресурсы</a>
</li></ul>
");
 }


 printrus
("<ul class=\"navs\"><li><a href=logs_view.php?action=view&countryName=".$GLOBALS['b']['countryName'].">Проверка захватов
</a></li></ul>
");


//}
//=============================================================================//Конец скрипту================================================================print "---<br/>\r\n";
//printrus ("<a href='dell.php?$ses'>Удаления</a>\n");

//printrus("<a href='profile.php?$ses'>Профиль</a><br/>-----<br/>");
//printrus ("<a href='moders.php?$ses'>Стражи порядка</a><br/>");
//if (_SHOP=="on")printrus ("<a href='shop.php?$ses'>Магазин</a><br/>");
//if (_SHOP=="off")printrus ("<a href='bonus.php?$ses'>Купить алмазы</a>");

//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");

 //print "<br/>\r\n";

//футер страницы:
include_once("other_inc/footer.php");
?>