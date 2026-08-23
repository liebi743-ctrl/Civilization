<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['l'])) $l = $_REQUEST['l'];
if (isset($_REQUEST['d'])) $d = $_REQUEST['d'];
if (isset($l) && !is_numeric($l)) $l=0;
if ($l!=0&&$l!=1&&$l!=2&&$l!=3&&$l!=4&&$l!=5&&$l!=6&&$l!=7) $l=0;
if ($l!=0&&$l!=1&&$l!=2&&($m!='wariors'||$n!='minus')) $l=0;
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;
if (isset($_REQUEST['neighbour'])) $neighbour = $_REQUEST['neighbour'];
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
if (isset($_REQUEST['countto'])) $countto = $_REQUEST['countto'];
if (isset($countto)&&!is_numeric($countto)) $countto=0;
if (isset($countto)&&$countto<0) $countto=0;

//==============================================================================
//подключаем скрипты

 if (isset($peopleto))$peopleto=round( (int) $peopleto);
 if (isset($countto))$countto=round( (int) $countto);
 if (isset($scientiststo))$scientiststo=round( (int) $scientiststo);
 if (isset($moneyto))$moneyto=round( (int) $moneyto);
 if (isset($wariorsto))$wariorsto=round( (int) $wariorsto);
 if (isset($wariorsto_2))$wariorsto_2=round( (int) $wariorsto_2);
 if (isset($wariorsto_3))$wariorsto_3=round( (int) $wariorsto_3);
 if (isset($wariorsto_4))$wariorsto_4=round( (int) $wariorsto_4);
 if (isset($wariorsto_5))$wariorsto_5=round( (int) $wariorsto_5);
 if (isset($wariorsto_6))$wariorsto_6=round( (int) $wariorsto_6);
 if (isset($wariorsto_7))$wariorsto_7=round( (int) $wariorsto_7);
 if (isset($wariorsto_8))$wariorsto_8=round( (int) $wariorsto_8);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];

//worksRefresh($_SESSION['countryID']);

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();
$us=UzersInfo($countryID);

$neighbourID=$neighbour;
$neighbourInfo=CountryInfo($neighbourID);
$rTime=(((time()-$neighbourInfo['reggedTime'])*1.5)<(time()-$b['reggedTime']))?1:0;
 $ost=(time()-$b['reggedTime'])-((time()-$neighbourInfo['reggedTime'])*1.5);
 function testCit($id,$str,$tst){ Global $b;
$file = fopen("../logs/cit$id", "r");
if(!$file){return false;exit;}
$buffer = fread($file, filesize("../logs/cit$id"));
fclose($file);

if($b['reggedTime']>(time()-(200*60*60)))
    return true;



if (substr_count($buffer, $str)>0){

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
 $tis=testCit("$neighbourID",$b['countryName'],"cit");


 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;


//******************************************************************************
//проверка на наличие здания:****************************************

build_exists_print($countryID,'warhouse');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Дом войны</u><br/>\r\n");

 $noob=$_SESSION['noob'];

 $wariors_free=$b["wariors_free"];
 $wariors_free_2=$b["wariors_free_2"];
 $wariors_free_3=$b["wariors_free_3"];
 $wariors_free_4=$b["wariors_free_4"];
 $wariors_free_5=$b["wariors_free_5"];
 $wariors_free_6=$b["wariors_free_6"];
 $wariors_free_7=$b["wariors_free_7"];
 $wariors_free_8=$b["wariors_free_8"];
 //$wariors_atall=$b["wariors_atall"];
 //$wariors_atall_2=$b["wariors_atall_2"];
 //$wariors_atall_3=$b["wariors_atall_3"];
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

 $wallboom_count=$b["count"];
 $wallboom_kind=$b["kind"];
 $wallboom_protection=$b["protection"];

 //Ресурсы, необходимые для обучения юнитов теперь записаны в параметрах юнитов
 /*
 $money_toteach=7;
 $iron_toteach=2+2*$weapon_kind+$bronya_kind;
 $stone_toteach=0;

 if (isset($l)){
  if ($l==1){
  $money_toteach=12;
  $iron_toteach=4+3*weapon_kind+2*$bronya_kind;
  $stone_toteach=20;
  }
  if ($l==2){
  $money_toteach=19;
  $iron_toteach=6+3*weapon_kind+3*$bronya_kind;
  $stone_toteach=30;
  }
  }
  */
 $iron_tomakewallboom=20+10*$wallboom_protection;
 $arbor_tomakewallboom=30;
 if ($wallboom_count!=0)$iron_toupwallboomprotection=($wallboom_protection*$wallboom_protection*$wallboom_count*3);
 else $iron_toupwallboomprotection=($wallboom_protection*$wallboom_protection*3);

 //Дерево и зерно, необходимые для обучения 1 военного
 /*
 $lamb_toteach = 2;
 $grain_toteach = 10;
 if (isset($l)){
         if($l==1){
         $lamb_toteach = 4;
         $grain_toteach = 20;
         }
         if($l==2){
         $lamb_toteach = 6;
         $grain_toteach = 25;
         }
 }
 */

  $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];

 is_repairing($countryID,'warhouse',$m);

if ($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
  printrus
("<a href=\"guard.php?$ses&amp;bld=warhouse\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Военные</a>
<br/>
");
//[".mkWarning($wariors_free)."/".mkWarning($wariors_atall)."]
//[".mkWarning($wariors_free_2)."/".mkWarning($wariors_atall_2)."]
//[".mkWarning($wariors_free_3)."/".mkWarning($wariors_atall_3)."]

  printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Обмундирование</a>
<br/>
");
  printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Стенобитные орудия</a>
[$wallboom_count]
<br/>
");
  printrus
("
<a href='../calc.php?$ses'>Калькулятор стен</a>
<br/>
");
  printrus
("<a href=\"warhouse.php?$ses&amp;m=war\">Война</a>
<br/>
");
  //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\\
  if(otkr_exists($countryID,"AFTH")==1 && $wallboom_count>0){
   printrus
("<a href=\"warhouse.php?$ses&amp;m=hiddenattack\">Скрытая атака</a>
<br/>
");
  }
  if($hits<100){
   printrus
("<a href=\"warhouse.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'warhouse',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//учим военных::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('wariors'):
  printrus ("Ученые: <b>$scientists</b><br/>\r\n");
  printrus ("Свободные военные:<br/>".print_voisko(array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8)));
  //printrus ("Свободные пехотинцы: <b>$wariors_free</b><br/>\r\n");
  //printrus ("Свободные кавалеристы: <b>$wariors_free_2</b><br/>\r\n");
  //printrus ("Свободные стрелки: <b>$wariors_free_3</b><br/>\r\n");
  /*
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
  */

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
("<a href=\"warhouse.php?$ses&amp;m=wariors&amp;l=$what&amp;n=plus\">Обучение</a>
[<b>$percent</b>%]
<br/>
");
   }else{
    printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors&amp;n=plus\">Обучить...</a>
<br/>
");
   }
   if($wariors_free+$wariors_free_2+$wariors_free_3+$wariors_free_4+$wariors_free_5+$wariors_free_6+$wariors_free_7+$wariors_free_8>0){
    printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors&amp;n=minus\">Уволить...</a>
<br/>
");
   }
  }elseif($n=="plus" and $teach==TRUE){
   $scientists=$proc_result[$zap]["peopleatwork"];
   $workersTo=$proc_result[$zap]["var1"];
   $percent=getWorkPercent($proc_result[$zap]["started"],$proc_result[$zap]["finished"],time());
   $str = get_unit_name($l);
   //if ($l==0) $str = 'пехотинцев';
   //if ($l==1) $str = 'кавалеристов';
   //if ($l==2) $str = 'стрелков';
   printrus ("Обучение $str: Готово <b>$percent</b>%<br/>\r\n");
   printrus ("Осталось ".mkTimeStr($proc_result[$zap]["finished"]-date(U))."<br/>\r\n");
   printrus ("Обучается военных: <b>$workersTo</b><br/>\r\n");
   printrus ("Ученые: <b>$scientists</b><br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Ok</a>
<br/>
");
  }elseif($n=="plus" and ($peopleto<=0 or empty($peopleto) or $scientiststo<=0 or empty($scientiststo) or !isset($l))){
   printrus ("Сколько рабочих вы хотите обучить:<br/>\r\n");
   printrus ("<form name=\"\" action=\"warhouse.php?$ses&amp;m=wariors&amp;n=plus\" method=\"post\">
<input format='*N' name='peopleto'/><br/>\r\n");
   printrus ("Ученые, которые будут обучать рабочих:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus ("Тип войск:<br/>\r\n");
   printrus ("<select name=\"l\">\n");
   printrus ("<option value=\"0\">Пехота</option>\n");
   if ($land>8000) printrus ("<option value=\"1\">Кавалерия</option>\n");
   if ($land>14000) printrus ("<option value=\"2\">Стрелки</option>\n");
   printrus ("</select><br/>\n");
   printrus
("<input type=\"submit\" value=\"Обучить\"/></form>
<br/>
");
  }elseif($n=="plus" and $scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors&amp;l=$l&amp;n=plus&amp;peopleto=$peopleto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" && (($l==1 && $land<8000)||($l==2 && $land<14000))){
   printrus ("Вы не можете пока обучать этот тип войск (для кавалерии необходимо 8000 земли, для стрелков - 14000)!<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>$workers){
   printrus ("У вас нет столько свободных рабочих! (всего: <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors&amp;l=$l&amp;n=plus&amp;peopleto=$workers&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>round($space*$b["plotn_people"]/10)){
   printrus ("Вы можете обучить только <b>".round($space*$b["plotn_people"]/10)."</b> крестьян!<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors&amp;l=$l&amp;n=plus&amp;peopleto=".round($space*$b["plotn_people"]/10)."&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["stone"]<$snd){
   printrus ("Не хватает камня на обучение! (необходимо <b>".($snd)."</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["money"]<$mnd){
   printrus ("Не хватает денег на обучение! (необходимо <b>".($mnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["iron"]<$ind){
   printrus ("Не хватает железа для обмундирования! (необходимо <b>".($ind)."</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["arbor"]<$lnd){
   printrus ("Не хватает дерева для обмундирования! (необходимо <b>".($lnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["grain"]<$gnd){
   printrus ("Не хватает зерна для армейского запаса! (необходимо <b>".($gnd)."</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $b["oil"]<$ond){
   printrus ("Не хватает нефти для обучения! (необходимо <b>".($ond)."</b>)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="plus"){
  //$mmd = $peopleto*$money_toteach;
  //$imd = $peopleto*$iron_toteach;
  //$snd = $peopleto*$stone_toteach;
  //if ($b['weapon_speed']+$b['weapon_force']>24) $lnd = $peopleto*$lamb_toteach; else $lnd = 5;
  //if ($b['weapon_speed']+$b['weapon_force']>24) $gnd = $peopleto*$grain_toteach; else $gnd = $peopleto*3;
   mysql_query("UPDATE countries SET workers = ($workers-$peopleto), scientists = ($scientists-$scientiststo), money = money - $mnd, iron = iron - $ind, arbor = arbor - $lnd, grain = grain - $gnd, stone = stone - $snd, oil = oil - $ond WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['workers'] = $workers-$peopleto;
   $b['scientists'] = $scientists-$scientiststo;
   $b['money'] = $b['money']-$mnd;
   $b['iron'] = $b['iron']-$ind;
   $b['arbor'] = $b['arbor']-$lnd;
   $b['grain'] = $b['grain']-$gnd;
   $b['stone'] = $b['stone']-$snd;
   $b['oil'] = $b['oil']-$ond;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   if ($l==0)$what='wariors';
   if ($l==1)$what='wariors_2';
   if ($l==2)$what='wariors_3';
   $work_time=round($peopleto/($scientiststo*$b["science"])*10000*($l+1));

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
  }elseif($n=="minus" and ($wariors_free+$wariors_free_2+$wariors_free_3+$wariors_free_4+$wariors_free_5+$wariors_free_6+$wariors_free_7+$wariors_free_8)<=0){
   printrus ("У вас нет свободных солдат вообще!<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
<br/>
");
  }elseif($n=="minus" and ($peopleto<=0 or empty($peopleto) || !isset($l))){
   print "<form name=\"\" action=\"warhouse.php?$ses&amp;m=wariors&amp;n=minus\" method=\"post\">
<input format='*N' name='peopleto'/><br/>\r\n";
   printrus ("<select name=\"l\">\n");
   printrus ("<option value=\"0\">Пехота</option>\n");
   if ($wariors_free_2>0)printrus ("<option value=\"1\">Кавалерия</option>\n");
   if ($wariors_free_3>0)printrus ("<option value=\"2\">Стрелки</option>\n");
   if ($wariors_free_4>0)printrus ("<option value=\"3\">Пушки</option>\n");
   if ($wariors_free_5>0)printrus ("<option value=\"4\">Подрывники</option>\n");
   if ($wariors_free_6>0)printrus ("<option value=\"5\">Самолеты</option>\n");
   if ($wariors_free_7>0)printrus ("<option value=\"6\">Маги</option>\n");
   if ($wariors_free_8>0)printrus ("<option value=\"7\">Генералиссимусы</option>\n");
   printrus ("</select><br/>\n");
   printrus
("<input type=\"submit\" value=\"Уволить/Разобрать\"/>
</form>
<br/>
");
  }elseif($n=="minus" and (($l==0 && $peopleto>$wariors_free)||($l==1 && $peopleto>$wariors_free_2)||($l==2 && $peopleto>$wariors_free_3)||($l==3 && $peopleto>$wariors_free_4)||($l==4 && $peopleto>$wariors_free_5)||($l==5 && $peopleto>$wariors_free_6)||($l==6 && $peopleto>$wariors_free_7)||($l==7 && $peopleto>$wariors_free_8))){
   printrus ("У вас нет стольких свободных военных этого типа! Всего:<br/>".print_voisko($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8)."\r\n");

   printrus
("<a href=\"warhouse.php?$ses&amp;m=wariors\">Отмена</a>
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
   if ($l==3){
   $b['wariors_free_4'] = $wariors_free_4-$peopleto;
   }
   if ($l==4){
   $b['wariors_free_5'] = $wariors_free_5-$peopleto;
   }
   if ($l==5){
   $b['wariors_free_6'] = $wariors_free_6-$peopleto;
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
//Война ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('war'):
  if(!empty($neighbour)){
   printrus ("Война: [<u>".$neighbourInfo['countryName']."</u>]<br/>\r\n");
  }

  $key=_PREFIKS.':wars'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $wcount = count($mem);
     }else{
  $r = mysql_query("SELECT count(*) as num FROM `wars` WHERE countryID = '$countryID'");
  $a = mysql_fetch_array($r);
  $wcount = $a['num'];
  }

  if(empty($n)){
   $neighbours=returnNeighbours($countryID);
   for($i=0;$i<count($neighbours);$i++){
    $countryName=$neighbours[$i];
    $nbr = getCountryID($neighbours[$i]);
    if(is_unitee($countryID,$nbr)){
     printrus ("<u>$countryName</u>\r\n");
     if(building_exists($countryID,"citadel")){
      printrus
("(<a href=\"citadel.php?$ses&amp;m=neighbours&amp;n=info&amp;neighbour=$nbr\">союзник</a>)
<br/>
");
     }else{//if(building_exists
      printrus ("(союзник)<br/>\r\n");
     }
    }else{//if(is_unitee
     printrus
("<a href=\"warhouse.php?$ses&amp;m=war&amp;n=info&amp;neighbour=$nbr\">$countryName</a>
<br/>
");
    }
   }
  }elseif($n=="info" && !neighbour_exists($countryID,$neighbourID)){
   printrus ("<u>нет такого соседа!!!</u><br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=war\">Отмена</a>
<br/>
");
  }elseif($n=="info" AND $rTime!=0 AND !$tis){
   //testCit($neighbourID,$country,'cit')
   // $rTime!=0
   printrus ("Вы намного старше этого государства!Подождите ".mkTimeStr($ost).".<br/>\r\n");
  }elseif($n=="info" && is_unitee($countryID,$neighbourID)){
   printrus ("<u>Вы не можете нападать на союзника!!!</u><br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=war\">Отмена</a>
<br/>
");
  }elseif($n=="info"){

   if(building_exists($countryID,"citadel")){
    $spy_lvl=$b["spy"];
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

     if(otkr_exists($countryID,"AFTH")==1 && $wallboom_count>0){
      printrus
("<a href=\"warhouse.php?$ses&amp;m=hiddenattack&amp;neighbour=$neighbour\">Скрытая атака</a>
<br/>
");
     }
    }else{//if(building_exists($neighbourID,"wall")
     printrus ("Стена остутствует<br/>\r\n");
    }
   }else{//if(building_exists($countryID,"citadel")
    if(building_exists($neighbourID,"wall")){
     printrus ("Стена<br/>\r\n");
     if(otkr_exists($countryID,"AFTH")==1 && $wallboom_count>0){
      printrus
("<a href=\"warhouse.php?$ses&amp;m=hiddenattack&amp;neighbour=$neighbour\">Скрытая атака</a>
<br/>
");
     }
    }else{//if(building_exists($neighbourID,"wall")
     printrus ("Стена остутствует<br/>\r\n");
    }
   }
   if(!building_exists($countryID,"citadel")){
    printrus ("Для войны необходимо построить цитадель!<br/>\r\n");
   }elseif($general=general_info($countryID)){
    printrus
("<a href=\"warhouse.php?$ses&amp;m=war&amp;n=attack&amp;neighbour=$neighbour\">Война!</a>
<br/>
");
   }else{
    printrus ("Без генерала нельзя начать войну!<br/>\r\n");
   }
  }elseif($n=="attack" && $nightmar==TRUE){
   printrus ("Вы находитесь в ночном моратории и не можете начать войну!<br/>\r\n");
  }elseif($n=="attack" && $b['moratory']>time()){
   printrus ("Вы находитесь в купленном моратории и не можете начать войну!<br/>\r\n");
  }elseif($n=="attack" && !neighbour_exists($countryID,$neighbourID)){
   exit;
  }elseif($n=="attack" && $mar=maratory($neighbourID)){
   printrus ("На эту страну действует мараторий неприкосновенности! Подождите ".mkTimeStr($mar)."<br/>\r\n");
  }elseif($n=="attack" && $wcount>=3){
   printrus ("Вы можете вести одновременно не более 3 войн!<br/>\r\n");
  }elseif($n=="attack" && war_between($countryID,$neighbourID)){
   printrus ("Вы уже воюете с этим гос-вом!<br/>\r\n");
  }elseif($n=="attack" && ($wariors_free+$wariors_free_2+$wariors_free_3+$wariors_free_4+$wariors_free_5+$wariors_free_6+$wariors_free_7+$wariors_free_8)<=0){
   printrus ("У вас нет свободных воинов!<br/>\r\n");
  }elseif($n=="attack" && !$general=general_info($countryID)){
   printrus ("Без генерала нельзя начать войну!<br/>\r\n");
  }elseif($n=="attack" && (($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8)<=0)){

   printrus ("Сколько воинов вы отправите в поход?<br/>\r\n");
   //Форма для выбора войск
   print_form_voisko('warhouse',array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8),'war','attack',$neighbour);

  }elseif($n=="attack" && ($wariorsto>$wariors_free||$wariorsto_2>$wariors_free_2||$wariorsto_3>$wariors_free_3||$wariorsto_4>$wariors_free_4||$wariorsto_5>$wariors_free_5||$wariorsto_6>$wariors_free_6||$wariorsto_7>$wariors_free_7||$wariorsto_8>$wariors_free_8)){
   printrus ("У вас нет столько свободных воинов!<br/>\r\n");
   printrus ("Сколько воинов вы отправите в поход?<br/>\r\n");
   //Форма для выбора войск
   print_form_voisko('warhouse',array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8),'war','attack',$neighbour);

  }elseif($n=="attack"){

   mysql_query("UPDATE countries SET wariors_free = ($wariors_free-$wariorsto),
   wariors_free_2 = ($wariors_free_2-$wariorsto_2), wariors_free_3 = ($wariors_free_3-$wariorsto_3),
   wariors_free_4 = ($wariors_free_4-$wariorsto_4), wariors_free_5 = ($wariors_free_5-$wariorsto_5),
   wariors_free_6 = ($wariors_free_6-$wariorsto_6), wariors_free_7 = ($wariors_free_7-$wariorsto_7),
   wariors_free_8 = ($wariors_free_8-$wariorsto_8)
   WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['wariors_free'] = $wariors_free-$wariorsto;
   $b['wariors_free_2'] = $wariors_free_2-$wariorsto_2;
   $b['wariors_free_3'] = $wariors_free_3-$wariorsto_3;
   $b['wariors_free_4'] = $wariors_free_4-$wariorsto_4;
   $b['wariors_free_5'] = $wariors_free_5-$wariorsto_5;
   $b['wariors_free_6'] = $wariors_free_6-$wariorsto_6;
   $b['wariors_free_7'] = $wariors_free_7-$wariorsto_7;
   $b['wariors_free_8'] = $wariors_free_8-$wariorsto_8;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   //Пишем в лог о битве:
 $open=fopen("../logs/war".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName']."
 напала на ".$neighbourInfo['countryName']."
 войском:<br/>".print_voisko(array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8))."\n\r");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   start_war($countryID,$neighbourID,array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8));

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");

  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//оружие::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('weapon'):

  printrus ("Обмундирование:<br/>\r\n");
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
  //В осаде/атаке замка
  $r = mysql_query("SELECT sum(0.4*wariors+wariors_2+1.2*wariors_3+1.5*wariors_4+1.2*wariors_5+1.7*wariors_6+1.7*wariors_7+wariors_8) as num FROM `zamok_defence` WHERE countryID = '$countryID'");
  $a = mysql_fetch_array($r);
  $all += $a['num'];

  $r = mysql_query("SELECT sum(0.4*wariors+wariors_2+1.2*wariors_3+1.5*wariors_4+1.2*wariors_5+1.7*wariors_6+1.7*wariors_7+wariors_8) as num FROM `zamok_attack` WHERE countryID = '$countryID'");
  $a = mysql_fetch_array($r);
  $all += $a['num'];

  $all = round($all);

  //if($n=="ch_w_kind"){
   $weapon_kind=1-$weapon_kind;
   $iron_to_change_weapon=(1+1*$weapon_kind-(1+$weapon_kind)*otkr_exists($countryID,"MWIB"))*$all;
  //}elseif($n=="ch_b_kind"){
   $bronya_kind=1-$bronya_kind;
   $iron_to_change_bronya=(1+$bronya_kind-(1+$bronya_kind)*otkr_exists($countryID,"MWIB"))*$all;
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
            if ($mem[$i]['kind']=='teaching'&&($mem[$i]['what']=='wariors'||$mem[$i]['what']=='wariors_2'||$mem[$i]['what']=='wariors_3'||$mem[$i]['what']=='wariors_4'||$mem[$i]['what']=='wariors_5'||$mem[$i]['what']=='wariors_6'||$mem[$i]['what']=='wariors_7'||$mem[$i]['what']=='wariors_8')){
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
("[<a href=\"warhouse.php?$ses&amp;m=help&amp;n=Weapon_".$weapon_kind."\">?</a>]
");
   }                                                     //легкое и тяжелое броня , оружие
   if($weapon_kind==1){
    printrus ("Тяжелое оружие\r\n");
    printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon&amp;n=ch_w_kind\">изменить<br /></a> (<b>$iron_to_change_weapon</b> железа)
<br/>
");
   }elseif($weapon_kind==0){
    printrus ("Легкое оружие\r\n");
    printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon&amp;n=ch_w_kind\">изменить<br /></a> (<b>$iron_to_change_weapon</b> железа)
<br/>
");
   }else{
    printrus ("Непонятное инопланетное оружие:)<br/>\r\n");
   }

   if($noob>=1){
    printrus
("[<a href=\"warhouse.php?$ses&amp;m=help&amp;n=Bronya_".$bronya_kind."\">?</a>]
");
   }
   if($bronya_kind==1){
    printrus ("Тяжелая броня\r\n");
    printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon&amp;n=ch_b_kind\">изменить<br /></a> (<b>$iron_to_change_bronya</b> железа)
<br/>
");
   }elseif($bronya_kind==0){
    printrus ("Легкая броня\r\n");
    printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon&amp;n=ch_b_kind\">изменить<br /></a> (<b>$iron_to_change_bronya</b> железа)
<br/>
");
   }else{printrus ("Непонятная инопланетная броня:)<br/>\r\n");}

  if($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time()){$speed_art10=$nz['un_3']; $force_art10=$nz['un_3'];}
  /*============================================================*/
  printrus ("<br />Пехота:<br/>\r\n");
  $speed_art1=0; $force_art1=0; $speed_art2=0; $force_art2=0;
  if (isArtefact($countryID, 'sapog')){printrus("+Кирзовый сапог: +50% сила и +50% скорость пехоты<br/><br />\r\n"); $speed_art1=50; $force_art1=50;}
  if (isArtefact($countryID, 'lions_shield_of_courage')){printrus("+Львиный щит бесстрашия: +200% сила и +100% скорость пехоты<br/><br />\r\n"); $speed_art2=100; $force_art2=200;}

  printrus ("<u>скорость</u> [$weapon_speed] \r\n");
  if (isArtefact($countryID, 'sapog')){printrus ("<b>+50%</b>=<b>(".round($weapon_speed+$weapon_speed*$speed_art1/100).")</b>\r\n");}
  if (isArtefact($countryID, 'lions_shield_of_courage')){printrus ("<b>+100%</b>=<b>(".round($weapon_speed+$weapon_speed*($speed_art1+$speed_art2)/100).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time() and $nz['un_3']>0){printrus ("<b>+".$speed_art10."</b>=<b>(".round(($weapon_speed+$weapon_speed*($speed_art1+$speed_art2)/100)+$speed_art10).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'dungeon') and ($nz['un_4']+259200) > time()){printrus ("<b>+5</b>=<b>(".round(($weapon_speed+$weapon_speed*($speed_art1+$speed_art2)/100)+$speed_art10+5).")</b>\r\n");}
  printrus("<a href=\"warhouse.php?$ses&amp;m=weapon_speedup&amp;l=0\"><br />поднять</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href=\"warhouse.php?$ses&amp;m=weapon_speeddown&amp;l=0\">понизить<br /></a><br/>");

  printrus ("<u>сила</u> [$weapon_force] \r\n");
  if (isArtefact($countryID, 'sapog')){printrus ("<b>+50%</b>=<b>(".round($weapon_force+$weapon_force*$force_art1/100).")</b>\r\n");}
  if (isArtefact($countryID, 'lions_shield_of_courage')){printrus ("<b>+200%</b>=<b>(".round($weapon_force+$weapon_force*($force_art1+$force_art2)/100).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time() and $nz['un_3']>0){printrus ("<b>+".$force_art10."</b>=<b>(".round(($weapon_force+$weapon_force*($force_art1+$force_art2)/100)+$force_art10).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'dungeon') and ($nz['un_1']+259200) > time()){printrus ("<b>+4</b>=<b>(".round(($weapon_force+$weapon_force*($force_art1+$force_art2)/100)+$force_art10+4).")</b>\r\n");}
  printrus("<a href=\"warhouse.php?$ses&amp;m=weapon_forceup&amp;l=0\"><br />поднять</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href=\"warhouse.php?$ses&amp;m=weapon_forcedown&amp;l=0\">понизить<br /></a><br/>");
  /*============================================================*/
  printrus ("<br />Кавалерия:<br/>\r\n");
  $speed_art1=0; $force_art1=0; $speed_art2=0; $force_art2=0;
  if (isArtefact($countryID, 'podkova')){printrus("+Стальная подкова: +50% сила и +50% скорость кавалерии<br/><br />\r\n"); $speed_art1=50; $force_art1=50;}
  if (isArtefact($countryID, 'red_dragon_flame_tongue')){printrus("+Языки пламени Красного Дракона: +100% скорость<br/><br />\r\n"); $speed_art2=100;}

  printrus ("<u>скорость</u> [$weapon_speed_2]\r\n");
  if (isArtefact($countryID, 'podkova')){printrus ("<b>+50%</b>=<b>(".round($weapon_speed_2+$weapon_speed_2*$speed_art1/100).")</b>\r\n");}
  if (isArtefact($countryID, 'red_dragon_flame_tongue')){printrus ("<b>+100%</b>=<b>(".round($weapon_speed_2+$weapon_speed_2*($speed_art1+$speed_art2)/100).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time() and $nz['un_3']>0){printrus ("<b>+".$speed_art10."</b>=<b>(".round(($weapon_speed_2+$weapon_speed_2*($speed_art1+$speed_art2)/100)+$speed_art10).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'dungeon') and ($nz['un_4']+259200) > time()){printrus ("<b>+5</b>=<b>(".round(($weapon_speed_2+$weapon_speed_2*($speed_art1+$speed_art2)/100)+$speed_art10+5).")</b>\r\n");}
  printrus("<a href=\"warhouse.php?$ses&amp;m=weapon_speedup&amp;l=1\"><br />поднять</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href=\"warhouse.php?$ses&amp;m=weapon_speeddown&amp;l=1\">понизить<br /></a><br/>");

  printrus ("<u>сила</u> [$weapon_force_2]\r\n");
  if (isArtefact($countryID, 'podkova')){printrus ("<b>+50%</b>=<b>(".round($weapon_force_2+$weapon_force_2*$force_art1/100).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time() and $nz['un_3']>0){printrus ("<b>+".$force_art10."</b>=<b>(".round(($weapon_force_2+$weapon_force_2*$force_art1/100)+$force_art10).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'dungeon') and ($nz['un_1']+259200) > time()){printrus ("<b>+4</b>=<b>(".round(($weapon_force_2+$weapon_force_2*$force_art1/100)+$force_art10+4).")</b>\r\n");}
  printrus("<a href=\"warhouse.php?$ses&amp;m=weapon_forceup&amp;l=1\"><br />поднять</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href=\"warhouse.php?$ses&amp;m=weapon_forcedown&amp;l=1\">понизить<br /></a><br/>");
  /*==============================================================*/
  printrus ("<br />Стрелки:<br/>\r\n");
  $speed_art1=0; $force_art1=0; $speed_art2=0; $force_art2=0;
  if (isArtefact($countryID, 'puli')){printrus("+Бронебойные пули: +30% сила и +30% скорость стрелков<br/><br />\r\n"); $speed_art1=30; $force_art1=30;}

  printrus ("<u>скорость</u> [$weapon_speed_3]\r\n");
  if (isArtefact($countryID, 'puli')){printrus ("<b>+30%</b>=<b>(".round($weapon_speed_3+$weapon_speed_3*$speed_art1/100).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time() and $nz['un_3']>0){printrus ("<b>+".$speed_art10."</b>=<b>(".round(($weapon_speed_3+$weapon_speed_3*$speed_art1/100)+$speed_art10).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'dungeon') and ($nz['un_4']+259200) > time()){printrus ("<b>+5</b>=<b>(".round(($weapon_speed_3+$weapon_speed_3*$speed_art1/100)+$speed_art10+5).")</b>\r\n");}
  printrus("<a href=\"warhouse.php?$ses&amp;m=weapon_speedup&amp;l=2\"><br />поднять</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href=\"warhouse.php?$ses&amp;m=weapon_speeddown&amp;l=2\">понизить<br /></a><br/>");

  printrus ("<u>сила</u> [$weapon_force_3]\r\n");
  if (isArtefact($countryID, 'puli')){printrus ("<b>+30%</b>=<b>(".round($weapon_force_3+$weapon_force_3*$force_art1/100).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'altar') and ($nz['time_sac']+259200) > time() and $nz['un_3']>0){printrus ("<b>+".$force_art10."</b>=<b>(".round(($weapon_force_3+$weapon_force_3*$force_art1/100)+$force_art10).")</b>\r\n");}
  if ($nz=isNewBuildings($countryID,'dungeon') and ($nz['un_1']+259200) > time()){printrus ("<b>+4</b>=<b>(".round(($weapon_force_3+$weapon_force_3*$force_art1/100)+$force_art10+4).")</b>\r\n");}
  printrus("<a href=\"warhouse.php?$ses&amp;m=weapon_forceup&amp;l=2\"><br />поднять</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href=\"warhouse.php?$ses&amp;m=weapon_forcedown&amp;l=2\">понизить<br /></a><br/>");


  printrus("<a href='warhouse.php?$ses'>OK</a><br/>");

  }elseif($n=="ch_w_kind" and $b["iron"]<$iron_to_change_weapon){
   printrus ("Недостаточно железа для перехода на другой вид оружия! (необходимо <b>$iron_to_change_weapon</b> железа)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_w_kind" && $ob==TRUE){
   printrus ("Нельзя изменить тип оружия/брони во время обучения солдат!<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_w_kind"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET weapon_kind = $weapon_kind, iron = iron - $iron_to_change_weapon WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['weapon_kind'] = $weapon_kind;
   $b['iron'] = $b['iron'] - $iron_to_change_weapon;
   if ($id_m==TRUE){
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
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_b_kind" && $ob==TRUE){
   printrus ("Нельзя изменить тип оружия/брони во время обучения солдат!<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=="ch_b_kind"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET bronya_kind = $bronya_kind, iron = iron - $iron_to_change_bronya WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['bronya_kind'] = $bronya_kind;
   $b['iron'] = $b['iron'] - $iron_to_change_bronya;
   if ($id_m==TRUE){
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
//скорость атаки военных::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('weapon_speedup'):
if (!isset($l))$l=0;
if ($l==0)$weapon_speed=$weapon_speed;
if ($l==1)$weapon_speed=$weapon_speed_2;
if ($l==2)$weapon_speed=$weapon_speed_3;
if($countto < 1){$countto=1;}
if($countto > 100){printrus ("Нельзя за раз повысить больше чем на 100!<br/>\r\n"); printrus("<a href='warhouse.php?$ses&amp;m=weapon'>Ок</a><br/>"); include_once("../other_inc/footer.php"); exit();}
$do=$weapon_speed+$countto; $rnd=0;
  for($i=$weapon_speed; $i<$do; $i++)
  {
  $ur=$i; if($ur >= 15){$ur=15;}
  $ir=round($ur*$ur*(1+$weapon_kind)*5+10);
  $rnd=$rnd+$ir;
  }
if ($l==1)$rnd=round($rnd*1.9);
if ($l==2)$rnd=round($rnd*2.7);

   if($n=='sure' and $b['iron']>=$rnd and $d=='yes')
   {
   if ($l==0)mysql_query("UPDATE countries SET iron = iron - $rnd, weapon_speed = weapon_speed + $countto WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==1)mysql_query("UPDATE countries SET iron = iron - $rnd, weapon_speed_2 = weapon_speed_2 + $countto WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==2)mysql_query("UPDATE countries SET iron = iron - $rnd, weapon_speed_3 = weapon_speed_3 + $countto WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['iron'] = $b['iron'] - $rnd;
   if ($l==0)$b['weapon_speed'] = $b['weapon_speed'] + $countto;
   if ($l==1)$b['weapon_speed_2'] = $b['weapon_speed_2'] + $countto;
   if ($l==2)$b['weapon_speed_3'] = $b['weapon_speed_3'] + $countto;
      if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Скорость атаки ".get_unit_name($l)." повышена на <b>$countto</b> уровней!<br/>\r\n");
   printrus("<a href='warhouse.php?$ses'>Ок</a><br/>");
   }
   elseif($n=='sure')
   {
   printrus ("Для поднятия уровня скорости атаки ".get_unit_name($l)." на <b>$countto</b> уровней необходимо: <b>$rnd</b> железа.<br/>\r\n");
     if($b['iron']>=$rnd){
     printrus("<a href='warhouse.php?$ses&amp;m=weapon_speedup&amp;n=sure&amp;l=$l&amp;countto=$countto&amp;d=yes'>Повысить</a><br/>");
     }else{
     printrus ("Нехватает материалов для поднятия уровня скорости атаки ".get_unit_name($l)."! (Необходимо: <b>$rnd</b> железа)<br/>\r\n");
     }
   printrus("<a href='warhouse.php?$ses'>Отмена</a><br/>");
   }
   else
   {
    printrus ("На сколько уровней повысить скорость аттаки ".get_unit_name($l)."?<br/>\r\n");
   printrus ("<form name=\"\" action=\"warhouse.php?$ses&amp;m=weapon_speedup&amp;n=sure&amp;l=$l\" method=\"post\">
   <input format='*N' name='countto'/><br/>\r\n");
   printrus("<input type=\"submit\" value=\"Повысить\"/></form><br/>");

   printrus("<a href='warhouse.php?$ses'>Отмена</a><br/>");
   }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//скорость атаки военных(снижение)::::::::::::::::::::::::::::::::::::::::::::::
 case('weapon_speeddown'):
 if (!isset($l))$l=0;
 if (($l==0&&$weapon_speed<=0)||($l==1&&$weapon_speed_2<=0)||($l==2&&$weapon_speed_3<=0)){
 printrus("Невозможно понизить еще!<br/>\r\n");
 }else{
  if ($l==0)$rnd=($weapon_speed<=8)?($weapon_speed-1)*($weapon_speed-1)*5+10:(8-1)*(8-1)*5+10;
  if ($l==1)$rnd=($weapon_speed_2<=8)?($weapon_speed_2-1)*($weapon_speed_2-1)*5+10:(8-1)*(8-1)*5+10;
  if ($l==2)$rnd=($weapon_speed_3<=8)?($weapon_speed_3-1)*($weapon_speed_3-1)*5+10:(8-1)*(8-1)*5+10;
  if ($l==1)$rnd=round($rnd*1.9);
  if ($l==2)$rnd=round($rnd*2.7);
  $rnd=round($rnd*0.8);
  if($n=='sure'){

   $freeplace=max(0,free_place($countryID));
   if($freeplace>=$rnd){

   if ($l==0)mysql_query("UPDATE countries SET iron = iron + $rnd, weapon_speed = weapon_speed-1 WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==1)mysql_query("UPDATE countries SET iron = iron + $rnd, weapon_speed_2 = weapon_speed_2-1 WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==2)mysql_query("UPDATE countries SET iron = iron + $rnd, weapon_speed_3 = weapon_speed_3-1 WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['iron'] = $b['iron'] + $rnd;
   if ($l==0)$b['weapon_speed'] = $b['weapon_speed'] - 1;
   if ($l==1)$b['weapon_speed_2'] = $b['weapon_speed_2'] - 1;
   if ($l==2)$b['weapon_speed_3'] = $b['weapon_speed_3'] - 1;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Скорость атаки ".get_unit_name($l)." понижена на <b>1</b> уровень!<br/>\r\n");
   printrus ("Вы выручили <b>$rnd</b> железа!<br/>\r\n");
   printrus
("
<a href='warhouse.php?$ses'>Ок</a>
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

  }else{
   printrus ("Вы уверены, что хотите понизить скорость атаки ".get_unit_name($l)." на 1 уровень? Вы выручите <b>$rnd</b> железа!<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon_speeddown&amp;l=$l&amp;n=sure\">Да</a>
<br/>
");

   printrus
("
<a href='warhouse.php?$ses'>Отмена</a>
<br/>
");
  }
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Сила атаки военных::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('weapon_forceup'):
if (!isset($l))$l=0;
if ($l==0)$weapon_force=$weapon_force;
if ($l==1)$weapon_force=$weapon_force_2;
if ($l==2)$weapon_force=$weapon_force_3;
if($countto < 1){$countto=1;}
if($countto > 100){printrus ("Нельзя за раз повысить больше чем на 100!<br/>\r\n"); printrus("<a href='warhouse.php?$ses&amp;m=weapon'>Ок</a><br/>"); include_once("../other_inc/footer.php"); exit();}
$do=$weapon_force+$countto; $rnd=0;
  for($i=$weapon_force; $i<$do; $i++)
  {
  $ur=$i; if($ur >= 15){$ur=15;}
  $ir=round($ur*$ur*(1+$weapon_kind)*10+15);
  $rnd=$rnd+$ir;
  }
if ($l==1)$rnd=round($rnd*1.9);
if ($l==2)$rnd=round($rnd*2.7);

   if($n=='sure' and $b['iron']>=$rnd and $d=='yes')
   {
   if ($l==0)mysql_query("UPDATE countries SET iron = iron - $rnd, weapon_force = weapon_force + $countto WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==1)mysql_query("UPDATE countries SET iron = iron - $rnd, weapon_force_2 = weapon_force_2 + $countto WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==2)mysql_query("UPDATE countries SET iron = iron - $rnd, weapon_force_3 = weapon_force_3 + $countto WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['iron'] = $b['iron'] - $rnd;
   if ($l==0)$b['weapon_force'] = $b['weapon_force'] + $countto;
   if ($l==1)$b['weapon_force_2'] = $b['weapon_force_2'] + $countto;
   if ($l==2)$b['weapon_force_3'] = $b['weapon_force_3'] + $countto;
      if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Сила атаки ".get_unit_name($l)." повышена на <b>$countto</b> уровней!<br/>\r\n");
   printrus("<a href='warhouse.php?$ses'>Ок</a><br/>");
   }
   elseif($n=='sure')
   {
   printrus ("Для поднятия уровня силы атаки ".get_unit_name($l)." на <b>$countto</b> уровней необходимо: <b>$rnd</b> железа.<br/>\r\n");
     if($b['iron']>=$rnd){
     printrus("<a href='warhouse.php?$ses&amp;m=weapon_forceup&amp;n=sure&amp;l=$l&amp;countto=$countto&amp;d=yes'>Повысить</a><br/>");
     }else{
     printrus ("Нехватает материалов для поднятия уровня силы атаки ".get_unit_name($l)."! (Необходимо: <b>$rnd</b> железа)<br/>\r\n");
     }
   printrus("<a href='warhouse.php?$ses'>Отмена</a><br/>");
   }
   else
   {
   printrus ("На сколько уровней повысить силу аттаки ".get_unit_name($l)."?<br/>\r\n");
   printrus ("<form name=\"\" action=\"warhouse.php?$ses&amp;m=weapon_forceup&amp;n=sure&amp;l=$l\" method=\"post\">
   <input format='*N' name='countto'/><br/>\r\n");
   printrus("<input type=\"submit\" value=\"Повысить\"/></form><br/>");

   printrus("<a href='warhouse.php?$ses'>Отмена</a><br/>");
   }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Сила атаки военных(понижение):::::::::::::::::::::::::::::::::::::::::::::::::
 case('weapon_forcedown'):
 if (!isset($l))$l=0;
 if (($l==0&&$weapon_force<=0)||($l==1&&$weapon_force_2<=0)||($l==2&&$weapon_force_3<=0)){
 printrus("Невозможно понизить еще!<br/>\r\n");
 }else{
  if ($l==0)$rnd=($weapon_force<=8)?($weapon_force-1)*($weapon_force-1)*10+15:(8-1)*(8-1)*10+15;
  if ($l==1)$rnd=($weapon_force_2<=8)?($weapon_force_2-1)*($weapon_force_2-1)*10+15:(8-1)*(8-1)*10+15;
  if ($l==2)$rnd=($weapon_force_3<=8)?($weapon_force_3-1)*($weapon_force_3-1)*10+15:(8-1)*(8-1)*10+15;
  if ($l==1)$rnd=round($rnd*1.9);
  if ($l==2)$rnd=round($rnd*2.7);
  $rnd=round($rnd*0.8);
  if($n=='sure'){

   $freeplace=max(0,free_place($countryID));
   if($freeplace>=$rnd){

   if ($l==0)mysql_query("UPDATE countries SET iron = iron + $rnd, weapon_force = weapon_force-1 WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==1)mysql_query("UPDATE countries SET iron = iron + $rnd, weapon_force_2 = weapon_force_2-1 WHERE countryID = '".$b['countryID']."' LIMIT 1");
   if ($l==2)mysql_query("UPDATE countries SET iron = iron + $rnd, weapon_force_3 = weapon_force_3-1 WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['iron'] = $b['iron'] + $rnd;
   if ($l==0)$b['weapon_force'] = $b['weapon_force'] - 1;
   if ($l==1)$b['weapon_force_2'] = $b['weapon_force_2'] - 1;
   if ($l==2)$b['weapon_force_3'] = $b['weapon_force_3'] - 1;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Сила атаки ".get_unit_name($l)." снижена на <b>1</b> уровень!<br/>\r\n");
   printrus
("
<a href='warhouse.php?$ses'>Ок</a>
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

  }else{
   printrus ("Вы уверены, что хотите снизить силу удара ".get_unit_name($l)."? Вы выручите: <b>$rnd</b> железа!<br/>\r\n");

   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon_forcedown&amp;l=$l&amp;n=sure\">Да</a>
<br/>
");

   printrus
("
<a href='warhouse.php?$ses'>Отмена</a>
<br/>
");
  }
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Стенобитные орудия::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('wallboom'):

  printrus ("Стенобитные орудия: [$wallboom_count]<br/>\r\n");
  $tmp = otkr_exists($countryID,"EWBA");
  if($n=="ch_kind"){
   $wallboom_kind=1-$wallboom_kind;

   $stone_to_change_wallboom=round(10*$wallboom_kind*(1-0.5*$tmp)*$wallboom_count);
   $arbor_to_change_wallboom=round((10*(1-$wallboom_kind)*(1-0.5*$tmp))*$wallboom_count);
  }elseif($n=="make"){
   $stone_tomakewallboom=round((3*$wallboom_kind*(1-0.5*$tmp))*10);
   $arbor_tomakewallboom=round((3*$wallboom_kind*(1-0.5*$tmp))*10)+$arbor_tomakewallboom;
  }

  if(empty($n)){
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom&amp;n=make\">Построить</a>
<br/>
");
   if($noob>=1){
    printrus
("[<a href=\"warhouse.php?$ses&amp;m=help&amp;n=wallboom_".$wallboom_kind."\">?</a>]
");
   }
   if($wallboom_kind==1){
    printrus ("Каменные заряды\r\n");
    printrus
("(<a href=\"warhouse.php?$ses&amp;m=wallboom&amp;n=ch_kind\">изменить</a>)
<br/>
");
   }elseif($wallboom_kind==0){
    printrus ("Огненные заряды\r\n");
    printrus
("(<a href=\"warhouse.php?$ses&amp;m=wallboom&amp;n=ch_kind\">изменить</a>)
<br/>
");
   }else{
    printrus ("Непонятные инопланетное заряды:)<br/>\r\n");
   }
   if($noob>=1)
    printrus
("[<a href=\"warhouse.php?$ses&amp;m=help&amp;n=wallboom_protection\">?</a>]
");
   printrus ("<u>защита</u> [$wallboom_protection]\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom&amp;n=up_protection\">^</a>
/
");

  printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom&amp;n=down_protection\">-</a>
<br/>
");

   printrus
("
<a href='warhouse.php?$ses'>OK</a>
<br/>
");

  }elseif($n=="ch_kind" && ($b["stone"]<$stone_to_change_wallboom || $b["arbor"]<$arbor_to_change_wallboom)){
   printrus ("Недостаточно ресурсов для перехода на другой вид оружия! (необходимо ");
   if($stone_to_change_wallboom>0){
    printrus ("<b>$stone_to_change_wallboom</b> камня)<br/>\r\n");
   }else{
    printrus ("<b>$arbor_to_change_wallboom</b> дерева)<br/>\r\n");
   }
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Ok</a>
<br/>
");
  }elseif($n=="ch_kind"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET kind = $wallboom_kind, arbor = arbor - $arbor_to_change_wallboom, stone = stone - $stone_to_change_wallboom WHERE countryID = '".$b['countryID']."'");
   $b['kind'] = $wallboom_kind;
   $b['arbor'] = $b['arbor'] - $arbor_to_change_wallboom;
   $b['stone'] = $b['stone'] - $stone_to_change_wallboom;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   if($wallboom_kind==1){
    printrus ("Теперь стенобитные орудия вооружены каменными зарядами!<br/>\r\n");
    printrus ("Затрачено <b>$stone_to_change_wallboom</b> камня.<br/>\r\n");
   }elseif($wallboom_kind==0){
    printrus ("Теперь стенобитные орудия вооружены огненными зарядами!<br/>\r\n");
    printrus ("Затрачено <b>$arbor_to_change_wallboom</b> дерева.<br/>\r\n");
   }

   printrus
("
<a href='warhouse.php?$ses'>OK</a>
<br/>
");
  }elseif($n=="make" && (empty($countto) || $countto<0)){
   printrus ("Для 1 орудия необходимо:<br/>\r\n");
   printrus ("Дерево: <b>$arbor_tomakewallboom</b><br/>\r\n");
   printrus ("Камень: <b>$stone_tomakewallboom</b><br/>\r\n");
   printrus ("Железо: <b>$iron_tomakewallboom</b><br/>\r\n");
   printrus ("Сколько орудий вы хотите построить?<br/>\r\n");
   printrus ("<form name=\"\" action=\"warhouse.php?$ses&amp;m=wallboom&amp;n=make\" method=\"post\">
<input format='*N' name='countto'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Построить\"/>
</form>
<br/>
");
  }elseif($n=="make" && ($b["stone"]<$stone_tomakewallboom*$countto || $b["arbor"]<$arbor_tomakewallboom*$countto || $b["iron"]<$iron_tomakewallboom*$countto)){
   printrus ("Нехватает материалов для постройки орудий!<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom&amp;n=make\">Ok</a>
<br/>
");
  }elseif($n=="make"){
   //устанавливаем новые значения ресурсов и вармента:)
   $arb = $arbor_tomakewallboom*$countto;
   $stn = $stone_tomakewallboom*$countto;
   $irn = $iron_tomakewallboom*$countto;
   mysql_query("UPDATE countries SET `count` = ($wallboom_count+$countto), arbor = arbor - $arb, stone = stone - $stn, iron = iron - $irn WHERE countryID = '".$b['countryID']."'");
   $b['count'] = $wallboom_count+$countto;
   $b['arbor'] = $b['arbor'] - $arb;
   $b['stone'] = $b['stone'] - $stn;
   $b['iron'] = $b['iron'] - $irn;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("$countto орудий готовы к работе!<br/>\r\n");
   printrus
("
<a href='warhouse.php?$ses'>OK</a>
<br/>
");
  }elseif($n=="up_protection" && $b["iron"]<$iron_toupwallboomprotection){
   printrus ("Нехватает материалов для поднятия уровня защиты орудий! (Необходимо: <b>$iron_toupwallboomprotection</b> железа)<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Ok</a>
<br/>
");
  }elseif($n=="up_protection"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET protection = ($wallboom_protection+1), iron = iron - $iron_toupwallboomprotection WHERE countryID = '".$b['countryID']."'");
   $b['protection'] = $wallboom_protection+1;
   $b['iron'] = $b['iron'] - $iron_toupwallboomprotection;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень защиты орудий повышен!<br/>\r\n");
   printrus ("Использовано <b>$iron_toupwallboomprotection</b> железа!<br/>\r\n");
   printrus
("
<a href='warhouse.php?$ses'>OK</a>
<br/>
");
  }elseif($n=="down_protection" && $b['protection']>1){
  //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET protection = protection-1 WHERE countryID = '".$b['countryID']."'");
   $b['protection'] = $b['protection']-1;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Уровень защиты орудий уменьшен на 1!<br/>\r\n");
          }elseif($n=="down_protection"){
                  printrus ("Невозможно понизить уровень защиты орудий еще!<br/>\r\n");
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
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=='Weapon_1'){
   printrus ("Справка: <u>Тяжелое оружие</u><br/>\r\n");
   printrus ("Этот тип оружия эффективен, когда у противника легкая броня.<br/>\r\n");
   printrus ("Вы получаете штраф, если вы атакуете противника с тяжелой броней тяжелым же оружием.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=='Bronya_0'){
   printrus ("Справка: <u>Легкая броня</u><br/>\r\n");
   printrus ("Этот тип брони эффективен для защиты от легкого оружия.<br/>\r\n");
   printrus ("Вы получаете штраф, если вас атакуют с тяжелым оружием, а у вас легкая броня.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=='Bronya_1'){
   printrus ("Справка: <u>Тяжелая броня</u><br/>\r\n");
   printrus ("Этот тип брони эффективен для защиты от тяжелого оружия.<br/>\r\n");
   printrus ("Вы получаете штраф, если вас атакуют с легким оружием, а у вас тяжелая броня.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=weapon\">Ok</a>
<br/>
");
  }elseif($n=='wallboom'){
   printrus ("Справка: <u>Стенобитные орудия</u><br/>\r\n");
   printrus ("Стенобитные орудия преднозначены для пролома стены вражеского государства.
                 Обычные воины, находящиеся на стене не могут атаковать стенобитные орудия.
          Они уязвимы только для укреплений стены. Также вместо стенобитных орудий могут использоваться пушки. 5 пушек работают с той же эффективностью, что и одно стенобитное орудие.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Ok</a>
<br/>
");
  }elseif($n=='wallboom_buildneed'){
   printrus ("Справка: <u>Стенобитные орудия</u><br/>\r\n");
   printrus ("Для постройки стенобитных орудий необходимы ратуша и научный центр.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Ok</a>
<br/>
");
  }elseif($n=='wallboom_0'){
   printrus ("Справка: <u>Огненный заряд</u><br/>\r\n");
   printrus ("Огненные заряды наиболее эффективны против деревянных стен и практически не имеют значения против каменных стен и укреплений.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Ok</a>
<br/>
");
  }elseif($n=='wallboom_1'){
   printrus ("Справка: <u>Каменный заряд</u><br/>\r\n");
   printrus ("Каменные заряды эффективны против деревянных стен и укреплений и менее эффективны против каменных стен.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Ok</a>
<br/>
");
  }elseif($n=='wallboom_protection'){
   printrus ("Справка: <u>Защита орудий</u><br/>\r\n");
   printrus ("Чем выше уровень защиты орудия, тем меньше оно уязвимо для укреплений стены.<br/>\r\n");
   printrus
("<a href=\"warhouse.php?$ses&amp;m=wallboom\">Ok</a>
<br/>
");
  }else{
   printrus ("Если у вас появилась непонятная инопланетная броня или оружие, то начните игру с начала, а лучше ничего не делайте и сообщите автору.<br/>\r\n");
  }

 break;
 endswitch;

}

//=============================================================================//Конец скрипту================================================================printrus "---<br/>\r\n";
printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");
?>
