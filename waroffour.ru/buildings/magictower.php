<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['l'])) $l = $_REQUEST['l'];
if (isset($_REQUEST['k'])) $k = $_REQUEST['k'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;

if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;

if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;

if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);

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

//******************************************************************************
//проверка на наличие здания:****************************************

 build_exists_print($countryID,'magictower');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Башня магов</u><br/>");

 is_repairing($countryID,'magictower',$m);


if($is_rep==0){

 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:

  printrus
("<a href=\"guard.php?$ses&amp;bld=magictower\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");

 printrus
("<a href=\"magictower.php?$ses&amp;m=add\">Обучение магов</a>
<br/>
");

  if($hits<100){
   printrus
("<a href=\"magictower.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }elseif(!builds($b['countryID'],"gorodmagov")){
   printrus
("<a href=\"magictower.php?$ses&amp;m=upgraide\">Строить улучшение (Город магов)</a>
<br/>
");
  }

 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'magictower',$m);
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//апгрейдим здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('upgraide'):
 build_upgrade($countryID,'gorodmagov','magictower');
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Учим магов::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('add'):

 $teach = FALSE;
  $proc_result = returnProcess($b['countryID'],'teaching');
  for ($i=0;$i<count($proc_result);$i++){
          if ($proc_result[$i]['what']=='wariors_7'){
                  $zap = $i;
                  $teach = TRUE;
                  break;
          }
  }

 if ($m=='add'&&isset($scientiststo) && isset($peopleto)){
  require ($_SERVER['DOCUMENT_ROOT'].'/units.php');
  //Коэффициент стоимости:

  $speed = $b['weapon_speed_7'];
  $force = $b['weapon_force_7'];

  $prc = 1+round(($speed+$force)/2)/100;
  $prc = $prc * (1+($b['weapon_kind']+$b['bronya_kind'])/10);
  if ($n!=0)$l=5;
  else $l=3;

  $mnd = round($units[$l]['cost'][0]*$peopleto*$prc);
  $ind = round($units[$l]['cost'][1]*$peopleto*$prc);
  $snd = round($units[$l]['cost'][2]*$peopleto*$prc);
  $lnd = round($units[$l]['cost'][3]*$peopleto*$prc);
  $gnd = round($units[$l]['cost'][4]*$peopleto*$prc);
  $ond = round($units[$l]['cost'][5]*$peopleto*$prc);
  }
 if ($teach==TRUE){
   $scientists=$proc_result[$zap]["peopleatwork"];
   $workersTo=$proc_result[$zap]["var1"];
   $percent=getWorkPercent($proc_result[$zap]["started"],$proc_result[$zap]["finished"],time());
   $str = get_unit_name($l);
   printrus ("Обучение $str: Готово <b>$percent</b>%<br/>\r\n");
   printrus ("Осталось ".mkTimeStr($proc_result[$zap]["finished"]-date(U))."<br/>\r\n");
   printrus ("Количество: <b>$workersTo</b><br/>\r\n");
   printrus ("Занятые ученые: <b>$scientists</b><br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses\">Ок</a>
<br/>
");
 }elseif (!isset($scientiststo)||!isset($peopleto)||$scientiststo<=0||$peopleto<=0){
 $wariors_free_7 = $b['wariors_free_7'];  //Маги
 printrus("Ученые:<br/><form name=\"\" action=\"magictower.php?$ses&amp;m=add\" method=\"post\">
<input format='*N' name='scientiststo' /><br/>");
 printrus("Количество:<br/><input format='*N' name='peopleto' /><br/>");

 printrus("Маги: <b>".$wariors_free_7."</b> ");
 printrus
("<input type=\"submit\" value=\"+\"/>
</form>
<br/>
");

printrus
("<a href=\"magictower.php?$ses\">назад</a>
<br/>
");
}elseif($scientiststo>$b['scientists']){
   printrus ("У вас нет столько ученых! (всего: <b>".$b['scientists']."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses&amp;m=add&amp;peopleto=$peopleto&amp;scientiststo=".$b['scientists']."\">Использовать всех</a>
<br/>
");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
}elseif($peopleto>$b['workers']){
   printrus ("У вас нет стольких свободных рабочих! (всего: <b>".$b['workers']."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses&amp;m=add&amp;peopleto=".$b['workers']."&amp;scientiststo=".$scientiststo."\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
}elseif($peopleto>round($space*($b["plotn_people"]/10))){
   printrus ("Вы можете обучить за раз только <b>".round($space*$b["plotn_people"]/10)."</b> магов!<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses&amp;m=add&amp;peopleto=".round($space*$b["plotn_people"]/10)."&amp;scientiststo=$scientiststo\"Обучить максимум</a>
<br/>
");
printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
}elseif($b["money"]<$mnd){
   printrus ("Не хватает денег для производства! (необходимо <b>".($mnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["iron"]<$ind){
   printrus ("Не хватает железа для производства! (необходимо <b>".($ind)."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["grain"]<$gnd){
   printrus ("Не хватает зерна для производства! (необходимо <b>".($gnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["stone"]<$snd){
   printrus ("Не хватает камня для производства! (необходимо <b>".($snd)."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["arbor"]<$lnd){
   printrus ("Не дерева для производства! (необходимо <b>".($lnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["oil"]<$ond){
   printrus ("Не хватает нефти для производства! (необходимо <b>".($ond)."</b>)<br/>\r\n");
   printrus
("<a href=\"magictower.php?$ses\">Отмена</a>
<br/>
");
  }else{
  mysql_query("UPDATE `countries` SET workers = workers - $peopleto, scientists = scientists-$scientiststo, money = money - $mnd, iron = iron - $ind, arbor = arbor - $lnd, grain = grain - $gnd, stone = stone - $snd, oil = oil - $ond WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['scientists'] = $b['scientists']-$scientiststo;
   $b['workers'] = $b['workers']-$peopleto;
   $b['money'] = $b['money']-$mnd;
   $b['iron'] = $b['iron']-$ind;
   $b['arbor'] = $b['arbor']-$lnd;
   $b['grain'] = $b['grain']-$gnd;
   $b['stone'] = $b['stone']-$snd;
   $b['oil'] = $b['oil']-$ond;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
   $what='wariors_7';
   $work_time=round($peopleto/($scientiststo*$b["science"])*12000*7);

   $query="insert into works values('$countryID','teaching','$what',$scientiststo,".date(U).",".($work_time+date(U)).", $peopleto, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'teaching', "what"=>$what, "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$peopleto, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Обучение займет ".mkTimeStr($work_time).". Это стоило вам:<br/>".res_print($mnd,$snd,$ind,$lnd,$gnd,$ond)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."начинает обучение $peopleto $what $scientiststo учеными. Время: ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
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