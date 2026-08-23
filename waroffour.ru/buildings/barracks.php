<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['l'])) $l = $_REQUEST['l'];
if (isset($l) && !is_numeric($l)) $l=0;
if ($l!=0&&$l!=1&&$l!=2&&$l!=3&&$l!=4&&$l!=5&&$l!=6&&$l!=7) $l=0;
if ($l!=0&&$l!=1&&$l!=2&&($m!='wariors'||$n!='minus')) $l=0;
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;
//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);
 $scientiststo=round( (int) $scientiststo);
 $moneyto=round( (int) $moneyto);

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

 $countryID = $_SESSION['countryID'];


//******************************************************************************
//проверка на наличие здания:****************************************

build_exists_print($countryID,'barracks');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Казармы</u><br/>\r\n");

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

 //$money_toteach=7;
 //$iron_toteach=2+2*$weapon_kind+$bronya_kind;
 /*
 if (isset($l)){
  if ($l==1){
  $money_toteach=12;
  $iron_toteach=4+3*weapon_kind+2*$bronya_kind;
  }
  if ($l==2){
  $money_toteach=19;
  $iron_toteach=6+3*weapon_kind+3*$bronya_kind;
  }
  }
 */

 $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];

is_repairing($countryID,'barracks',$m);

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
  printrus
("<a href=\"guard.php?bld=barracks&amp;$ses\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  printrus
("<a href=\"barracks.php?m=wariors&amp;$ses\">Военные</a>
<br/>
");
//[".mkWarning($wariors_free)."/".mkWarning($wariors_atall)."]
//[".mkWarning($wariors_free_2)."/".mkWarning($wariors_atall_2)."]
//[".mkWarning($wariors_free_3)."/".mkWarning($wariors_atall_3)."]
  printrus
("<a href=\"barracks.php?m=weapon&amp;$ses\">Обмундирование</a>
<br/>
");
  if($hits<100){
   printrus
("<a href=\"barracks.php?m=repaire&amp;$ses\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }elseif(!builds($b['countryID'],"warhouse")){
   printrus
("<a href=\"barracks.php?m=upgraide&amp;$ses\">Строить улучшение (Дом войны)</a>
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
 repair($countryID,'barracks',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//апгрейдим здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('upgraide'):
 build_upgrade($countryID,'warhouse','barracks');
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//учим военных::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('wariors'):
  printrus ("Ученые: <b>$scientists</b><br/>\r\n");
  printrus ("Свободные военные:<br/>".print_voisko(array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8)));

  if ($n=='plus' && isset($peopleto) && isset($l)){
  require ($_SERVER['DOCUMENT_ROOT'].'/units.php');
  //Коэффициент стоимости:
  if ($l!=0)$s = 'weapon_speed_'.($l+1); else $s = 'weapon_speed';
  $speed = $$s;
  if ($l!=0)$s = 'weapon_force_'.($l+1); else $s = 'weapon_force';
  $force = $$s;
  $prc = 1+round(($speed+$force)/2)/100;
  $prc = $prc * (1+($b['weapon_kind']+$b['bronya_kind'])/10);

  $mnd = round($units[$l]['cost'][0]*$peopleto*$prc);
  $ind = round($units[$l]['cost'][1]*$peopleto*$prc);
  $snd = round($units[$l]['cost'][2]*$peopleto*$prc);
  $lnd = round($units[$l]['cost'][3]*$peopleto*$prc);
  $gnd = round($units[$l]['cost'][4]*$peopleto*$prc);
  $ond = round($units[$l]['cost'][5]*$peopleto*$prc);
  }

  $land = countAllLand($b['countryID'],TRUE);
  //А идет ли обучение военных?
  $teach = FALSE;
  $proc_result = returnProcess($b['countryID'],'teaching');
  for ($i=0;$i<count($proc_result);$i++){
          if ($proc_result[$i]['what']=='wariors'||$proc_result[$i]['what']=='wariors_2'||$proc_result[$i]['what']=='wariors_3'){
                  $zap = $i;
                  $teach = TRUE;
                  break;
          }
  }
  if(empty($n)){
   if($teach==TRUE){
    $percent=getWorkPercent($proc_result[$zap]["started"],$proc_result[$zap]["finished"],time());
    $what = $proc_result[$zap]['what'];
    printrus
("<a href=\"barracks.php?$ses&amp;m=wariors&amp;n=plus&amp;l=$what\">Обучение</a>
[<b>$percent</b>%]
<br/>
");
   }else{
    printrus
("<a href=\"barracks.php?$ses&amp;m=wariors&amp;n=plus\">Обучить...</a>
<br/>
");
   }
   if(($wariors_free+$wariors_free_2+$wariors_free_3+$wariors_free_4+$wariors_free_5+$wariors_free_6+$wariors_free_7+$wariors_free_8)>0){
    printrus
("<a href=\"barracks.php?$ses&amp;m=wariors&amp;n=minus\">Уволить...</a>
<br/>
");
   }
  }elseif($n=="plus" and $teach==TRUE){
   $scientists=$proc_result[$zap]["peopleatwork"];
   $workersTo=$proc_result[$zap]["var1"];
   $percent=getWorkPercent($proc_result[$zap]["started"],$proc_result[$zap]["finished"],time());
   $str = get_unit_name($l);
   printrus ("Обучение $str: Готово <b>$percent</b>%<br/>\r\n");
   printrus ("Осталось ".mkTimeStr($proc_result[$zap]["finished"]-date(U))."<br/>\r\n");
   printrus ("Обучается военных: <b>$workersTo</b><br/>\r\n");
   printrus ("Ученые: <b>$scientists</b><br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Ok</a>
<br/>
");
  }elseif($n=="plus" && isset($l) && $l!=0){
   printrus ("В казармах можно обучать только пехотинцев!<br/>\r\n");
  printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and ($peopleto<=0 or empty($peopleto) or $scientiststo<=0 or empty($scientiststo) or !isset($l))){
   printrus ("Сколько рабочих вы хотите обучить:<br/>\r\n");
   printrus ("<form name=\"\" action=\"barracks.php?$ses&amp;m=wariors&amp;n=plus\" method=\"post\">
   <input format='*N' name='peopleto'/><br/>\r\n");
   printrus ("Ученые, которые будут обучать рабочих:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus ("Тип войск:<br/>\r\n");
   printrus ("<select name=\"l\">\n");
   printrus ("<option value=\"0\">Пехота</option>\n");
   if ($land>8000) printrus ("<option value=\"1\">Кавалерия</option>\n");
   if ($land>14000) printrus ("<option value=\"2\">Стрелки</option>\n");
   printrus ("</select>
   <input  type=\"submit\" value=\"Обучить\"/>
   </form><br/>\n");

  }elseif($n=="plus" and $scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors&amp;l=$l&amp;n=plus&amp;peopleto=$peopleto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" && (($l==1 && $land<8000)||($l==2 && $land<14000))){
   printrus ("Вы не можете пока обучать этот тип войск!<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>$workers){
   printrus ("У вас нет столько свободных рабочих! (всего: <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors&amp;l=$l&amp;n=plus&amp;peopleto=$workers&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>round($space*($b["plotn_people"]/10))){
   printrus ("Вы можете обучить только <b>".round($space*$b["plotn_people"]/10)."</b> рабочих!<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors&amp;l=$l&amp;n=plus&amp;peopleto=".round($space*$b["plotn_people"]/10)."&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["money"]<$mnd){
   printrus ("Не хватает денег на обучение! (необходимо <b>".($mnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["iron"]<$ind){
   printrus ("Не хватает железа для обмундирования! (необходимо <b>".($ind)."</b>)<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["grain"]<$gnd){
   printrus ("Не хватает зерна для армейского запаса! (необходимо <b>".($gnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus"){      //Остальные ресурсы даже не проверяем, так как в казармах можно обучать только пехоту, на которую, кроме денег и железа и зерна, ничего не надо

   mysql_query("UPDATE countries SET workers = workers - $peopleto, scientists = scientists - $scientiststo, money = money - $mnd, iron = iron - $ind, grain = grain - $gnd WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['scientists'] = $scientists - $scientiststo;
   $b['iron'] = $b['iron'] - $ind;
   $b['grain'] = $b['grain'] - $gnd;
   $b['workers'] = $workers - $peopleto;
   $b['money'] = $b['money'] - $mnd;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($peopleto/($scientiststo*$b["science"])*10000*($l+1));
   if ($l==0)$what='wariors';
   if ($l==1)$what='wariors_2';
   if ($l==2)$what='wariors_3';
   $query="insert into works values('$countryID','teaching','$what',$scientiststo,".date(U).",".($work_time+date(U)).", $peopleto, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'teaching', "what"=>$what, "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$peopleto, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Обучение займет ".mkTimeStr($work_time).". Это стоило вам:<br/>".res_print($mnd,0,$ind,0,$gnd,0)."<br/>\r\n");

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
  }elseif($n=="minus" and ($wariors_free+$wariors_free_2+$wariors_free_3+$wariors_free_4+$wariors_free_5+$wariors_free_6+$wariors_free_7+$wariors_free_8)==0){
   printrus ("У вас нет свободных солдат вообще!<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="minus" and ($peopleto<=0 or empty($peopleto) || !isset($l))){



   print "<form name=\"\" action=\"barracks.php?$ses&amp;m=wariors&amp;n=minus\" method=\"post\">
   <input format='*N' name='peopleto'/><br/>\r\n";
   printrus ("<select name=\"l\">\n");
   if ($wariors_free>0)printrus ("<option value=\"0\">Пехота</option>\n");
   if ($wariors_free_2>0)printrus ("<option value=\"1\">Кавалерия</option>\n");
   if ($wariors_free_3>0)printrus ("<option value=\"2\">Стрелки</option>\n");
   if ($wariors_free_4>0)printrus ("<option value=\"3\">Пушки</option>\n");
   if ($wariors_free_5>0)printrus ("<option value=\"4\">Подрывники</option>\n");
   if ($wariors_free_6>0)printrus ("<option value=\"5\">Самолеты</option>\n");
   if ($wariors_free_7>0)printrus ("<option value=\"6\">Маги</option>\n");
   if ($wariors_free_8>0)printrus ("<option value=\"7\">Генералиссимусы</option>\n");
   printrus ("</select><br/>\n
   <input type=\"submit\" value=\"Уволить\"/>
   </form>");


  }elseif($n=="minus" and (($l==0 && $peopleto>$wariors_free)||($l==1 && $peopleto>$wariors_free_2)||($l==2 && $peopleto>$wariors_free_3)||($l==3 && $peopleto>$wariors_free_4)||($l==4 && $peopleto>$wariors_free_5)||($l==5 && $peopleto>$wariors_free_6)||($l==6 && $peopleto>$wariors_free_7)||($l==7 && $peopleto>$wariors_free_8))){
   printrus ("У вас нет стольких свободных военных этого типа! Всего:<br/>".print_voisko($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8)."\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="minus"){
   //Кол-во ресурсов, выручаемых при увольнении юнитов:
   $units_plus = array(
   array(3,1,0,0,0,0),   //Пехотинец
   array(5,1,2,1,7,0),  //Кавалерист
   array(5,2,3,2,9,0), //Стрелок
   array(14,4,6,4,2,2),  //Пушка
   array(9,3,3,3,3,0),   //Подрывник
   array(19,4,6,4,2,4),  //Самолет
   array(26,6,7,5,10,2), //Маг
   array(15000,2500,2500,2500,2500,750)  //Генералиссимус
   );
   $m_plus = $units_plus[$l][0]*$peopleto;
   $i_plus = $units_plus[$l][1]*$peopleto;
   $s_plus = $units_plus[$l][2]*$peopleto;
   $l_plus = $units_plus[$l][3]*$peopleto;
   $g_plus = $units_plus[$l][4]*$peopleto;
   $o_plus = $units_plus[$l][5]*$peopleto;

   $freeplace=max(0,free_place($countryID));
   if ($freeplace>=($m_plus+$i_plus+$s_plus+$l_plus+$g_plus+$o_plus)){

   if ($l==0) mysql_query("UPDATE countries SET workers = ($workers + $peopleto), wariors_free = ($wariors_free - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==1) mysql_query("UPDATE countries SET workers = ($workers + $peopleto), wariors_free_2 = ($wariors_free_2 - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==2) mysql_query("UPDATE countries SET workers = ($workers + $peopleto), wariors_free_3 = ($wariors_free_3 - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==3) mysql_query("UPDATE countries SET wariors_free_4 = ($wariors_free_4 - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==4) mysql_query("UPDATE countries SET workers = ($workers + $peopleto), wariors_free_5 = ($wariors_free_5 - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==5) mysql_query("UPDATE countries SET wariors_free_6 = ($wariors_free_6 - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==6) mysql_query("UPDATE countries SET workers = ($workers + $peopleto), wariors_free_7 = ($wariors_free_7 - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==8) mysql_query("UPDATE countries SET workers = ($workers + $peopleto), wariors_free_8 = ($wariors_free_8 - $peopleto), money = money+$m_plus, iron = iron+$i_plus, stone=stone+$s_plus, arbor=arbor+$l_plus, grain=grain+$g_plus, oil=oil+$o_plus WHERE countryID = '".$b['countryID']."' LIMIT 1");

   if ($l!=3&&$l!=5)$b['workers'] = $workers+$peopleto;
   if ($l==0){
   $b['wariors_free'] = $wariors_free-$peopleto;
   }
   if ($l==1){
   $b['wariors_free_2'] = $wariors_free_2-$peopleto;
   }
   if ($l==2){
   $b['wariors_free_3'] = $wariors_free_3-$peopleto;
   }
   if ($l==4){
   $b['wariors_free_5'] = $wariors_free_5-$peopleto;
   }
   if ($l==6){
   $b['wariors_free_7'] = $wariors_free_7-$peopleto;
   }
   if ($l==7){
   $b['wariors_free_8'] = $wariors_free_8-$peopleto;
   }
   $b['money'] = $b['money']+$m_plus;
   $b['iron'] = $b['iron']+$i_plus;
   $b['stone'] = $b['stone']+$s_plus;
   $b['arbor'] = $b['arbor']+$l_plus;
   $b['grain'] = $b['grain']+$g_plus;
   $b['oil'] = $b['oil']+$o_plus;

   $str = get_unit_name($l);
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   if ($l!=3&&$l!=5)printrus ("Вы только что уволили <b>$peopleto</b> $str! Вы выручили при этом:<br/>".res_print($m_plus,$s_plus,$i_plus,$l_plus,$g_plus,$o_plus)."\r\n");
   else printrus ("Вы только что разобрали <b>$peopleto</b> $str! Вы выручили при этом:<br/>".res_print($m_plus,$s_plus,$i_plus,$l_plus,$g_plus,$o_plus)."\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."увольняет $peopleto $str\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
}else{
printrus ("Не хватает места в хранилище для освобождающихся ресурсов! Освободите место.<br/>\r\n");
  printrus
("
<a href='warhouse.php?$ses'>Ок</a>
<br/>
");
}
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//оружие::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('weapon'):

 //Считаем ДЕЙСТВИТЕЛЬНО всех военных:
  //Задействованные в войнах:
  $key=_PREFIKS.':wars'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++) $num = $num + 0.4*$mem[$i]['wariors']+$mem[$i]['wariors_2']+1.2*$mem[$i]['wariors_3']+1.5*$mem[$i]['wariors_4']+1.2*$mem[$i]['wariors_5']+1.7*$mem[$i]['wariors_6']+1.7*$mem[$i]['wariors_7']+$mem[$i]['wariors_8'];
     //$all = $wariors_atall+1.2*$wariors_atall_2+1.5*$wariors_atall_3+$num;
     $all = $num;
     }else{
  $r = mysql_query("SELECT sum(0.4*wariors+wariors_2+1.2*wariors_3+1.5*wariors_4+1.2*wariors_5+1.7*wariors_6+1.7*wariors_7+wariors_8) as num FROM `wars` WHERE countryID = '$countryID' LIMIT 1");
  $a = mysql_fetch_array($r);
  $all = $a['num'];
  //$all = $wariors_atall+1.2*$wariors_atall_2+1.5*$wariors_atall_3+$a['num'];
  }
  //Свободные военные
  $all = $all + 0.4*$b['wariors_free'] + $b['wariors_free_2'] + 1.2*$b['wariors_free_3'] + 1.5*$b['wariors_free_4'] + 1.2*$b['wariors_free_5'] + 1.7*$b['wariors_free_6'] + 1.7*$b['wariors_free_7']+$b['wariors_free_8'];
  //Задействованные в охране зданий:
  $buildings = returnBuildings($countryID);
  for ($i=0;$i<count($buildings);$i++){
  $all = $all + 0.4*$buildings[$i]['guard']+$buildings[$i]['guard_2']+1.2*$buildings[$i]['guard_3']+1.5*$buildings[$i]['guard_4']+1.2*$buildings[$i]['guard_5']+1.7*$buildings[$i]['guard_6']+1.7*$buildings[$i]['guard_7']+$buildings[$i]['guard_8'];
  }

  $all = round($all);

  printrus ("Обмундирование:<br/>\r\n");
  //if($n=="ch_w_kind"){
   $weapon_kind=1-$weapon_kind;
   $iron_to_change_weapon=round((1+2*$weapon_kind-(1+$weapon_kind)*otkr_exists($b['countryID'],"MWIB"))*$all);
  //}elseif($n=="ch_b_kind"){
   $bronya_kind=1-$bronya_kind;
   $iron_to_change_bronya=round((1+$bronya_kind-(1+$bronya_kind)*otkr_exists($b['countryID'],"MWIB"))*$all);
   $weapon_kind=1-$weapon_kind;
   $bronya_kind=1-$bronya_kind;
  //}

 if ($n=="ch_w_kind"||$n=="ch_b_kind"){
   $weapon_kind=1-$weapon_kind;
   $bronya_kind=1-$bronya_kind;
     //Проверка, обучаются ли военные
     $key=_PREFIKS.':works'.$countryID;
     if (($mem=$memcache->get($key))!==FALSE){
        $ob=FALSE;
        for ($i=0;$i<count($mem);$i++){
            if ($mem[$i]['kind']=='teaching'&&($mem[$i]['what']=='wariors' || $mem[$i]['what']=='wariors_2' || $mem[$i]['what']=='wariors_3'||$mem[$i]['what']=='wariors_4'||$mem[$i]['what']=='wariors_5'||$mem[$i]['what']=='wariors_6'||$mem[$i]['what']=='wariors_7'||$mem[$i]['what']=='wariors_8')){
                    $ob=TRUE;
                    break;
                }
            }
        }else{
        $r2 = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'teaching' and (what = 'wariors' or what = 'wariors_2' or what = 'wariors_3' or what = 'wariors_4' or what = 'wariors_5' or what = 'wariors_6' or what = 'wariors_7' or what = 'wariors_8') LIMIT 1");
        if (mysql_num_rows($r2)!=0) $ob=TRUE; else $ob=FALSE;
        }
     }

  if(empty($n)){
   if($noob>=1){
    printrus
("[<a href=\"barracks.php?$ses&amp;m=help&amp;n=Weapon_".$weapon_kind."\">?</a>]
");
   }
   if($weapon_kind==1){
    printrus ("Тяжелое оружие\r\n");
    printrus
("(<a href=\"barracks.php?$ses&amp;m=weapon&amp;n=ch_w_kind\">изменить</a> (<b>$iron_to_change_weapon</b> жел.))
<br/>
");
   }elseif($weapon_kind==0){
    printrus ("Легкое оружие\r\n");
    printrus
("(<a href=\"barracks.php?$ses&amp;m=weapon&amp;n=ch_w_kind\">изменить</a> (<b>$iron_to_change_weapon</b> жел.))
<br/>
");
   }else{
    printrus ("Непонятное инопланетное оружие:)<br/>\r\n");
   }

   if($noob>=1){
    printrus
("[<a href=\"barracks.php?$ses&amp;m=help&amp;n=Bronya_".$bronya_kind."\">?</a>]
");
   }
   if($bronya_kind==1){
    printrus ("Тяжелая броня\r\n");
    printrus
("(<a href=\"barracks.php?$ses&amp;m=weapon&amp;n=ch_b_kind\">изменить</a> (<b>$iron_to_change_bronya</b> жел.))
<br/>
");
   }elseif($bronya_kind==0){
    printrus ("Легкая броня\r\n");
printrus
("(<a href=\"barracks.php?$ses&amp;m=weapon&amp;n=ch_b_kind\">изменить</a> (<b>$iron_to_change_bronya</b> жел.))
<br/>
");
   }else{
    printrus ("Непонятная инопланетная броня:)<br/>\r\n");
   }

   printrus ("Пехота:<br/>\r\n");
   printrus ("<u>скорость</u> [$weapon_speed]<br/>\r\n");
   printrus ("<u>сила</u> [$weapon_force]<br/>\r\n");

   printrus ("Кавалерия:<br/>\r\n");
   printrus ("<u>скорость</u> [$weapon_speed_2]<br/>\r\n");
   printrus ("<u>сила</u> [$weapon_force_2]<br/>\r\n");

   printrus ("Стрелки:<br/>\r\n");
   printrus ("<u>скорость</u> [$weapon_speed_3]<br/>\r\n");
   printrus ("<u>сила</u> [$weapon_force_3]<br/>\r\n");

   printrus
("
<a href='barracks.php?$ses'>OK</a>
<br/>
");

  }elseif($n=="ch_w_kind" and $b["iron"]<$iron_to_change_weapon){
   printrus ("Недостаточно железа для перехода на другой вид оружия! (необходимо <b>$iron_to_change_weapon</b> железа)<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_w_kind" and $ob==TRUE){
   printrus ("Невозможно сменить тип брони/оружия во время обучения военных!<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_w_kind"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET weapon_kind = $weapon_kind, iron = iron - $iron_to_change_weapon WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['weapon_kind'] = $weapon_kind;
   $b['iron'] = $b['iron'] - $iron_to_change_weapon;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   if($weapon_kind==1){
    printrus ("Теперь ваши войска вооружены тяжелым оружием!<br/>\r\n");
   }elseif($weapon_kind==0){
    printrus ("Теперь ваши войска вооружены легким оружием!<br/>\r\n");
   }
   if($iron_to_change_weapon>0){
    printrus ("На новое оружие ушло <b>$iron_to_change_weapon</b> железа!<br/>\r\n");
   }elseif($iron_to_change_weapon<0){
    printrus ("При переплавке старых оружий в новые вы выручили <b>".(-$iron_to_change_weapon)."</b> железа!<br/>\r\n");
   }
   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="ch_b_kind" and $b["iron"]<$iron_to_change_bronya){
   printrus ("Недостаточно железа для перехода на другой вид брони! (необходимо <b>$iron_to_change_bronya</b> железа)<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_b_kind" and $ob==TRUE){
   printrus ("Невозможно сменить тип брони/оружия во время обучения военных!<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_b_kind"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET bronya_kind = $bronya_kind, iron = iron - $iron_to_change_bronya WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['bronya_kind'] = $bronya_kind;
   $b['iron'] = $b['iron'] - $iron_to_change_bronya;
   //СТРАННО!!! ПОЧЕМУ $weapon_kind, а не $bronya_kind????  - ИСПРАВИЛ
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   if($bronya_kind==1){
    printrus ("Теперь ваши войска используют тяжелую броню!<br/>\r\n");
   }elseif($bronya_kind==0){
    printrus ("Теперь ваши войска используют легкую броню!<br/>\r\n");
   }
   if($iron_to_change_bronya>0){
    printrus ("На новую броню ушло <b>$iron_to_change_bronya</b> железа!<br/>\r\n");
   }elseif($iron_to_change_bronya<0){
    printrus ("При переплавке старых лат в новые вы выручили <b>".(-$iron_to_change_bronya)."</b> железа!<br/>\r\n");
   }
   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//В помощь нубам!!!:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('help'):

  if(empty($n)){

  }elseif($n=='Weapon_0'){
   printrus ("Справка: <u>Легкое оружие</u><br/>\r\n");
   printrus ("Этот тип оружия эффективен, когда у противника тяжелая броня.<br/>\r\n");
   printrus ("Вы получаете штраф, если вы атакуете противника с легкой броней легким же оружием.<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=='Weapon_1'){
   printrus ("Справка: <u>Тяжелое оружие</u><br/>\r\n");
   printrus ("Этот тип оружия эффективен, когда у противника легкая броня.<br/>\r\n");
   printrus ("Вы получаете штраф, если вы атакуете противника с тяжелой броней тяжелым же оружием.<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=='Bronya_0'){
   printrus ("Справка: <u>Легкая броня</u><br/>\r\n");
   printrus ("Этот тип брони эффективен для защиты от легкого оружия.<br/>\r\n");
   printrus ("Вы получаете штраф, если вас атакуют с тяжелым оружием, а у вас легкая броня.<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=='Bronya_1'){
   printrus ("Справка: <u>Тяжелая броня</u><br/>\r\n");
   printrus ("Этот тип брони эффективен для защиты от тяжелого оружия.<br/>\r\n");
   printrus ("Вы получаете штраф, если вас атакуют с легким оружием, а у вас тяжелая броня.<br/>\r\n");
   printrus
("<a href=\"barracks.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }

 break;
 endswitch;

}

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
include_once("../other_inc/footer.php");
?>
