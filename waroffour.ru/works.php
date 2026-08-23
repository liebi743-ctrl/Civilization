<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['kind'])) $kind = $_REQUEST['kind'];
if (isset($kind)&&$kind!='building'&&$kind!='newplace')exit;
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['peopleto'])) $peopleto = $_REQUEST['peopleto'];
if (isset($peopleto) && !is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what) && ($what!='barracks'&&$what!='citadel'&&$what!='keeping'&&$what!='market'&&$what!='ratusha' &&$what!='scientificcenter' &&$what!='university' &&$what!='village' &&$what!='wall' &&$what!='warhouse'&&$what!='neftevxwka'&&$what!='fabrika'&&$what!='zavod'&&$what!='magictower'&&$what!='gorodmagov'&&$what!='oil'&&$what!='altar'&&$what!='farm'&&$what!='necropolis'&&$what!='dungeon')) exit;
if (isset($_REQUEST['minus'])) $m ='minus';
if (isset($_REQUEST['plus'])) $m ='plus';
//==============================================================================
//подключаем скрипты

$peopleto=round( (int) $peopleto);

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];
worksRefresh($countryID);

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

//worksRefresh($b['countryID']);


//******************************************************************************
//проверка на валидность идентификатора:****************************************

 if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  print "<br/>-------<br/>\r\n";
  printrus ("<br/><a href='index.php'>Назад</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 $countryID = $_SESSION['countryID'];

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

// switch($kind):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//показываем инфу о постройках::::::::::::::::::::::::::::::::::::::::::::::::::
// case('building'):


 if ($kind=='building' OR $kind=='newplace')
 {

  $result=returnProcess($countryID,$kind,$what);
  $started=$result[0]['started'];
  $finished=$result[0]['finished'];
  $now=time();
  $building=$result[0]['what'];
  $peopleatwork=$result[0]['peopleatwork'];
  $building_land=$what."_land";
  if ($what <> 'oil')
  {
      printrus ("Строится: <u>".printBuilding($what)."</u><br/>\r\n");
  }
  else
  {
      printrus ("Разработка месторождения:<br/>\r\n");
  }

  if($now>=$finished){
   printrus ("Работа завершена!<br/>");
  }elseif(empty($m) || (($peopleto==0 || empty($peopleto)) && $m!="break")){
   $percent=getWorkPercent($started,$finished,$now);

   printrus ("До завершения: ".mkTimeStr(($finished-$now))."<br/>\r\n");

   printrus ("Рабочие: <b>$peopleatwork</b><br/>\r\n");
   printrus ("<form name=\"\" action=\"works.php?kind=$kind&amp;what=$building&amp;$ses\" method=\"post\">
<input format='*N' name='peopleto'/> \r\n
<input name=\"plus\" type=\"submit\" value=\"+\"/>/
<input name=\"minus\" type=\"submit\" value=\"-\"/>
</form>");

  }elseif($m=="plus" && $peopleto>$b["workers"]){

   printrus ("До завершения: ".mkTimeStr(($finished-$now))."<br/>\r\n");

   printrus ("У вас нет столько рабочих!<br/>\r\n");
   $freeWorkers=$b["workers"];
   printrus ("Свободно: <b>$freeWorkers</b><br/>\r\n");
   if($freeWorkers!=0){
    printrus ("<form name=\"\" action=\"works.php?kind=$kind&amp;what=$building&amp;$ses\" method=\"post\">
<input name=\"m\" type=\"hidden\" value=\"plus\"/>
<input name=\"peopleto\" type=\"hidden\" value=\"$freeWorkers\"/>
<input  type=\"submit\" value=\"Добавить всех\"/>
</form>");


   }else{
    printrus
("<a href=\"works.php?kind=$kind&amp;what=$building&amp;$ses\">Ок</a><br />
");
   }

  }elseif(   ($m=="plus" && ($peopleto+$peopleatwork)>($workers_max*$$building_land))  AND $what<>'oil' ){

   printrus ("Над этим зданием может работать только <b>".($workers_max*$$building_land)."</b> рабочих!<br/>\r\n");
   if(($peopleto+$peopleatwork)>=($workers_max*$$building_land)){
    printrus
("<a href=\"works.php?kind=$kind&amp;what=$building&amp;m=plus&amp;peopleto=".($workers_max*$$building_land-$peopleatwork)."&amp;$ses\">К работе всех!</a><br />
");
   }else{
    printrus ("Но у вас только <b>$people</b> рабочих.<br/>\r\n");
    printrus
("<a href=\"works.php?kind=$kind&amp;what=$building&amp;m=plus&amp;peopleto=".$people."&amp;$ses\">К работе всех!</a><br />
");
   }
   printrus
("<a href=\"works.php?kind=$kind&amp;what=$building&amp;$ses\">Отмена</a><br />
");

  }elseif($m=="plus"){

   $freeWorkers=$b["workers"];
   mysql_query("UPDATE countries SET workers = workers-$peopleto WHERE countryID = '".$countryID."'");
   $b['workers'] = $b['workers'] - $peopleto;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $newFinished=round(($finished-$now)*($peopleatwork/($peopleto+$peopleatwork))+$now);


   if($newFinished<=$now){
    $newFinished=$now+60;
   }

   mysql_query("UPDATE works SET finished = $newFinished, peopleatwork = ($peopleto+$peopleatwork) WHERE countryID = '".$countryID."' and kind = '$kind' and what = '$what'");
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=="$kind"&&$mem[$i]['what']==$what){
          $mem[$i]['peopleatwork']=$peopleto+$peopleatwork;
          $mem[$i]['finished']=$newFinished;
          break;
          }
    $memcache->set($key,$mem,false,86400);
      }

   printrus ("До завершения: ".mkTimeStr(($newFinished-$now))."<br/>\r\n");
   printrus ("Теперь за работой <b>".($peopleto+$peopleatwork)."</b> человек<br/>\r\n");

  }elseif($m=="minus" && $peopleto>$peopleatwork){

   printrus ("До завершения: ".mkTimeStr(($finished-$now))."<br/>\r\n");

   printrus ("Над зданием работают только <b>$peopleatwork</b> рабочих!<br/>\r\n");
   printrus ("<a href=\"works.php?kind=$kind&amp;what=$building&amp;m=minus&amp;peopleto=$peopleatwork&amp;$ses\">Прервать</a><br />");

  }elseif($m=="minus" && $peopleto==$peopleatwork){

   printrus ("До завершения: ".mkTimeStr(($finished-$now))."<br/>\r\n");

   printrus ("Вы уверены, что хотите прекратить работу?<br/>\r\n");
    printrus ("<a href=\"works.php?kind=$kind&amp;what=$building&amp;m=break&amp;$ses\">Да</a><br />");
    printrus ("<a href=\"works.php?kind=$kind&amp;what=$building&amp;$ses\">Нет</a><br />");

  }elseif($m=="minus"){

   $freeWorkers=$b["workers"];
   mysql_query("UPDATE countries SET workers = workers+$peopleto WHERE countryID = '".$countryID."'");
   $b['workers'] = $b['workers'] + $peopleto;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $newFinished=round(($finished-$now)*($peopleatwork/($peopleatwork-$peopleto))+$now);


   if($newFinished<=$now){
    $newFinished=$now+30;
   }

   mysql_query("UPDATE works SET finished = $newFinished, peopleatwork = ($peopleatwork - $peopleto) WHERE countryID = '".$countryID."' and kind = '$kind' and what = '$what'");
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=="$kind"&&$mem[$i]['what']==$what){
          $mem[$i]['peopleatwork']=$peopleatwork - $peopleto;
          $mem[$i]['finished']=$newFinished;
          break;
          }
    $memcache->set($key,$mem,false,86400);
      }

   printrus ("До завершения: ".mkTimeStr(($newFinished-$now))."<br/>\r\n");
   printrus ("Теперь за работой <b>".($peopleatwork-$peopleto)."</b> человек<br/>\r\n");

  }elseif($m=="break"){

   $query="delete from works where countryID='".$b['countryID']."' and kind='$kind' and what='$what' limit 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=="$kind"&&$mem[$i]['what']==$what){
          }else array_push($neww,$mem[$i]);
    $memcache->set($key,$neww,false,86400);
      }

   $freeWorkers=$b["workers"];
   mysql_query("UPDATE countries SET workers = ($freeWorkers+$peopleatwork) WHERE countryID = '".$countryID."'");
   $b['workers'] = $freeWorkers+$peopleatwork;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Постройка прекращена!<br/>\r\n");

  }



}

// break;













// endswitch;


//=============================================================================//Конец скрипту================================================================print "---<br/>\r\n";
printrus
("
<a href='buildings.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");





/*                      НЕМНОГО ТЕОРИИ:


                                                         начальное                      конечное
 начало                 настоящий                     значение времени               значение времени
 работы                  момент                      завершения работы              завершения работы
    |                      |                                 |                            |
   [S]::::::::::::::::::::[N]:::::::::::::::::::::::::::::::[F]=========================[F`]------------------------------------------>
    |         (w1)         |              (w1)               |                            |                                      ось времени
    \__________  __________/                                 |                            |
    |          \/          \________________  _______________/                            |
    |     проделанная      |                \/                                            |
            работа         |   работа, которую осталось доделать                          |
                           |     до изменения числа рабочих                               |
                           |                             (w2)                             |
                           \______________________________  ______________________________/
                                                          \/
    |                                                                                     |
    \________________________________________  ___________________________________________/
                                             \/


           F`=F*(W1/W2)+N

           F`/W1 = F/W2 - N/W1



*/
















?>
