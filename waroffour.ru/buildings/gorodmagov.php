<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['l'])) $l = $_REQUEST['l'];
if (isset($_REQUEST['k'])) $k = $_REQUEST['k'];
if (isset($_REQUEST['d'])) $d = $_REQUEST['d'];
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
if (isset($_REQUEST['countto'])) $countto = $_REQUEST['countto'];
if (isset($countto)&&!is_numeric($countto)) $countto=0;
if (isset($countto)&&$countto<0) $countto=0;
//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);
 if (isset($countto))$countto=round( (int) $countto);
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

 build_exists_print($countryID,'gorodmagov');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Город магов</u><br/>");

 is_repairing($countryID,'gorodmagov',$m);


if($is_rep==0){

 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:

  printrus
("<a href=\"guard.php?$ses&amp;bld=gorodmagov\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");

 printrus
("<a href=\"gorodmagov.php?$ses&amp;m=add\">Обучение магов</a>
<br/>
");

printrus
("<a href=\"gorodmagov.php?$ses&amp;m=params\">Мастерство магов</a>
<br/>
");

  if($hits<100){
   printrus
("<a href=\"gorodmagov.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }

 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'gorodmagov',$m);
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
("<a href=\"gorodmagov.php?$ses\">Ок</a>
<br/>
");
 }elseif (!isset($scientiststo)||!isset($peopleto)||$scientiststo<=0||$peopleto<=0){
 $wariors_free_7 = $b['wariors_free_7'];  //Маги
 printrus("Ученые:<br/><form name=\"\" action=\"gorodmagov.php?$ses&amp;m=add\" method=\"post\">
<input format='*N' name='scientiststo' /><br/>");
 printrus("Количество:<br/><input format='*N' name='peopleto' /><br/>");

 printrus("Маги: <b>".$wariors_free_7."</b> ");
 printrus
("<input type=\"submit\" value=\"+\"/>
</form>
<br/>
");

printrus
("<a href=\"gorodmagov.php?$ses\">назад</a>
<br/>
");
}elseif($scientiststo>$b['scientists']){
   printrus ("У вас нет столько ученых! (всего: <b>".$b['scientists']."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses&amp;m=add&amp;peopleto=$peopleto&amp;scientiststo=".$b['scientists']."\">Использовать всех</a>
<br/>
");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
}elseif($peopleto>$b['workers']){
   printrus ("У вас нет стольких свободных рабочих! (всего: <b>".$b['workers']."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses&amp;m=add&amp;peopleto=".$b['workers']."&amp;scientiststo=".$scientiststo."\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
}elseif($peopleto>round($space*($b["plotn_people"]/10))){
   printrus ("Вы можете обучить за раз только <b>".round($space*$b["plotn_people"]/10)."</b> магов!<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses&amp;m=add&amp;peopleto=".round($space*$b["plotn_people"]/10)."&amp;scientiststo=$scientiststo\">Обучить максимум</a>
<br/>
");
printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
}elseif($b["money"]<$mnd){
   printrus ("Не хватает денег для производства! (необходимо <b>".($mnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["iron"]<$ind){
   printrus ("Не хватает железа для производства! (необходимо <b>".($ind)."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["grain"]<$gnd){
   printrus ("Не хватает зерна для производства! (необходимо <b>".($gnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["stone"]<$snd){
   printrus ("Не хватает камня для производства! (необходимо <b>".($snd)."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["arbor"]<$lnd){
   printrus ("Не дерева для производства! (необходимо <b>".($lnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
  }elseif($b["oil"]<$ond){
   printrus ("Не хватает нефти для производства! (необходимо <b>".($ond)."</b>)<br/>\r\n");
   printrus
("<a href=\"gorodmagov.php?$ses\">Отмена</a>
<br/>
");
  }else{
  mysql_query("UPDATE `countries` SET workers = workers - $peopleto, scientists = scientists-$scientiststo, money = money - $mnd, iron = iron - $ind, arbor = arbor - $lnd, grain = grain - $gnd, stone = stone - $snd, oil = oil - $ond WHERE countryID = '".$b['countryID']."' LIMIT 1");
  echo mysql_error();
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

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Параметры магов:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('params'):

if($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time() and $nz['un_3']>0){$speed_art10=$nz['un_3']; $force_art10=$nz['un_3']; $p10=1;}
 printrus("Мастерство магов<br/>\n\r");
 if (isArtefact($countryID, 'teh_volshebstvo')){printrus("+Техническое волшебство: +50% сила и +50% знания магов<br/><br />\r\n"); $p7=1; $ar=1;}
 $force = $b['weapon_force_7'];
 $speed = $b['weapon_speed_7'];

 if (!isset($l)){
printrus("Знание: <b>$speed</b>\r\n");
if ($p7 == 1 and $ar == 1 and $p10 != 1){printrus ("<b>+50%</b>=<b>(".round($speed+$speed*50/100).")</b>\r\n");}
if ($p7 == 1 and $ar == 1 and $p10 == 1){printrus ("<b>+50%</b>=<b>(".round($speed+$speed*50/100).")</b> <b>+".$speed_art10."</b>=<b>(".round($speed+$speed*50/100+$speed_art10).")</b>\r\n");}

if ($p7 != 1 and $p10 == 1){printrus ("<b>+".$speed_art10."</b>=<b>(".round($speed+$speed_art10).")</b>\r\n");}
printrus("<a href=\"gorodmagov.php?$ses&amp;m=params&amp;l=plus&amp;k=speed\">+</a> / <a href=\"gorodmagov.php?$ses&amp;m=params&amp;l=minus&amp;k=speed\">-</a><br/>");

printrus("Сила магии: <b>$force</b>\r\n");
if ($p7 == 1 and $ar == 1 and $p10 != 1){printrus ("<b>+50%</b>=<b>(".round($force+$force*50/100).")</b>\r\n");}
if ($p7 == 1 and $ar == 1 and $p10 == 1){printrus ("<b>+50%</b>=<b>(".round($force+$force*50/100).")</b> <b>+".$force_art10."</b>=<b>(".round($force+$force*50/100+$force_art10).")</b>\r\n");}

if ($p7 != 1 and $p10 == 1){printrus ("<b>+".$force_art10."</b>=<b>(".round($force+$force_art10).")</b>\r\n");}
printrus("<a href=\"gorodmagov.php?$ses&amp;m=params&amp;l=plus&amp;k=force\">+</a> / <a href=\"gorodmagov.php?$ses&amp;m=params&amp;l=minus&amp;k=force\">-</a><br/>");

}elseif(!isset($sure)){
if ($l=='plus'){
  if($d=='yes')
   {
   if($countto < 1){$countto=1;}
   if($countto > 100){printrus ("Нельзя за раз повысить больше чем на 100!<br/>\r\n"); printrus("<a href='gorodmagov.php?$ses'>Ок</a><br/>"); include_once("../other_inc/footer.php"); exit();}
   $prc=1;
   $prc = $prc*1.4;
   if ($k=='speed')$param=$b['weapon_speed_7'];
   else {$param=$b['weapon_force_7'];$prc=$prc*0.9;}

   if($countto < 1){$countto=1;}
   $do=$param+$countto; $mnd=0; $snd=0; $lnd=0; $ond=0;
     for($i=$param; $i<$do; $i++)
     {
     $ur=$i; if($ur >= 15){$ur=15;}
     $mn = round(50*($ur+1)*($ur+1)*$prc);
     $sn = round(8*($ur+1)*($ur+1)*$prc);
     $ln = round(10*($ur+1)*($ur+1)*$prc);
     $on = round(2*($ur+1)*($ur+1)*$prc);
     $mnd=$mnd+$mn; $snd=$snd+$sn; $lnd=$lnd+$ln; $ond=$ond+$on;
     }

   printrus("Увеличение параметра на $countto уровеней стоит ".res_print($mnd,$snd,0,$lnd,0,$ond).'<br/>');
   printrus("<a href=\"gorodmagov.php?sure&amp;$ses&amp;m=params&amp;n=$n&amp;l=$l&amp;countto=$countto&amp;k=$k\">Повысить</a><br/>");
   }
   else
   {
   printrus ("На сколько уровней повысить?<br/>\r\n");
   printrus ("<form name=\"\" action=\"gorodmagov.php?$ses&amp;m=params&amp;n=$n&amp;l=$l&amp;k=$k&amp;d=yes\" method=\"post\">
   <input format='*N' name='countto'/><br/>\r\n");
   printrus("<input type=\"submit\" value=\"Повысить\"/></form><br/>");
   }


}else{
  if($d=='yes')
   {
   if($countto < 1){$countto=1;}
   if($countto > 100){printrus ("Нельзя за раз понизить больше чем на 100!<br/>\r\n"); printrus("<a href='gorodmagov.php?$ses'>Ок</a><br/>"); include_once("../other_inc/footer.php"); exit();}
   $prc=1;
   $prc = $prc*1.4;
   if ($k=='speed')$param=$b['weapon_speed_7'];
   else {$param=$b['weapon_force_7'];$prc=$prc*0.9;}

   if($countto < 1){$countto=1;}
   $do=$param-$countto; $mnd=0; $snd=0; $lnd=0; $ond=0;
     if($do >= 1)
     {
       for($i=$param; $i>$do; $i--)
       {
       $ur=$i; if($ur > 15){$ur=15;}
       $mn = max(0,round(25*($ur-1)*($ur-1)*$prc));
       $sn = max(0,round(2*($ur-1)*($ur-1)*$prc));
       $ln = max(0,round(3*($ur-1)*($ur-1)*$prc));
       $on = max(0,round(1*($ur-1)*($ur-1)*$prc));
       $mnd=$mnd+$mn; $snd=$snd+$sn; $lnd=$lnd+$ln; $ond=$ond+$on;
       }
     printrus("Уменьшение параметра на $countto уровеней принесет вам ".res_print($mnd,$snd,0,$lnd,0,$ond).'<br/>');
     printrus("<a href=\"gorodmagov.php?sure&amp;$ses&amp;m=params&amp;n=$n&amp;l=$l&amp;countto=$countto&amp;k=$k\">Понизить</a><br/>");
     }
     else
     {
     printrus("Нельзя уменьшить на $countto!<br/>\n\r");
     printrus("<a href=\"gorodmagov.php?$ses\">Ок</a><br/>");
     }
   }
   else
   {
   printrus ("На сколько уровней понизить?<br/>\r\n");
   printrus ("<form name=\"\" action=\"gorodmagov.php?$ses&amp;m=params&amp;n=$n&amp;l=$l&amp;k=$k&amp;d=yes\" method=\"post\">
   <input format='*N' name='countto'/><br/>\r\n");
   printrus("<input type=\"submit\" value=\"Понизить\"/></form><br/>");
   }

}

}else{
$str='';

if ($l=='plus'){
$prc=1;

$prc = $prc*1.4;
if ($k=='speed'){$param=$b['weapon_speed_7'];$str='weapon_speed_7=weapon_speed_7+'.$countto.'';}
else {$param=$b['weapon_force_7'];$prc=$prc*0.9;$str='weapon_force_7=weapon_force_7+'.$countto.'';}

  if($countto < 1){$countto=1;}
  $do=$param+$countto; $mnd=0; $snd=0; $lnd=0; $ond=0;
    for($i=$param; $i<$do; $i++)
    {
    $ur=$i; if($ur >= 15){$ur=15;}
    $mn = round(50*($ur+1)*($ur+1)*$prc);
    $sn = round(8*($ur+1)*($ur+1)*$prc);
    $ln = round(10*($ur+1)*($ur+1)*$prc);
    $on = round(2*($ur+1)*($ur+1)*$prc);
    $mnd=$mnd+$mn; $snd=$snd+$sn; $lnd=$lnd+$ln; $ond=$ond+$on;
    }
}else{

$freeplace=max(0,free_place($countryID));

$prc=1;

$prc = $prc*1.4;
if ($k=='speed'){$param=$b['weapon_speed_7'];$str='weapon_speed_7=weapon_speed_7-'.$countto.'';}
else {$param=$b['weapon_force_7'];$prc=$prc*0.9;$str='weapon_force_7=weapon_force_7-'.$countto.'';}

  if($countto < 1){$countto=1;}
  $do=$param-$countto; $mnd=0; $snd=0; $lnd=0; $ond=0;
    for($i=$param; $i>$do; $i--)
    {
    $ur=$i; if($ur > 15){$ur=15;}
    $mn = max(0,round(25*($ur-1)*($ur-1)*$prc));
    $sn = max(0,round(2*($ur-1)*($ur-1)*$prc));
    $ln = max(0,round(3*($ur-1)*($ur-1)*$prc));
    $on = max(0,round(1*($ur-1)*($ur-1)*$prc));
    $mnd=$mnd+$mn; $snd=$snd+$sn; $lnd=$lnd+$ln; $ond=$ond+$on;
    }
}

if ($l=='minus'&&$do<1){
printrus("Нельзя уменьшить на $countto!<br/>\n\r");
printrus
("<a href=\"gorodmagov.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='minus'&&$freeplace<($mnd+$snd+$lnd+$ond)){
printrus("Не хватает места в хранилище для освободившихся ресурсов. Освободите место!<br/>\n\r");
printrus
("<a href=\"gorodmagov.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['money']<$mnd){
printrus("Не хватает денег для увеличения параметра! Необходимо: <b>$mnd</b><br/>\n\r");
printrus
("<a href=\"gorodmagov.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['stone']<$snd){
printrus("Не хватает камня для увеличения параметра! Необходимо: <b>$snd</b><br/>\n\r");
printrus
("<a href=\"gorodmagov.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['arbor']<$lnd){
printrus("Не хватает дерева для увеличения параметра! Необходимо: <b>$lnd</b><br/>\n\r");
printrus
("<a href=\"gorodmagov.php?$ses\">Ок</a>
<br/>
");
}elseif($l=='plus'&&$b['oil']<$ond){
printrus("Не хватает нефти для увеличения параметра! Необходимо: <b>$ond</b><br/>\n\r");
printrus
("<a href=\"gorodmagov.php?$ses\">Ок</a>
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

if ($k=='speed') $b['weapon_speed_7']=$b['weapon_speed_7']+$countto;
else $b['weapon_force_7']=$b['weapon_force_7']+$countto;

}else{

if ($k=='speed') $b['weapon_speed_7']=$b['weapon_speed_7']-$countto;
else $b['weapon_force_7']=$b['weapon_force_7']-$countto;

}
if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
if ($l=='plus')printrus("Параметр увеличен на $countto. Вы затратили: ".res_print(-$mnd,-$snd,0,-$lnd,0,-$ond).'<br/>');
else printrus("Параметр уменьшен на $countto. Вы выручили: ".res_print($mnd,$snd,0,$lnd,0,$ond).'<br/>');
printrus
("<a href=\"gorodmagov.php?m=params&amp;$ses\">Ок</a>
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