<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($n)&&$n!=1)$n=0;
if ($m=='params'&&$n!=0)$n=0;
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
if(isset($_REQUEST['push'])) $n=0;
if(isset($_REQUEST['sam'])) $n=1;
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

 build_exists_print($countryID,'fabrika');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Фабрика</u><br/>");

 is_repairing($countryID,'fabrika',$m);


if($is_rep==0){

 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:

  printrus
("<a href=\"guard.php?$ses&amp;bld=fabrika\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");

 printrus
("<a href=\"fabrika.php?$ses&amp;m=add\">Производство техники</a>
<br/>
");

printrus
("<a href=\"fabrika.php?$ses&amp;m=params&amp;n=0\">Параметры пушек</a>
<br/>
");

  if($hits<100){
   printrus
("<a href=\"fabrika.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }elseif(!builds($b['countryID'],"zavod")){
   printrus
("<a href=\"fabrika.php?$ses&amp;m=upgraide\">Строить улучшение (Завод)</a>
<br/>
");
  }

 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'fabrika',$m);
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//апгрейдим здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('upgraide'):
 build_upgrade($countryID,'zavod','fabrika');
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Строим пушки и самолеты:::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('add'):

 $teach = FALSE;
  $proc_result = returnProcess($b['countryID'],'teaching');
  for ($i=0;$i<count($proc_result);$i++){
          if ($proc_result[$i]['what']=='wariors_4'||$proc_result[$i]['what']=='wariors_6'){
                  $zap = $i;
                  $teach = TRUE;
                  break;
          }
  }

 if ($m=='add'&&isset($scientiststo) && isset($peopleto) && isset($n)){
  require ($_SERVER['DOCUMENT_ROOT'].'/units.php');
  //Коэффициент стоимости:
  if ($n!=0){
  $speed = $b['weapon_speed_6'];
  $force = $b['weapon_force_6'];
  }else{
  $speed = $b['weapon_speed_4'];
  $force = $b['weapon_force_4'];
  }
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
   printrus ("Производство $str: Готово <b>$percent</b>%<br/>\r\n");
   printrus ("Осталось ".mkTimeStr($proc_result[$zap]["finished"]-date(U))."<br/>\r\n");
   printrus ("Количество едениц: <b>$workersTo</b><br/>\r\n");
   printrus ("Занятые ученые: <b>$scientists</b><br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses\">Ок</a>
<br/>
");
 }elseif (!isset($scientiststo)||!isset($peopleto)||!isset($n)||$scientiststo<=0||$peopleto<=0){
 $wariors_free_4 = $b['wariors_free_4'];  //Пушки
 $wariors_free_6 = $b['wariors_free_6'];  //Самолеты
 printrus("Ученые:<br/><form name=\"\" action=\"fabrika.php?$ses&amp;m=add\" method=\"post\">
<input format='*N' name='scientiststo' /><br/>");
 printrus("Количество:<br/><input format='*N' name='peopleto' /><br/>");

 printrus("Пушки: <b>".$wariors_free_4."</b> ");
 printrus
("<input name=\"push\" type=\"submit\" value=\"+\"/>
<br/>
");

 printrus("Самолеты: <b>".$wariors_free_6."</b> ");
 printrus
("<input name=\"sam\" type=\"submit\" value=\"+\"/>
</form>
<br/>
");
printrus
("<a href=\"fabrika.php?$ses\">назад</a>
<br/>
");
}elseif($scientiststo>$b['scientists']){
   printrus ("У вас нет столько ученых! (всего: <b>".$b['scientists']."</b>)<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses&amp;m=add&amp;n=$n&amp;peopleto=$peopleto&amp;scientiststo=".$b['scientists']."\">Использовать всех</a>
<br/>
");
   printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
}elseif($peopleto>round($space*($b["plotn_people"]/10))){
   printrus ("Вы можете произвести за раз только <b>".round($space*$b["plotn_people"]/10)."</b> едениц техники!<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses&amp;m=add&amp;n=$n&amp;peopleto=".round($space*$b["plotn_people"]/10)."&amp;scientiststo=$scientiststo\">Произвести максимум</a>
<br/>
");
printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
}elseif($b["money"]<$mnd){
   printrus ("Не хватает денег для производства! (необходимо <b>".($mnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["iron"]<$ind){
   printrus ("Не хватает железа для производства! (необходимо <b>".($ind)."</b>)<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["grain"]<$gnd){
   printrus ("Не хватает зерна для производства! (необходимо <b>".($gnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["stone"]<$snd){
   printrus ("Не хватает камня для производства! (необходимо <b>".($snd)."</b>)<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["arbor"]<$lnd){
   printrus ("Не дерева для производства! (необходимо <b>".($lnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["oil"]<$ond){
   printrus ("Не хватает нефти для производства! (необходимо <b>".($ond)."</b>)<br/>\r\n");
   printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");
  }else{
  mysql_query("UPDATE `countries` SET scientists = scientists-$scientiststo, money = money - $mnd, iron = iron - $ind, arbor = arbor - $lnd, grain = grain - $gnd, stone = stone - $snd, oil = oil - $ond WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['scientists'] = $b['scientists']-$scientiststo;
   $b['money'] = $b['money']-$mnd;
   $b['iron'] = $b['iron']-$ind;
   $b['arbor'] = $b['arbor']-$lnd;
   $b['grain'] = $b['grain']-$gnd;
   $b['stone'] = $b['stone']-$snd;
   $b['oil'] = $b['oil']-$ond;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
   if ($n==0)$what='wariors_4';
   else $what='wariors_6';
   $work_time=round($peopleto/($scientiststo*$b["science"])*12000*(4+$n*2));

   $query="insert into works values('$countryID','teaching','$what',$scientiststo,".date(U).",".($work_time+date(U)).", $peopleto, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'teaching', "what"=>$what, "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$peopleto, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Производство займет ".mkTimeStr($work_time).". Это стоило вам:<br/>".res_print($mnd,$snd,$ind,$lnd,$gnd,$ond)."<br/>\r\n");

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

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Параметры пушек:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('params'):

 if ($n==0){
 printrus("Параметры пушек<br/>\n\r");
 $force = $b['weapon_force_4'];
 $speed = $b['weapon_speed_4'];
 }
 else{
 printrus("Параметры самолетов<br/>\n\r");
 $force = $b['weapon_force_6'];
 $speed = $b['weapon_speed_6'];
 }
 if (!isset($l)){
 printrus("Маневренность: <b>$speed</b>\r\n");
 printrus
("<a href=\"fabrika.php?$ses&amp;m=params&amp;n=$n&amp;l=plus&amp;k=speed\">+</a>/
<a href=\"fabrika.php?$ses&amp;m=params&amp;n=$n&amp;l=minus&amp;k=speed\">-</a>
<br/>
");

printrus("Мощность: <b>$force</b>\r\n");
 printrus
("<a href=\"fabrika.php?$ses&amp;m=params&amp;n=$n&amp;l=plus&amp;k=force\">+</a>/
<a href=\"fabrika.php?$ses&amp;m=params&amp;n=$n&amp;l=minus&amp;k=force\">-</a>
<br/>
");
}elseif(!isset($sure)){
if ($l=='plus'){
$prc=1;
if ($n==0){
if ($k=='speed')$param=$b['weapon_speed_4'];
else {$param=$b['weapon_force_4'];$prc=$prc*0.9;}
}else{
$prc = $prc*1.2;
if ($k=='speed')$param=$b['weapon_speed_6'];
else {$param=$b['weapon_force_6'];$prc=$prc*0.9;}
}
if($param>8)$param=8;
$mnd = round(50*($param+1)*($param+1)*$prc);
$snd = round(8*($param+1)*($param+1)*$prc);
$lnd = round(10*($param+1)*($param+1)*$prc);
$ond = round(2*($param+1)*($param+1)*$prc);
printrus("Увеличение параметра на 1 уровень стоит ".res_print($mnd,$snd,0,$lnd,0,$ond).'<br/>');
}else{
$prc=1;
if ($n==0){
if ($k=='speed')$param=$b['weapon_speed_4'];
else {$param=$b['weapon_force_4'];$prc=$prc*0.9;}
}else{
$prc = $prc*1.2;
if ($k=='speed')$param=$b['weapon_speed_6'];
else {$param=$b['weapon_force_6'];$prc=$prc*0.9;}
}
if($param>8)$param=8;
$mnd = max(0,round(25*($param-1)*($param-1)*$prc));
$snd = max(0,round(2*($param-1)*($param-1)*$prc));
$lnd = max(0,round(3*($param-1)*($param-1)*$prc));
$ond = max(0,round(1*($param-1)*($param-1)*$prc));
printrus("Уменьшение параметра на 1 уровень принесет вам ".res_print($mnd,$snd,0,$lnd,0,$ond).'<br/>');
}
printrus
("<a href=\"fabrika.php?sure&amp;$ses&amp;m=params&amp;n=$n&amp;l=$l&amp;k=$k\">Ok</a>
<br/>
");
printrus
("<a href=\"fabrika.php?$ses\">Отмена</a>
<br/>
");

}else{
$str='';

if ($l=='plus'){
$prc=1;
if ($n==0){
if ($k=='speed'){$param=$b['weapon_speed_4'];$str='weapon_speed_4=weapon_speed_4+1';}
else {$param=$b['weapon_force_4'];$prc=$prc*0.9;$str='weapon_force_4=weapon_force_4+1';}
}else{
$prc = $prc*1.2;
if ($k=='speed'){$param=$b['weapon_speed_6'];$str='weapon_speed_6=weapon_speed_6+1';}
else {$param=$b['weapon_force_6'];$prc=$prc*0.9;$str='weapon_force_6=weapon_force_6+1';}
}
if($param>8)$param=8;
$mnd = round(50*($param+1)*($param+1)*$prc);
$snd = round(8*($param+1)*($param+1)*$prc);
$lnd = round(10*($param+1)*($param+1)*$prc);
$ond = round(2*($param+1)*($param+1)*$prc);
}else{

$freeplace=max(0,free_place($countryID));

$prc=1;
if ($n==0){
if ($k=='speed'){$param=$b['weapon_speed_4'];$str='weapon_speed_4=weapon_speed_4-1';}
else {$param=$b['weapon_force_4'];$prc=$prc*0.9;$str='weapon_force_4=weapon_force_4-1';}
}else{
$prc = $prc*1.2;
if ($k=='speed'){$param=$b['weapon_speed_6'];$str='weapon_speed_6=weapon_speed_6-1';}
else {$param=$b['weapon_force_6'];$prc=$prc*0.9;$str='weapon_force_6=weapon_force_6-1';}
}
if($param>8)$param=8;
$mnd = max(0,round(25*($param-1)*($param-1)*$prc));
$snd = max(0,round(2*($param-1)*($param-1)*$prc));
$lnd = max(0,round(3*($param-1)*($param-1)*$prc));
$ond = max(0,round(1*($param-1)*($param-1)*$prc));
}

if ($l=='minus'&&$param<=1){
printrus("Нельзя уменьшить еще!<br/>\n\r");
printrus
("<a href=\"fabrika.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='minus'&&$freeplace<($mnd+$snd+$lnd+$ond)){
printrus("Не хватает места в хранилище для освободившихся ресурсов. Освободите место!<br/>\n\r");
printrus
("<a href=\"fabrika.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['money']<$mnd){
printrus("Не хватает денег для увеличения параметра! Необходимо: <b>$mnd</b><br/>\n\r");
printrus
("<a href=\"fabrika.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['stone']<$snd){
printrus("Не хватает камня для увеличения параметра! Необходимо: <b>$snd</b><br/>\n\r");
printrus
("<a href=\"fabrika.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['arbor']<$lnd){
printrus("Не хватает дерева для увеличения параметра! Необходимо: <b>$lnd</b><br/>\n\r");
printrus
("<a href=\"fabrika.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['oil']<$ond){
printrus("Не хватает нефти для увеличения параметра! Необходимо: <b>$ond</b><br/>\n\r");
printrus
("<a href=\"fabrika.php?$ses\">Ок</a>
<br/>
");
}else{
if ($l=='plus'){
$mnd = -$mnd;
$lnd = -$lnd;
$snd = -$snd;
$ond = -$ond;
}
mysql_query("UPDATE `countries` SET $str, money=money+$mnd, arbor=arbor+$lnd, stone=stone+$snd, oil=oil+$ond WHERE countryID = '".$b['countryID']."' LIMIT 1");
$b['arbor'] = $b['arbor']+$lnd;
$b['stone'] = $b['stone']+$snd;
$b['money'] = $b['money']+$mnd;
$b['oil'] = $b['oil']+$ond;
if ($l=='plus'){
if ($n==0){
if ($k=='speed') $b['weapon_speed_4']=$b['weapon_speed_4']+1;
else $b['weapon_force_4']=$b['weapon_force_4']+1;
}else{
if ($k=='speed') $b['weapon_speed_6']=$b['weapon_speed_6']+1;
else $b['weapon_force_6']=$b['weapon_force_6']+1;
}
}else{
if ($n==0){
if ($k=='speed') $b['weapon_speed_4']=$b['weapon_speed_4']-1;
else $b['weapon_force_4']=$b['weapon_force_4']-1;
}else{
if ($k=='speed') $b['weapon_speed_6']=$b['weapon_speed_6']-1;
else $b['weapon_force_6']=$b['weapon_force_6']-1;
}
}
if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
if ($l=='plus')printrus("Параметр увеличен. Вы затратили: ".res_print(-$mnd,-$snd,0,-$lnd,0,-$ond).'<br/>');
else printrus("Параметр уменьшен. Вы выручили: ".res_print($mnd,$snd,0,$lnd,0,$ond).'<br/>');
printrus
("<a href=\"fabrika.php?m=params&amp;$ses\">Ок</a>
<br/>
");
}

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
