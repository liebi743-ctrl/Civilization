<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['peopleto'])) $peopleto = $_REQUEST['peopleto'];
if (isset($peopleto)&& !is_numeric($peopleto))$peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['building'])) $building = $_REQUEST['building'];
if (isset($building)&&$building!='barracks'&&$building!='ratusha'&&$building!='university'&&$building!='keeping'&&$building!='village'&&$building!='wall'&&$building!='fabrika'&&$building!='magictower'&&$building!='neftevxwka'&&$building!='altar'&&$building!='farm'&&$building!='necropolis'&&$building!='dungeon') exit;
  if(isset($_GET['clv']))$dddd="?clv=".$_GET['clv'];
//==============================================================================
//подключаем скрипты

$peopleto=@round( (int) $peopleto);

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
 if(isset($_SESSION['dies']))header("Location: profile.php$dddd");
//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

 $b=CountryInfo($countryID);
 isAuthed();
 $uz=UzersInfo($countryID);
//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

//узнаем, какие ваще здания есть в стране:
$bldstring=array();
 $result=returnBuildings($b['countryID']);
  for ($i=0;$i<count($result);$i++){
          //$bldstring.=$result[$i]['building'];
          array_push($bldstring,$result[$i]['building']);
          }
  $exists = $bldstring; //Здания, которые уже построены
  $country_land = countAllLand($b['countryID'],TRUE);

  $result = returnProcess($b['countryID'],'building');
          for ($i=0;$i<count($result);$i++){
          //$bldstring.=$result[$i]['what'];
          array_push($bldstring,$result[$i]['what']);
          }

 if (!isset($building)){

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//подефолту:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

  if (!in_array('barracks',$bldstring)&&!in_array('warhouse',$bldstring)){
   printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=barracks&amp;$ses\"><img src=\"/img/pic/barracks.png\" alt=\".\" />Казармы</a></li></ul>
");
  }
  if (!in_array('ratusha',$bldstring)&&!in_array('citadel',$bldstring)){
printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=ratusha&amp;$ses\"><img src=\"/img/pic/ratusha.png\" alt=\".\" />Ратуша</a></li></ul>
");
  }
  if (!in_array('university',$bldstring)&&!in_array('scientificcenter',$bldstring)){
   printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=university&amp;$ses\"><img src=\"/img/pic/university.png\" alt=\".\" />Университет</a></li></ul>
");
  }
  if (!in_array('village',$bldstring)){
   printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=village&amp;$ses\"><img src=\"/img/pic/village.png\" alt=\".\" />Деревня</a></li></ul>
");
  }
  if (!in_array('keeping',$bldstring)&&!in_array('market',$bldstring)){
  	printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=keeping&amp;$ses\"><img src=\"/img/pic/keeping.png\" alt=\".\" />Хранилище</a></li></ul>
");
  }
  if (!in_array('wall',$bldstring)){
   printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=wall&amp;$ses\"><img src=\"/img/pic/wall.png\" alt=\".\" />Стена</a></li></ul>
");
  }
  if (!in_array('fabrika',$bldstring)&&!in_array('zavod',$bldstring)){
   printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=fabrika&amp;$ses\"><img src=\"/img/pic/fabrika.png\" alt=\".\" />Фабрика</a></li></ul>
");
  }
  if (!in_array('magictower',$bldstring)&&!in_array('gorodmagov',$bldstring)){
   printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=magictower&amp;$ses\"><img src=\"/img/pic/magictower.png\" alt=\".\" />Башня магов</a></li></ul>
");
  }
  if (!in_array('neftevxwka',$bldstring)){
   printrus
("<ul class=\"navs\"><li><a href=\"buildings.php?building=neftevxwka&amp;$ses\"><img src=\"/img/pic/neftevxwka.png\" alt=\".\" />Нефтевышка</a></li></ul>
");
  }

  if($uz['race'] == 1 and !in_array('altar',$bldstring)){  printrus("<ul class=\"navs\"><li><a href=\"buildings.php?building=altar&amp;$ses\"><img src=\"/img/pic/altar.png\" alt=\".\" />Алтарь смерти</a></li></ul>");
  }
  if($uz['race'] == 2 and !in_array('farm',$bldstring)){
  printrus("<ul class=\"navs\"><li><a href=\"buildings.php?building=farm&amp;$ses\"><img src=\"/img/pic/farm.png\" alt=\".\" />Ферма</a></li></ul>");
  }
  if($uz['race'] == 3 and !in_array('necropolis',$bldstring)){
  printrus("<ul class=\"navs\"><li><a href=\"buildings.php?building=necropolis&amp;$ses\"><img src=\"/img/pic/necropolis.png\" alt=\".\" />Некрополь</a></li></ul>");
  }
  if($uz['race'] == 4 and !in_array('dungeon',$bldstring)){
  printrus("<ul class=\"navs\"><li><a href=\"buildings.php?building=dungeon&amp;$ses\"><img src=\"/img/pic/dungeon.png\" alt=\".\" />Подземелье</a></li></ul>");
  }

  print "---<br/>\r\n";
}else{

if ($building=='fabrika' && !in_array('scientificcenter',$exists)){
printrus("Для постройки фабрики необходим научный центр!<br/>\r\n");
}elseif ($building=='magictower' && (!in_array('scientificcenter',$exists)||$b['science']<40)){
printrus("Для постройки башни магов необходим научный центр и уровень науки не менее 40!<br/>\r\n");
}elseif (($building=='altar' and $uz['race']!=1) or ($building=='farm' and $uz['race']!=2) or ($building=='necropolis' and $uz['race']!=3) or ($building=='dungeon' and $uz['race']!=4)){
printrus("У вашей расы нет такого здания!<br/>\r\n");
}else{

//СТроительство зданий
require ($_SERVER['DOCUMENT_ROOT'].'/b_params.php');

$s=$building.'_money';
$money=$$s;
$s=$building.'_stone';
$stone=$$s;
$s=$building.'_iron';
$iron=$$s;
$s=$building.'_arbor';
$arbor=$$s;
$s=$building.'_grain';
$grain=$$s;
$s=$building.'_oil';
$oil=$$s;
$s=$building.'_land';
$land=$$s;
$s=$building.'_time';
$time=$$s;



printrus ("<u>".printBuilding($building)."</u><br/>\r\n");
  if(in_array($building,$bldstring) || in_array(get_upgrade_build($building),$bldstring)){
   printrus ("Здание или его улучшение уже имеются в стране!<br/>\r\n");
  }elseif($b['workers']<=0){
   printrus ("У вас нет рабочих!<br/>\r\n");
  }elseif(empty($peopleto) || $peopleto==0){
   printrus(res_print($money,$stone,$iron,$arbor,$grain,$oil).'<br/>');
   printrus ("земля: <b>$land</b><br/>\r\n");
   printrus ("рабочие: <br/>\r\n");
   printrus ("<form name=\"\" action=\"buildings.php?$ses\" method=\"post\">
   <input format='*N' name='peopleto' /><br/>\r\n
   <input name=\"building\" type=\"hidden\" value=\"$building\"/>
   <input type=\"submit\" value=\"Строить\"/>
   </form>");

  }elseif($peopleto>($workers_max*$land)){
   printrus ("Над этим зданием может работать только <b>".($workers_max*$land)."</b> рабочих!<br/>\r\n");
   if(($workers_max*$land)<=$b['workers']){
    printrus
("<a href=\"buildings.php?building=$building&amp;peopleto=".($workers_max*$land)."&amp;$ses\">К работе всех</a><br/>
");
   }else{
    printrus ("Но у вас всего <b>".$b['workers']."</b>.<br/>\r\n");
    printrus
("<a href=\"buildings.php?building=$building&amp;peopleto=".$b['workers']."&amp;$ses\">К работе всех</a><br/>
");
   }
  }elseif($b['arbor']<$arbor){
   printrus ("Не хватает дерева для постройки этого здания!<br/>(необходимо <b>$arbor</b>)<br/>\r\n");
  }elseif($b['stone']<$stone){
   printrus ("Не хватает камня для постройки этого здания!<br/>(необходимо <b>$stone</b>)<br/>\r\n");
  }elseif($b['iron']<$iron){
   printrus ("Не хватает железа для постройки этого здания!<br/>(необходимо <b>$iron</b>)<br/>\r\n");
  }elseif($b['money']<$money){
   printrus ("Не хватает денег для постройки этого здания!<br/>(необходимо <b>$money</b>)<br/>\r\n");
  }elseif($b['oil']<$oil){
   printrus ("Не хватает нефти для постройки этого здания!<br/>(необходимо <b>$oil</b>)<br/>\r\n");
  }elseif(countFreeLand($b['countryID'])<$land){
   printrus ("Недостаточно свободного пространства для постройки этого здания!<br/>(необходимо <b>$land</b>)<br/>\r\n");
  }elseif($b['workers']<$peopleto){
   printrus ("У вас нет столько рабочих!<br/>(всего: <b>".($b['workers'])."</b>)<br/>\r\n");
   printrus
("<a href=\"buildings.php?building=$building&amp;peopleto=".$b['workers']."&amp;$ses\">Использовать всех</a><br/>
");
  }else{
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET arbor = arbor - $arbor, money = money - $money,
   stone = stone - $stone, iron = iron - $iron, oil = oil - $oil,
   workers = workers - $peopleto
   WHERE countryID = '".$b["countryID"]."'");
   $b['arbor'] = $b['arbor'] - $arbor;
   $b['stone'] = $b['stone'] - $stone;
   $b['iron'] = $b['iron'] - $iron;
   $b['money'] = $b['money'] - $money;
   $b['oil'] = $b['oil'] - $oil;
   $b['workers'] = $b['workers'] - $peopleto;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
   //просчитываем,скока понадобится времени для постройки зданий:
   if($building == 'altar' or $building == 'farm' or $building == 'necropolis' or $building == 'dungeon'){
   $work_time=round($time/$peopleto*34);
   }else{$work_time=round($time/$peopleto);}
   //записываем в мускул, что здание строится:
   $query="insert into works values('$countryID','building','$building',$peopleto,".date(U).",".($work_time+date(U)).",0,0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'building', "what"=>$building, "peopleatwork"=>$peopleto, "started"=>date(U), "finished"=>($work_time+date(U)),"var1"=>0, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   //все окичикипуки:
   printrus (printBuilding($building)." будет построен через ".mkTimeStr($work_time)."<br/>\r\n");
 //Пишем в лог работ:
 @$open=fopen("logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."строит $building $peopleto рабочими.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);


  }
}
  print "---<br/>\r\n";
  printrus
("
<a href='buildings.php?$ses'>&lt;&lt;к выбору</a>
<br/>
");
}


//==============================================================================
//Конец скрипту=================================================================
printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");

?>
