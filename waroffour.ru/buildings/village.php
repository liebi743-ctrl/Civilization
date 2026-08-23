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
//if (isset($_REQUEST['building'])) $building = $_REQUEST['building'];
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what)&&$what!='arbor'&&$what!='stone'&&$what!='iron'&&$what!='grain')exit;
if (isset($_REQUEST['newNal'])) $newNal = $_REQUEST['newNal'];
if (isset($newNal)&&!is_numeric($newNal)) $newNal=0;
if (isset($newNal)&&$newNal<0) $newNal=0;
if (isset($_REQUEST['spaceto'])) $spaceto = $_REQUEST['spaceto'];
if (isset($spaceto)&&!is_numeric($spaceto)) $spaceto=0;
if (isset($spaceto)&&$spaceto<0) $spaceto=0;
if (isset($_REQUEST['sure_space_minus'])) $sure_space_minus = $_REQUEST['sure_space_minus'];
if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;
if (isset($_REQUEST['minuswork']))$m='minuswork';
if (isset($_REQUEST['pluswork']))$m='pluswork';

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);
 $spaceto=round( (int) $spaceto);
 $newNal=round( (int) $newNal);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();
worksRefresh($_SESSION['countryID']);

//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();

//******************************************************************************
//проверка на наличие здания:****************************************

 build_exists_print($countryID,'village');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Деревня</u><br/>\r\n");

 $workers=$b['workers'];

 is_repairing($countryID,'village',$m);

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:

   //Текущие работы:
   $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $a=array();
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working')array_push($a,$mem[$i]);
     }else{
  $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'working'");
  $a = array();
  while (($s=mysql_fetch_array($r))!==FALSE){
        array_push($a,$s);
        }

  }

   if (count($a)!=0) printrus("Текущие работы:<br/>\n");
   for ($i=0;$i<count($a);$i++){
           $what = $a[$i]['what'];
           $people = $a[$i]['peopleatwork'];
           $finished = $a[$i]['finished'];
           $time = mkTimeStr($finished-date(U));
           switch ($what):
           case ('arbor'): $name = "Добыча древесины";break;
           case ('stone'): $name = "Добыча камня";break;
           case ('iron'): $name = "Добыча железа";break;
           case ('grain'): $name = "Выращивание зерна";break;
           endswitch;
printrus("$name ($people рабочих)[конец через $time]<br/>\n");

printrus ("Рабочие:<br/><form name=\"\" action=\"village.php?$ses&amp;what=$what\" method=\"post\">
<input format='*N' name='peopleto' /><br/>\r\n");

printrus
("<input name=\"minuswork\" type=\"submit\" value=\"отозвать\"/>
<br/>
");
printrus
("<input name=\"pluswork\" type=\"submit\" value=\"добавить\"/>
</form>
<br/>
");
printrus
("---<br/><a href=\"village.php?$ses&amp;m=stopwork&amp;what=$what\">Прервать работу</a>
<br/>---<br/>
");
           }

  //$workers_max=$space*$b["plotn_people"];
  //$workers_max=30*$b["plotn_people"];
  $workers_max=count_workers_max($countryID);
  $MaxMounts=floor(2999+sqrt($b['land']+$b['mountains']+$b['forest'])*max(0,($b['mountains_max']-10)));
  if($workers>$workers_max){
   printrus ("Рабочие [<u><b>$workers</b></u>]<br/>\r\n");
   printrus ("Количество рабочих превышает максимально возможное! Исследуйте плотность населения!<br/>\r\n");
  }elseif($workers==$workers_max){
   printrus ("Рабочие [<u>$workers</u>]<br/>\r\n");
  }else{
   printrus ("Рабочие [$workers]<br/>\r\n");
  }
  printrus ("Макс. гор [$MaxMounts]<br/>\r\n");
  printrus
("<a href=\"village.php?$ses&amp;m=space\">Территория</a>
[$space]
<br/>
");
  printrus
("<a href=\"village.php?$ses&amp;m=nalog\">Налоги</a>
<br/>
");
  printrus
("<a href=\"guard.php?$ses&amp;bld=village\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  printrus
("<a href=\"village.php?$ses&amp;m=arbor\">Рубка деревьев</a>
<br/>
");
  printrus
("<a href=\"village.php?$ses&amp;m=stone\">Добыча камня</a>
<br/>
");
  printrus
("<a href=\"village.php?$ses&amp;m=iron\">Добыча железа</a>
<br/>
");
  printrus
("<a href=\"village.php?$ses&amp;m=grain\">Выращивание зерна</a>
<br/>
");
  if($hits<100){
   printrus
("<a href=\"village.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'village',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Налоги::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('nalog'):
  $nalog=$b["nalog"];
  $napr=$b["napr"];
  $lastNal=$b["lastNal"];

  if(empty($n)){
   printrus
("<a href=\"village.php?$ses&amp;m=nalog&amp;n=ch_nalog\">Налог</a>
[<b>$nalog</b>]
<br/>
");
   printrus ("Напряжение в стране: <b>$napr %</b><br/>\r\n");
   printrus ("С прошлого сбора налогов прошло: ".mkTimeStr(date(U)-$lastNal)."<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=nalog&amp;n=tk_nalog\">Собрать налог</a>
<br/>
");
  }elseif($n=="ch_nalog" && (empty($newNal) or $newNal<=0)){
   printrus ("Сколько денег вы хотите взимать с каждого рабочего в вашей стране?<br/>\r\n");
   printrus ("<form name=\"\" action=\"village.php?$ses&amp;m=nalog&amp;n=ch_nalog\" method=\"post\">
<input format='*N' name='newNal' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("<a href=\"village.php?$ses&amp;m=nalog\">Отмена</a>
<br/>
");
  }elseif($n=="ch_nalog"){
   mysql_query("UPDATE countries SET nalog = $newNal WHERE countryID = '".$b['countryID']."'");
   $b['nalog'] = $newNal;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Новый налог: <b>$newNal</b>.<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=nalog\">Оk</a>
<br/>
");
  }elseif($n=="tk_nalog"){
   $napr_end=$napr+round($nalog*$workers*360/(date(U)-$lastNal));
   if($napr_end>=100){
    printrus ("Слишком высокий налог, напряжение превысит 100%!<br/>\r\n");
    printrus ("Напряжение в стране не может превышать 100%! Уменьшите налог.<br/>\r\n");
   }else{
    printrus ("Вы уверены, что хотите взять налог с вашего неселения?<br/>\r\n");
    printrus ("Напряжение в стране может подняться на <b>".($napr_end-$napr)." %</b>!<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=nalog&amp;n=tk_nalogsure\">Да</a>
<br/>
");
}
   printrus
("<a href=\"village.php?$ses&amp;m=nalog\">Отмена</a>
<br/>
");
  }elseif($n=="tk_nalogsure"){
   //Проверим, а нет ли на территории вражины:
   $r = mysql_query("SELECT count(*) as num FROM `wars` WHERE targetID = '$countryID' and wariors>0");
   $a = mysql_fetch_array($r);
   $new=CountryInfo($countryID);
   $napr=$new["napr"];
   $napr_plus=round($nalog*$workers*360/(date(U)-$lastNal));

   if(($napr+$napr_plus)<100){
   $dt = date(U);
   if(!isset($_SESSION['nalll']) || $_SESSION['nalll']<time()){
   	$_SESSION['nalll']=(time()+10);
   mysql_query("UPDATE countries SET lastNal = $dt, napr = ($napr + $napr_plus) WHERE countryID = '".$b['countryID']."'");
   $b['lastNal'] = $dt;
   $b['napr'] = $napr+$napr_plus;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

    $pm = round(1.5*$nalog*$workers);

    mysql_query("UPDATE countries SET money = money + $pm WHERE countryID = '".$b['countryID']."'");
    $b['money'] = $b['money'] + $pm;
    if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
      }
    printrus ("Вы получили <b>".($pm)."</b> денег! Напряжение выросло на <b>$napr_plus %</b>.<br/>\r\n");
    printrus
("<a href=\"village.php?$ses&amp;m=nalog\">Ok</a>
<br/>
");
    /*mysql_query("UPDATE countries SET money = money + $pm WHERE countryID = '".$b['countryID']."'");
    $b['money'] = $b['money'] + $pm;
    if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      } */

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."собрал налог $pm денег. Напряжометр +$napr_plus %\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   }else{
    printrus ("Вы не можете снять такой налог, т.к. напряжение превысит 100%!<br/>\r\n");
             printrus
("<a href=\"village.php?$ses&amp;m=nalog\">Ok</a>
<br/>
");
   }
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Изменение территории::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('space'):
  $space_free=countFreeLand($countryID);
  $r = mysql_query("SELECT count(*) as num FROM `wars` WHERE targetID = '$countryID'");
  $a = mysql_fetch_array($r);
  if ($a['num']!=0){
  printrus("Вы не можете изменять территорию деревни, пока на вашей территории стоят вражеские войска!<br/>");
  }elseif(empty($n)){
   printrus ("Вы хотите\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=space&amp;n=plus\">увеличить</a>
");
   printrus ("или\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=space&amp;n=minus\">уменьшить</a>
");
   printrus ("территорию деревни?<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//прибавляем территорию^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  }elseif($n=="plus" && $space_free<=0){
   printrus ("Нет свободной земли!<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="plus" && (empty($spaceto) or $spaceto<=0)){
   printrus ("На сколько вы хотите увеличить территорию деревни?<br/>\r\n");
   printrus ("<form name=\"\" action=\"village.php?$ses&amp;m=space&amp;n=plus\" method=\"post\">
<input format='*N' name='spaceto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=="plus" && ($spaceto*2)>$space_free){
   printrus ("У вас нет столько свободной земли! (всего <b>$space_free</b>) Увеличение территории деревни на 1 приводит к уменьшению свободной земли на 2<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=space&amp;n=plus&amp;spaceto=$space_free\">Использовать всю землю</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=="plus"){
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET land = land - $spaceto WHERE countryID = '".$b['countryID']."'");
   $b['land'] = $b['land'] - $spaceto;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   mysql_query("UPDATE buildings SET space = space + $spaceto WHERE countryID = '".$b['countryID']."' and building = 'village'");
   $key=_PREFIKS.':buildings'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='village'){
          $mem[$i]['space'] = $mem[$i]['space'] + $spaceto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Территория поселения увеличена на $spaceto! Свободная земля уменьшилась на ".($spaceto*2)."<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//уменьшаем территорию^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  }elseif($n=="minus" && $space<=$village_land){
   printrus ("Нельзя уменьшить территорию деревни!<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="minus" && (empty($spaceto) or $spaceto<=0)){
   printrus ("На сколько вы хотите уменьшить территорию деревни?<br/>\r\n");
   printrus ("<form name=\"\" action=\"village.php?$ses&amp;m=space&amp;n=minus\" method=\"post\">
<input format='*N' name='spaceto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=="minus" && $spaceto>($space-$village_land)){
   printrus ("Вы можете уменьшить территорию только на <b>".($space-$village_land)."</b>!<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=space&amp;n=minus&amp;spaceto=".($space-$village_land)."\">Уменьшить</a>
<br/>
");
   printrus
("\<a href=\"village.php?$ses&amp;m=space&amp;n=minus\">Отмена</a>
<br/>
");
  }elseif($n=="minus" && ($space-$spaceto)<($workers/$b["plotn_people"]) && empty($sure_space_minus)){
   printrus ("Текущая плотность населения не позволяет разместиться всем рабочим на оставшейся территории (".($space-$spaceto).").<br/>\r\n");
   $people_to_leave=$workers-($space-$spaceto)*$b["plotn_people"];
   printrus ("<b>$people_to_leave</b> рабочих покинут вашу страну.<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=space&amp;n=minus&amp;sure_space_minus=true&amp;spaceto=$spaceto\">Продолжить</a>
<br/>
");
   $space_needed=round($workers/$b["plotn_people"]+0.5);
   if($space_needed<$space){
    printrus
("<a href=\"village.php?$ses&amp;m=space&amp;n=minus&amp;spaceto=".($space-$space_needed)."\">Убрать только свободные земли</a>(".($space-$space_needed).")
<br/>
");
   }
   printrus
("<a href=\"village.php?$ses&amp;m=space&amp;n=minus\">Отмена</a>
<br/>
");
  }elseif($n=="minus"){
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET land = land + $spaceto WHERE countryID = '".$b['countryID']."'");
   $b['land'] = $b['land'] + $spaceto;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   mysql_query("UPDATE buildings SET space = space - $spaceto WHERE countryID = '".$b['countryID']."' and building = 'village'");
   $key=_PREFIKS.':buildings'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='village'){
          $mem[$i]['space'] = $mem[$i]['space'] - $spaceto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Территория поселения уменьшена на $spaceto!<br/>\r\n");

   $people_to_leave=$workers-($space-$spaceto)*$b["plotn_people"];
   if($people_to_leave>0){
    mysql_query("UPDATE countries SET workers = ($workers-$people_to_leave) WHERE countryID = '".$b['countryID']."'");
    $b['workers'] = $workers-$people_to_leave;
    if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

    printrus ("Вашу страну в негодовании покинули <b>$people_to_leave</b> рабочих!<br/>\r\n");
   }
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
  }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добыча дерева:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 case('arbor'):
  $space_free=countFreeLand($countryID);
  $money=$b["money"];

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$m){
         $work = $mem[$i]['what'];
         $timeleft=$mem[$i]['finished']-time();
         break;
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='working' and what='$m' limit 1";
  $result=@MYSQL_QUERY($query);
  $work=@mysql_result($result,0,'what');
  $timeleft=@mysql_result($result,0,'finished')-time();
  }

  if($work==$m){
   printrus ("Идет рубка деревьев.<br/>\r\n");
   printrus ("До конца осталось ".mkTimeStr($timeleft)."<br/>\r\n");

  }elseif($b["forest"]<=0){
   printrus ("В вашей стране нет леса вообще!<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
  }elseif(empty($peopleto) or $peopleto<=0 or empty($moneyto) or $moneyto<=0){
   printrus ("Сколько рабочих будут работать над вырубкой?<br/>\r\n");
   printrus ("<form name=\"\" action=\"village.php?$ses&amp;m=arbor\" method=\"post\">
<input format='*N' name='peopleto' /><br/>");
   printrus ("Сколько денег вы выделите на работу?<br/>\r\n");
   printrus ("<input format='*N' name='moneyto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($peopleto>$workers){
   printrus ("У вас нет столько рабочих! (всего <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=arbor&amp;peopleto=$workers&amp;moneyto=$moneyto\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$money){
   printrus ("У вас нет столько денег! (всего <b>$money</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=arbor&amp;peopleto=$peopleto&amp;moneyto=$money\">Использовать все деньги</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }else{
   //просчитываем,скока понадобится времени для работы:
   $forest_taken=max(1,min($b["forest"],round((round($moneyto/10)+1)*$peopleto/20)));
   $arbor_made=round($forest_taken*$b["arbor_making"]/10);
   if(isNewBuildings($countryID,'farm')){$arbor_made=$arbor_made+round($arbor_made*50/100);}
   $work_time=workTime($arbor_made,0,0,$forest_taken,$peopleto);

   mysql_query("UPDATE countries SET money = ($money - $moneyto), workers = ($workers-$peopleto), forest = forest - $forest_taken WHERE countryID = '".$b['countryID']."'");
   $b['money'] = $money-$moneyto;
   $b['workers'] = $workers-$peopleto;
   $b['forest'] = $b['forest'] - $forest_taken;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   //записываем в мускул, что идет вырубка:
   $query="insert into `works` values('$countryID','working','arbor',$peopleto,".date(U).",".($work_time+date(U)).", $arbor_made, $forest_taken)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array("countryID"=>$countryID, "kind"=>'working', "what"=>'arbor', "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$arbor_made, "var2"=>$forest_taken);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Через ".mkTimeStr($work_time)." ваши рабочие принесут <b>$arbor_made</b> дерева<br/>\r\n");

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."посылает $peopleto рабочих на добычу дерева ($arbor_made). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добыча камня::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('stone'):
  $space_free=countFreeLand($countryID);
  $money=$b["money"];

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$m){
         $work = $mem[$i]['what'];
         $timeleft=$mem[$i]['finished']-time();
         break;
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='working' and what='$m' limit 1";
  $result=@MYSQL_QUERY($query);
  $work=@mysql_result($result,0,'what');
  $timeleft=@mysql_result($result,0,'finished')-date(U);
  }

  if($work==$m){
   printrus ("Идет добыча камня.<br/>\r\n");
   printrus ("До конца осталось ".mkTimeStr($timeleft)."<br/>\r\n");

  }elseif($b["mountains"]<=0){
   printrus ("В вашей стране нет гор вообще!<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
  }elseif(empty($peopleto) or $peopleto<=0 or empty($moneyto) or $moneyto<=0){
   printrus ("Сколько рабочих будут работать на каменоломне?<br/>\r\n");
   printrus ("<form name=\"\" action=\"village.php?$ses&amp;m=stone\" method=\"post\">
<input format='*N' name='peopleto' /><br/>");
   printrus ("Сколько денег вы выделите на работу?<br/>\r\n");
   printrus ("<input format='*N' name='moneyto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($peopleto>$workers){
   printrus ("У вас нет столько рабочих! (всего <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=stone&amp;peopleto=$workers&amp;moneyto=$moneyto\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$money){
   printrus ("У вас нет столько денег! (всего <b>$money</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=stone&amp;peopleto=$peopleto&amp;moneyto=$money\">Использовать все деньги</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }else{
   //просчитываем,скока понадобится времени для работы:
   $mountains_taken=max(1,min($b["mountains"],round((round($moneyto/30)+1)*$peopleto/20)));
   $stone_made=round($mountains_taken*$b["stone_making"]/10);
  if($b['improved_mine'] > 99){$stone_made=$stone_made+round($stone_made*20/100);}
   $work_time=workTime($stone_made,0,0,$mountains_taken,$peopleto);

   mysql_query("UPDATE countries SET money = ($money - $moneyto), workers = ($workers-$peopleto), mountains = mountains - $mountains_taken WHERE countryID = '".$b['countryID']."'");
   $b['money'] = $money-$moneyto;
   $b['workers'] = $workers-$peopleto;
   $b['mountains'] = $b['mountains'] - $mountains_taken;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   //записываем в мускул, что идет вырубка:
   $query="insert into `works` values('$countryID','working','stone',$peopleto,".date(U).",".($work_time+date(U)).", $stone_made, $mountains_taken)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array("countryID"=>$countryID, "kind"=>'working', "what"=>'stone', "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$stone_made, "var2"=>$mountains_taken);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Через ".mkTimeStr($work_time)." ваши рабочие принесут <b>$stone_made</b> камня<br/>\r\n");

  //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."посылает $peopleto рабочих на добычу камня ($stone_made). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добыча железа:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('iron'):
  $space_free=countFreeLand($countryID);
  $money=$b["money"];

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$m){
         $work = $mem[$i]['what'];
         $timeleft=$mem[$i]['finished']-time();
         break;
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='working' and what='$m' limit 1";
  $result=@MYSQL_QUERY($query);
  $work=@mysql_result($result,0,'what');
  $timeleft=@mysql_result($result,0,'finished')-date(U);
  }

  if($work==$m){
   printrus ("Идет добыча руды.<br/>\r\n");
   printrus ("До конца осталось ".mkTimeStr($timeleft)."<br/>\r\n");

  }elseif($b["mountains"]<=0){
   printrus ("В вашей стране нет гор вообще!<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
  }elseif(empty($peopleto) or $peopleto<=0 or empty($moneyto) or $moneyto<=0){
   printrus ("Сколько рабочих будут работать в шахте?<br/>\r\n");
   printrus ("<form name=\"\" action=\"village.php?$ses&amp;m=iron\" method=\"post\">
<input format='*N' name='peopleto' /><br/>");
   printrus ("Сколько денег вы выделите на работу?<br/>\r\n");
   printrus ("<input format='*N' name='moneyto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($peopleto>$workers){
   printrus ("У вас нет столько рабочих! (всего <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=iron&amp;peopleto=$workers&amp;moneyto=$moneyto\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$money){
   printrus ("У вас нет столько денег! (всего <b>$money</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=iron&amp;peopleto=$peopleto&amp;moneyto=$money\">Использовать все деньги</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }else{
   //просчитываем,скока понадобится времени для работы:
   $mountains_taken=max(1,min($b["mountains"],round((round($moneyto/40)+1)*$peopleto/20)));
   if (!otkr_exists($countryID,'PERJ'))$iron_made=round($mountains_taken*$b["iron_making"]/30);
   else $iron_made=round($mountains_taken*1.20*$b["iron_making"]/30);
  if($b['improved_mine'] > 99){$iron_made=$iron_made+round($iron_made*20/100);}
   $work_time=workTime($iron_made,0,0,$mountains_taken,$peopleto);

   mysql_query("UPDATE countries SET money = ($money - $moneyto), workers = ($workers-$peopleto), mountains = mountains - $mountains_taken WHERE countryID = '".$b['countryID']."'");
   $b['money'] = $money-$moneyto;
   $b['workers'] = $workers-$peopleto;
   $b['mountains'] = $b['mountains'] - $mountains_taken;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   //записываем в мускул, что идет вырубка:
   $query="insert into `works` values('$countryID','working','iron',$peopleto,".date(U).",".($work_time+date(U)).", $iron_made, $mountains_taken)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array("countryID"=>$countryID, "kind"=>'working', "what"=>'iron', "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$iron_made, "var2"=>$mountains_taken);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Через ".mkTimeStr($work_time)." ваши рабочие принесут <b>$iron_made</b> железа<br/>\r\n");

  //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."посылает $peopleto рабочих на добычу железа ($iron_made). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добавление рабочих на работе :::::::::::::::::::::::::::::::::::::::::::::::::
case('pluswork'):

$key=_PREFIKS.':works'.$countryID;
if (($mem=$memcache->get($key))!==FALSE){
   $num=0;
   for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$what){
       $num=1;
       $people = $mem[$i]['peopleatwork'];
       $finished = $mem[$i]['finished'];
       $var2 = $mem[$i]['var2'];
       break;
       }
   }else{
$r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'working' and what = '$what' LIMIT 1");
$num = mysql_num_rows($r);
$a = mysql_fetch_array($r);
$people = $a['peopleatwork'];  //Сколько рабочих работают
$finished = $a['finished'];    //Время завершения
$var2 = $a['var2']; //Сколько земли занято под посевы
}

 if ($num!=0){

 if (!isset($peopleto)||(isset($peopleto)&&$peopleto<=0)){
 printrus("Вы должны указать целое положительное число рабочих!<br/>\r\n");
 }elseif($peopleto>$b['workers']){
 printrus("У вас только ".$b['workers']." свободных рабочих!<br/>\r\n");
 }else{

 $w_time = $finished-time(); //Осталось времени до завершения
 $new_time = time()+round($w_time*$people/($people+$peopleto));

 mysql_query("UPDATE `countries` SET workers = workers - $peopleto WHERE countryID = '$countryID'");
 $b['workers'] = $b['workers'] - $peopleto;
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }



 printrus("Теперь за работой ".($people+$peopleto)." рабочих. Работа будет завершена через ".mkTimeStr($new_time-time())."<br/>\n");

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."добавляет к работе $what $peopleto рабочих\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 mysql_query("UPDATE `works` SET finished = '".$new_time."', peopleatwork = peopleatwork + $peopleto WHERE countryID = '$countryID' and kind = 'working' and what = '$what' LIMIT 1");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$what){
          $mem[$i]['finished'] = $new_time;
          $mem[$i]['peopleatwork'] = $mem[$i]['peopleatwork'] + $peopleto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

 }

 }else{
       printrus("Ваши рабочие не выполняют данную работу!<br/>\n");
         }
 printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");


break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Сокращение рабочих на работе :::::::::::::::::::::::::::::::::::::::::::::::::
case('minuswork'):

$key=_PREFIKS.':works'.$countryID;
if (($mem=$memcache->get($key))!==FALSE){
   $num=0;
   for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$what){
       $num=1;
       $people = $mem[$i]['peopleatwork'];
       $finished = $mem[$i]['finished'];
       $var2 = $mem[$i]['var2'];
       break;
       }
   }else{
$r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'working' and what = '$what' LIMIT 1");
$num = mysql_num_rows($r);
$a = mysql_fetch_array($r);
$people = $a['peopleatwork'];  //Сколько рабочих работают
$finished = $a['finished'];    //Время завершения
$var2 = $a['var2']; //Сколько земли занято под посевы
}

 if ($num!=0){

 if (!isset($peopleto)||(isset($peopleto)&&$peopleto<=0)){
 printrus("Вы должны указать целое положительное число рабочих!<br/>\r\n");
 }elseif($peopleto>=$people){
 printrus("Вы можете отозвать только ".($people-1)." рабочих!<br/>\r\n");
 }else{

 $w_time = $finished-time(); //Осталось времени до завершения
 $new_time = time()+round($w_time*$people/($people-$peopleto));

 mysql_query("UPDATE `countries` SET workers = workers + $peopleto WHERE countryID = '$countryID'");
 $b['workers'] = $b['workers'] + $peopleto;
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }



 printrus("Теперь за работой ".($people-$peopleto)." рабочих. Работа будет завершена через ".mkTimeStr($new_time-time())."<br/>\n");

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."снимает с работы $what $peopleto рабочих\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 mysql_query("UPDATE `works` SET finished = '".$new_time."', peopleatwork = peopleatwork - $peopleto WHERE countryID = '$countryID' and kind = 'working' and what = '$what' LIMIT 1");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$what){
          $mem[$i]['finished'] = $new_time;
          $mem[$i]['peopleatwork'] = $mem[$i]['peopleatwork'] - $peopleto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

 }

 }else{
       printrus("Ваши рабочие не выполняют данную работу!<br/>\n");
         }
 printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");


break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Прекращение работы :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
case('stopwork'):

$key=_PREFIKS.':works'.$countryID;
if (($mem=$memcache->get($key))!==FALSE){
   $num=0;
   for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$what){
       $num=1;
       $people = $mem[$i]['peopleatwork'];
       $var2 = $mem[$i]['var2'];
       break;
       }
   }else{
$r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'working' and what = '$what' LIMIT 1");
$num = mysql_num_rows($r);
$a = mysql_fetch_array($r);
$people = $a['peopleatwork'];  //Сколько рабочих работают
$var2 = $a['var2']; //Сколько земли занято под посевы
}

 if ($num!=0){

 if ($what!='grain'){
 mysql_query("UPDATE `countries` SET workers = workers + $people WHERE countryID = '$countryID'");
 $b['workers'] = $b['workers'] + $people;
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

 }else{
 mysql_query("UPDATE `countries` SET workers = workers + $people, land = land + $var2 WHERE countryID = '$countryID'");
 $b['workers'] = $b['workers'] + $people;
 $b['land'] = $b['land'] + $var2;
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

         }

 printrus("Работа прекращена! Вернулись $people крестьян<br/>\n");

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."прекращает работу $what. $people рабочих вернулось\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'working' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$what){
          }else array_push($neww,$mem[$i]);
      $memcache->set($key,$neww,false,86400);
      }

 }else{
       printrus("Ваши рабочие не выполняют данную работу!<br/>\n");
         }
 printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");


break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Выращивание зерна:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('grain'):
  $space_free=countFreeLand($countryID);
  $money=$b["money"];

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']==$m){
         $work = $mem[$i]['what'];
         $timeleft=$mem[$i]['finished']-time();
         break;
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='working' and what='$m' limit 1";
  $result=@MYSQL_QUERY($query);
  $work=@mysql_result($result,0,'what');
  $timeleft=@mysql_result($result,0,'finished')-date(U);
  }

  if($work==$m){
   printrus ("Поля засеяны.<br/>\r\n");
   printrus ("До сбора урожая осталось ".mkTimeStr($timeleft)."<br/>\r\n");
  }elseif($space_free<=0){
   printrus ("В вашей стране нет свободных полей!<br/>\r\n");
   printrus
("
<a href='village.php?$ses'>Ок</a>
<br/>
");
  }elseif(empty($peopleto) or $peopleto<=0 or empty($moneyto) or $moneyto<=0){
   printrus ("Сколько рабочих будут работать на полях?<br/>\r\n");
   printrus ("<form name=\"\" action=\"village.php?$ses&amp;m=grain\" method=\"post\">
<input format='*N' name='peopleto' /><br/>");
   printrus ("Сколько денег вы выделите на работу?<br/>\r\n");
   printrus ("<input format='*N' name='moneyto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($peopleto>$workers){
   printrus ("У вас нет столько рабочих! (всего <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=grain&amp;peopleto=$workers&amp;moneyto=$moneyto\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$money){
   printrus ("У вас нет столько денег! (всего <b>$money</b>)<br/>\r\n");
   printrus
("<a href=\"village.php?$ses&amp;m=grain&amp;peopleto=$peopleto&amp;moneyto=$money\">Использовать все деньги</a>
<br/>
");
   printrus
("
<a href='village.php?$ses'>Отмена</a>
<br/>
");
  }else{
   //просчитываем,скока понадобится времени для работы:
   $land_taken=max(1,min($space_free,(round($moneyto/5)+1)*$peopleto));
   $grain_made=round(min(10000,$land_taken)*$b["grain_making"]/100*0.5);
   if(isNewBuildings($countryID,'farm')){$grain_made=$grain_made+round($grain_made*50/100);}
   $work_time=workTime($grain_made,0,0,$grain_made,$peopleto);
   mysql_query("UPDATE countries SET money = ($money - $moneyto), workers = ($workers-$peopleto), land = land-$land_taken WHERE countryID = '".$b['countryID']."'");
   $b['money'] = $money-$moneyto;
   $b['workers'] = $workers-$peopleto;
   $b['land'] = $b['land']-$land_taken;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
  //записываем в мускул, что идет вырубка:
   $query="insert into `works` values('$countryID','working','grain',$peopleto,".date(U).",".($work_time+date(U)).", $grain_made, $land_taken)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array("countryID"=>$countryID, "kind"=>'working', "what"=>'grain', "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$grain_made, "var2"=>$land_taken);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Через ".mkTimeStr($work_time)." ваши рабочие принесут <b>$grain_made</b> зерна<br/>\r\n");
      /*
  //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."посылает $peopleto рабочих на добычу зерна ($grain_made). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);*/

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
