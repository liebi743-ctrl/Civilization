<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['kind'])) $kind = $_REQUEST['kind'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['neighbour'])) $neighbour = $_REQUEST['neighbour'];
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['wariorsto'])) $wariorsto = ceil($_REQUEST['wariorsto']);
if (isset($wariorsto)&&!is_numeric($wariorsto)) $wariorsto=0;
if (isset($wariorsto)&&$wariorsto<0) $wariorsto=0;
if (!isset($wariorsto)) $wariorsto=0;
if (isset($_REQUEST['wariorsto_2'])) $wariorsto_2 = ceil($_REQUEST['wariorsto_2']);
if (isset($wariorsto_2)&&!is_numeric($wariorsto_2)) $wariorsto_2=0;
if (isset($wariorsto_2)&&$wariorsto_2<0) $wariorsto_2=0;
if (!isset($wariorsto_2)) $wariorsto_2=0;
if (isset($_REQUEST['wariorsto_3'])) $wariorsto_3 = ceil($_REQUEST['wariorsto_3']);
if (isset($wariorsto_3)&&!is_numeric($wariorsto_3)) $wariorsto_3=0;
if (isset($wariorsto_3)&&$wariorsto_3<0) $wariorsto_3=0;
if (!isset($wariorsto_3)) $wariorsto_3=0;
if (isset($_REQUEST['wariorsto_4'])) $wariorsto_4 = ceil($_REQUEST['wariorsto_4']);
if (isset($wariorsto_4)&&!is_numeric($wariorsto_4)) $wariorsto_4=0;
if (isset($wariorsto_4)&&$wariorsto_4<0) $wariorsto_4=0;
if (!isset($wariorsto_4)) $wariorsto_4=0;
if (isset($_REQUEST['wariorsto_5'])) $wariorsto_5 = ceil($_REQUEST['wariorsto_5']);
if (isset($wariorsto_5)&&!is_numeric($wariorsto_5)) $wariorsto_5=0;
if (isset($wariorsto_5)&&$wariorsto_5<0) $wariorsto_5=0;
if (!isset($wariorsto_5)) $wariorsto_5=0;
if (isset($_REQUEST['wariorsto_6'])) $wariorsto_6 = ceil($_REQUEST['wariorsto_6']);
if (isset($wariorsto_6)&&!is_numeric($wariorsto_6)) $wariorsto_6=0;
if (isset($wariorsto_6)&&$wariorsto_6<0) $wariorsto_6=0;
if (!isset($wariorsto_6)) $wariorsto_6=0;
if (isset($_REQUEST['wariorsto_7'])) $wariorsto_7 = ceil($_REQUEST['wariorsto_7']);
if (isset($wariorsto_7)&&!is_numeric($wariorsto_7)) $wariorsto_7=0;
if (isset($wariorsto_7)&&$wariorsto_7<0) $wariorsto_7=0;
if (!isset($wariorsto_7)) $wariorsto_7=0;
if (isset($_REQUEST['wariorsto_8'])) $wariorsto_8 = ceil($_REQUEST['wariorsto_8']);
if (isset($wariorsto_8)&&!is_numeric($wariorsto_8)) $wariorsto_8=0;
if (isset($wariorsto_8)&&$wariorsto_8<0) $wariorsto_8=0;
if (!isset($wariorsto_8)) $wariorsto_8=0;
if (isset($_REQUEST['name'])) $name = $_REQUEST['name'];
if (isset($_REQUEST['age'])) $age = ceil($_REQUEST['age']);
if (isset($age)&&!is_numeric($age)) $age=0;
if (isset($_REQUEST['atw'])) $atw = ceil($_REQUEST['atw']);
if (isset($atw)&&!is_numeric($atw)) $atw=0;
if (isset($atw)&&$atw<0) $atw=0;
if (!isset($atw)) $atw=0;
if (isset($_REQUEST['atw_2'])) $atw_2 = ceil($_REQUEST['atw_2']);
if (isset($atw_2)&&!is_numeric($atw_2)) $atw_2=0;
if (isset($atw_2)&&$atw_2<0) $atw_2=0;
if (!isset($atw_2)) $atw_2=0;
if (isset($_REQUEST['atw_3'])) $atw_3 = ceil($_REQUEST['atw_3']);
if (isset($atw_3)&&!is_numeric($atw_3)) $atw_3=0;
if (isset($atw_3)&&$atw_3<0) $atw_3=0;
if (!isset($atw_3)) $atw_3=0;
if (isset($_REQUEST['atw_4'])) $atw_4 = ceil($_REQUEST['atw_4']);
if (isset($atw_4)&&!is_numeric($atw_4)) $atw_4=0;
if (isset($atw_4)&&$atw_4<0) $atw_4=0;
if (!isset($atw_4)) $atw_4=0;
if (isset($_REQUEST['atw_5'])) $atw_5 = ceil($_REQUEST['atw_5']);
if (isset($atw_5)&&!is_numeric($atw_5)) $atw_5=0;
if (isset($atw_5)&&$atw_5<0) $atw_5=0;
if (!isset($atw_5)) $atw_5=0;
if (isset($_REQUEST['atw_6'])) $atw_6 = ceil($_REQUEST['atw_6']);
if (isset($atw_6)&&!is_numeric($atw_6)) $atw_6=0;
if (isset($atw_6)&&$atw_6<0) $atw_6=0;
if (!isset($atw_6)) $atw_6=0;
if (isset($_REQUEST['atw_7'])) $atw_7 = ceil($_REQUEST['atw_7']);
if (isset($atw_7)&&!is_numeric($atw_7)) $atw_7=0;
if (isset($atw_7)&&$atw_7<0) $atw_7=0;
if (!isset($atw_7)) $atw_7=0;
if (isset($_REQUEST['atw_8'])) $atw_8 = ceil($_REQUEST['atw_8']);
if (isset($atw_8)&&!is_numeric($atw_8)) $atw_8=0;
if (isset($atw_8)&&$atw_8<0) $atw_8=0;
if (!isset($atw_8)) $atw_8=0;
if (isset($_REQUEST['prid'])) $prid = $_REQUEST['prid'];
if (isset($_REQUEST['pag'])) $pag = $_REQUEST['pag'];
if (isset($pag)&&!is_numeric($pag)) $pag=0;
if (isset($pag)&&$pag<0) $pag=0;
if (isset($_REQUEST['study'])) $study = ceil($_REQUEST['study']);
if (isset($study)&&!is_numeric($study)) $study=1;
if (isset($study)&&$study<1) $study=1;
if (isset($_REQUEST['res'])) $res = $_REQUEST['res'];
if (isset($res)&&($res!='iron'&&$res!='arbor'&&$res!='grain'&&$res!='stone'&&$res!='money'&&$res!='oil')) exit;
if (isset($_REQUEST['hisres'])) $hisres = $_REQUEST['hisres'];
if (isset($hisres)&&($hisres!='iron'&&$hisres!='arbor'&&$hisres!='grain'&&$hisres!='stone'&&$hisres!='money'&&$hisres!='oil')) exit;
if (isset($_REQUEST['resgive'])) $resgive = ceil($_REQUEST['resgive']);
if (isset($resgive)&&!is_numeric($resgive)) $resgive=0;
if (isset($resgive)&&$resgive<0) $resgive=0;
if (isset($_REQUEST['restake'])) $restake = ceil($_REQUEST['restake']);
if (isset($restake)&&!is_numeric($restake)) $restake=0;
if (isset($restake)&&$restake<0) $restake=0;
if (isset($_REQUEST['messcheck'])) $messcheck = $_REQUEST['messcheck'];
//^^Передается ф-ей вывода сообщений exec_message
if (isset($_REQUEST['quan'])) $quan = $_REQUEST['quan'];
if (isset($quan)&&!is_numeric($quan)) $quan=0;
if (isset($quan)&&$quan<0) $quan=0;

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);
 $scientiststo=round( (int) $scientiststo);
 $moneyto=round( (int) $moneyto);
 $wariorsto=round( (int) $wariorsto);
 $wariorsto_2=round( (int) $wariorsto_2);
 $wariorsto_3=round( (int) $wariorsto_3);
 $wariorsto_4=round( (int) $wariorsto_4);
 $wariorsto_5=round( (int) $wariorsto_5);
 $wariorsto_6=round( (int) $wariorsto_6);
 $wariorsto_7=round( (int) $wariorsto_7);
 $wariorsto_8=round( (int) $wariorsto_8);
 $atw=round( (int) $atw);
 $atw_2=round( (int) $atw_2);
 $atw_3=round( (int) $atw_3);
 $atw_4=round( (int) $atw_4);
 $atw_5=round( (int) $atw_5);
 $atw_6=round( (int) $atw_6);
 $atw_7=round( (int) $atw_7);
 $atw_8=round( (int) $atw_8);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();
$us=UzersInfo($countryID);

$country=$b['countryName'];
//$countryID=$b['countryID'];

 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;

 if (isset($neighbour)){
 $neighbourID=$neighbour;
 $neighbourInfo = CountryInfo($neighbourID);
 $neighbour_ = $neighbourInfo['countryName'];
 $rTime=(((time()-$neighbourInfo['reggedTime'])*1.5)<(time()-$b['reggedTime']))?1:0;
 $ost=(time()-$b['reggedTime'])-((time()-$neighbourInfo['reggedTime'])*1.5);

 $z2 = mysql_query("SELECT ip FROM `uzers` WHERE countryID = '$neighbourID' LIMIT 1");
 $s2 = mysql_fetch_array($z2);
 $ips = $s2['ip'];

 function testCit($id,$str,$tst){
 	Global $b;
$file = fopen("../logs/cit$id", "r");
if(!$file){return false;exit;}
$buffer = fread($file, filesize("../logs/cit$id"));
fclose($file);

if($b['reggedTime']>(time()-(200*60*60)))
    return true;

if (substr_count($buffer, $str)>0 ){

    return true;



}
else{

    $file = fopen("../logs/war$id", "r");
    if(!$file){return false;exit;}
    $buffer = fread($file, filesize("../logs/war$id"));
    fclose($file);
    if (substr_count($buffer, $str)>0){
      return true;
    }
    else{
         return false;
        }




}





}
 //testCit($neighbourID,$country,'cit')
 // $rTime!=0
 $tis=testCit("$neighbourID","$country","cit");
 }

//******************************************************************************
//проверка на наличие здания:****************************************

build_exists_print($countryID,'citadel');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Цитадель</u><br/>\r\n");

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

is_repairing($countryID,'citadel',$m);

  if($att_nz=isNewBuildings($countryID,'altar')){
  if(($att_nz['time_sac']+259200) > time()){$att_mor=$att_nz['un_1'];}else{$att_mor=0;}
  if(($att_nz['time_uz']+259200) > time()){$att_altar=10;}else{$att_altar=0;}
  }
  if($att_nz=isNewBuildings($countryID,'dungeon')){
  if(($att_nz['un_2']+259200) > time()){$att_dungeon=10;}else{$att_dungeon=0;}
  }

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:

  printrus
("<a href=\"guard.php?$ses&amp;bld=citadel\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");



  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=spy\">?</a>]
");
  printrus ("Шпионаж [".$b["spy"]."%]".$pcit."\r\n");
  if ($att_altar >0){printrus ("+10)=".($b["spy"]+=10)."\r\n");}
  if (isArtefact($countryID, 'medal')){printrus ("+5)=".($b["spy"]+=5)."\r\n");}    //артефакт шпионажа
  if($b["spy"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=spyup\">^</a>

");
  print "<br/>\r\n";


  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=sabotage\">?</a>]");
  printrus ("Саботаж [".$b["sabotage"]."%]".$pcit."\r\n");
  if ($att_altar >0){printrus ("+10)=".($b["sabotage"]+=10)."\r\n");}
  if (isArtefact($countryID, 'medal')){printrus ("+5)=".($b["sabotage"]+=5)."\r\n");}    //артефакт саботажа
  if($b["sabotage"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=sabotageup\">^</a>

");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=grab\">?</a>]");
  printrus ("Воровство [".$b["grabber"]."%]".$pcit."\r\n");
  if ($att_altar >0){printrus ("+10)=".($b["grabber"]+=10)."\r\n");}
  if (isArtefact($countryID, 'medal')){printrus ("+5)=".($b["grabber"]+=5)."\r\n");}    //артефакт воровства
  if($b["grabber"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=grabberup\">^</a>

");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=verb\">?</a>]");
  printrus ("Вербовка [".$b["verb"]."%]".$pcit."\r\n");
  if ($att_altar >0){printrus ("+10)=".($b["verb"]+=10)."\r\n");}
  if (isArtefact($countryID, 'medal')){printrus ("+5)=".($b["verb"]+=5)."\r\n");}    //артефакт вербовки
  if($b["verb"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=verbup\">^</a>

");
  print "<br/>\r\n";
  printrus
("<a href=\"/artefacts.php?$ses&amp;cits=arts\">Артефакты</a>
<br/>
");
  printrus
("<a href=\"citadel.php?$ses&amp;m=general\">Генерал</a>
<br/>
");
  printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Соседи...</a>
<br/>
");
  if($hits<100){
   printrus
("<a href=\"citadel.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'citadel',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//шпионаж:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('spyup'):

  $lvl_up=min(5,100-$b["spy"]);
  $mnd=$b["spy"]*$b["spy"]*$lvl_up;
  if ($b['spy']>50) $mnd = $mnd*(round($b['spy']/15)-1);

  if ($lvl_up < 1)
  {
      $lvl_up=1;
      $mnd=80000;
      for ($i=100; $i<$b["spy"]; $i++)
      $mnd=round($mnd*1.2);
  }


  if(empty($n)){
   printrus ("Шпионаж: (+$lvl_up %)<br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($money>=$mnd){
    printrus
("<a href=\"citadel.php?$ses&amp;m=spyup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure' && $money<$mnd){
   printrus ("У вас не достаточно денег! (Необходимо: <b>$mnd</b>)<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure'){
   mysql_query("UPDATE countries SET money=($money - $mnd), spy = spy + $lvl_up WHERE countryID='".$b['countryID']."'");
   $b['money'] = $money - $mnd;
   $b['spy'] = $b['spy'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень шпионажа: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
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

  if ($lvl_up < 1)
  {
      $lvl_up=1;
      $mnd=80000;
      for ($i=100; $i<$b["sabotage"]; $i++)
      $mnd=round($mnd*1.2);
  }


  if(empty($n)){
   printrus ("Саботаж: (+$lvl_up %)<br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($money>=$mnd){
    printrus
("<a href=\"citadel.php?$ses&amp;m=sabotageup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure' && $money<$mnd){
   printrus ("У вас недостаточно денег! (Необходимо: <b>$mnd</b>)<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=='sure'){
   mysql_query("UPDATE countries SET money=($money - $mnd), sabotage = sabotage + $lvl_up WHERE countryID='".$b['countryID']."'");
   $b['money'] = $money - $mnd;
   $b['sabotage'] = $b['sabotage'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
   printrus ("Уровень саботажа: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
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


  if ($lvl_up < 1)
  {
      $lvl_up=1;
      $mnd=80000;
      for ($i=100; $i<$b["grabber"]; $i++)
      $mnd=round($mnd*1.2);
  }


  if($n=='sure'){
   if ($b['money']>=$mnd){
   mysql_query("UPDATE countries SET money=money - $mnd, grabber = grabber + $lvl_up WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $mnd;
   $b['grabber'] = $b['grabber'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень воровства: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");
  }else{
        printrus ("У вас недостаточно денег!<br/>\r\n");
          }
  }else{
   printrus ("Воровство: (+$lvl_up %)<br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($b['money']>=$mnd){
    printrus
("<a href=\"citadel.php?$ses&amp;m=grabberup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
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

  if ($lvl_up < 1)
  {
      $lvl_up=1;
      $mnd=80000;
      for ($i=100; $i<$b["verb"]; $i++)
      $mnd=round($mnd*1.2);
  }


  if($n=='sure'){
   if ($b['money']>=$mnd){
   mysql_query("UPDATE countries SET money=money - $mnd, verb = verb + $lvl_up WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $mnd;
   $b['verb'] = $b['verb'] + $lvl_up;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень вербовки: <b>+$lvl_up %</b>!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
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
("<a href=\"citadel.php?$ses&amp;m=verbup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Соседи::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('neighbours'):
  if ($n=='offerunite' || $n=='mkunite'){
  $key=_PREFIKS.':unite'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $ucount=count($mem);
     }else{
  $r = mysql_query("SELECT count(*) as num FROM `unite` WHERE countryID = '$countryID'");
  $a = mysql_fetch_array($r);
  $ucount = $a['num'];
  }
  if ($n=='mkunite'){
  //Считаем число союзов у союзника
  $key=_PREFIKS.':unite'.$neighbourID;
  if (($mem=$memcache->get($key))!==FALSE){
     $uncount=count($mem);
     }else{
  $r = mysql_query("SELECT count(*) as num FROM `unite` WHERE countryID = '$neighbourID'");
  $a = mysql_fetch_array($r);
  $uncount = $a['num'];
  }
     }

     }

  if ($n=="attack"){
  $key=_PREFIKS.':wars'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $wcount=count($mem);
     }else{
  $r = mysql_query("SELECT count(*) as num FROM `wars` WHERE attackerID = '$countryID'");
  $a = mysql_fetch_array($r);
  $wcount = $a['num'];
  }

          }


  $neighbour_ = checkCountryID($neighbourID);
  if(!empty($neighbour)){
   if (is_unitee($b['countryID'],$neighbourID)) printrus ("Союзник: [<u>$neighbour_</u>]<br/>\r\n");
   else printrus ("Сосед: [<u>$neighbour_</u>]<br/>\r\n");
  }

  if($n=='offerunite'){

   $query="select * FROM `messages` WHERE `from`='offerunite' AND `message`='$country' limit 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $nump=@mysql_num_rows($result);

  }
  if(!empty($n))$_SESSION['cheat']=0;

  if(empty($n)){

$show = FALSE;
if (!isset($_SESSION['cheat']))$_SESSION['cheat']=0;
$_SESSION['cheat']++;
if ($_SESSION['cheat']>7){
$_SESSION['cheat']=0;
$show=TRUE;
}

  $neighbours = array();
  $nids = array();
  $key=_PREFIKS.':neighs'.$countryID;
  /*if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++){
         array_push($nids,$mem[$i]);
         array_push($neighbours,checkCountryID($mem[$i]));
         }
     }else{ */
  $r = mysql_query("SELECT countryID FROM `neighbours` WHERE neighbourID = '$countryID'");
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($neighbours,checkCountryID($a[0]));
          array_push($nids,$a[0]);
          }
  //}

   if (!isset($pag))$pag=0;
   //for($i=$pag;($i<count($neighbours) && $i<$pag+10);$i++){
   	for($i=$pag;($i<count($nids) && $i<$pag+10);$i++){
    $countryName=checkCountryID($nids[$i]);
    $nbr = $nids[$i];
    if ($show==TRUE){
    $r2 = mysql_query("SELECT onlineflag FROM `uzers` WHERE countryID = '$nbr' LIMIT 1");
    $a2 = mysql_fetch_array($r2);
    }
    $fantom1 = mysql_query("SELECT count(*) as num FROM `messages` WHERE countryID = '$nbr' and from='loose' LIMIT 1");
    $fantom2 = mysql_fetch_array($fantom1);
    $fantom=$fantom2['num'];
    if($fantom<1){
    $ff = mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$nbr' LIMIT 1");
    $gg = mysql_fetch_array($ff);
    $clanID = $gg['clanID'];
    require_once('../other_inc/klans.php');
    if(in_array($clanID,$klan))$see=$znak[$clanID];else $see='';
    printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=".$nbr."\">$countryName</a>
");
if ($show==TRUE){
if (time()<$a2['onlineflag'])
printrus("[onl]");
else
printrus("[off]");
    $r3 = mysql_query("SELECT * FROM `countries` WHERE countryID = '$nbr' LIMIT 1");
    $a3 = mysql_fetch_array($r3);
printrus(" Возраст: ".mkTimeStr(time()-$a3['reggedTime']));
}
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
($see."<b>{</b><a href=\"../viewclan.php?$ses&amp;cid=$clanID\">$clanName</a><b>}</b>
");

   }

    if(is_unitee($b['countryID'],$nbr)){
     printrus ("(союзник)");
    }elseif(war_between($b['countryID'],$nbr)){
     printrus ("(враг)");
    }
    print "<br/>\r\n";  }
   }
   if(count($nids)<=0)
    printrus ("У вас нет соседей!<br/>\r\n");
   if(count($nids)<20){
    if($noob>=1)
     printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=diplomat\">?</a>]
");
    printrus ("Расширить дипломатическое влияние<br/>");
    printrus
("<a href=\"citadel.php?$ses&amp;m=getneighbours&amp;kind=0\">на восток</a>
<br/>
");
printrus
("<a href=\"citadel.php?$ses&amp;m=getneighbours&amp;kind=1\">на запад</a>
<br/>
");
  }
  if ($pag>0){
     $npag=max(0,$pag-9);
     printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;pag=$npag\">назад...</a>
<br/>
");
          }
  if ($pag+9<count($neighbours)){
     $npag=min(count($neighbours),$pag+9);
     printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;pag=$npag\">вперед...</a>
<br/><br/>
");
          }

  }elseif(!neighbour_exists($b['countryID'],$neighbourID)){
   printrus ("<u>нет такого соседа!!!</u><br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Отмена</a>
<br/>
");
  }elseif($n=='closeunite' && !is_unitee($b['countryID'],$neighbourID)){
   printrus ("<u>нет такого союзника!!!</u><br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Отмена</a>
<br/>
");
  }elseif($n=='closeunite' && empty($sure)){
   printrus ("Вы уверены, что хотите расторгнуть союз с гос-вом <u>$neighbour_</u>?<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=closeunite&amp;neighbour=$neighbour&amp;sure=sure\">Да</a>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Нет</a>
<br/>
");
  }elseif($n=='closeunite'){
   sendMessage($neighbourID,'closeunite',"$country");
   remUnitee($b['countryID'],$neighbourID);
   printrus ("Союз с гос-вом <u>$neighbour_</u> расторгнут!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Оk</a>
<br/>
");
  }elseif(($n=='offerunite' || $n=='mkunite') && war_between($countryID,$neighbourID)){
   printrus ("Вы не можете заключить союз с вражеским гос-вом <u>$neighbour_</u>!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Оkа</a>
<br/>
");
  }elseif(($n=='offerunite' || $n=='mkunite') && $b['unites']<=0){
   printrus ("Вы не можете заключать союз, так как вы исчерпали лимит союзов за игру!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Оk</a>
<br/>
");
  }elseif(($n=='offerunite' || $n=='mkunite') && $nump!=0){
   printrus ("Вы не можете заключать союз, пока рассматривается другое ваше предложение!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Оk</a>
<br/>
");
  }elseif($n=='offerunite' && empty($sure)){
   printrus ("Вы уверены, что хотите заключить союз с гос-вом <u>$neighbour_</u>?<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=offerunite&amp;neighbour=$neighbour&amp;sure=sure\">Да</a>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Нет</a>
<br/>
");
  }elseif($n=='offerunite' && !building_exists($neighbourID,'citadel')){
   printrus ("Вы не можете заключить союз с гос-вом <u>$neighbour_</u>, тк у него нет цитадели!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='offerunite' && $ucount>=2){
   printrus ("Вы не можете заключить союз с гос-вом <u>$neighbour_</u>, т.к. максимум можно иметь 2 союза!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='offerunite' && ($b['reggedTime']+3600*24)>=time()){
   printrus ("Вы не можете заключить союз с гос-вом <u>$neighbour_</u>, т.к. предложение о союзе можно отправить только через 24 часа после создния страны!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='offerunite'){

   $key=_PREFIKS.':messages'.$neighbourID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='offerunite'&&$mem[$i]['message']==$country){
          $num=1;break;
          }
      }else{
   $query="select * FROM `messages` WHERE `countryID`='$neighbourID' AND `from`='offerunite' AND `message`='$country' limit 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $num=@mysql_num_rows($result);
   }

   if($num>0){
    printrus ("Предложение о заключении союза уже рассматривается гос-вом <u>$neighbour_</u>!<br/>\r\n");
   }else{
    sendMessage($neighbourID,'offerunite',"$country");
    printrus ("Предложение о заключении союза отправлено гос-ву <u>$neighbour_</u>!<br/>\r\n");
   }
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='mkunite' && empty($sure)){
   printrus ("Вы уверены, что хотите заключить союз с гос-вом <u>$neighbour_</u>?<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=mkunite&amp;neighbour=$neighbour&amp;sure=sure\">Да</a>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Нет</a>
<br/>
");
  }elseif($n=='mkunite' && !building_exists($neighbourID,'citadel')){
   printrus ("Вы не можете заключить союз с гос-вом <u>$neighbour_</u>, тк у него нет цитадели!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='mkunite' && $ucount>=2){
   printrus ("Вы не можете заключить союз с гос-вом <u>$neighbour_</u>, т.к. максимум можно иметь 2 союза!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='mkunite' && $uncount>=2){
   printrus ("Вы не можете заключить союз с гос-вом <u>$neighbour_</u>, т.к. у него уже есть 2 союза!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='mkunite'){

   $key=_PREFIKS.':messages'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='offerunite'&&$mem[$i]['message']==$neighbour_){
          $num=1;break;
          }
      }else{
   $query="select * FROM `messages` WHERE `countryID`='$countryID' AND `from`='offerunite' AND `message`='$neighbour_' limit 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $num=@mysql_num_rows($result);
   }

   if($num>0){
    sendMessage($neighbourID,'mkunite',"$country");
    setUnitee($b['countryID'],$neighbourID);
    printrus ("Союз с гос-вом <u>$neighbour_</u> успешно заключен!<br/>\r\n");

    $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = 'offerunite' AND `message` = '$neighbour_'";
    $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
    $key=_PREFIKS.':messages'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       $newm=array();
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='offerunite' && $mem[$i]['message']==$neighbour_){}else array_push($newm,$mem[$i]);
       $memcache->set($key,$newm,false,86400);
       }
    $query="UPDATE `countries` SET unites = unites - 1 WHERE countryID = '$countryID' or countryID = '$neighbourID' LIMIT 2";
    $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
    $b['unites']=$b['unites']-1;
    if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }
    $key=_PREFIKS.':countries'.$neighbourID;
    if (($mem=$memcache->get($key))!==FALSE){
            $mem['unites']=$mem['unites']-1;
            $memcache->set($key,$mem,false,86400);
    }

   }else{
    printrus ("Гос-во <u>$neighbour_</u> не предлагало вам союз!<br/>\r\n");
   }

   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif($n=='nounite'){

    $key=_PREFIKS.':messages'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='offerunite'&&$mem[$i]['message']==$neighbour_){
          $num=1;break;
          }
      }else{
   $query="select * FROM `messages` WHERE `countryID`='$countryID' AND `from`='offerunite' AND `message`='$neighbour_' limit 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $num=mysql_num_rows($result);
   }

   if($num>0){
    sendMessage($neighbourID,'nounite',"$country");
    printrus ("Запрос о союзе с гос-вом <u>$neighbour_</u> отклонен!<br/>\r\n");

    $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = 'offerunite' AND `message` = '$neighbour_'";
    $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
    $key=_PREFIKS.':messages'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       $newm=array();
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='offerunite' && $mem[$i]['message']==$neighbour_){}else array_push($newm,$mem[$i]);
       $memcache->set($key,$newm,false,86400);
       }

   }else{
    printrus ("Гос-во <u>$neighbour_</u> не предлагало вам союз!<br/>\r\n");
   }

   printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="info"){
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=resourses&amp;neighbour=$neighbour\">Ресурсы</a>
<br/>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=science&amp;neighbour=$neighbour\">Наука</a>
<br/>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=wariors&amp;neighbour=$neighbour\">Войско</a>
<br/>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=guard&amp;neighbour=$neighbour\">Оборона</a>
<br/>
");
   if(is_unitee($b['countryID'],$neighbourID)){
    printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=closeunite&amp;neighbour=$neighbour\">Расторгнуть союз</a>
<br/>
");

//Вторжения к союзнику
$r = mysql_query("SELECT * FROM `wars` WHERE targetID = '$neighbour'");
if (mysql_affected_rows()!=0){
printrus ("<u>Вторжения к союзнику:</u><br/>Воинов в поход:<br/>\r\n
<form name=\"\" action=\"citadel.php?$ses&amp;m=neighbours&amp;n=help&amp;neighbour=$neighbour\" method=\"post\">");
if ($wariors_free>0)printrus (get_unit_name(0).":<br/><input format='*N' name='atw' /><br/>\r\n");
if ($wariors_free_2>0)printrus (get_unit_name(1).":<br/><input format='*N' name='atw_2' /><br/>\r\n");
if ($wariors_free_3>0)printrus (get_unit_name(2).":<br/><input format='*N' name='atw_3' /><br/>\r\n");
if ($wariors_free_4>0)printrus (get_unit_name(3).":<br/><input format='*N' name='atw_4' /><br/>\r\n");
if ($wariors_free_5>0)printrus (get_unit_name(4).":<br/><input format='*N' name='atw_5' /><br/>\r\n");
if ($wariors_free_6>0)printrus (get_unit_name(5).":<br/><input format='*N' name='atw_6' /><br/>\r\n");
if ($wariors_free_7>0)printrus (get_unit_name(6).":<br/><input format='*N' name='atw_7' /><br/>\r\n");
if ($wariors_free_8>0)printrus (get_unit_name(7).":<br/><input format='*N' name='atw_8' /><br/>\r\n");



while (($a=mysql_fetch_array($r))!==FALSE){
      $prid = $a['countryID'];
      $wrs = $a['wariors'];
      $wrs_2 = $a['wariors_2'];
      $wrs_3 = $a['wariors_3'];
      $wrs_4 = $a['wariors_4'];
      $wrs_5 = $a['wariors_5'];
      $wrs_6 = $a['wariors_6'];
      $wrs_7 = $a['wariors_7'];
      $wrs_8 = $a['wariors_8'];
      $aname = checkCountryID($prid);

      printrus
("$aname.<br/><u>Войско</u>:<br/>".print_voisko(array($wrs,$wrs_2,$wrs_3,$wrs_4,$wrs_5,$wrs_6,$wrs_7,$wrs_8))."
<input name=\"prid\" type=\"checkbox\" value=\"$prid\"/>Поставь галочку!<br />
<input type=\"submit\" value=\"Атака\"/>

");
      }
   printrus("</form>"); }
   }else{
    printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;neighbour=$neighbour&amp;n=offerunite\">Предложить союз</a>
<br/>
");
    printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;neighbour=$neighbour&amp;n=attack\">Война!</a>
<br/>
");
  }
   printrus
("<a href=\"../messages/writemessage.php?$ses&amp;to=$neighbour\">Сообщение</a>
<br/>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  printrus
("<a href=\"/faq.php?m=strboti&amp;$ses\"><font color='#EE7621'>Все о Странах-Ботах</font></a>
<br/>
");


  }elseif($n=="resourses"){
   if(is_unitee($b['countryID'],$neighbourID)){
    $spy_lvl=100;
   }else{
    $spy_lvl=min(100,$b["spy"]+$plus_altar);
    printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");
   }
   $iron=round($neighbourInfo["iron"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Железо: <b>$iron</b><br/>\r\n");
   $arbor=round($neighbourInfo["arbor"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Дерево: <b>$arbor</b><br/>\r\n");
   $grain=round($neighbourInfo["grain"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Зерно: <b>$grain</b><br/>\r\n");
   $stone=round($neighbourInfo["stone"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Камень: <b>$stone</b><br/>\r\n");
   $money=round($neighbourInfo["money"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Деньги: <b>$money</b><br/>\r\n");
   $oil=round($neighbourInfo["oil"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Нефть: <b>$oil</b><br/>\r\n");

   if(is_unitee($countryID,$neighbourID)){
    printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour\">Обмен</a>
<br/>
");
   }else{
    printrus
("<a href=\"citadel.php?$ses&amp;m=grab&amp;neighbour=$neighbour\">Украсть</a>
<br/>
");
   }

 printrus ("<font color='#EE7621'>Помните что кража это :</font><br/>
   <font color='#EE7621'>Статья 158 Уголовного кодекса РФ.</font><br/>\r\n");

   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;neighbour=$neighbour&amp;n=info\">Оk</a>
<br/>
");

  }elseif($n=="wariors"){

   if(is_unitee($countryID,$neighbourID)){
    $spy_lvl=100;
   }else{
    $spy_lvl=min(100,$b["spy"]+$plus_altar);
    printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");
   }

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
   //$atall=round($neighbourInfo["wariors_atall"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   //$atall_2=round($neighbourInfo["wariors_atall_2"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   //$atall_3=round($neighbourInfo["wariors_atall_3"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   //printrus (" всего: <b>$atall</b> пехоты, <b>$atall_2</b> кавалерии, <b>$atall_3</b> стрелков<br/>\r\n");
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

    if(($free+$free_2+$free_3+$free_4+$free_5+$free_6+$free_7+$free_8)>0 && !is_unitee($countryID,$neighbourID))
     printrus
("<a href=\"citadel.php?$ses&amp;m=verb&amp;neighbour=$neighbour\">Завербовать</a>
<br/>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$neighbour\">Ok</a>
<br/>
");

  }elseif($n=="science"){

   if(is_unitee($countryID,$neighbourID)){
    $spy_lvl=100;
   }else{
    $spy_lvl=min(100,$b["spy"]+$plus_altar);
   }
   if(building_exists($neighbourID,"university")){
    if(is_unitee($countryID,$neighbourID))
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

    if($neighbourInfo["grain_making"]>$b["grain_making"] || $neighbourInfo["arbor_making"]>$b["arbor_making"] || $neighbourInfo["iron_making"]>$b["iron_making"] || $neighbourInfo["stone_making"]>$b["stone_making"] || $neighbourInfo["oil_making"]>$b["oil_making"]){
     printrus
("<a href=\"citadel.php?$ses&amp;m=sciencespy&amp;neighbour=$neighbour\">Украсть разработки</a>
<br/>
");
    }else{
     printrus ("Уровень всех разработок ниже вашего! Вы не можете ничего украсть.<br/>\r\n");
    }

   }elseif(building_exists($neighbourID,"scientificcenter")){
    if(is_unitee($countryID,$neighbourID))
     printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");

    $key=_PREFIKS.':buildings'.$neighbour;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='scientificcenter'){
           $var2=$mem[$i]['var2'];
           break;
           }
       }else{
    $var2=getValue("countryID='$neighbour' and building='scientificcenter'","buildings","var2");
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
    if($var2>=3){
     $demontaj=round($neighbourInfo["demontaj"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
     printrus ("Демонтаж зданий: <b>$demontaj</b><br/>\r\n");
    }
    if($var2>=3){
     $arheol=round($neighbourInfo["artefakt"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
     printrus ("Археология: <b>$arheol</b><br/>\r\n");
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

    if(!is_unitee($countryID,$neighbourID))
     if($neighbourInfo["people_adding"]>$b["people_adding"] || $neighbourInfo["plotn_wariors"]>$b["plotn_wariors"] || $neighbourInfo["plotn_people"]>$b["plotn_people"] || $neighbourInfo["forest_adding"]>$b["forest_adding"] || $neighbourInfo["science"]>$b["science"] || $neighbourInfo["grain_making"]>$b["grain_making"] || $neighbourInfo["arbor_making"]>$b["arbor_making"] || $neighbourInfo["iron_making"]>$b["iron_making"] || $neighbourInfo["stone_making"]>$b["stone_making"] || $neighbourInfo["oil_making"]>$b["oil_making"]|| $neighbourInfo["forest_max"]>$b["forest_max"]|| $neighbourInfo["mountains_max"]>$b["mountains_max"]){
      printrus
("<a href=\"citadel.php?$ses&amp;m=sciencespy&amp;neighbour=$neighbour\">Украсть разработки</a>
<br/>
");
     }else{
      printrus ("Уровень всех разработок ниже вашего!<br/>\r\n");
     }

   }else{
    printrus ("Наука у этого гос-ва не развита!<br/>\r\n");
   }

   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$neighbour\">Ok</a>
<br/>
");

  }elseif($n=="guard"){

   if(is_unitee($countryID,$neighbourID)){
    $spy_lvl=100;
   }else{
    $spy_lvl=min(100,$b["spy"]+$plus_altar);
   }
   if(building_exists($neighbourID,"wall")){
    if(is_unitee($countryID,$neighbourID))
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

    if(!is_unitee($countryID,$neighbourID)){
     printrus
("<a href=\"citadel.php?$ses&amp;m=sabotage&amp;neighbour=$neighbour\">Саботаж</a>
<br/>
");
if($b['atomic']==1)
printrus
("<a href=\"citadel.php?$ses&amp;m=atomic&amp;neighbour=$neighbour\">Взорвать атомной бомбой</a>
<br/>
");
}
   }else{
           //if(building_exists($neighbourID,"wall")
    printrus ("Стена остутствует<br/>\r\n");
   }

   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$neighbour\">Ok</a>
<br/>
");
  }elseif($n=="attack" && $nightmar==TRUE){
   printrus ("Вы находитесь в ночном моратории и не можете начать войну!<br/>\r\n");
  }elseif($n=="attack" && $b['moratory']>time()){
   printrus ("Вы находитесь в купленном моратории и не можете начать войну!<br/>\r\n");
  }elseif($n=="attack" AND $rTime!=0 AND !$tis and $ips!='sysreg' and $ips!='botsysreg1' and $ips!='botsysreg2' and $ips!='botsysreg3' and $ips!='botsysreg4' and $ips!='botsysreg5' and $ips!='botsysreg6' and $ips!='botsysreg7' and $ips!='botsysreg8' and $ips!='botsysreg9' and $ips!='botsysreg10' and $ips!='botsysreg11' and $ips!='botsysreg12' and $ips!='botsysreg13' and $ips!='botsysreg14' and $ips!='botsysreg15' and $ips!='botsysreg16' and $ips!='botsysreg17' and $ips!='botsysreg18' and $ips!='botsysreg19' and $ips!='botsysreg20'){
   //testCit($neighbourID,$country,'cit')
   // $rTime!=0
   printrus ("Вы намного старше этого государства!Подождите ".mkTimeStr($ost).".<br/>\r\n");
  }elseif($n=="attack" && is_unitee($countryID,$neighbourID)){#$neighbour_ = $neighbourInfo['countryName'];
   printrus ("Нельзя атаковать союзника!<br/>\r\n");
  }elseif($wcount>=3){
   printrus ("Можно вести максимум 3 войны!<br/>\r\n");
  }elseif($n=="attack" && war_between($countryID,$neighbourID)){
   printrus ("Вы уже воюете с этим гос-вом!<br/>\r\n");
  }elseif($n=="attack" && $mar=maratory($neighbourID)){
   printrus ("На эту страну действует мараторий неприкосновенности! Повторите попытку через ".mkTimeStr($mar)."<br/>\r\n");
  }elseif($n=="attack" && ($wariors_free+$wariors_free_2+$wariors_free_3+$wariors_free_4+$wariors_free_5+$wariors_free_6+$wariors_free_7+$wariors_free_8)<=0){
   printrus ("У вас нет свободных воинов!<br/>\r\n");
  }elseif($n=="attack" && !$general=general_info($countryID)){
   printrus ("Без генерала нельзя начать войну!<br/>\r\n");
  }elseif($n=="attack" && ($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8<=0)){
   printrus ("Сколько воинов вы отправите в поход?<br/>\r\n");
   //Форма для выбора войск
   print_form_voisko('citadel',array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8),'neighbours','attack',$neighbour);

  }elseif($n=="attack" && ($wariorsto>$wariors_free||$wariorsto_2>$wariors_free_2||$wariorsto_3>$wariors_free_3||$wariorsto_4>$wariors_free_4||$wariorsto_5>$wariors_free_5||$wariorsto_6>$wariors_free_6||$wariorsto_7>$wariors_free_7||$wariorsto_8>$wariors_free_8)){
   printrus ("У вас нет столько свободных воинов!<br/>\r\n");
   printrus ("Сколько воинов вы отправите в поход?<br/>\r\n");
   //Форма для выбора войск
   print_form_voisko('citadel',array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8),'neighbours','attack',$neighbour);

  }elseif($n=="attack"){

   mysql_query("UPDATE countries SET wariors_free = wariors_free - $wariorsto,
   wariors_free_2 = wariors_free_2 - $wariorsto_2, wariors_free_3 = wariors_free_3 - $wariorsto_3,
   wariors_free_4 = wariors_free_4 - $wariorsto_4, wariors_free_5 = wariors_free_5 - $wariorsto_5,
   wariors_free_6 = wariors_free_6 - $wariorsto_6, wariors_free_7 = wariors_free_7 - $wariorsto_7,
   wariors_free_8 = wariors_free_8 - $wariorsto_8
   WHERE countryID = '".$countryID."' LIMIT 1");
   $b['wariors_free'] = $b['wariors_free'] - $wariorsto;
   $b['wariors_free_2'] = $b['wariors_free_2'] - $wariorsto_2;
   $b['wariors_free_3'] = $b['wariors_free_3'] - $wariorsto_3;
   $b['wariors_free_4'] = $b['wariors_free_4'] - $wariorsto_4;
   $b['wariors_free_5'] = $b['wariors_free_5'] - $wariorsto_5;
   $b['wariors_free_6'] = $b['wariors_free_6'] - $wariorsto_6;
   $b['wariors_free_7'] = $b['wariors_free_7'] - $wariorsto_7;
   $b['wariors_free_8'] = $b['wariors_free_8'] - $wariorsto_8;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

  //Пишем в лог о битве:
 $open=fopen("../logs/war".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName']."(ID=".$countryID.") напала на ".$neighbour_." войском ".print_voisko(array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8))."\n\r");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   start_war($countryID,$neighbourID,array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8));

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");

  }elseif($n=='help'){

 //Время последней атаки
 $key=_PREFIKS.':wars'.$prid;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$neighbourID){
            $time3=$mem[$i]['time3'];
            break;
        }
    }else{
 $query="select * from `wars` where targetID='".$neighbourID."' and countryID='".$prid."' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $time3 = $a['time3'];
 }

  if (($atw+$atw_2+$atw_3+$atw_4+$atw_5+$atw_6+$atw_7+$atw_8)<10){
     printrus("Минимальное войско, которое вы можете послать - 10 человек!<br/>\n");
     }elseif(!is_unitee($countryID,$neighbour)){
     printrus("Данная страна не является Вашим союзником!<br/>\n");
     }elseif(!war_between($prid,$neighbourID)){
     printrus("Нет вторжения на территорию Вашего союзника от этого государства!<br/>\n");
     }elseif($time3+3600>time()){
     printrus("Вы можете атаковать противника только через час после последней атаки (неважно, атаковал ли его ваш союзник или вы)!<br/>\n");
     }elseif($atw>$b['wariors_free']||$atw_2>$b['wariors_free_2']||$atw_3>$b['wariors_free_3']||$atw_4>$b['wariors_free_4']||$atw_5>$b['wariors_free_5']||$atw_6>$b['wariors_free_6']||$atw_7>$b['wariors_free_7']||$atw_8>$b['wariors_free_8']){
     printrus("У вас нет стольких свободных воинов!<br/>\n");
     printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=help&amp;neighbour=$neighbour&amp;prid=$prid&amp;atw=".$b['wariors_free']."&amp;atw_2=".$b['wariors_free_2']."&amp;atw_3=".$b['wariors_free_3']."&amp;atw_4=".$b['wariors_free_4']."&amp;atw_5=".$b['wariors_free_5']."&amp;atw_6=".$b['wariors_free_6']."&amp;atw_7=".$b['wariors_free_7']."&amp;atw_8=".$b['wariors_free_8']."\">Послать всех!</a>
<br/>
");
     }elseif(!general_info($countryID)){
     printrus("У вас нет генерала!<br/>\n");
     }else{

printrus("Вы атаковали войско противника на территории вашего союзника!<br/>\n");
$nname = checkCountryID($neighbourID);
//$wariors = $atw;
//$wariors_2 = $atw_2;
//$wariors_3 = $atw_3;
$att_wariors = array($atw,$atw_2,$atw_3,$atw_4,$atw_5,$atw_6,$atw_7,$atw_8);

 $key2=_PREFIKS.':id'.$prid;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;
 $key3=_PREFIKS.':wars'.$prid;
 if (($mc=$memcache->get($key3))!==FALSE) $warst_m = TRUE; else $warst_m = FALSE;

 if ($idt_m==TRUE){
    $a=$mb;
    }else{
 $query="select * from `countries` where countryID='$prid' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 }


 $attacker=$a["countryName"];
 $country=$b["countryName"];

 //инфа о вражеском войске:
 if ($warst_m==TRUE){
    for ($i=0;$i<count($mc);$i++){
        if ($mc[$i]['targetID']==$neighbourID) {
                $attackers = $mc[$i]['wariors'];
                $attackers_2 = $mc[$i]['wariors_2'];
                $attackers_3 = $mc[$i]['wariors_3'];
                $attackers_4 = $mc[$i]['wariors_4'];
                $attackers_5 = $mc[$i]['wariors_5'];
                $attackers_6 = $mc[$i]['wariors_6'];
                $attackers_7 = $mc[$i]['wariors_7'];
                $attackers_8 = $mc[$i]['wariors_8'];
                break;
            }
        }

    }else{
 //$attackers=getValue("targetID='$neighbourID' and countryID='$prid'","wars","wariors");
 $r2 = mysql_query("SELECT wariors, wariors_2, wariors_3, wariors_4, wariors_5, wariors_6, wariors_7, wariors_8 FROM `wars` WHERE targetID='$neighbourID' and countryID='$prid' LIMIT 1");
 $a2 = mysql_fetch_array($r2);
 $attackers = $a2['wariors'];
 $attackers_2 = $a2['wariors_2'];
 $attackers_3 = $a2['wariors_3'];
 $attackers_4 = $a2['wariors_4'];
 $attackers_5 = $a2['wariors_5'];
 $attackers_6 = $a2['wariors_6'];
 $attackers_7 = $a2['wariors_7'];
 $attackers_8 = $a2['wariors_8'];
 }
 $def_wariors=array($attackers,$attackers_2,$attackers_3,$attackers_4,$attackers_5,$attackers_6,$attackers_7,$attackers_8);

 $def_params['bronya_kind']=$a["bronya_kind"];
 $def_params['weapon_kind']=$a["weapon_kind"];
 $def_params['weapon_speed']=array($a["weapon_speed"],$a["weapon_speed_2"],$a["weapon_speed_3"],$a["weapon_speed_4"],$a["weapon_speed_5"],$a["weapon_speed_6"],$a["weapon_speed_7"],$a["weapon_speed_8"]);
 $def_params['weapon_force']=array($a["weapon_force"],$a["weapon_force_2"],$a["weapon_force_3"],$a["weapon_force_4"],$a["weapon_force_5"],$a["weapon_force_6"],$a["weapon_force_7"],$a["weapon_force_8"]);

 //инфа о своем войске:
 $att_params['bronya_kind']=$b["bronya_kind"];
 $att_params['weapon_kind']=$b["weapon_kind"];

 $att_params['weapon_speed']=array($b["weapon_speed"],$b["weapon_speed_2"],$b["weapon_speed_3"],$b["weapon_speed_4"],$b["weapon_speed_5"],$b["weapon_speed_6"],$b["weapon_speed_7"],$b["weapon_speed_8"]);
 $att_params['weapon_force']=array($b["weapon_force"],$b["weapon_force_2"],$b["weapon_force_3"],$b["weapon_force_4"],$b["weapon_force_5"],$b["weapon_force_6"],$b["weapon_force_7"],$b["weapon_force_8"]);

$att_skill_speed=array($b["weapon_speed"],$b["weapon_speed_2"],$b["weapon_speed_3"],$b["weapon_speed_4"],$b["weapon_speed_5"],$b["weapon_speed_6"],$b["weapon_speed_7"],$b["weapon_speed_8"]);
$att_skill_force=array($b["weapon_force"],$b["weapon_force_2"],$b["weapon_force_3"],$b["weapon_force_4"],$b["weapon_force_5"],$b["weapon_force_6"],$b["weapon_force_7"],$b["weapon_force_8"]);
if($b["bronya_kind"] == 0){$att_bronya='легкая';}elseif($b["bronya_kind"] == 1){$att_bronya='тяжелая';}else{$att_bronya='инопланетная';}
if($b["weapon_kind"] == 0){$att_weapon='легкое';}elseif($b["weapon_kind"] == 1){$att_weapon='тяжелое';}else{$att_weapon='инопланетное';}

$def_skill_speed=array($a["weapon_speed"],$a["weapon_speed_2"],$a["weapon_speed_3"],$a["weapon_speed_4"],$a["weapon_speed_5"],$a["weapon_speed_6"],$a["weapon_speed_7"],$a["weapon_speed_8"]);
$def_skill_force=array($a["weapon_force"],$a["weapon_force_2"],$a["weapon_force_3"],$a["weapon_force_4"],$a["weapon_force_5"],$a["weapon_force_6"],$a["weapon_force_7"],$a["weapon_force_8"]);
if($a["bronya_kind"] == 0){$def_bronya='легкая';}elseif($a["bronya_kind"] == 1){$def_bronya='тяжелая';}else{$def_bronya='инопланетная';}
if($a["weapon_kind"] == 0){$def_weapon='легкое';}elseif($a["weapon_kind"] == 1){$def_weapon='тяжелое';}else{$def_weapon='инопланетное';}


  //     начало артефактов
$x=1;
 //Влияние артефактов
 if (isArtefact($prid, 'sapog'))  // 1
 {
    $def_params['weapon_speed'][0]*=1.5*$x;
    $def_params['weapon_force'][0]*=1.5*$x;
    $def_art.='Кирзовый сапог, ';
 }
 if (isArtefact($prid, 'podkova'))   // 2
 {
    $def_params['weapon_speed'][1]*=1.5*$x;
    $def_params['weapon_force'][1]*=1.5*$x;
    $def_art.='Стальная подкова, ';
 }
 if (isArtefact($prid, 'red_dragon_flame_tongue'))   // 3
 {
    $def_params['weapon_speed'][1]*=2*$x;
    $def_art.='Языки пламени Красного Дракона, ';
 }
 if (isArtefact($prid, 'puli'))   // 4
  {
    $def_params['weapon_speed'][2]*=1.3*$x;
    $def_params['weapon_force'][2]*=1.3*$x;
    $def_art.='Бронебойные пули, ';
 }

 if (isArtefact($prid, 'yadro'))  // 5
  {
    $def_params['weapon_speed'][3]*=1.3*$x;
    $def_params['weapon_force'][3]*=1.3*$x;
    $def_art.='Чугунное ядро, ';
 }

 if (isArtefact($prid, 'the_artillery_fire'))    // 6
  {
    $def_params['weapon_speed'][3]*=1.2*$x;
    $def_params['weapon_force'][3]*=1.5*$x;
    $def_art.='Артиллерийская стрельба, ';
 }

  if (isArtefact($prid, 'podrivnoe_delo'))     // 7
  {
    $def_params['weapon_speed'][4]*=1.3*$x;
    $def_params['weapon_force'][4]*=1.3*$x;
    $def_art.='Брошюра подрывное дело, ';
 }

  if (isArtefact($prid, 'pult'))            // 8
  {
    $def_params['weapon_speed'][4]*=2*$x;
    $def_params['weapon_force'][4]*=2*$x;
    $def_art.='Пульт с дистанционным управлением, ';
 }

  if (isArtefact($prid, 'avia_pulemet'))       // 9
  {
    $def_params['weapon_speed'][5]*=1.2*$x;
    $def_params['weapon_force'][5]*=1.2*$x;
    $def_art.='Авиа пулемёт, ';
 }

 if (isArtefact($prid, 'angel_wings'))      // 10
  {
    $def_params['weapon_speed'][5]*=1.3*$x;
    $def_params['weapon_force'][5]*=1.15*$x;
    $def_art.='Ангельские крылья, ';
 }

 if (isArtefact($prid, 'teh_volshebstvo'))  // 11
  {
    $def_params['weapon_speed'][6]*=1.5*$x;
    $def_params['weapon_force'][6]*=1.5*$x;
    $def_art.='Техническое волшебство, ';
 }

  if (isArtefact($prid, 'lions_shield_of_courage'))  // 12
  {
    $def_params['weapon_speed'][0]*=2*$x;
    $def_params['weapon_force'][0]*=4*$x;
    $def_art.='Львиный щит бесстрашия, ';
 }


 if (isArtefact($countryID, 'sapog'))       // 1
 {
    $att_params['weapon_speed'][0]*=1.5*$x;
    $att_params['weapon_force'][0]*=1.5*$x;
    $att_art.='Кирзовый сапог, ';
 }
 if (isArtefact($countryID, 'podkova'))      // 2
  {
    $att_params['weapon_speed'][1]*=1.5*$x;
    $att_params['weapon_force'][1]*=1.5*$x;
    $att_art.='Стальная подкова, ';
 }
 if (isArtefact($countryID, 'red_dragon_flame_tongue'))    // 3
  {
    $att_params['weapon_speed'][1]*=2*$x;
    $att_art.='Языки пламени Красного Дракона, ';
 }
 if (isArtefact($countryID, 'puli'))    // 4
 {
    $att_params['weapon_speed'][2]*=1.3*$x;
    $att_params['weapon_force'][2]*=1.3*$x;
    $att_art.='Бронебойные пули, ';
 }

  if (isArtefact($countryID, 'yadro'))    // 5
 {
    $att_params['weapon_speed'][3]*=1.3*$x;
    $att_params['weapon_force'][3]*=1.3*$x;
    $att_art.='Чугунное ядро, ';
 }

 if (isArtefact($countryID, 'the_artillery_fire'))   // 6
 {
    $att_params['weapon_speed'][3]*=1.2*$x;
    $att_params['weapon_force'][3]*=1.5*$x;
    $att_art.='Артиллерийская стрельба, ';
 }

  if (isArtefact($countryID, 'podrivnoe_delo'))   // 7
  {
    $att_params['weapon_speed'][4]*=1.3*$x;
    $att_params['weapon_force'][4]*=1.3*$x;
    $att_art.='Брошюра подрывное дело, ';
 }

  if (isArtefact($countryID, 'pult'))        // 8
  {
    $att_params['weapon_speed'][4]*=2*$x;
    $att_params['weapon_force'][4]*=2*$x;
    $att_art.='Пульт с дистанционным управлением, ';
 }

  if (isArtefact($countryID, 'avia_pulemet'))   // 9
  {
    $att_params['weapon_speed'][5]*=1.2*$x;
    $att_params['weapon_force'][5]*=1.2*$x;
    $att_art.='Авиа пулемёт, ';
 }

 if (isArtefact($countryID, 'angel_wings'))         // 10
  {
    $att_params['weapon_speed'][5]*=1.3*$x;
    $att_params['weapon_force'][5]*=1.15*$x;
    $att_art.='Ангельские крылья, ';
 }

  if (isArtefact($countryID, 'teh_volshebstvo'))    // 11
  {
    $att_params['weapon_speed'][6]*=1.5*$x;
    $att_params['weapon_force'][6]*=1.5*$x;
    $att_art.='Техническое волшебство, ';
 }

 if (isArtefact($countryID, 'lions_shield_of_courage'))    // 12
  {
    $att_params['weapon_speed'][0]*=2*$x;
    $att_params['weapon_force'][0]*=4*$x;
    $att_art.='Львиный щит бесстрашия, ';
 }


 $att_general = general_info($countryID);
 if(($general=general_info($prid))) $def_general = $general;
 else $def_general = array();

  if($att_nz=isNewBuildings($countryID,'altar')){
  $att_nowZD.='Алтарь смерти: ';
    if(($att_nz['time_sac']+259200) > time()){
    $att_general['moral']+=$att_nz['un_1'];
    $att_params['weapon_speed'][0]+=$att_nz['un_3'];
    $att_params['weapon_force'][0]+=$att_nz['un_3'];
    $att_params['weapon_speed'][1]+=$att_nz['un_3'];
    $att_params['weapon_force'][1]+=$att_nz['un_3'];
    $att_params['weapon_speed'][2]+=$att_nz['un_3'];
    $att_params['weapon_force'][2]+=$att_nz['un_3'];
    $att_params['weapon_speed'][3]+=$att_nz['un_3'];
    $att_params['weapon_force'][3]+=$att_nz['un_3'];
    $att_params['weapon_speed'][4]+=$att_nz['un_3'];
    $att_params['weapon_force'][4]+=$att_nz['un_3'];
    $att_params['weapon_speed'][5]+=$att_nz['un_3'];
    $att_params['weapon_force'][5]+=$att_nz['un_3'];
    $att_params['weapon_speed'][6]+=$att_nz['un_3'];
    $att_params['weapon_force'][6]+=$att_nz['un_3'];
    $att_nowZD.='+'.$att_nz['un_1'].' мораль, +'.$att_nz['un_3'].' параметры войск, ';
    }
  if(($att_nz['time_uz']+259200) > time()){$att_general['study']+=10; $att_general['moral']+=10; $att_nowZD.='+10 мораль, +10 навыка, ';}
  $att_nowZD.='<br />';
  }

  if($att_nz=isNewBuildings($countryID,'dungeon')){
  $att_nowZD.='Подземелье: ';
    if(($att_nz['un_1']+259200) > time()){
    $att_params['weapon_force'][0]+=4;
    $att_params['weapon_force'][1]+=4;
    $att_params['weapon_force'][2]+=4;
    $att_params['weapon_force'][4]+=4;
    $att_nowZD.='Гномий кузнечный молот + 4 к силе пехотинцев, кавалеристам, стрелкам, подрывникам, ';
    }
    if(($att_nz['un_4']+259200) > time()){
    $att_params['weapon_speed'][0]+=5;
    $att_params['weapon_speed'][1]+=5;
    $att_params['weapon_speed'][2]+=5;
    $att_params['weapon_speed'][4]+=5;
    $att_nowZD.='Поножи Короля Гномов + 5 к скорости пехотинцев, кавалеристов, стрелков, подрывников, ';
    }
  if(($att_nz['un_2']+259200) > time()){$att_general['study']+=10; $att_general['moral']+=10; $att_nowZD.='Кираса Короля Гномов +10 к морали генерала, +10 к навыку генерала, ';}
  $att_nowZD.='<br />';
  }

  if($def_nz=isNewBuildings($prid,'altar')){
  $def_nowZD.='Алтарь смерти: ';
    if(($def_nz['time_sac']+259200) > time()){
    $def_general['moral']+=$def_nz['un_1'];
    $def_params['weapon_speed'][0]+=$def_nz['un_3'];
    $def_params['weapon_force'][0]+=$def_nz['un_3'];
    $def_params['weapon_speed'][1]+=$def_nz['un_3'];
    $def_params['weapon_force'][1]+=$def_nz['un_3'];
    $def_params['weapon_speed'][2]+=$def_nz['un_3'];
    $def_params['weapon_force'][2]+=$def_nz['un_3'];
    $def_params['weapon_speed'][3]+=$def_nz['un_3'];
    $def_params['weapon_force'][3]+=$def_nz['un_3'];
    $def_params['weapon_speed'][4]+=$def_nz['un_3'];
    $def_params['weapon_force'][4]+=$def_nz['un_3'];
    $def_params['weapon_speed'][5]+=$def_nz['un_3'];
    $def_params['weapon_force'][5]+=$def_nz['un_3'];
    $def_params['weapon_speed'][6]+=$def_nz['un_3'];
    $def_params['weapon_force'][6]+=$def_nz['un_3'];
    $def_nowZD.='+'.$def_nz['un_1'].' мораль, +'.$def_nz['un_3'].' параметры войск, ';
    }
  if(($def_nz['time_uz']+259200) > time()){$def_general['study']+=10; $def_general['moral']+=10; $def_nowZD.='+10 мораль, +10 навыка, ';}
  $def_nowZD.='<br />';
  }

  if($def_nz=isNewBuildings($prid,'dungeon')){
  $def_nowZD.='Подземелье: ';
    if(($def_nz['un_1']+259200) > time()){
    $def_params['weapon_force'][0]+=4;
    $def_params['weapon_force'][1]+=4;
    $def_params['weapon_force'][2]+=4;
    $def_params['weapon_force'][4]+=4;
    $def_nowZD.='Гномий кузнечный молот + 4 к силе пехотинцев, кавалеристам, стрелкам, подрывникам, ';
    }
    if(($def_nz['un_4']+259200) > time()){
    $def_params['weapon_speed'][0]+=5;
    $def_params['weapon_speed'][1]+=5;
    $def_params['weapon_speed'][2]+=5;
    $def_params['weapon_speed'][4]+=5;
    $def_nowZD.='Поножи Короля Гномов + 5 к скорости пехотинцев, кавалеристов, стрелков, подрывников, ';
    }
  if(($def_nz['un_2']+259200) > time()){$def_general['study']+=10; $def_general['moral']+=10; $def_nowZD.='Кираса Короля Гномов +10 к морали генерала, +10 к навыку генерала, ';}
  $def_nowZD.='<br />';
  }

$att_skill_speed_art=array($att_params['weapon_speed'][0],$att_params['weapon_speed'][1],$att_params['weapon_speed'][2],$att_params['weapon_speed'][3],$att_params['weapon_speed'][4],$att_params['weapon_speed'][5],$att_params['weapon_speed'][7],$att_params['weapon_speed'][7]);
$att_skill_force_art=array($att_params['weapon_force'][0],$att_params['weapon_force'][1],$att_params['weapon_force'][2],$att_params['weapon_force'][3],$att_params['weapon_force'][4],$att_params['weapon_force'][5],$att_params['weapon_force'][7],$att_params['weapon_force'][7]);

$def_skill_speed_art=array($def_params['weapon_speed'][0],$def_params['weapon_speed'][1],$def_params['weapon_speed'][2],$def_params['weapon_speed'][3],$def_params['weapon_speed'][4],$def_params['weapon_speed'][5],$def_params['weapon_speed'][7],$def_params['weapon_speed'][7]);
$def_skill_force_art=array($def_params['weapon_force'][0],$def_params['weapon_force'][1],$def_params['weapon_force'][2],$def_params['weapon_force'][3],$def_params['weapon_force'][4],$def_params['weapon_force'][5],$def_params['weapon_force'][7],$def_params['weapon_force'][7]);

  //Артефакт учебник тактики
  if (isArtefact($countryID, 'kniga_taktiki'))    // 1
  {$att_general['study']+=200; $att_art.='Учебник по тактике, ';}

  if (isArtefact($prid, 'kniga_taktiki'))   // 1
  {$def_general['study']+=200; $def_art.='Учебник по тактике, ';}

  //Артефакт медаль за храбрость
  if (isArtefact($countryID, 'medal'))            // 2
  {$att_general['moral']+=30; $att_art.='Медаль за храбрость, ';}
                                                  // 2
  if (isArtefact($prid, 'medal'))
  {$def_general['moral']+=30; $def_art.='Медаль за храбрость, ';}

  //Артефакт Щит из чешуи дракона
  if (isArtefact($countryID, 'dragon_scale_shield'))    // 3
  {$att_general['moral']+=50; $att_art.='Щит из чешуи дракона, ';}

  if (isArtefact($prid, 'dragon_scale_shield'))  // 3
  {$def_general['moral']+=50; $def_art.='Щит из чешуи дракона, ';}

   //Герб Доблести:  +100000 опыта генералу
  if (isArtefact($countryID, 'crest_of_valor'))    // 4
  {$att_general['expiriense']+=5000; $att_art.='Герб Доблести, ';}

  if (isArtefact($prid, 'crest_of_valor'))  // 4
  {$def_general['expiriense']+=5000; $def_art.='Герб Доблести, ';}

/*=================================================== для лога войны ============================================================*/
$att_arm_info=''; $def_arm_info='';


$att_us=UzersInfo($countryID);
$def_us=UzersInfo($prid);
$sz_us=UzersInfo($neighbourID);

if($att_us['class'] == 1){$att_class='Воин';}elseif($att_us['class'] == 2){$att_class='Торговец';}elseif($att_us['class'] == 3){$att_class='Странник';}elseif($att_us['class'] == 4){$att_class='Ремесленник';}
elseif($att_us['class'] == 5){$att_class='Вор';}elseif($att_us['class'] == 6){$att_class='Дипломат';}elseif($att_us['class'] == 7){$att_class='Адмирал';}elseif($att_us['class'] == 8){$att_class='Разбойник';}else{$att_class='Вася';}
if($att_us['race'] == 1){$att_rassa="Демон";}elseif($att_us['race'] == 2){$att_rassa="Человек";}elseif($att_us['race'] == 3){$att_rassa="Нежить";}
elseif($att_us['race'] == 4){$att_rassa="Гном";}else{$att_rassa="Вася";}

if($def_us['class'] == 1){$def_class='Воин';}elseif($def_us['class'] == 2){$def_class='Торговец';}elseif($def_us['class'] == 3){$def_class='Странник';}
elseif($def_us['class'] == 4){$def_class='Ремесленник';}elseif($def_us['class'] == 5){$def_class='Вор';}elseif($def_us['class'] == 6){$def_class='Дипломат';}
elseif($def_us['class'] == 7){$def_class='Адмирал';}elseif($def_us['class'] == 8){$def_class='Разбойник';}else{$def_class='Вася';}
if($def_us['race'] == 1){$def_rassa="Демон";}elseif($def_us['race'] == 2){$def_rassa="Человек";}elseif($def_us['race'] == 3){$def_rassa="Нежить";}
elseif($def_us['race'] == 4){$def_rassa="Гном";}else{$def_rassa="Вася";}

if($sz_us['class'] == 1){$sz_class='Воин';}elseif($sz_us['class'] == 2){$sz_class='Торговец';}elseif($sz_us['class'] == 3){$sz_class='Странник';}
elseif($sz_us['class'] == 4){$sz_class='Ремесленник';}elseif($sz_us['class'] == 5){$sz_class='Вор';}elseif($sz_us['class'] == 6){$sz_class='Дипломат';}
elseif($sz_us['class'] == 7){$sz_class='Адмирал';}elseif($sz_us['class'] == 8){$sz_class='Разбойник';}else{$sz_class='Вася';}
if($sz_us['race'] == 1){$sz_rassa="Демон";}elseif($sz_us['race'] == 2){$sz_rassa="Человек";}elseif($sz_us['race'] == 3){$sz_rassa="Нежить";}
elseif($sz_us['race'] == 4){$sz_rassa="Гном";}else{$sz_rassa="Вася";}

$att_logs.='Бой страны <span class="r1"><u>'.$country.'</u> ['.$att_rassa.'-'.$att_class.']</span> на территории союзника <span class="r3"><u>'.$neighbour_.'</u> ['.$sz_rassa.'-'.$sz_class.']</span>, против войска Страны <span class="r2"><u>'.$attacker.'</u> ['.$def_rassa.'-'.$def_class.']</span>.<br />';
$def_logs.='Бой страны <span class="r1"><u>'.$country.'</u> ['.$att_rassa.'-'.$att_class.']</span> на территории союзника <span class="r3"><u>'.$neighbour_.'</u> ['.$sz_rassa.'-'.$sz_class.']</span>, против войска Страны <span class="r2"><u>'.$attacker.'</u> ['.$def_rassa.'-'.$def_class.']</span>.<br />';

  for($i=0;$i<=7;$i++){
  if ($att_wariors[$i]>0) $att_arm_info .= get_unit_name($i).': <b>'.$att_wariors[$i].'</b> ['.$att_skill_speed[$i].'/'.$att_skill_force[$i].'] ('.$att_skill_speed_art[$i].'/'.$att_skill_force_art[$i].'),<br/>';
  }

  for($j=0;$j<=7;$j++){
  if ($def_wariors[$j]>0) $def_arm_info .= get_unit_name($j).': <b>'.$def_wariors[$j].'</b> ['.$def_skill_speed[$j].'/'.$def_skill_force[$j].'] ('.$def_skill_speed_art[$j].'/'.$def_skill_force_art[$j].'),<br/>';
  }

$att_gen = general_info($countryID);
$def_gen = general_info($prid);
if($def_art == ''){$def_art='Нету';}
if($att_art == ''){$att_art='Нету';}

$att_logs.='Войско страны <span class="r1"><u>'.$country.'</u></span><br />'.$att_arm_info.'Броня ['.$att_bronya.']; Оружие ['.$att_weapon.']<br />Генерал страны <span class="r1"><u>'.$country.'</u></span> [мораль '.$att_gen['moral'].', опыт '.$att_gen['expiriense'].', навык '.$att_gen['study'].']['.$att_general['moral'].'/'.$att_general['expiriense'].'/'.$att_general['study'].']<br />Артефакты: '.$att_art.'<br />'.$att_nowZD.'Войско страны <span class="r2"><u>'.$attacker.'</u></span><br />'.$def_arm_info.'Броня ['.$def_bronya.']; Оружие ['.$def_weapon.']<br />Генерал страны <span class="r2"><u>'.$attacker.'</u></span> [мораль '.$def_gen['moral'].', опыт '.$def_gen['expiriense'].', навык '.$def_gen['study'].']['.$def_general['moral'].'/'.$def_general['expiriense'].'/'.$def_general['study'].']<br />Артефакты: '.$def_art.'<br />'.$def_nowZD.'';

$def_logs.='Войско страны <span class="r2"><u>'.$attacker.'</u></span><br />'.$def_arm_info.'Броня ['.$def_bronya.']; Оружие ['.$def_weapon.']<br />Генерал страны <span class="r2"><u>'.$attacker.'</u></span> [мораль '.$def_gen['moral'].', опыт '.$def_gen['expiriense'].', навык '.$def_gen['study'].']['.$def_general['moral'].'/'.$def_general['expiriense'].'/'.$def_general['study'].']<br />Артефакты: '.$def_art.'<br />'.$def_nowZD.'Войско страны <span class="r1"><u>'.$country.'</u></span><br />'.$att_arm_info.'Броня ['.$att_bronya.']; Оружие ['.$att_weapon.']<br />Генерал страны <span class="r1"><u>'.$country.'</u></span> [мораль '.$att_gen['moral'].', опыт '.$att_gen['expiriense'].', навык '.$att_gen['study'].']['.$att_general['moral'].'/'.$att_general['expiriense'].'/'.$att_general['study'].']<br />Артефакты: '.$att_art.'<br />'.$att_nowZD.'';



 $br = battle($att_general,$att_params,$att_wariors,$def_general,$def_params,$def_wariors);

$att_logs.='Реальные характеристики войск <span class="r1"><u>'.$country.'</u></span> = нанес урона ('.$br[3].'), берсерк ('.$br[4].'), влияние тер-рии (1)<br />Реальные характеристики войск <span class="r2"><u>'.$attacker.'</u></span> = нанес урона (1), берсерк (0), влияние тер-рии (1)<br />';

$def_logs.='Реальные характеристики войск <span class="r2"><u>'.$attacker.'</u></span> = нанес урона (1), берсерк (0), влияние тер-рии (1)<br />Реальные характеристики войск <span class="r1"><u>'.$country.'</u></span> = нанес урона ('.$br[3].'), берсерк ('.$br[4].'), влияние тер-рии (1)<br />';


 //конец сражения:
 if($br[0]=='att')
 {
 //мы победили

  $query="delete from `wars` where countryID='$prid' and targetID='$neighbourID' limit 1";
  $result=@MYSQL_QUERY($query);
  if ($warst_m==TRUE){
     $neww=array();
     for ($i=0;$i<count($mc);$i++) if ($mc[$i]['targetID']!=$neighbourID) array_push($neww,$mc[$i]);
     $memcache->set($key3,$neww,false,86400);
     }
  $wariors_end = round($att_wariors[0]*(1-$br[1]/$br[2]));
  $ubito = round($att_wariors[0]*$br[1]/$br[2]);
  $wariors_end_2 = round($att_wariors[1]*(1-$br[1]/$br[2]));
  $ubito_2 = round($att_wariors[1]*$br[1]/$br[2]);
  $wariors_end_3 = round($att_wariors[2]*(1-$br[1]/$br[2]));
  $ubito_3 = round($att_wariors[2]*$br[1]/$br[2]);
  $wariors_end_4 = round($att_wariors[3]*(1-$br[1]/$br[2]));
  $ubito_4 = round($att_wariors[3]*$br[1]/$br[2]);
  $wariors_end_5 = round($att_wariors[4]*(1-$br[1]/$br[2]));
  $ubito_5 = round($att_wariors[4]*$br[1]/$br[2]);
  $wariors_end_6 = round($att_wariors[5]*(1-$br[1]/$br[2]));
  $ubito_6 = round($att_wariors[5]*$br[1]/$br[2]);
  $wariors_end_7 = round($att_wariors[6]*(1-$br[1]/$br[2]));
  $ubito_7 = round($att_wariors[6]*$br[1]/$br[2]);
  $wariors_end_8 = round($att_wariors[7]*(1-$br[1]/$br[2]));
  $ubito_8 = round($att_wariors[7]*$br[1]/$br[2]);

  mysql_query("UPDATE countries SET wariors_free = wariors_free - $ubito,
  wariors_free_2 = wariors_free_2 - $ubito_2, wariors_free_3 = wariors_free_3 - $ubito_3,
  wariors_free_4 = wariors_free_4 - $ubito_4, wariors_free_5 = wariors_free_5 - $ubito_5,
  wariors_free_6 = wariors_free_6 - $ubito_6, wariors_free_7 = wariors_free_7 - $ubito_7,
  wariors_free_8 = wariors_free_8 - $ubito_8
  WHERE countryID = '".$countryID."' LIMIT 1");
  $b['wariors_free'] = $b['wariors_free'] - $ubito;
  $b['wariors_free_2'] = $b['wariors_free_2'] - $ubito_2;
  $b['wariors_free_3'] = $b['wariors_free_3'] - $ubito_3;
  $b['wariors_free_4'] = $b['wariors_free_4'] - $ubito_4;
  $b['wariors_free_5'] = $b['wariors_free_5'] - $ubito_5;
  $b['wariors_free_6'] = $b['wariors_free_6'] - $ubito_6;
  $b['wariors_free_7'] = $b['wariors_free_7'] - $ubito_7;
  $b['wariors_free_8'] = $b['wariors_free_8'] - $ubito_8;
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

     if(isNewBuildings($countryID,'necropolis')){
     mysql_query("UPDATE buildings SET un_1 = un_1 + $ubito,
     un_2 = un_2 + $ubito_2, un_3 = un_3 + $ubito_3, un_4 = un_4 + $ubito_4,
     un_5 = un_5 + $ubito_5, un_6 = un_6 + $ubito_6, un_7 = un_7 + $ubito_7
     WHERE countryID = '$countryID' and building = 'necropolis' LIMIT 1");

     $key=_PREFIKS.':buildings'.$countryID;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
        $mem[$i]['un_1'] = $mem[$i]['un_1'] + $ubito;
        $mem[$i]['un_2'] = $mem[$i]['un_2'] + $ubito_2;
        $mem[$i]['un_3'] = $mem[$i]['un_3'] + $ubito_3;
        $mem[$i]['un_4'] = $mem[$i]['un_4'] + $ubito_4;
        $mem[$i]['un_5'] = $mem[$i]['un_5'] + $ubito_5;
        $mem[$i]['un_6'] = $mem[$i]['un_6'] + $ubito_6;
        $mem[$i]['un_7'] = $mem[$i]['un_7'] + $ubito_7;
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }
     }

     if(isNewBuildings($prid,'necropolis')){
     mysql_query("UPDATE buildings SET un_1 = un_1 + $attackers,
     un_2 = un_2 + $attackers_2, un_3 = un_3 + $attackers_3, un_4 = un_4 + $attackers_4,
     un_5 = un_5 + $attackers_5, un_6 = un_6 + $attackers_6, un_7 = un_7 + $attackers_7
     WHERE countryID = '$prid' and building = 'necropolis' LIMIT 1");

     $key=_PREFIKS.':buildings'.$prid;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
        $mem[$i]['un_1'] = $mem[$i]['un_1'] + $attackers;
        $mem[$i]['un_2'] = $mem[$i]['un_2'] + $attackers_2;
        $mem[$i]['un_3'] = $mem[$i]['un_3'] + $attackers_3;
        $mem[$i]['un_4'] = $mem[$i]['un_4'] + $attackers_4;
        $mem[$i]['un_5'] = $mem[$i]['un_5'] + $attackers_5;
        $mem[$i]['un_6'] = $mem[$i]['un_6'] + $attackers_6;
        $mem[$i]['un_7'] = $mem[$i]['un_7'] + $attackers_7;
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }
     }


  printrus ("Вы разбили войско гос-ва <u>$attacker</u>. Потери:<br/>".print_voisko(array($ubito,$ubito_2,$ubito_3,$ubito_4,$ubito_5,$ubito_6,$ubito_7,$ubito_8))."\r\n");
  sendMessage($prid,"fullMessage","Гос-во <u>$country</u> (союзник <u>$nname</u>) разбило все ваше войско на своей территории гос-ва <u>$nname</u>.");
  sendMessage($neighbourID,"fullMessage","Ваш союзник <u>$country</u> разбил все войска гос-ва <u>$attacker</u> на вашей территории!");

  //повышение опыта генералов:
  $lg=general_exp($countryID,$prid,array($ubito,$ubito_2,$ubito_3,$ubito_4,$ubito_5,$ubito_6,$ubito_7,$ubito_8),$def_wariors);

  $att_logs.='Гос-во <span class="r1"><u>'.$country.'</u></span> одержало победу над вражеским войском!<br />После битвы у страны <span class="r1"><u>'.$country.'</u></span> Уцелело воинов:<br/>'.print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8)).'';

 $def_logs.='Гос-во <span class="r1"><u>'.$country.'</u></span> разбило все ваше войско на территории союзника <span class="r3"><u>'.$neighbour_.'</u></span>!<br />После битвы у страны <span class="r1"><u>'.$country.'</u></span> Уцелело воинов:<br/>'.print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8)).'';

 }
 else
 {

  //Запишем время последней атаки
 $query="UPDATE `wars` SET time3='".time()."' where countryID='$prid' and targetID='$neighbourID' limit 1";
 $result=@MYSQL_QUERY($query);
 if ($warst_m==TRUE){
 for ($i=0;$i<count($mc);$i++) if ($mc[$i]['targetID']==$neighbourID){
         $mc[$i]['time3']=time();
         break;
    }
 $memcache->set($key3,$mc,false,86400);
 }

  $att_end = round($def_wariors[0]*(1-$br[2]/$br[1]));
  $ubito = round($def_wariors[0]*$br[2]/$br[1]);
  $att_end_2 = round($def_wariors[1]*(1-$br[2]/$br[1]));
  $ubito_2 = round($def_wariors[1]*$br[2]/$br[1]);
  $att_end_3 = round($def_wariors[2]*(1-$br[2]/$br[1]));
  $ubito_3 = round($def_wariors[2]*$br[2]/$br[1]);
  $att_end_4 = round($def_wariors[3]*(1-$br[2]/$br[1]));
  $ubito_4 = round($def_wariors[3]*$br[2]/$br[1]);
  $att_end_5 = round($def_wariors[4]*(1-$br[2]/$br[1]));
  $ubito_5 = round($def_wariors[4]*$br[2]/$br[1]);
  $att_end_6 = round($def_wariors[5]*(1-$br[2]/$br[1]));
  $ubito_6 = round($def_wariors[5]*$br[2]/$br[1]);
  $att_end_7 = round($def_wariors[6]*(1-$br[2]/$br[1]));
  $ubito_7 = round($def_wariors[6]*$br[2]/$br[1]);
  $att_end_8 = round($def_wariors[7]*(1-$br[2]/$br[1]));
  $ubito_8 = round($def_wariors[7]*$br[2]/$br[1]);
  //Должен остаться хотя бы 1 юнит:
  if (($att_end+$att_end_2+$att_end_3+$att_end_4+$att_end_5+$att_end_6+$att_end_7+$att_end_8)<=0){
  if ($def_wariors[0]>0)$att_end=1;
  elseif ($def_wariors[1]>0)$att_end_2=1;
  elseif ($def_wariors[2]>0)$att_end_3=1;
  elseif ($def_wariors[3]>0)$att_end_4=1;
  elseif ($def_wariors[4]>0)$att_end_5=1;
  elseif ($def_wariors[5]>0)$att_end_6=1;
  elseif ($def_wariors[6]>0)$att_end_7=1;
  elseif ($def_wariors[7]>0)$att_end_8=1;
  }

  mysql_query("UPDATE `wars` SET wariors = $att_end, wariors_2 = $att_end_2, wariors_3 = $att_end_3,
  wariors_4 = $att_end_4, wariors_5 = $att_end_5, wariors_6 = $att_end_6,
  wariors_7 = $att_end_7, wariors_8 = $att_end_8
  WHERE countryID = '$prid' and targetID = '$neighbourID' LIMIT 1");

  if ($warst_m==TRUE){
     for ($i=0;$i<count($mc);$i++){
         if ($mc[$i]['targetID']==$neighbourID){
                 $mc[$i]['wariors']=$att_end;
                 $mc[$i]['wariors_2']=$att_end_2;
                 $mc[$i]['wariors_3']=$att_end_3;
                 $mc[$i]['wariors_4']=$att_end_4;
                 $mc[$i]['wariors_5']=$att_end_5;
                 $mc[$i]['wariors_6']=$att_end_6;
                 $mc[$i]['wariors_7']=$att_end_7;
                 $mc[$i]['wariors_8']=$att_end_8;
                 $memcache->set($key3,$mc,false,86400);
                 break;
            }
         }
     }


  printrus ("Ваше войско было разбито. Вам не удалось разбить войско гос-ва <u>$attacker</u>! Вы убили:<br/>".print_voisko(array($ubito,$ubito_2,$ubito_3,$ubito_4,$ubito_5,$ubito_6,$ubito_7,$ubito_8))."\r\n");
  sendMessage($prid,"fullMessage","Ваши войска на территории гос-ва <u>$nname</u> были атакованы союзным ему гос-вом <u>$country</u>, но врагу не удалось вас разбить. Уцелело:<br/>".print_voisko(array($att_end,$att_end_2,$att_end_3,$att_end_4,$att_end_5,$att_end_6,$att_end_7,$att_end_8)));
  sendMessage($neighbourID,"fullMessage","Ваш союзник <u>$country</u> атаковал войска гос-ва <u>$attacker</u> на вашей территории! Но ему не удалось выбить врага с территории.");

  mysql_query("UPDATE countries SET wariors_free = wariors_free - $atw,
  wariors_free_2 = wariors_free_2 - $atw_2, wariors_free_3 = wariors_free_3 - $atw_3,
  wariors_free_4 = wariors_free_4 - $atw_4, wariors_free_5 = wariors_free_5 - $atw_5,
  wariors_free_6 = wariors_free_6 - $atw_6, wariors_free_7 = wariors_free_7 - $atw_7,
  wariors_free_8 = wariors_free_8 - $atw_8
  WHERE countryID = '".$countryID."'");
  $b['wariors_free'] = $b['wariors_free'] - $atw;
  $b['wariors_free_2'] = $b['wariors_free_2'] - $atw_2;
  $b['wariors_free_3'] = $b['wariors_free_3'] - $atw_3;
  $b['wariors_free_4'] = $b['wariors_free_4'] - $atw_4;
  $b['wariors_free_5'] = $b['wariors_free_5'] - $atw_5;
  $b['wariors_free_6'] = $b['wariors_free_6'] - $atw_6;
  $b['wariors_free_7'] = $b['wariors_free_7'] - $atw_7;
  $b['wariors_free_8'] = $b['wariors_free_8'] - $atw_8;

  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }


     if(isNewBuildings($countryID,'necropolis')){
     mysql_query("UPDATE buildings SET un_1 = un_1 + $atw,
     un_2 = un_2 + $atw_2, un_3 = un_3 + $atw_3, un_4 = un_4 + $atw_4,
     un_5 = un_5 + $atw_5, un_6 = un_6 + $atw_6, un_7 = un_7 + $atw_7
     WHERE countryID = '$countryID' and building = 'necropolis' LIMIT 1");

     $key=_PREFIKS.':buildings'.$countryID;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
        $mem[$i]['un_1'] = $mem[$i]['un_1'] + $atw;
        $mem[$i]['un_2'] = $mem[$i]['un_2'] + $atw_2;
        $mem[$i]['un_3'] = $mem[$i]['un_3'] + $atw_3;
        $mem[$i]['un_4'] = $mem[$i]['un_4'] + $atw_4;
        $mem[$i]['un_5'] = $mem[$i]['un_5'] + $atw_5;
        $mem[$i]['un_6'] = $mem[$i]['un_6'] + $atw_6;
        $mem[$i]['un_7'] = $mem[$i]['un_7'] + $atw_7;
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }
     }

     if(isNewBuildings($prid,'necropolis')){
     mysql_query("UPDATE buildings SET un_1 = un_1 + $ubito,
     un_2 = un_2 + $ubito_2, un_3 = un_3 + $ubito_3, un_4 = un_4 + $ubito_4,
     un_5 = un_5 + $ubito_5, un_6 = un_6 + $ubito_6, un_7 = un_7 + $ubito_7
     WHERE countryID = '$prid' and building = 'necropolis' LIMIT 1");

     $key=_PREFIKS.':buildings'.$prid;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
        $mem[$i]['un_1'] = $mem[$i]['un_1'] + $ubito;
        $mem[$i]['un_2'] = $mem[$i]['un_2'] + $ubito_2;
        $mem[$i]['un_3'] = $mem[$i]['un_3'] + $ubito_3;
        $mem[$i]['un_4'] = $mem[$i]['un_4'] + $ubito_4;
        $mem[$i]['un_5'] = $mem[$i]['un_5'] + $ubito_5;
        $mem[$i]['un_6'] = $mem[$i]['un_6'] + $ubito_6;
        $mem[$i]['un_7'] = $mem[$i]['un_7'] + $ubito_7;
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }
     }


  //повышение опыта генералов:
  $lg=general_exp($countryID,$prid,$att_wariors,array($ubito,$ubito_2,$ubito_3,$ubito_4,$ubito_5,$ubito_6,$ubito_7,$ubito_8));

  $att_logs.='Гос-во <span class="r1"><u>'.$country.'</u></span> не смогло разбить войско гос-ва <span class="r2"><u>'.$attacker.'</u></span>!<br />Осталось:<br/>'.print_voisko(array($att_end,$att_end_2,$att_end_3,$att_end_4,$att_end_5,$att_end_6,$att_end_7,$att_end_8)).'';

 $def_logs.='Гос-во <span class="r1"><u>'.$country.'</u></span> не смогло разбить войско гос-ва <span class="r2"><u>'.$attacker.'</u></span>!<br />Осталось:<br/>'.print_voisko(array($att_end,$att_end_2,$att_end_3,$att_end_4,$att_end_5,$att_end_6,$att_end_7,$att_end_8)).'';

 }

 //вот теперь совсем конец.

  $att_logs.='Опыт генерала страны <span class="r1"><u>'.$country.'</u></span> +'.$lg[0].' ед.<br />Опыт генерала страны <span class="r2"><u>'.$attacker.'</u></span> +'.$lg[1].' ед.<br />';
$def_logs.='Опыт генерала страны <span class="r2"><u>'.$attacker.'</u></span> +'.$lg[1].' ед.<br />Опыт генерала страны <span class="r1"><u>'.$country.'</u></span> +'.$lg[0].' ед.<br />';

 $att_logs.='-------------------------';
 $def_logs.='-------------------------';
 //Пишем в лог о битве:
 $open=fopen("../logs/war".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("[d-m-Y H:i] ").$att_logs."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

//Пишем в лог о битве жертве:
 $open=fopen("../logs/war".$prid,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("[d-m-Y H:i] ").$def_logs."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  //Пишем в лог о битве союзу:
 $open=fopen("../logs/war".$neighbourID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("[d-m-Y H:i] ").$att_logs."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

       printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours&amp;neighbour=$neighbour\">Ok</a>
<br/>
");

     }

  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Расширение::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('getneighbours'):
  $neighcount=count(returnNeighbours($countryID));
  $mneed = 2500;
  $ineed = 0;
  $all = countAllLand($countryID,TRUE);
  if ($all>15000) $mneed = round(min(100000,round($all*0.37))*0.8);
  if ($all>20000) $ineed = round(min(10000,round($all/1000*0.65))*0.8);
  if ($kind==1){ //Если расширяемся "на запад", то дешевле
          $mneed = round($mneed*0.75);
          $ineed = round($ineed*0.75);
  }
  $mneed=$mneed/2;
  if($neighcount>=20){
   printrus ("У вас достаточно соседей!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Ok</a>
<br/>
");
  }elseif(!isset($sure)){
   printrus("Вы уверены, что хотите расширить дипломатическое влияние? Это обойдется вам в <b>$mneed</b> денег");
   if ($ineed>0)printrus(" и <b>$ineed</b> железа");
   printrus("<br/><a href=\"citadel.php?m=getneighbours&amp;sure&amp;kind=$kind&amp;$ses\">Да</a> или <a href=\"citadel.php?m=neighbours&amp;$ses\">отмена</a><br/>");
  }elseif($money<$mneed){
   printrus ("У вас не хватает денег! (Необходимо <b>$mneed</b>)<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Отмена</a>
<br/>
");
  }elseif($b['iron']<$ineed){
   printrus ("У вас не хватает железа! (Необходимо <b>$ineed</b>)<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=neighbours\">Отмена</a>
<br/>
");
  }else{
   if ($kind==1) $query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
   and (reggedTime<".$b['reggedTime'].") ORDER BY reggedTime DESC
   LIMIT 2";
   else $query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
   and (reggedTime>".$b['reggedTime'].") ORDER BY reggedTime ASC
   LIMIT 2";
   $result=@MYSQL_QUERY($query);
   $k=0;
   while (($a=mysql_fetch_array($result))!==FALSE){

    $neigh_=$a["countryName"];
    $neighbourID=$a["countryID"];

    setNeighbour($countryID,$neighbourID);
    sendMessage($neighbourID,"newNeighbour","$country");
    sendMessage($countryID,"newNeighbour",$neigh_);
    $k++;
    print "|";

   }

   if($k>0){
   //if(2==1){
    printrus ("Дипломатическое влияние страны расширено! <b>+$k</b> соседа!<br/>\r\n");
    mysql_query("UPDATE countries SET money = money - $mneed, iron = iron - $ineed WHERE countryID = '".$countryID."'");
    $b['money'] = $b['money'] - $mneed;
    $b['iron'] = $b['iron'] - $ineed;
    if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   }else{
    printrus ("Невозможно получить еще соседей!<br/>\r\n");
	//printrus ("Эта возможность временно отключена<br/>\r\n");
   }

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Генерал:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('general'):
  if($general=general_info($countryID) && $n=='fire'){
   printrus ("Вы уверены что хотите уволить генерала?<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=general&amp;n=firesure\">Да</a>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=general\">Нет</a>
<br/>
");
  }elseif($general=general_info($countryID) && $n=='firesure'){
   $query="delete from `general` where countryID='$countryID'";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':general'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $memcache->set($key,'',FALSE,86400);
      }

   printrus ("Ваш генерал уволен!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");
  }elseif($general=general_info($countryID)){
   printrus ("Генерал:\r\n");
   printrus ("<u>".$general["name"]."</u><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=age\">?</a>]
");
   printrus ("<u>Возраст</u> [".$general["age"]."]<br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=exp\">?</a>]
");
   printrus ("<u>Опыт</u> [".$general["expiriense"]."]<br/>\r\n");
  if (isArtefact($countryID, 'crest_of_valor')){printrus ("+5000)=".($general["expiriense"]+=5000)."<br/>\r\n");}
  if (isArtefact($countryID, 'expiriense1')){printrus ("+100)=".($general["expiriense"]+=100)."<br/>\r\n");}

   //артефакты генерала
   if($noob>=1)
    printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=study\">?</a>]
");
  $art1=mysql_query("SELECT * FROM `artefakt` WHERE countryID='".$countryID."' AND artID='1' AND artName='0'");
  $art2=mysql_fetch_array($z);
  $query="select count(*) as num from `artefakt` where countryID='$countryID' and artID='1' and artName='0' limit 1";
  $result=@MYSQL_QUERY($query);
  $ar = mysql_fetch_array($result);
  $art = $ar['num'];
   printrus ("<u>Навык</u> [".$general["study"]."]\r\n");
  if ($att_altar >0){printrus ("+10)=".($general["study"]+=10)."\r\n");}
  if ($att_dungeon >0){printrus ("+10)=".($general["study"]+=10)."\r\n");}
  if (isArtefact($countryID, 'kniga_taktiki')){printrus ("+200)=".($general["study"]+=200)."\r\n");}
   /*if($art>0){
   	@include_once("../arts/art.php");
   	printrus ("(".($arts[1][0][0]+$general["study"]).")\r\n");
   }*/
   printrus
("<a href=\"citadel.php?$ses&amp;m=generalstudyup\">^</a>
<br/>
");
   if($noob>=1)
    printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=moral\">?</a>]
");


   printrus ("<u>Мораль</u> [".$general["moral"]."]\r\n");
  if ($att_altar >0){printrus ("+10)=".($general["moral"]+=10)."\r\n");}
  if ($att_dungeon >0){printrus ("+10)=".($general["moral"]+=10)."\r\n");}
  if ($att_mor >0){printrus ("+".$att_mor.")=".($general["moral"]+=$att_mor)."\r\n");}
  if (isArtefact($countryID, 'medal')){printrus ("+30)=".($general["moral"]+=30)."\r\n");}
  if (isArtefact($countryID, 'dragon_scale_shield')){printrus ("+50)=".($general["moral"]+=50)."\r\n");}
   printrus
("<a href=\"citadel.php?$ses&amp;m=generalmoralup\">^</a>
<br/>
");


   printrus
("<a href=\"/artefacts.php?$ses&amp;cit=art\">Артефакты</a>
<br/>
");
   printrus
("<a href=\"citadel.php?$ses&amp;m=general&amp;n=fire\">Уволить</a>
<br/>
");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");
  }elseif(!general_info($countryID) && (empty($age) || empty($study) || empty($name) || $study<=0)){
   printrus ("Наймите генерала!<br/>\r\n");
   printrus ("Имя:<br/>\r\n");
   printrus ("<form name=\"\" action=\"citadel.php?$ses&amp;m=general\" method=\"post\">
   <input name='name' /><br/>\r\n");
   printrus ("Возраст:<br/>\r\n");
   printrus ("<input format='*N' name='age' /><br/>\r\n");
   printrus ("Навык:<br/>\r\n");
   printrus ("<input format='*N' name='study' /><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Нанять\"/>
</form>
<br/>
");
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }elseif(!general_info($countryID) && ($age<16 || $age>90)){
   printrus ("Генерал должен быть не младше 16 и не старше 90 лет!<br/>\r\n");
   printrus ("Возраст:<br/>\r\n");
   printrus ("<form name=\"\" action=\"citadel.php?$ses&amp;m=general&amp;name=$name&amp;study=$study\" method=\"post\">
<input format='*N' name='age' /><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Нанять\"/>
</form>
<br/>
");
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }elseif(!general_info($countryID) && $money<round($study*min(10,max(1,$study-50))*10000/$age)){
   printrus ("У вас не хватает денег, чтобы нанять такого генерала! (требуется ".(round($study*min(10,max(1,$study-50))*10000/$age))." денег)<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Отмена</a>
<br/>
");
  }elseif(!general_info($countryID)){
   $name=iconv('utf-8','cp1251',htmlspecialchars($name));
   $query="INSERT INTO `general` VALUES ('$countryID','$name',$age,1,1,$study)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':general'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newg = array("countryID"=>$countryID, "name"=>$name, "age"=>$age, "expiriense"=>1, "moral"=>1, "study"=>$study);
      $memcache->set($key,$newg,false,86000);
      }

   $mmn = round($study*min(10,max(1,$study-50))*10000/$age);
   mysql_query("UPDATE countries SET money = ($money - $mmn) WHERE countryID = '".$b['countryID']."'");
   $b['money'] = $money - $mmn;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
   printrus ("Вы успешно наняли генерала за <b>".$mmn."</b> денег!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");
  }


 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//обучение генерала:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('generalstudyup'):

  $general=general_info($countryID);
  $mnd=round($general['age']*$general['study']*5000/(min($general['expiriense']+1,10000)));
  //if ($general['study']>=35) $mnd=round($mnd*$general['expiriense']/10);
  if(!$general){
   printrus ("У вас нет генерала!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=general\">Отмена</a>
<br/>
");
  }elseif($n!='sure' || $money<$mnd){
   printrus ("Навык генерала: <b>".$general['study']."</b><br/>\r\n");
   printrus ("Для поднятия уровня требуется: <b>$mnd</b> денег!<br/>\r\n");
   if($b['money']>=$mnd){
    printrus
("<a href=\"citadel.php?$ses&amp;m=generalstudyup&amp;n=sure\">Поднять уровень</a>
<br/>
");
   }else{
    printrus ("У вас недостаточно денег!<br/>\r\n");
   }
   printrus
("<a href=\"citadel.php?$ses&amp;m=general\">Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = ($money - $mnd) WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['money'] = $money - $mnd;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   mysql_query("UPDATE general SET study = study + 1 WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $key=_PREFIKS.':general'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem['study'] = $mem['study']+1;
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Навык вашего генерала поднят на <b>1</b> уровень!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//морализование:) генерала::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('generalmoralup'):

  $quan = intval($quan);
  if (!isset($quan)||(isset($quan)&&$quan<=0))$quan=1;
  $general=general_info($countryID);
  $mnd = 0;
  $ind = 0;
  $gmoral = $general['moral'];
  for ($i=1;$i<=$quan;$i++){
  //$mnd=round($general['moral']*5000/($general['age']));
  //if ($general['moral']>20 && $general['moral']<=50) $ind=150;
  //else if ($general['moral']>50)$ind=100;
  //else $ind=0;
  $mnd=$mnd+round($gmoral*5000/($general['age']));
  if ($gmoral>20 && $gmoral<=50) $ind=$ind+150;
  else if ($gmoral>50)$ind=$ind+100;
  else $ind=$ind+0;
  $gmoral++;
  }
  if(!$general){
   printrus ("У вас нет генерала!<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=general\">Отмена</a>
<br/>
");
  }elseif($n!='sure' || $b['money']<$mnd || $b['iron']<$ind){
   printrus ("Мораль генерала: <b>".$general['moral']."</b><br/>\r\n");
   if ($ind==0)printrus ("Для поднятия уровня морали на $quan требуется: <b>$mnd</b> денег!<br/>\r\n");
   else printrus ("Для поднятия уровня морали на $quan требуется: <b>$mnd</b> денег и <b>$ind</b> железа!<br/>\r\n");
   printrus ("На сколько уровней поднимем?<br/>
   <form name=\"\" action=\"citadel.php?$ses&amp;m=generalmoralup&amp;n=sure\" method=\"post\">
   <input format='*N' name='quan' /><br/>\r\n");
   if($b['money']>=$mnd && $b['iron']>=$ind){
    printrus
("<input type=\"submit\" value=\"Поднять уровень\"/>
</form>
<br/>
");
   }else{
    printrus ("У вас недостаточно ресурсов!<br/>\r\n");
   }
   printrus
("<a href=\"citadel.php?$ses&amp;m=general\">Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $mnd, iron = iron - $ind WHERE countryID = '".$b['countryID']."'");
   $b['money'] = $b['money'] - $mnd;
   $b['iron'] = $b['iron'] - $ind;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
   mysql_query("UPDATE general SET moral = moral + $quan WHERE countryID = '".$b['countryID']."'");
   $key=_PREFIKS.':general'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem['moral'] = $mem['moral']+$quan;
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Мораль вашего генерала повышена на <b>$quan</b> уровней!<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Бартер ок ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('okbarter'):
  printrus ("Обмен: [<u>$neighbour_</u>]<br/>\r\n");

  $key=_PREFIKS.':messages'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='barter'&&$mem[$i]['message']==$messcheck){
         $num=1;
         break;
         }
     }else{
  $query="select * FROM `messages` WHERE `countryID`='$countryID' AND `from`='barter' AND `message`='$messcheck' limit 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $num=@mysql_num_rows($result);
  }

  if(!is_unitee($countryID,$neighbourID)){
   printrus ("Вы можете обмениваться ресурсами только с союзниками!<br/>\r\n");
  }elseif($num<=0){
   printrus ("Гос-во <u>$neighbour_</u> не предлагало вам обмен!<br/>\r\n");
  }elseif($neighbourInfo["$res"]<$resgive){
   printrus ("К сожалению, гос-во <u>$neighbour_</u> теперь не может предоставить вам все предложенные ресурсы.<br/>\r\n");
  }elseif($b["$hisres"]<$restake){
   printrus ("К сожалению, вы не можете предоставить гос-ву <u>$neighbour_</u> все предложенные ресурсы.<br/>\r\n");
  }else{
   mysql_query("UPDATE countries SET $hisres = $hisres - $restake, $res = $res + $resgive WHERE countryID = '".$b['countryID']."'");
   $b["$hisres"] = $b["$hisres"] - $restake;
   $b["$res"] = $b["$res"] + $resgive;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   mysql_query("UPDATE countries SET $hisres = $hisres + $restake, $res = $res - $resgive WHERE countryID = '".$neighbourID."'");

   $key=_PREFIKS.':id'.$neighbourID;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem["$hisres"] = $mem["$hisres"] + $restake;
      $mem["$res"] = $mem["$res"] - $resgive;
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Бартер был успешно совершен!<br/>\r\n");
   //Пишем лог для отлова дрищей-клонов))
   @$open=fopen("../logs/".$countryID,"a+");
         @flock ($open,LOCK_EX);
         @fwrite($open,date("H:i j.m:").$b['countryName']." обм. $restake $hisres на $resgive $res у $neighbour_ (ID=$neighbourID)\n");
         @fflush($open);
         @flock ($open,LOCK_UN);
         @fclose($open);
   @$open=fopen("../logs/".$neighbourID,"a+");
         @flock ($open,LOCK_EX);
         @fwrite($open,date("H:i j.m:").$b['countryName']." (ID=$countryID) обм. $restake $hisres на $resgive $res у $neighbour_ (ID=$neighbourID)\n");
         @fflush($open);
         @flock ($open,LOCK_UN);
         @fclose($open);


   sendMessage($neighbourID,'fullMessage',"Гос-во <u>$country</u> подтвердило ваш запрос на обмен ресурсами. Бартер был успешно совершен!");
   $query="DELETE FROM `messages` WHERE `countryID`='$countryID' AND `from`='barter' AND `message`='$messcheck'";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':messages'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newm = array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='barter'&&$mem[$i]['message']==$messcheck){}else array_push($newm,$mem[$i]);
      $memcache->set($key,$newm,false,86400);
      }

  }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Бартер хер::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('nobarter'):
  printrus ("Обмен: [<u>$neighbour_</u>]<br/>\r\n");

  $key=_PREFIKS.':messages'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='barter'&&$mem[$i]['message']==$messcheck){
         $num=1;
         break;
         }
     }else{
  $query="select * FROM `messages` WHERE `countryID`='$countryID' AND `from`='barter' AND `message`='$messcheck' limit 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $num=@mysql_num_rows($result);
  }

  if($num>0){
   printrus ("Обмен, предложенный гос-вом <u>$neighbour_</u> был отклонен!<br/>\r\n");
   sendMessage($neighbourID,'fullMessage',"Гос-во <u>$country</u> отклонило ваш запрос на обмен ресурсами.");
   $query="DELETE FROM `messages` WHERE `countryID`='$countryID' AND `from`='barter' AND `message`='$messcheck'";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':messages'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newm = array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['from']=='barter'&&$mem[$i]['message']==$messcheck){}else array_push($newm,$mem[$i]);
      $memcache->set($key,$newm,false,86400);
      }

  }else{
   printrus ("Гос-во <u>$neighbour_</u> не предлагало вам обмен!<br/>\r\n");
  }
  printrus
("
<a href='citadel.php?$ses'>Ок</a>
<br/>
");

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Бартер::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('barter'):

 $query="select countryID from `wars` where targetID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $attCount=@mysql_num_rows($result);

 if ($attCount>0){$BAR = FALSE;}else{$BAR = TRUE;}

 if($BAR == FALSE){
 $def_num = 0;
   while (($a=mysql_fetch_array($result))!==FALSE){
   $attackerID=$a["countryID"];
   $def_us=UzersInfo($attackerID);
   if($def_us['race']==2){$def_num++;}
   }
 }

  printrus ("Обмен: [<u>$neighbour_</u>]<br/>\r\n");

// НУЖНА ПРОВЕРКА НА ФЛУД!!!

  if(!is_unitee($countryID,$neighbourID)){
   printrus ("Вы можете обмениваться ресурсами только с союзниками!<br/>\r\n");
  }elseif(($BAR == FALSE and $us['race']!=2) or ($BAR == FALSE and $us['race']==2 and $def_num>0)){
   printrus ("Вы не можете производить бартер, т.к. на вашей территории стоят вражеские войска!<br/>\r\n");
  }elseif(empty($resgive) || empty($res) || $res=='grain'){
   printrus ("Вы хотите обменять:<br/>\r\n");
   printrus ("<form name=\"\" action=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour\" method=\"post\">
<input format='*N' name='resgive' /><br/>\r\n");
   printrus ("<select name=\"res\">\n");
   printrus ("<option value=\"iron\">железа</option>\n");
   printrus ("<option value=\"arbor\">дерева</option>\n");
   printrus ("<option value=\"stone\">камня</option>\n");
   printrus ("<option value=\"grain\">зерна</option>\n");
   printrus ("<option value=\"money\">денег</option>\n");
   printrus ("<option value=\"oil\">нефти</option>\n");
   printrus ("</select>");
   printrus ("<input type=\"submit\" value=\"Обменять\"/>\n");
   printrus
   ("</form><br/>");
  }elseif($resgive>$b["$res"]){
   $resact=$b["$res"];
   if($resact>0){
    printrus ("У вас недостаточно ресурсов чтобы обменять! (всего: <b>$resact</b>)<br/>\r\n");
    printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour&amp;resgive=$resact&amp;res=$res\"Обменять все></a>
<br/>
");
    printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour\">Отмена</a>
<br/>
");
   }else{
    printrus ("У вас нет этого ресурса вообще!<br/>\r\n");
    printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour\">Отмена</a>
<br/>
");
   }
  }elseif($res=='grain'&&($b["res"]-$resgive<10000)){
  printrus ("В запасах после обмена должно оставаться по крайней мере 10000 зерна!<br/>\r\n");
    printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour\">Отмена</a>
<br/>
");
  }elseif(empty($restake) || empty($hisres)){
   printrus ("Свои ресурсы вы хотите обменять на:<br/>\r\n");
   printrus ("<form name=\"\" action=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour&amp;resgive=$resgive&amp;res=$res\" method=\"post\">
<input format='*N' name='restake' /><br/>\r\n");
    printrus ("<select name=\"hisres\">\n");
   printrus ("<option value=\"iron\">железа</option>\n");
   printrus ("<option value=\"arbor\">дерева</option>\n");
   printrus ("<option value=\"stone\">камня</option>\n");
   printrus ("<option value=\"grain\">зерна</option>\n");
   printrus ("<option value=\"money\">денег</option>\n");
   printrus ("<option value=\"oil\">нефти</option>\n");
   printrus ("</select>");
   printrus ("<input type=\"submit\" value=\"Обменять\"/>\n");
   printrus("</form><br/>");
  }elseif($restake>$neighbourInfo["$hisres"]){
   $resact=$neighbourInfo["$hisres"];
   if($resact>0){
    printrus ("У вашего союзника <u>$neighbour_</u> недостаточно ресурсов для обмена! (всего: <b>$resact</b>)<br/>\r\n");
   printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour&amp;resgive=$resgive&amp;res=$res&amp;restake=$resact&amp;hisres=$hisres\"Обменять на все></a>
<br/>
");

    printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour\">Отмена</a>
<br/>
");
   }else{
    printrus ("У вашего союзника <u>$neighbour_</u> нет этого ресурса вообще!<br/>\r\n");
    //printrus ($res."|".$neighbourInfo["$res"]."|".$neighbourInfo['iron']."|".$neighbourinfo['stone']);
    printrus
("<a href=\"citadel.php?$ses&amp;m=barter&amp;neighbour=$neighbour\">Отмена</a>
<br/>
");
   }
  }else{
   $can = TRUE;
   if ($res=='grain'){
      $r = mysql_query("SELECT * FROM `wars` WHERE targetID = '$countryID' LIMIT 1");
      if (mysql_num_rows($r)!=0) $can==FALSE;
      }
   if ($can==TRUE){
   sendMessage($neighbourID,'barter',"$countryID***$resgive***$res***$restake***$hisres");
   printrus ("Предложение об обмене успешно отправлено!<br/>\r\n");
   }else{
   printrus ("Вы не можете осуществлять обмен зерна, пока вражеские войска стоят на вашей территории!<br/>\r\n");
   }
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Воруем::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('grab'):
  if(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете ограбить только соседа!<br/>\r\n");
  }elseif($rTime!=0 AND !$tis and $ips!='sysreg' and $ips!='botsysreg1' and $ips!='botsysreg2' and $ips!='botsysreg3' and $ips!='botsysreg4' and $ips!='botsysreg5' and $ips!='botsysreg6' and $ips!='botsysreg7' and $ips!='botsysreg8' and $ips!='botsysreg9' and $ips!='botsysreg10' and $ips!='botsysreg11' and $ips!='botsysreg12' and $ips!='botsysreg13' and $ips!='botsysreg14' and $ips!='botsysreg15' and $ips!='botsysreg16' and $ips!='botsysreg17' and $ips!='botsysreg18' and $ips!='botsysreg19' and $ips!='botsysreg20'){
   //testCit($neighbourID,$country,'cit')
   // $rTime!=0
   printrus ("Вы намного старше этого государства!Подождите ".mkTimeStr($ost).".<br/>\r\n");
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
  }elseif($rTime!=0 AND !$tis and $ips!='sysreg' and $ips!='botsysreg1' and $ips!='botsysreg2' and $ips!='botsysreg3' and $ips!='botsysreg4' and $ips!='botsysreg5' and $ips!='botsysreg6' and $ips!='botsysreg7' and $ips!='botsysreg8' and $ips!='botsysreg9' and $ips!='botsysreg10' and $ips!='botsysreg11' and $ips!='botsysreg12' and $ips!='botsysreg13' and $ips!='botsysreg14' and $ips!='botsysreg15' and $ips!='botsysreg16' and $ips!='botsysreg17' and $ips!='botsysreg18' and $ips!='botsysreg19' and $ips!='botsysreg20'){
   //testCit($neighbourID,$country,'cit')
   // $rTime!=0
   printrus ("Вы намного старше этого государства!Подождите ".mkTimeStr($ost).".<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }elseif(!building_exists($neighbourID,"wall")){
   printrus ("У этого государства нет стены!<br/>\r\n");
  }else{
   sabotage_bld($countryID,$neighbourID,"wall");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Атомная бомба ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('atomic'):
  if($b['atomic']!=1){
  printrus ("У вас нет атомной бомбы!<br/>\r\n");
  }elseif($rTime!=0 AND !$tis and $ips!='sysreg' and $ips!='botsysreg1' and $ips!='botsysreg2' and $ips!='botsysreg3' and $ips!='botsysreg4' and $ips!='botsysreg5' and $ips!='botsysreg6' and $ips!='botsysreg7' and $ips!='botsysreg8' and $ips!='botsysreg9' and $ips!='botsysreg10' and $ips!='botsysreg11' and $ips!='botsysreg12' and $ips!='botsysreg13' and $ips!='botsysreg14' and $ips!='botsysreg15' and $ips!='botsysreg16' and $ips!='botsysreg17' and $ips!='botsysreg18' and $ips!='botsysreg19' and $ips!='botsysreg20'){
   //testCit($neighbourID,$country,'cit')
   // $rTime!=0
   printrus ("Вы намного старше этого государства!Подождите ".mkTimeStr($ost).".<br/>\r\n");
  }elseif(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете разрушать только соседскую стену!<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }else{
   atomic_bld($countryID,$neighbourID);
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Вербуем:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('verb'):
  if(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете завербовать только соседские войска!<br/>\r\n");
  }elseif($rTime!=0 AND !$tis and $ips!='sysreg' and $ips!='botsysreg1' and $ips!='botsysreg2' and $ips!='botsysreg3' and $ips!='botsysreg4' and $ips!='botsysreg5' and $ips!='botsysreg6' and $ips!='botsysreg7' and $ips!='botsysreg8' and $ips!='botsysreg9' and $ips!='botsysreg10' and $ips!='botsysreg11' and $ips!='botsysreg12' and $ips!='botsysreg13' and $ips!='botsysreg14' and $ips!='botsysreg15' and $ips!='botsysreg16' and $ips!='botsysreg17' and $ips!='botsysreg18' and $ips!='botsysreg19' and $ips!='botsysreg20'){
   //testCit($neighbourID,$country,'cit')
   // $rTime!=0
   printrus ("Вы намного старше этого государства!Подождите ".mkTimeStr($ost).".<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }elseif(($neighbourInfo["wariors_free"]+$neighbourInfo["wariors_free_2"]+$neighbourInfo["wariors_free_3"]+$neighbourInfo["wariors_free_4"]+$neighbourInfo["wariors_free_5"]+$neighbourInfo["wariors_free_6"]+$neighbourInfo["wariors_free_7"]+$neighbourInfo["wariors_free_8"])<=0){
   printrus ("Вы не можете никого завербовать!<br/>\r\n");
  }else{
   verb($countryID,$neighbourID);
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//крадем науку::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('sciencespy'):
  if(!neighbour_exists($countryID,$neighbourID)){
   printrus ("Вы можете шпионить только на территории соседнего гос-ва!<br/>\r\n");
  }elseif($rTime!=0 AND !$tis and $ips!='sysreg' and $ips!='botsysreg1' and $ips!='botsysreg2' and $ips!='botsysreg3' and $ips!='botsysreg4' and $ips!='botsysreg5' and $ips!='botsysreg6' and $ips!='botsysreg7' and $ips!='botsysreg8' and $ips!='botsysreg9' and $ips!='botsysreg10' and $ips!='botsysreg11' and $ips!='botsysreg12' and $ips!='botsysreg13' and $ips!='botsysreg14' and $ips!='botsysreg15' and $ips!='botsysreg16' and $ips!='botsysreg17' and $ips!='botsysreg18' and $ips!='botsysreg19' and $ips!='botsysreg20'){
   //testCit($neighbourID,$country,'cit')
   // $rTime!=0
   printrus ("Вы намного старше этого государства!Подождите ".mkTimeStr($ost).".<br/>\r\n");
  }elseif(is_unitee($countryID,$neighbourID)){
   printrus ("Вы не можете вредить союзнику!<br/>\r\n");
  }elseif(!building_exists($neighbourID,"university") && !building_exists($neighbourID,"scientificcenter")){
   printrus ("У этого государства нет научных зданий!<br/>\r\n");
  }elseif($neighbourInfo["people_adding"]<$b["people_adding"] && $neighbourInfo["plotn_wariors"]<$b["plotn_wariors"] && $neighbourInfo["plotn_people"]<$b["plotn_people"] && $neighbourInfo["forest_adding"]<$b["forest_adding"] && $neighbourInfo["science"]<$b["science"] && $neighbourInfo["grain_making"]<$b["grain_making"] && $neighbourInfo["arbor_making"]<$b["arbor_making"] && $neighbourInfo["iron_making"]<$b["iron_making"] && $neighbourInfo["stone_making"]<$b["stone_making"] && $neighbourInfo["oil_making"]<$b["oil_making"] && $neighbourInfo["forest_max"]<$b["forest_max"] && $neighbourInfo["mountains_max"]<$b["mountains_max"]){
   printrus ("Уровень ваших научных разработок выше чем у этого государства!<br/>\r\n");
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
<a href='citadel.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='grab'){
   printrus ("Справка: <u>Воровство</u><br/>\r\n");
   printrus ("Позволяет украсть у вашего соседа ресурсы. <br/>Если уровень шпионажа противника выше вашего воровства, то попытка будет предотвращена, если меньше или равен, то вам удастся что-нибудь украсть.<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='sabotage'){
   printrus ("Справка: <u>Саботаж</u><br/>\r\n");
   printrus ("Позволяет разрушить вражеское здание(во время войны) или стену(в мирное время). <br/>Если уровень шпионажа противника выше вашего саботажа, то попытка будет предотвращена, если меньше или равен, то вам удастся разрушить здание.<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='verb'){
   printrus ("Справка: <u>Вербовка</u><br/>\r\n");
   printrus ("Позволяет перевербовать вражеских солдат. <br/>Если уровень шпионажа противника выше вашей вербовки, то попытка будет предотвращена, если меньше или равен, то вам удастся завербовать его военных.<br/>\r\n");
   printrus
("
<a href='citadel.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='moral'){
   printrus ("Справка: <u>Мораль генерала</u><br/>\r\n");
   printrus ("Чем выше мораль вашего генерала, тем сильнее ваши воины дерутся в бою. При прочих равных, генерал, обладающий учетверенной моралью, будет бить в 2 раза сильнее.<br/>\r\n");
   printrus
("<a href='citadel.php?$ses&amp;m=general'>OK</a>
<br/>
");
  }elseif($n=='study'){
   printrus ("Справка: <u>Навык генерала</u><br/>\r\n");
   printrus ("Чем выше навык вашего генерала, тем сильнее ваши воины дерутся в бою. При прочих равных, генерал, обладающий учетверенным навыком, будет бить в 2 раза сильнее<br/>\r\n");
   printrus
("<a href='citadel.php?$ses&amp;m=general'>OK</a>
<br/>
");
  }elseif($n=='exp'){
   printrus ("Справка: <u>Опыт генерала</u><br/>\r\n");
   printrus ("Опыт генерала влияет на стоимость повышения его навыка, а также играет ту же роль, что и навык, но в пропорции 500 опыта = 1 навыку.<br/>\r\n");
   printrus
("<a href='citadel.php?$ses&amp;m=general'>OK</a>
<br/>
");
  }elseif($n=='age'){
   printrus ("Справка: <u>Возраст генерала</u><br/>\r\n");
   printrus ("Генерал погибает в возрасте от 80 до 90 лет. Если есть открытие \"элексир долголетия\", срок жизни увеличивается на 7 лет.<br/>\r\n");
   printrus
("<a href='citadel.php?$ses&amp;m=general'>OK</a>
<br/>
");
  }elseif($n=='diplomat'){
   printrus ("Справка: <u>Дипломатическое влияние</u><br/>\r\n");
   printrus ("На расширение дипломатического влияния необходимо тем больше ресурсов, чем больше земли у вас в стране. Если кол-во соседей не привышает <b>10</b>. При расширении вы получаете 2х новых соседей. (Если вы получили 1 или не получили соседей совсем, это значит что на карте мира больше нет не граничащих с вами государств.)<br/>\r\n");
   printrus
("<a href='citadel.php?$ses&amp;m=neighbours'>OK</a>
<br/>
");
  }

 break;
 endswitch;

}

//=============================================================================
//Конец скрипту================================================================print "---<br/>\r\n";


printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");


//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");
?>