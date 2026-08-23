<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['target'])) $target = $_REQUEST['target'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];

if (isset($_REQUEST['wariorsto'])) $wariorsto = $_REQUEST['wariorsto'];
if (isset($wariorsto)&&!is_numeric($wariorsto)) $wariorsto=0;
if (isset($wariorsto)&&$wariorsto<0) $wariorsto=0;
if (!isset($wariorsto)) $wariorsto=0;
if (isset($_REQUEST['wariorsto_2'])) $wariorsto_2 = $_REQUEST['wariorsto_2'];
if (isset($wariorsto_2)&&!is_numeric($wariorsto_2)) $wariorsto_2=0;
if (isset($wariorsto_2)&&$wariorsto_2<0) $wariorsto_2=0;
if (!isset($wariorsto_2)) $wariorsto_2=0;
if (isset($_REQUEST['wariorsto_3'])) $wariorsto_3 = $_REQUEST['wariorsto_3'];
if (isset($wariorsto_3)&&!is_numeric($wariorsto_3)) $wariorsto_3=0;
if (isset($wariorsto_3)&&$wariorsto_3<0) $wariorsto_3=0;
if (!isset($wariorsto_3)) $wariorsto_3=0;
if (isset($_REQUEST['wariorsto_4'])) $wariorsto_4 = $_REQUEST['wariorsto_4'];
if (isset($wariorsto_4)&&!is_numeric($wariorsto_4)) $wariorsto_4=0;
if (isset($wariorsto_4)&&$wariorsto_4<0) $wariorsto_4=0;
if (!isset($wariorsto_4)) $wariorsto_4=0;
if (isset($_REQUEST['wariorsto_5'])) $wariorsto_5 = $_REQUEST['wariorsto_5'];
if (isset($wariorsto_5)&&!is_numeric($wariorsto_5)) $wariorsto_5=0;
if (isset($wariorsto_5)&&$wariorsto_5<0) $wariorsto_5=0;
if (!isset($wariorsto_5)) $wariorsto_5=0;
if (isset($_REQUEST['wariorsto_6'])) $wariorsto_6 = $_REQUEST['wariorsto_6'];
if (isset($wariorsto_6)&&!is_numeric($wariorsto_6)) $wariorsto_6=0;
if (isset($wariorsto_6)&&$wariorsto_6<0) $wariorsto_6=0;
if (!isset($wariorsto_6)) $wariorsto_6=0;
if (isset($_REQUEST['wariorsto_7'])) $wariorsto_7 = $_REQUEST['wariorsto_7'];
if (isset($wariorsto_7)&&!is_numeric($wariorsto_7)) $wariorsto_7=0;
if (isset($wariorsto_7)&&$wariorsto_7<0) $wariorsto_7=0;
if (!isset($wariorsto_7)) $wariorsto_7=0;
if (isset($_REQUEST['wariorsto_8'])) $wariorsto_8 = $_REQUEST['wariorsto_8'];
if (isset($wariorsto_8)&&!is_numeric($wariorsto_8)) $wariorsto_8=0;
if (isset($wariorsto_8)&&$wariorsto_8<0) $wariorsto_8=0;
if (!isset($wariorsto_8)) $wariorsto_8=0;

if (isset($_REQUEST['bld'])) $bld = $_REQUEST['bld'];
if (isset($bld)&&$bld!='barracks'&&$bld!='citadel'&&$bld!='keeping'&&$bld!='market'&&$bld!='ratusha'&&$bld!='scientificcenter'&&$bld!='university'&&$bld!='village'&&$bld!='wall'&&$bld!='warhouse'&&$bld!='fabrika'&&$bld!='zavod'&&$bld!='magictower'&&$bld!='gorodmagov'&&$bld!='neftevxwka'&&$bld!='altar'&&$bld!='farm'&&$bld!='necropolis'&&$bld!='dungeon') exit;

//==============================================================================
//подключаем скрипты

$wariorsto=round( (int) $wariorsto);
$wariorsto_2=round( (int) $wariorsto_2);
$wariorsto_3=round( (int) $wariorsto_3);
$wariorsto_4=round( (int) $wariorsto_4);
$wariorsto_5=round( (int) $wariorsto_5);
$wariorsto_6=round( (int) $wariorsto_6);
$wariorsto_7=round( (int) $wariorsto_7);
$wariorsto_8=round( (int) $wariorsto_8);

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("other_inc/header.php");

$countryID = $_SESSION['countryID'];

 $b=CountryInfo($countryID);
 isAuthed();

//worksRefresh($b['countryID']);

//==============================================================================
//Рабочая часть скрипта=========================================================
 $noob=$_SESSION['noob'];

  $wariors_free=$b["wariors_free"];
  $wariors_free_2=$b["wariors_free_2"];
  $wariors_free_3=$b["wariors_free_3"];
  $wariors_free_4=$b["wariors_free_4"];
  $wariors_free_5=$b["wariors_free_5"];
  $wariors_free_6=$b["wariors_free_6"];
  $wariors_free_7=$b["wariors_free_7"];
  $wariors_free_8=$b["wariors_free_8"];

  $mywariors = array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8);

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Валидность идентификатора цели :::::::::::::::::::::::::::::::::::::::::::::::

 if (isset($target))$targetInfo=CountryInfo($target); //В $target - ID страны, а не имя!

 $key = _PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $tNum=0;
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetInfo["countryID"]) {
            $wariors=$mem[$i]['wariors'];
            $wariors_2=$mem[$i]['wariors_2'];
            $wariors_3=$mem[$i]['wariors_3'];
            $wariors_4=$mem[$i]['wariors_4'];
            $wariors_5=$mem[$i]['wariors_5'];
            $wariors_6=$mem[$i]['wariors_6'];
            $wariors_7=$mem[$i]['wariors_7'];
            $wariors_8=$mem[$i]['wariors_8'];
            $time1=$mem[$i]['time1'];
            $time2=$mem[$i]['time2'];
            $tNum=1;
            break;
            }
    }else{

 $query="select * from `wars` where countryID='$countryID' and targetID='".$targetInfo["countryID"]."' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $tNum=@mysql_num_rows($result);
 $wariors=@mysql_result($result,0,'wariors');
 $wariors_2=@mysql_result($result,0,'wariors_2');
 $wariors_3=@mysql_result($result,0,'wariors_3');
 $wariors_4=@mysql_result($result,0,'wariors_4');
 $wariors_5=@mysql_result($result,0,'wariors_5');
 $wariors_6=@mysql_result($result,0,'wariors_6');
 $wariors_7=@mysql_result($result,0,'wariors_7');
 $wariors_8=@mysql_result($result,0,'wariors_8');
 $time1=@mysql_result($result,0,'time1');
 $time2=@mysql_result($result,0,'time2');
 }

 if($tNum>0){
 }else{
  printrus ("Вы не воюете с гос-вом <u>".$targetInfo['countryName']."</u>!<br/>\r\n");
  print "<br/>---<br/>\r\n";
  printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//  printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");
  die("");
 }
 $atwariors=array($wariors,$wariors_2,$wariors_3,$wariors_4,$wariors_5,$wariors_6,$wariors_7,$wariors_8);

 //Если нет генерала (это может быть, если его уволили, либо если он умер от
 //старости)
 if (!general_info($countryID)){
  printrus ("У вас нет генерала для управления войсками!<br/>\r\n");
  print "<br/>---<br/>\r\n";
  printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//  printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");
  exit();
 }

 printrus ("Война: <u>".$targetInfo["countryName"]."</u><br/>\r\n");
 switch($m):


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//война:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 default:


  printrus ("Войско:<br/>".print_voisko(array($wariors,$wariors_2,$wariors_3,$wariors_4,$wariors_5,$wariors_6,$wariors_7,$wariors_8))."\r\n");
  printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved\">Разведка</a>
<br/>
");
  printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=addwariors\">Подкрепление</a>
<br/>
");
  printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=getback\">Отозвать войска</a>
<br/>
");
  if($noob>=1)
    printrus
("[<a href=\"war.php?$ses&amp;target=$target&amp;m=help&amp;n=time2\">?</a>]
");
  printrus ("С последней атаки здания прошло: ".mkTimeStr(date(U)-$time2)."<br/>\r\n");
  if($noob>=1)
    printrus
("[<a href=\"war.php?$ses&amp;target=$target&amp;m=help&amp;n=time1\">?</a>]
");
  printrus ("С начала войны прошло: ".mkTimeStr(date(U)-$time1)."<br/><br />\r\n");

  $weapon_kind=$b["weapon_kind"];
 $bronya_kind=$b["bronya_kind"];
//Считаем ДЕЙСТВИТЕЛЬНО всех военных:
  //Задействованные в войнах:
  $key=_PREFIKS.':wars'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++) $num = $num + 0.4*$mem[$i]['wariors']+$mem[$i]['wariors_2']+1.2*$mem[$i]['wariors_3']+1.5*$mem[$i]['wariors_4']+1.2*$mem[$i]['wariors_5']+1.7*$mem[$i]['wariors_6']+1.7*$mem[$i]['wariors_7']+$mem[$i]['wariors_8'];
     $all = $num;
     }else{
  $r = mysql_query("SELECT sum(0.4*wariors+wariors_2+1.2*wariors_3+1.5*wariors_4+1.2*wariors_5+1.7*wariors_6+1.7*wariors_7+wariors_8) as num FROM `wars` WHERE countryID = '$countryID' LIMIT 1");
  $a = mysql_fetch_array($r);
  $all = $a['num'];
  }
  //Свободные военные
  $all = $all + 0.4*$b['wariors_free'] + $b['wariors_free_2'] + 1.2*$b['wariors_free_3'] + 1.5*$b['wariors_free_4'] + 1.2*$b['wariors_free_5'] + 1.7*$b['wariors_free_6'] + 1.7*$b['wariors_free_7']+$b['wariors_free_8'];
  //Задействованные в охране зданий:
  $buildings = returnBuildings($countryID);
  for ($i=0;$i<count($buildings);$i++){
  $all = $all + 0.4*$buildings[$i]['guard']+$buildings[$i]['guard_2']+1.2*$buildings[$i]['guard_3']+1.5*$buildings[$i]['guard_4']+1.2*$buildings[$i]['guard_5']+1.7*$buildings[$i]['guard_6']+1.7*$buildings[$i]['guard_7']+$buildings[$i]['guard_8'];
  }

  $all = round($all);

   $weapon_kind=1-$weapon_kind;
   $iron_to_change_weapon=(1+1*$weapon_kind-(1+$weapon_kind)*otkr_exists($countryID,"MWIB"))*$all;
   $bronya_kind=1-$bronya_kind;

   $iron_to_change_bronya=(1+$bronya_kind-(1+$bronya_kind)*otkr_exists($countryID,"MWIB"))*$all;
   $weapon_kind=1-$weapon_kind;
   $bronya_kind=1-$bronya_kind;

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

  if($n=="ch_w_kind" and $b["iron"]<$iron_to_change_weapon){
   printrus ("Недостаточно железа для перехода на другой вид оружия! (необходимо <b>$iron_to_change_weapon</b> железа)<br/>\r\n");
  printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</a><br/>");
  }elseif($n=="ch_w_kind" && $ob==TRUE){
   printrus ("Нельзя изменить тип оружия/брони во время обучения солдат!<br/>\r\n");
  printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</a><br/>");
  }elseif($n=="ch_w_kind"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET weapon_kind = $weapon_kind, iron = iron - $iron_to_change_weapon WHERE countryID = '$countryID' LIMIT 1");
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
   printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</font></a><br/>");
   }elseif($iron_to_change_weapon<0){
    printrus ("При переплавке старых оружий в новые вы выручили <b>".(-$iron_to_change_weapon)."</b> железа!<br/>\r\n");
   printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</font></a><br/>");
   }

  }elseif($n=="ch_b_kind" and $b["iron"]<$iron_to_change_bronya){
   printrus ("Недостаточно железа для перехода на другой вид брони! (необходимо <b>$iron_to_change_bronya</b> железа)<br/>\r\n");
  printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</font></a><br/>");
  }elseif($n=="ch_b_kind" && $ob==TRUE){
   printrus ("Нельзя изменить тип оружия/брони во время обучения солдат!<br/>\r\n");
  printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</font></a><br/>");
  }elseif($n=="ch_b_kind"){
   //устанавливаем новые значения ресурсов и вармента:)
   mysql_query("UPDATE countries SET bronya_kind = $bronya_kind, iron = iron - $iron_to_change_bronya WHERE countryID = '$countryID' LIMIT 1");
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
    printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</font></a><br/>");
   }elseif($iron_to_change_bronya<0){
    printrus ("При переплавке старых лат в новые вы выручили <b>".(-$iron_to_change_bronya)."</b> железа!<br/>\r\n");
    printrus("<a href=\"war.php?$ses&amp;target=$target\"><font color='#EE7621'>Ок</font></a><br/>");
   }
  }

printrus ("---<br />");
$weapon_kind=$b["weapon_kind"];
$bronya_kind=$b["bronya_kind"];

 if($weapon_kind==1){
 printrus ("Тяжелое оружие ");
 printrus("<a href=\"war.php?$ses&amp;n=ch_w_kind&amp;target=$target\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_weapon</b> железа)<br/>");
 }elseif($weapon_kind==0){
 printrus ("Легкое оружие ");
 printrus("<a href=\"war.php?$ses&amp;n=ch_w_kind&amp;target=$target\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_weapon</b> железа)<br/>");
 }else{
 printrus ("Непонятное инопланетное оружие:)<br/>\r\n");
 }

 if($bronya_kind==1){
 printrus ("Тяжелая броня ");
 printrus("<a href=\"war.php?$ses&amp;n=ch_b_kind&amp;target=$target\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_bronya</b> железа)<br/>");
 }elseif($bronya_kind==0){
 printrus ("Легкая броня ");
 printrus("<a href=\"war.php?$ses&amp;n=ch_b_kind&amp;target=$target\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_bronya</b> железа)<br/>");
 }else{printrus ("Непонятная инопланетная броня:)<br/>\r\n");}

$neighbourInfo = CountryInfo($target);

$spy_lvl=min(100,$b["spy"]+$plus_altar);
printrus ("---<br /><div class=\"r2\">Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");

   $w_kind=round($neighbourInfo["weapon_kind"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Оружие: \r\n");
   if($w_kind==1){
    printrus ("<font color='#FF4040'>тяжелое</font><br/>\r\n");
   }else{
    printrus ("<font color='#FF4040'>легкое</font><br/>\r\n");
   }

   $b_kind=round($neighbourInfo["bronya_kind"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("Броня : \r\n");
   if($b_kind==1){
    printrus ("<font color='#FF4040'>тяжелая</font><br/>\r\n");
   }else{
    printrus ("<font color='#FF4040'>легкая</font><br/>\r\n");
   }

   $free=round($neighbourInfo["wariors_free"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_2=round($neighbourInfo["wariors_free_2"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_3=round($neighbourInfo["wariors_free_3"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_4=round($neighbourInfo["wariors_free_4"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_5=round($neighbourInfo["wariors_free_5"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_6=round($neighbourInfo["wariors_free_6"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $free_7=round($neighbourInfo["wariors_free_7"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("<br /><font color='#FF4040'>Воинов</font>");
   printrus (" <font color='#FF4040'>свободно:</font><br/>".print_voisko(array($free,$free_2,$free_3,$free_4,$free_5,$free_6,$free_7,$free_8)));




   $wb_kind=round($neighbourInfo["kind"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $wb_count=round($neighbourInfo["count"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $wb_protection=round($neighbourInfo["protection"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("</div>");




 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Подкрепление::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('addwariors'):

  if($wariors_free<=0 && $wariors_free_2<=0 && $wariors_free_3<=0 && $wariors_free_4<=0 && $wariors_free_5<=0 && $wariors_free_6<=0 && $wariors_free_7<=0 && $wariors_free_8<=0){
   printrus ("У вас нет свободных воинов!<br/>\r\n");
  }elseif( ($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8)<=0){
   printrus ("Сколько воинов вы хотите отправить в подкрепление?<br/>\r\n");
                   printrus("<form name=\"\" action=\"war.php?$ses&amp;target=$target&amp;m=addwariors\" method=\"post\">");
for ($i=0;$i<count($mywariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($mywariors[$i]>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего:<b>".$mywariors[$i]."</b>)<br/>\r\n");
}

printrus("<input type=\"submit\" value=\"Отправить\"/>");
printrus ("</form><br/>");

printrus
("<a href=\"citadel.php?$ses&amp;target=$target&amp;m=neighbours&amp;n=wariors&amp;neighbour=$neighbour\">Войско</a>
<br/>
");

  }



  elseif($wariorsto>$wariors_free || $wariorsto_2>$wariors_free_2 || $wariorsto_3>$wariors_free_3 || $wariorsto_4>$wariors_free_4 || $wariorsto_5>$wariors_free_5 || $wariorsto_6>$wariors_free_6 || $wariorsto_7>$wariors_free_7 || $wariorsto_8>$wariors_free_8){
   printrus ("У вас нет столько свободных воинов! Всего:<br/>".print_voisko($mywariors)."\r\n");
                 printrus("<form name=\"\" action=\"war.php?$ses&amp;target=$target&amp;m=addwariors\" method=\"post\">");
for ($i=0;$i<count($mywariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($mywariors[$i]>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего:<b>".$mywariors[$i]."</b>)<br/>\r\n");
}
printrus("<input type=\"submit\" value=\"Отправить\"/>");
printrus ("</form><br/>");
   printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=addwariors&amp;wariorsto=$wariors_free&amp;wariorsto_2=$wariors_free_2&amp;wariorsto_3=$wariors_free_3&amp;wariorsto_4=$wariors_free_4&amp;wariorsto_5=$wariors_free_5&amp;wariorsto_6=$wariors_free_6&amp;wariorsto_7=$wariors_free_7&amp;wariorsto_8=$wariors_free_8\">Отправить всех!</a>
<br/>
");


  }else{

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

   mysql_query("UPDATE `wars` SET wariors = ($wariors + $wariorsto),
   wariors_2 = ($wariors_2 + $wariorsto_2), wariors_3 = ($wariors_3 + $wariorsto_3),
   wariors_4 = ($wariors_4 + $wariorsto_4), wariors_5 = ($wariors_5 + $wariorsto_5),
   wariors_6 = ($wariors_6 + $wariorsto_6), wariors_7 = ($wariors_7 + $wariorsto_7),
   wariors_8 = ($wariors_8 + $wariorsto_8)
   WHERE countryID='".$countryID."' and targetID='".$targetInfo['countryID']."' LIMIT 1");

   $key=_PREFIKS.':wars'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetInfo['countryID']){
          $mem[$i]['wariors'] = $mem[$i]['wariors'] + $wariorsto;
          $mem[$i]['wariors_2'] = $mem[$i]['wariors_2'] + $wariorsto_2;
          $mem[$i]['wariors_3'] = $mem[$i]['wariors_3'] + $wariorsto_3;
          $mem[$i]['wariors_4'] = $mem[$i]['wariors_4'] + $wariorsto_4;
          $mem[$i]['wariors_5'] = $mem[$i]['wariors_5'] + $wariorsto_5;
          $mem[$i]['wariors_6'] = $mem[$i]['wariors_6'] + $wariorsto_6;
          $mem[$i]['wariors_7'] = $mem[$i]['wariors_7'] + $wariorsto_7;
          $mem[$i]['wariors_8'] = $mem[$i]['wariors_8'] + $wariorsto_8;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Подкрепление успешно отправлено!<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target\">Ok</a>
<br/>
");

  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//отступаем:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('getback'):
  if ($n=='sure'&&($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8)>0&&$wariorsto<=$wariors&&$wariorsto_2<=$wariors_2&&$wariorsto_3<=$wariors_3&&$wariorsto_4<=$wariors_4&&$wariorsto_5<=$wariors_5&&$wariorsto_6<=$wariors_6&&$wariorsto_7<=$wariors_7&&$wariorsto_8<=$wariors_8){

   if ($wariorsto==$wariors&&$wariorsto_2==$wariors_2&&$wariorsto_3==$wariors_3&&$wariorsto_4==$wariors_4&&$wariorsto_5==$wariors_5&&$wariorsto_6==$wariors_6&&$wariorsto_7==$wariors_7&&$wariorsto_8==$wariors_8){
   $query="delete from `wars` where countryID='".$countryID."' and targetID='".$targetInfo['countryID']."' limit 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':wars'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']!=$targetInfo['countryID']) array_push($neww,$mem[$i]);
      $memcache->set($key,$neww,false,86400);
      }

   }else{
   $query="UPDATE `wars` SET wariors=wariors - $wariorsto, wariors_2 = wariors_2 - $wariorsto_2,
   wariors_3 = wariors_3 - $wariorsto_3, wariors_4 = wariors_4 - $wariorsto_4,
   wariors_5 = wariors_5 - $wariorsto_5, wariors_6 = wariors_6 - $wariorsto_6,
   wariors_7 = wariors_7 - $wariorsto_7, wariors_8 = wariors_8 - $wariorsto_8
   WHERE countryID='".$countryID."' and targetID='".$targetInfo['countryID']."' limit 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':wars'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetInfo['countryID']){
          $mem[$i]['wariors'] = $mem[$i]['wariors'] - $wariorsto;
          $mem[$i]['wariors_2'] = $mem[$i]['wariors_2'] - $wariorsto_2;
          $mem[$i]['wariors_3'] = $mem[$i]['wariors_3'] - $wariorsto_3;
          $mem[$i]['wariors_4'] = $mem[$i]['wariors_4'] - $wariorsto_4;
          $mem[$i]['wariors_5'] = $mem[$i]['wariors_5'] - $wariorsto_5;
          $mem[$i]['wariors_6'] = $mem[$i]['wariors_6'] - $wariorsto_6;
          $mem[$i]['wariors_7'] = $mem[$i]['wariors_7'] - $wariorsto_7;
          $mem[$i]['wariors_8'] = $mem[$i]['wariors_8'] - $wariorsto_8;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   }

   mysql_query("UPDATE countries SET wariors_free = wariors_free + $wariorsto,
   wariors_free_2 = wariors_free_2 + $wariorsto_2, wariors_free_3 = wariors_free_3 + $wariorsto_3,
   wariors_free_4 = wariors_free_4 + $wariorsto_4, wariors_free_5 = wariors_free_5 + $wariorsto_5,
   wariors_free_6 = wariors_free_6 + $wariorsto_6, wariors_free_7 = wariors_free_7 + $wariorsto_7,
   wariors_free_8 = wariors_free_8 + $wariorsto_8
   WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['wariors_free'] = $b['wariors_free'] + $wariorsto;
   $b['wariors_free_2'] = $b['wariors_free_2'] + $wariorsto_2;
   $b['wariors_free_3'] = $b['wariors_free_3'] + $wariorsto_3;
   $b['wariors_free_4'] = $b['wariors_free_4'] + $wariorsto_4;
   $b['wariors_free_5'] = $b['wariors_free_5'] + $wariorsto_5;
   $b['wariors_free_6'] = $b['wariors_free_6'] + $wariorsto_6;
   $b['wariors_free_7'] = $b['wariors_free_7'] + $wariorsto_7;
   $b['wariors_free_8'] = $b['wariors_free_8'] + $wariorsto_8;

   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   if ($wariorsto==$wariors&&$wariorsto_2==$wariors_2&&$wariorsto_3==$wariors_3&&$wariorsto_4==$wariors_4&&$wariorsto_5==$wariors_5&&$wariorsto_6==$wariors_6&&$wariorsto_7==$wariors_7&&$wariorsto_8==$wariors_8)sendMessage($targetInfo['countryID'],"fullMessage","Войско гос-ва <u>".$b['countryName']."</u> покинуло территорию вашего гос-ва!");
   else sendMessage($targetInfo['countryID'],"fullMessage",print_voisko(array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8))." гос-ва <u>".$b['countryName']."</u> покинуло территорию вашего гос-ва!");

   if ($wariorsto==$wariors&&$wariorsto_2==$wariors_2&&$wariorsto_3==$wariors_3&&$wariorsto_4==$wariors_4&&$wariorsto_5==$wariors_5&&$wariorsto_6==$wariors_6&&$wariorsto_7==$wariors_7&&$wariorsto_8==$wariors_8)printrus ("Ваши войска покинули территорию гос-ва <u>".$targetInfo['countryName']."</u>!<br/>\r\n");
   else printrus (print_voisko(array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8))." покинули территорию гос-ва <u>".$targetInfo['countryName']."</u>!<br/>\r\n");
   printrus
("
<a href='game.php?$ses'>Ок</a>
<br/>
");
  }elseif(($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8)<=0){
  printrus("Сколько солдат вы желаете отозвать?<br/>\n");
                    printrus("<form name=\"\" action=\"war.php?$ses&amp;target=$target&amp;m=getback\" method=\"post\">");
for ($i=0;$i<count($atwariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($atwariors[$i]>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего:<b>".$atwariors[$i]."</b>)<br/>\r\n");
}

printrus("<input type=\"submit\" value=\"Отозвать\"/>");
printrus ("</form><br/>");

}elseif($wariorsto>$wariors || $wariorsto_2>$wariors_2 || $wariorsto_3>$wariors_3 || $wariorsto_4>$wariors_4 || $wariorsto_5>$wariors_5 || $wariorsto_6>$wariors_6 || $wariorsto_7>$wariors_7 || $wariorsto_8>$wariors_8){
printrus("У вас только:<br/>".print_voisko($atwariors)."\n");
printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=getback&amp;wariorsto_2=$wariors_2&amp;wariorsto_3=$wariors_3&amp;wariorsto_4=$wariors_4&amp;wariorsto_5=$wariors_5&amp;wariorsto_6=$wariors_6&amp;wariorsto_7=$wariors_7&amp;wariorsto_8=$wariors_8\">Отозвать всех</a>
<br/>
");
printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=getback\">Отмена</a>
<br/>
");
          }else{
   printrus ("Вы уверены, что хотите отозвать:<br/>".print_voisko(array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8))." с территории гос-ва <u>".$targetInfo['countryName']."</u>?<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;n=sure&amp;target=$target&amp;m=getback&amp;wariorsto=$wariorsto&amp;wariorsto_2=$wariorsto_2&amp;wariorsto_3=$wariorsto_3&amp;wariorsto_4=$wariorsto_4&amp;wariorsto_5=$wariorsto_5&amp;wariorsto_6=$wariorsto_6&amp;wariorsto_7=$wariorsto_7&amp;wariorsto_8=$wariorsto_8\">Да</a>
");
   printrus
("<a href=\"war.php?$ses&amp;target=$target\">Нет</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//разведочка::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('razved'):
  $spy_lvl=$b["spy"];
  if($n!='attack' && $n!='sabotage')
   printrus ("Точность шпионажа: <b>$spy_lvl %</b><br/>\r\n");

  if(empty($n)){
   $result=returnBuildings($targetInfo['countryID']);
   $buildings=count($result);

   if($buildings>0){
    for ($i=0;$i<count($result);$i++){

     $building=$result[$i]["building"];

     $key=_PREFIKS.':works'.$targetInfo['countryID'];
     if (($mem=$memcache->get($key))!==FALSE){
     $repCount=0;
     for ($j=0;$j<count($mem);$j++) if ($mem[$j]['kind']=='repairing'&&$mem[$j]['what']==$building) {$repCount=1;break;}
        }else{
     $query="select count(*) as num from works where countryID='".$targetInfo['countryID']."' and kind='repairing' and what='$building'";
     $result_=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
     $b = mysql_fetch_array($result_);
     $repCount=$b['num'];
     }


     if($repCount<=0||$buildings<=1){
      $guard=$result[$i]["guard"];
      $guard=round($guard*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      $guard_2=$result[$i]["guard_2"];
      $guard_2=round($guard_2*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      $guard_3=$result[$i]["guard_3"];
      $guard_3=round($guard_3*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      $guard_4=$result[$i]["guard_4"];
      $guard_4=round($guard_4*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      $guard_5=$result[$i]["guard_5"];
      $guard_5=round($guard_5*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      $guard_6=$result[$i]["guard_6"];
      $guard_6=round($guard_6*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      $guard_7=$result[$i]["guard_7"];
      $guard_7=round($guard_7*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      $guard_8=$result[$i]["guard_8"];
      $guard_8=round($guard_8*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
      printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved&amp;n=bld&amp;bld=$building\">".printBuilding($building)."</a>
[".($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
     }else{
      printrus ("{<u>".printBuilding($building)."</u>}");
     }
    }

   printrus
("------<br />
<a href=\"war.php?$ses&amp;target=$target&amp;m=takecountry\">Захватить страну</a>
<br/>
");
   }else{
    printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=takecountry\">Захватить страну</a>
<br/>
");
   }
  }elseif(!building_exists($targetInfo['countryID'],$bld) && ($n=='bld' or $n=='attack' or $n=='sabotage')){
   printrus ("У гос-ва <u>".$targetInfo['countryName']."</u> нет такого здания!<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved\">Ok</a>
<br/>
");
  }elseif($n=='bld'){

   $key=_PREFIKS.':buildings'.$targetInfo['countryID'];
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
          $var1=$mem[$i]['var1'];
          $var2=$mem[$i]['var2'];
          $guard=$mem[$i]['guard'];
          $guard_2=$mem[$i]['guard_2'];
          $guard_3=$mem[$i]['guard_3'];
          $guard_4=$mem[$i]['guard_4'];
          $guard_5=$mem[$i]['guard_5'];
          $guard_6=$mem[$i]['guard_6'];
          $guard_7=$mem[$i]['guard_7'];
          $guard_8=$mem[$i]['guard_8'];
          break;
          }
      }else{
   $query="select * from `buildings` where countryID='".$targetInfo['countryID']."' and building='$bld' limit 1";
   $result=@MYSQL_QUERY($query);
   $var1=@mysql_result($result,0,"var1");
   $var2=@mysql_result($result,0,"var2");
   $guard=@mysql_result($result,0,"guard");
   $guard_2=@mysql_result($result,0,"guard_2");
   $guard_3=@mysql_result($result,0,"guard_3");
   $guard_4=@mysql_result($result,0,"guard_4");
   $guard_5=@mysql_result($result,0,"guard_5");
   $guard_6=@mysql_result($result,0,"guard_6");
   $guard_7=@mysql_result($result,0,"guard_7");
   $guard_8=@mysql_result($result,0,"guard_8");
   }

   $var1=round($var1*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus (printBuilding($bld)."\r\n");
   if($bld=='wall' && $var1==0){
    printrus ("(дерево)\r\n");
   }elseif($bld=='wall' && $var1==1){
    printrus ("(камень)\r\n");
   }
   print "<br/>\r\n";
   $guard=round($guard*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $guard_2=round($guard_2*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $guard_3=round($guard_3*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $guard_4=round($guard_4*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $guard_5=round($guard_5*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $guard_6=round($guard_6*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $guard_7=round($guard_7*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $guard_8=round($guard_8*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));

   printrus ("Охрана:<br/>".print_voisko(array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8))."\r\n");

   if($bld=='wall'){
    $var2=round($var2*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Укрепление: <b>$var2</b><br/>\r\n");
   }elseif($blg=='scientificcenter'){
    $var2=round($var2*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
    printrus ("Уровень: <b>$var2</b><br/>\r\n");
   }
   if(building_exists($targetInfo['countryID'],"ratusha") || building_exists($targetInfo['countryID'],"citadel"))
    printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved&amp;n=sabotage&amp;bld=$bld\">Саботаж</a>
<br/>
");
   printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved&amp;n=attack&amp;bld=$bld\">Атаковать</a>
<br/>
");
  }elseif(($n=='attack' or $n=='sabotage') && date(U)<($time2+2400)){
   printrus ("Вы не можете пока атаковать это здание! Здания можно атаковать с 40-минутным перерывом.<br/>\r\n");
   printrus ("Подождите ".mkTimeStr($time2+2400-date(U))."<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved\">Отмена</a>
<br/>
");
  }elseif(($n=='attack' or $n=='sabotage') && date(U)<($time1+3600*3)){
   printrus ("Вы можете атаковать здания только по прошествии 3 часов нахождения на территории государства!<br/>\r\n");
   printrus ("Подождите ".mkTimeStr($time1+3600*3-date(U))."<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved\">Отмена</a>
<br/>
");
  }elseif($n=='attack'){
   if(($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8)<=0){
  printrus ("Сколько воинов вы хотите отправить в атаку?<br/>\r\n");
            printrus("<form name=\"\" action=\"war.php?$ses&amp;target=$target&amp;m=razved&amp;n=attack&amp;bld=$bld\" method=\"post\">");
for ($i=0;$i<count($atwariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($atwariors[$i]>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего:<b>".$atwariors[$i]."</b>)<br/>\r\n");
}

printrus("<input type=\"submit\" value=\"Отправить\"/>");
printrus ("</form><br/>");

   }elseif($wariorsto>$wariors||$wariorsto_2>$wariors_2||$wariorsto_3>$wariors_3||$wariorsto_4>$wariors_4||$wariorsto_5>$wariors_5||$wariorsto_6>$wariors_6||$wariorsto_7>$wariors_7||$wariorsto_8>$wariors_8){
    printrus ("У вас нет столько воинов! Всего: ".print_voisko(array($wariors,$wariors_2,$wariors_3,$wariors_4,$wariors_5,$wariors_6,$wariors_7,$wariors_8))."\r\n");
    printrus ("Сколько воинов вы отправите в атаку?<br/>\r\n");
                        printrus("<form name=\"\" action=\"war.php?$ses&amp;target=$target&amp;m=razved&amp;n=attack&amp;bld=$bld\" method=\"post\">");
for ($i=0;$i<count($atwariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($atwariors[$i]>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего:<b>".$atwariors[$i]."</b>)<br/>\r\n");
}

printrus("<input type=\"submit\" value=\"Отправить\"/>");
printrus ("</form><br/>");

  printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved&amp;n=attack&amp;bld=$bld&amp;wariorsto=$wariors&amp;wariorsto_2=$wariors_2&amp;wariorsto_3=$wariors_3&amp;wariorsto_4=$wariors_4&amp;wariorsto_5=$wariors_5&amp;wariorsto_6=$wariors_6&amp;wariorsto_7=$wariors_7&amp;wariorsto_8=$wariors_8\">Отправить всех!</a>
<br/>
");
   }else{

    mysql_query("UPDATE `wars` SET wariors = wariors - $wariorsto, wariors_2 = wariors_2 - $wariorsto_2,
    wariors_3 = wariors_3 - $wariorsto_3, wariors_4 = wariors_4 - $wariorsto_4,
    wariors_5 = wariors_5 - $wariorsto_5, wariors_6 = wariors_6 - $wariorsto_6,
    wariors_7 = wariors_7 - $wariorsto_7, wariors_8 = wariors_8 - $wariorsto_8
    WHERE countryID = '".$countryID."' and targetID = '".$targetInfo['countryID']."' LIMIT 1");
    $key=_PREFIKS.':wars'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetInfo['countryID']){
          $mem[$i]['wariors'] = $mem[$i]['wariors'] - $wariorsto;
          $mem[$i]['wariors_2'] = $mem[$i]['wariors_2'] - $wariorsto_2;
          $mem[$i]['wariors_3'] = $mem[$i]['wariors_3'] - $wariorsto_3;
          $mem[$i]['wariors_4'] = $mem[$i]['wariors_4'] - $wariorsto_4;
          $mem[$i]['wariors_5'] = $mem[$i]['wariors_5'] - $wariorsto_5;
          $mem[$i]['wariors_6'] = $mem[$i]['wariors_6'] - $wariorsto_6;
          $mem[$i]['wariors_7'] = $mem[$i]['wariors_7'] - $wariorsto_7;
          $mem[$i]['wariors_8'] = $mem[$i]['wariors_8'] - $wariorsto_8;
          break;
          }
      $memcache->set($key,$mem,false,86400);
       }

   $att_wariors = array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8);
   battle_bld($countryID,$targetInfo['countryID'],$att_wariors,$bld,true);


    printrus
("<a href=\"war.php?$ses&amp;target=$target\">Ok</a>
<br/>
");

   }
  }elseif($n=='sabotage' && (building_exists($targetInfo['countryID'],"ratusha") || building_exists($targetInfo['countryID'],"citadel"))){
   printrus ("Саботаж: <u>".printBuilding($bld)."</u><br/>\r\n");
   sabotage_bld($countryID,$targetInfo['countryID'],$bld,true);
   //Пишем в лог о битве:
 $open=fopen("logs/war".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("[d-m-Y H:i] ").$b['countryName']."(ID=".$countryID.") саботир. ".$targetInfo['countryName'].", здание $bld\n\r");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //Пишем в лог о битве жертве:
 $open=fopen("logs/war".$targetInfo['countryID'],"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName']."(ID=".$countryID.") саботир. ваше здание $bld\n\r");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//захватываем страну :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('takecountry'):
  $result=returnBuildings($targetInfo['countryID']);
  $buildings=count($result);

  if(date(U)<($time1+43200)){  //if(date(U)<($time1+10)){
   printrus ("Вы не можете пока захватить эту страну!<br/>\r\n");
   printrus ("Вы должны продержаться на этой территории еще не менее ".mkTimeStr($time1+43200-date(U))."<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved\">Отмена</a>
<br/>
");
  }elseif($buildings>20){
   printrus ("Вы не можете захватить эту страну, тк не все здания еще разрушены!<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target&amp;m=razved\">Отмена</a>
<br/>
");
  }else{
   takecountry($countryID,$targetInfo['countryID'],array($wariors,$wariors_2,$wariors_3,$wariors_4,$wariors_5,$wariors_6,$wariors_7,$wariors_8));
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//В помощь нубам!!!:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('help'):

  if(empty($n)){

  }elseif($n=='time1'){
   printrus ("Справка: <u>Захват страны</u><br/>\r\n");
   printrus ("Чтобы захватить страну необходимо уничтожить все здания в этой стране и продержаться на ее территории не менее <b>12</b> часов с начала войны. Здания можно разрушать через 3 часа после вторжения войск в страну<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target\">Ok</a>
<br/>
");
  }elseif($n=='time2'){
   printrus ("Справка: <u>Атака здания</u><br/>\r\n");
   printrus ("Для атаки любого здания необходимо продержаться на территории этого гос-ва хотя бы 3 часа после начала войны.<br/>\r\n");
   printrus
("<a href=\"war.php?$ses&amp;target=$target\">Ok</a>
<br/>
");
  }
 break;
 endswitch;

//==============================================================================
//Конец скрипту=================================================================
print "---<br/>\r\n";
printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
?>