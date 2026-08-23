<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['neighbour'])) $neighbour = $_REQUEST['neighbour'];

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);
 $scientiststo=round( (int) $scientiststo);
 $moneyto=round( (int) $moneyto);
 $wariorsto=round( (int) $wariorsto);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();
//worksRefresh($_SESSION['countryID']);

//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();
$us=UzersInfo($countryID);

 if (isset($neighbour)){
 $neighbourID=$neighbour;
 $neighbourInfo=CountryInfo($neighbourID);
 }


 $countryID = $_SESSION['countryID'];


//******************************************************************************
//проверка на наличие здания:****************************************

 build_exists_print($countryID,'ratusha');


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Ратуша</u><br/>\r\n");

 $noob=$_SESSION['noob'];

 $wariors_free=$b["wariors_free"];
 $wariors_free_2=$b["wariors_free_2"];
 $wariors_free_3=$b["wariors_free_3"];
 $wariors_free_4=$b["wariors_free_4"];
 $wariors_free_5=$b["wariors_free_5"];
 $wariors_free_6=$b["wariors_free_6"];
 $wariors_free_7=$b["wariors_free_7"];
 $wariors_free_8=$b["wariors_free_8"];
 $weapon_kind=$b["weapon_kind"];
 $bronya_kind=$b["bronya_kind"];

 $weapon_force=$b["weapon_force"];
 $weapon_force_2=$b["weapon_force_2"];
 $weapon_force_3=$b["weapon_force_3"];
 $weapon_force_4=$b["weapon_force_4"];
 $weapon_force_5=$b["weapon_force_5"];
 $weapon_force_6=$b["weapon_force_6"];
 $weapon_force_7=$b["weapon_force_7"];
 $weapon_force_8=$b["weapon_force_8"];
 $weapon_speed=$b["weapon_speed"];
 $weapon_speed_2=$b["weapon_speed_2"];
 $weapon_speed_3=$b["weapon_speed_3"];
 $weapon_speed_4=$b["weapon_speed_4"];
 $weapon_speed_5=$b["weapon_speed_5"];
 $weapon_speed_6=$b["weapon_speed_6"];
 $weapon_speed_7=$b["weapon_speed_7"];
 $weapon_speed_8=$b["weapon_speed_8"];

 $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];

is_repairing($countryID,'ratusha',$m);

  if($att_nz=isNewBuildings($countryID,'altar')){
  if(($att_nz['time_uz']+259200) > time()){$plus_altar=10;}else{$plus_altar=0;}
  }

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
  printrus
("<a href=\"guard.php?$ses&amp;bld=ratusha\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  if($noob>=1)
   printrus
("[<a href=\"ratusha.php?$ses&amp;m=help&amp;n=spy\">?</a>]
");
  printrus ("<u>Шпионаж</u> [".$b["spy"]."%]\r\n");
  if ($plus_altar >0){printrus ("+10)=".($b["spy"]+=10)."\r\n");}
  if($b["spy"]<100)
   printrus
("<a href=\"ratusha.php?$ses&amp;m=spyup\">^</a>

");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"ratusha.php?$ses&amp;m=help&amp;n=sabotage\">?</a>]
");
  printrus ("<u>Саботаж</u> [".$b["sabotage"]."%]\r\n");
  if ($plus_altar >0){printrus ("+10)=".($b["sabotage"]+=10)."\r\n");}
  if($b["sabotage"]<100)
   printrus
("<a href=\"ratusha.php?$ses&amp;m=sabotageup\">^</a>");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"ratusha.php?$ses&amp;m=help&amp;n=grab\">?</a>]
");
  printrus ("<u>Воровство</u> [".$b["grabber"]."%]\r\n");
  if ($plus_altar >0){printrus ("+10)=".($b["grabber"]+=10)."\r\n");}
  if($b["grabber"]<100)
   printrus
("<a href=\"ratusha.php?$ses&amp;m=grabberup\">^</a>
");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"ratusha.php?$ses&amp;m=help&amp;n=verb\">?</a>]
");
  printrus ("<u>Вербовка</u> [".$b["verb"]."%]\r\n");
  if ($plus_altar >0){printrus ("+10)=".($b["verb"]+=10)."\r\n");}
  if($b['verb']<100)
   printrus
("<a href=\"ratusha.php?$ses&amp;m=verbup\">^</a>

");
  print "<br/>\r\n";

  printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours\">Соседи...</a>
<br/>
");
  if($hits<100){
   printrus
("<a href=\"ratusha.php?$ses&amp;m=repaire\">Починить...</a>
(".mkWarning($hits)."%)
<br/>
");
  }elseif(!builds($countryID,'citadel')){
   printrus
("<a href=\"ratusha.php?$ses&amp;m=upgraide\">Строить улучшение (Цитадель)</a>
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'ratusha',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//апгрейдим здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('upgraide'):
  build_upgrade($countryID,'citadel','ratusha');
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//шпионаж:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('spyup'):

 $lvl_up=min(5,100-$b["spy"]);
  $mnd=$b["spy"]*$b["spy"]*$lvl_up;
  if ($b['spy']>50) $mnd = $mnd*(round($b['spy']/15)-1);
  if(empty($n)){
   printrus ("Шпионаж: (+$lvl_up %)<br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($money>=$mnd){
    printrus
("<a href=\"ratusha.php?$ses&amp;m=spyup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='ratusha.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure' && $money<$mnd){
   printrus ("У вас не достаточно денег! (Необходимо: <b>$mnd</b>)<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure'){
   mysql_query("UPDATE countries SET money=($money - $mnd), spy = spy + $lvl_up WHERE countryID='".$b['countryID']."' LIMIT 1");
   $b['money'] = $money - $mnd;
   $b['spy'] = $b['spy'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень шпионажа: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Саботаж:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('sabotageup'):

  $lvl_up=min(5,100-$b["sabotage"]);
  $mnd=$b["sabotage"]*$b["sabotage"]*$lvl_up;
  if ($b['sabotage']>50) $mnd = $mnd*(round($b['sabotage']/15)-1);
  if(empty($n)){
   printrus ("Саботаж: (+$lvl_up %)<br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($money>=$mnd){
    printrus
("<a href=\"ratusha.php?$ses&amp;m=sabotageup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='ratusha.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure' && $money<$mnd){
   printrus ("У вас не достаточно денег! (Необходимо: <b>$mnd</b>)<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure'){
   mysql_query("UPDATE countries SET money=($money - $mnd), sabotage = sabotage + $lvl_up WHERE countryID='".$b['countryID']."' LIMIT 1");
   $b['money'] = $money - $mnd;
   $b['sabotage'] = $b['sabotage'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень саботажа: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//ВОровство:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('grabberup'):

  $lvl_up=min(5,100-$b["grabber"]);
  $mnd=$b["grabber"]*$b["grabber"]*$lvl_up;
  if ($b['grabber']>50) $mnd = $mnd*(round($b['grabber']/15)-1);
  if($n=='sure'){
   if ($b['money']>=$mnd){
   mysql_query("UPDATE countries SET money=money - $mnd, grabber = grabber + $lvl_up WHERE countryID='".$b['countryID']."' LIMIT 1");
   $b['money'] = $b['money'] - $mnd;
   $b['grabber'] = $b['grabber'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень воровства: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>Ок</a>
<br/>
");
}else{
      printrus ("У вас недостаточно денег!<br/>\r\n");
        }

  }else{
   printrus ("Воровтсво: (+$lvl_up %)<br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($b['money']>=$mnd){
    printrus
("<a href=\"ratusha.php?$ses&amp;m=grabberup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='ratusha.php?$ses'>Отмена</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Вербовка::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('verbup'):

  $lvl_up=min(5,100-$b["verb"]);
  $mnd=$b["verb"]*$b["verb"]*$lvl_up;
  if ($b['verb']>50) $mnd = $mnd*(round($b['verb']/15)-1);
  if($n=='sure'){
   if ($b['money']>=$mnd){
   mysql_query("UPDATE countries SET money=money - $mnd, verb = verb + $lvl_up WHERE countryID='".$b['countryID']."' LIMIT 1");
   $b['money'] = $b['money'] - $mnd;
   $b['verb'] = $b['verb'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень вербовки: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>Ок</a>
<br/>
");
   }else{
        printrus ("У вас недостаточно денег!<br/>\r\n");
           }

  }else{
   printrus ("Вербовка: (+$lvl_up %)<br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($b['money']>=$mnd){
    printrus
("<a href=\"ratusha.php?$ses&amp;m=verbup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='ratusha.php?$ses'>Отмена</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Соседи::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('neighbours'):
  if(!empty($neighbour)){
   //$query="select * from `countries` where countryID='$neighbourID' limit 1";
   //$result=@MYSQL_QUERY($query);
   //$countryName=@mysql_result($result,0,"countryName");

   printrus ("Сосед: [<u>".$neighbourInfo['countryName']."</u>]<br/>\r\n");
  }

  if(empty($n)){

   /*
   $neighbours=returnNeighbours($countryID);
   for($i=0;$i<count($neighbours);$i++){
    $countryName = $neighbours[$i];
    printrus
("<anchor>
$countryName
<go href='ratusha.php?$ses' method='post'>
<postfield name='m' value='neighbours'/>
<postfield name='n' value='info'/>");
$nbr = getCountryID($neighbours[$i]);
print "
<postfield name='neighbour' value='".$nbr."'/>
</go>
</anchor>
<br/>
";
   }
   */

  $neighbours = array();
  $nids = array();
  $key=_PREFIKS.':neighs'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++){
         array_push($nids,$mem[$i]);
         array_push($neighbours,checkCountryID($mem[$i]));
         }
     }else{
  $r = mysql_query("SELECT countryID FROM `neighbours` WHERE neighbourID = '$countryID'");
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($neighbours,checkCountryID($a[0]));
          array_push($nids,$a[0]);
          }
  }

  for($i=0;$i<count($neighbours);$i++){
    $countryName = $neighbours[$i];
    $nbr= $nids[$i];
    printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$nbr\">$countryName</a>
");

$key=_PREFIKS.':clans'.$nbr;
if (($mem=$memcache->get($key))!==FALSE){
   $clanID = $mem;
   }else{
   $z = mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$nbr' LIMIT 1");
   $s = mysql_fetch_array($z);
   $clanID = $s['clanID'];
   }
if ($clanID!=0){
   $z = mysql_query("SELECT * FROM `clans` WHERE id = '$clanID' LIMIT 1");
   $s = mysql_fetch_array($z);
   $clanName = $s['name'];
   printrus
("<b>{</b><a href=\"../viewclan.php?$ses&amp;cid=$clanID\">$clanName</a><b>}</b>
");
   }
   echo "<br/>";
   }


   if(count($neighbours)<=0)
    printrus ("У вас нет соседей!<br/>\r\n");

  }elseif(($n=="info" || $n=="resourses") && !neighbour_exists($countryID,$neighbourID)){
   printrus ("<u>нет такого соседа!!!</u><br/>\r\n");
   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours\">Отмена</a>
<br/>
");
  }elseif($n=="info"){
   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=resourses&amp;neighbour=$neighbour\">Ресурсы</a>
<br/>
");
   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=science&amp;neighbour=$neighbour\">Наука</a><br />");

   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=wariors&amp;neighbour=$neighbour\">Войско</a><br />");
   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=guard&amp;neighbour=$neighbour\">Оборона</a><br />");
   printrus
("<a href=\"../messages/writemessage.php?$ses&amp;to=$neighbour\">Сообщение</a>
<br/>
");
   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours\">Оk</a>
<br/>
");

  }elseif($n=="resourses"){

   $spy_lvl=$b["spy"]+$plus_altar;
   printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");

   $iron=round($neighbourInfo["iron"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Железо: <b>$iron</b><br/>\r\n");
   $arbor=round($neighbourInfo["arbor"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Дерево: <b>$arbor</b><br/>\r\n");
   $grain=round($neighbourInfo["grain"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Зерно: <b>$grain</b><br/>\r\n");
   $stone=round($neighbourInfo["stone"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Камень: <b>$stone</b><br/>\r\n");
   $oil=round($neighbourInfo["oil"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Нефть: <b>$oil</b><br/>\r\n");

   printrus
("<a href=\"ratusha.php?$ses&amp;m=grab&amp;neighbour=$neighbour\">Украсть</a>
<br/>
");
   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$neighbour\">Ok</a>
<br/>
");

  }elseif($n=="wariors"){

   $spy_lvl=$b["spy"]+$plus_altar;
   printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");

   printrus ("Воинов");
   $free=round($neighbourInfo["wariors_free"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_2=round($neighbourInfo["wariors_free_2"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_3=round($neighbourInfo["wariors_free_3"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_4=round($neighbourInfo["wariors_free_4"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_5=round($neighbourInfo["wariors_free_5"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_6=round($neighbourInfo["wariors_free_6"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_7=round($neighbourInfo["wariors_free_7"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_8=round($neighbourInfo["wariors_free_8"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus (" свободно:<br/>".print_voisko(array($free,$free_2,$free_3,$free_4,$free_5,$free_6,$free_7,$free_8)));
   $w_kind=round($neighbourInfo["weapon_kind"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Оружие: \r\n");
   if($w_kind==1){
    printrus ("тяжелое<br/>\r\n");
   }else{
    printrus ("легкое<br/>\r\n");
   }
   $b_kind=round($neighbourInfo["bronya_kind"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Броня : \r\n");
   if($b_kind==1){
    printrus ("тяжелая<br/>\r\n");
   }else{
    printrus ("легкая<br/>\r\n");
   }

   $speed=round($neighbourInfo["weapon_speed"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $speed_2=round($neighbourInfo["weapon_speed_2"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $speed_3=round($neighbourInfo["weapon_speed_3"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $speed_4=round($neighbourInfo["weapon_speed_4"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $speed_5=round($neighbourInfo["weapon_speed_5"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $speed_6=round($neighbourInfo["weapon_speed_6"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $speed_7=round($neighbourInfo["weapon_speed_7"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $speed_8=round($neighbourInfo["weapon_speed_8"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   //printrus (" скорость: пехота: <b>$speed</b>, кавалерия: <b>$speed_2</b>, стрелки: <b>$speed_3</b><br/>\r\n");
   $force=round($neighbourInfo["weapon_force"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $force_2=round($neighbourInfo["weapon_force_2"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $force_3=round($neighbourInfo["weapon_force_3"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $force_4=round($neighbourInfo["weapon_force_4"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $force_5=round($neighbourInfo["weapon_force_5"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $force_6=round($neighbourInfo["weapon_force_6"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $force_7=round($neighbourInfo["weapon_force_7"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $force_8=round($neighbourInfo["weapon_force_8"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   //printrus (" сила: пехота: <b>$force</b>, кавалерия: <b>$force_2</b>, стрелки: <b>$force_3</b><br/>\r\n");
   printrus(get_unit_name_im(0).':'.$speed.'/'.$force.'<br/>');
   printrus(get_unit_name_im(1).':'.$speed_2.'/'.$force_2.'<br/>');
   printrus(get_unit_name_im(2).':'.$speed_3.'/'.$force_3.'<br/>');
   printrus(get_unit_name_im(3).':'.$speed_4.'/'.$force_4.'<br/>');
   printrus(get_unit_name_im(4).':'.$speed_5.'/'.$force_5.'<br/>');
   printrus(get_unit_name_im(5).':'.$speed_6.'/'.$force_6.'<br/>');
   printrus(get_unit_name_im(6).':'.$speed_7.'/'.$force_7.'<br/>');
   printrus(get_unit_name_im(7).':'.$speed_8.'/'.$force_8.'<br/>');

   $wb_kind=round($neighbourInfo["kind"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $wb_count=round($neighbourInfo["count"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $wb_protection=round($neighbourInfo["protection"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Стенобитные орудия: <b>$wb_count</b><br/>\r\n");
   if($wb_kind==1){
    printrus (" каменный заряд<br/>\r\n");
   }else{
    printrus (" огненный заряд<br/>\r\n");
   }
   printrus (" защита: <b>$wb_protection</b><br/>\r\n");

   if(($free+$free_2+$free_3+$free_4+$free_5+$free_6+$free_7+$free_8)>0){
    printrus
("<a href=\"ratusha.php?$ses&amp;m=verb&amp;neighbour=$neighbour\">Завербовать</a>
<br/>
");
}
   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$neighbour\">Ok</a>
<br/>
");

  }elseif($n=="science"){

   $spy_lvl=$b["spy"]+$plus_altar;
   //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! Подозрительно: почему $neighbour, а не $neighbourID???? (исправил)
   if(building_exists($neighbourID,"university")){
    printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");

    $grain_making=round($neighbourInfo["grain_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство зерна: <b>$grain_making</b><br/>\r\n");
    $arbor_making=round($neighbourInfo["arbor_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство древесины: <b>$arbor_making</b><br/>\r\n");
    $iron_making=round($neighbourInfo["iron_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство железа: <b>$iron_making</b><br/>\r\n");
    $stone_making=round($neighbourInfo["stone_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство камня: <b>$stone_making</b><br/>\r\n");
    $oil_making=round($neighbourInfo["oil_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Добыча нефти: <b>$oil_making</b><br/>\r\n");


    if($grain_making>$b["grain_making"] || $arbor_making>$b["arbor_making"] || $iron_making>$b["iron_making"] || $stone_making>$b["stone_making"] || $oil_making>$b["oil_making"]){
     printrus
("<a href=\"ratusha.php?$ses&amp;m=sciencespy&amp;neighbour=$neighbour\">Украсть разработки</a>
<br/>
");
    }else{
     printrus ("Уровень всех разработок ниже вашего! Вы не можете ничего украсть.<br/>\r\n");
    }

   }elseif(building_exists($neighbourID,"scientificcenter")){
    printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");
    //Было $neighbour, исправил на $neighbourID:

    $key=_PREFIKS.':buildings'.$neighbourID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='scientificcenter'){
           $var2=$mem[$i]['var2'];
           break;
           }
       }else{
    $var2=getValue("countryID='$neighbourID' and building='scientificcenter'","buildings","var2");
    }

    printrus("Уровень научного центра:<b>$var2</b><br/>\r\n");

    $grain_making=round($neighbourInfo["grain_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство зерна: <b>$grain_making</b><br/>\r\n");
    $arbor_making=round($neighbourInfo["arbor_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство древесины: <b>$arbor_making</b><br/>\r\n");
    $iron_making=round($neighbourInfo["iron_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство железа: <b>$iron_making</b><br/>\r\n");
    $stone_making=round($neighbourInfo["stone_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прозводство камня: <b>$stone_making</b><br/>\r\n");
    $oil_making=round($neighbourInfo["oil_making"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Добыча нефти: <b>$oil_making</b><br/>\r\n");

    if($var2>=1){
     $forest_adding=round($neighbourInfo["forest_adding"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
     printrus ("Выращивание лесов: <b>$forest_adding</b><br/>\r\n");
    }
    if($var2>=3){
     $science=round($neighbourInfo["science"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
     printrus ("Научный уровень: <b>$science</b><br/>\r\n");
    }
    if($var2>=5){
     $plotn_people=round($neighbourInfo["plotn_people"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
     printrus ("Макс. плотность населения: <b>$plotn_people</b><br/>\r\n");
    }
    if($var2>=7){
     $plotn_wariors=round($neighbourInfo["plotn_wariors"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
     printrus ("Макс. плотность войска: <b>$plotn_wariors</b><br/>\r\n");
    }
    if($var2>=7){
     $people_adding=round($neighbourInfo["people_adding"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
     printrus ("Прирост населения: <b>$people_adding</b><br/>\r\n");
    }

    $mountains_max=round($neighbourInfo["mountains_max"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Прочность шахт: <b>$mountains_max</b><br/>\r\n");

    $forest_max=round($neighbourInfo["forest_max"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Сохранение лесов: <b>$forest_max</b><br/>\r\n");

    if($people_adding>$b["people_adding"] || $plotn_wariors>$b["plotn_wariors"] || $plotn_people>$b["plotn_people"] || $forest_adding>$b["forest_adding"] || $science>$b["science"] || $grain_making>$b["grain_making"] || $arbor_making>$b["arbor_making"] || $iron_making>$b["iron_making"] || $stone_making>$b["stone_making"] || $oil_making>$b["oil_making"]|| $forest_max>$b["forest_max"]|| $mountains_max>$b["mountains_max"]){
     printrus
("<a href=\"ratusha.php?$ses&amp;m=sciencespy&amp;neighbour=$neighbour\">Украсть разработки</a>
<br/>
");
    }else{
     printrus ("Уровень всех разработок ниже вашего! Вы не можете ничего украсть.<br/>\r\n");
    }

   }else{
    printrus ("Наука у этого гос-ва не развита!<br/>\r\n");
   }

   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$neighbour\">Ok</a><br />
");

  }elseif($n=="guard"){

   $spy_lvl=$b["spy"]+$plus_altar;
   if(building_exists($neighbourID,"wall")){
    printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");
    printrus ("Стена\r\n");


    $key=_PREFIKS.':buildings'.$neighbourID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='wall'){
           $var1=$mem[$i]['var1'];
           $guard=$mem[$i]['guard'];
           $guard_2=$mem[$i]['guard_2'];
           $guard_3=$mem[$i]['guard_3'];
           $guard_4=$mem[$i]['guard_4'];
           $guard_5=$mem[$i]['guard_5'];
           $guard_6=$mem[$i]['guard_6'];
           $guard_7=$mem[$i]['guard_7'];
           $guard_8=$mem[$i]['guard_8'];
           $var2=$mem[$i]['var2'];
           $hits=$mem[$i]['hits'];
           break;
           }
       }else{
    $query="select * from `buildings` where countryID='$neighbourID' and building='wall' limit 1";
    $result=@MYSQL_QUERY($query);
    $var1=@mysql_result($result,0,"var1");
    $guard=@mysql_result($result,0,"guard");
    $guard_2=@mysql_result($result,0,"guard_2");
    $guard_3=@mysql_result($result,0,"guard_3");
    $guard_4=@mysql_result($result,0,"guard_4");
    $guard_5=@mysql_result($result,0,"guard_5");
    $guard_6=@mysql_result($result,0,"guard_6");
    $guard_7=@mysql_result($result,0,"guard_7");
    $guard_8=@mysql_result($result,0,"guard_8");
    $var2=@mysql_result($result,0,"var2");
    $hits=@mysql_result($result,0,"hits");
    }

    $var1=round($var1*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    if($var1==1){
     printrus ("(камень)<br/>\r\n");
    }elseif($var1==0){
     printrus ("(дерево)<br/>\r\n");
    }else{
     printrus ("(тип не определен)<br/>\r\n");
    }

    $guard=round($guard*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $guard_2=round($guard_2*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $guard_3=round($guard_3*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $guard_4=round($guard_4*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $guard_5=round($guard_5*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $guard_6=round($guard_6*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $guard_7=round($guard_7*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $guard_8=round($guard_8*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Охрана:<br/>".print_voisko(array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8))."\r\n");

    $var2=round($var2*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Укрепление: <b>$var2</b><br/>\r\n");

    $hits=round($hits*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    $hits=min(100,$hits);
    printrus ("Целостность: <b>$hits %</b><br/>\r\n");

    if($hits>10){
    printrus
("<a href=\"ratusha.php?$ses&amp;m=sabotage&amp;neighbour=$neighbour\">Саботаж</a>
<br/>
");

}
   }else{//if(building_exists($neighbour,"wall")
    printrus ("Стена остутствует<br/>\r\n");
   }

   printrus
("<a href=\"ratusha.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$neighbour\">Ok</a>
<br/>
");

  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Воруем::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('grab'):
  if(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете ограбить только соседа!<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }else{
   grab($countryID,$neighbourID);
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Саботаж ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('sabotage'):
  if(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете разрушать только соседские здания!<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }else{
   sabotage_bld($countryID,$neighbourID,"wall");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Вербуем:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('verb'):
  if(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете завербовать только соседские войска!<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }else{
   verb($countryID,$neighbourID);
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//крадем науку::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('sciencespy'):
  if(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете шпионить только на территории соседнего гос-ва!<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }else{
   sciencespy($countryID,$neighbourID);
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//В помощь нубам!!!:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('help'):

  if(empty($n)){

  }elseif($n=='spy'){
   printrus ("Справка: <u>Шпионаж</u><br/>\r\n");
   printrus ("Шпионаж позволяет украсть у вашего соседа научные разработки, является защитой от воров, шпионажа и т.д. Так-же используется для определения характеристик вражеских зданий.<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='grab'){
   printrus ("Справка: <u>Воровство</u><br/>\r\n");
   printrus ("Позволяет украсть у вашего соседа ресурсы. <br/>Если уровень шпионажа противника выше вашего воровства, то попытка будет предотвращена, если меньше или равен, то вам удастся что-нибудь украсть.<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='sabotage'){
   printrus ("Справка: <u>Саботаж</u><br/>\r\n");
   printrus ("Позволяет разрушить вражеское здание(во время войны) или стену(в мирное время). <br/>Если уровень шпионажа противника выше вашего саботажа, то попытка будет предотвращена, если меньше или равен, то вам удастся разрушить здание.<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='verb'){
   printrus ("Справка: <u>Вербовка</u><br/>\r\n");
   printrus ("Позволяет перевербовать вражеских солдат. <br/>Если уровень шпионажа противника выше вашей вербовки, то попытка будет предотвращена, если меньше или равен, то вам удастся завербовать его военных.<br/>\r\n");
   printrus
("
<a href='ratusha.php?$ses'>OK</a>
<br/>
");
  }

 break;
 endswitch;

}

//=============================================================================//Конец скрипту================================================================print "---<br/>\r\n";
printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");
?>
