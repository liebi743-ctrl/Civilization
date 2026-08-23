<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
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
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['attacker'])) $attacker = $_REQUEST['attacker'];

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

//==============================================================================
//Рабочая часть скрипта=========================================================

 $b=CountryInfo($countryID);
 isAuthed();

 $wariors_free=$b["wariors_free"];
 $wariors_free_2=$b["wariors_free_2"];
 $wariors_free_3=$b["wariors_free_3"];
 $wariors_free_4=$b["wariors_free_4"];
 $wariors_free_5=$b["wariors_free_5"];
 $wariors_free_6=$b["wariors_free_6"];
 $wariors_free_7=$b["wariors_free_7"];
 $wariors_free_8=$b["wariors_free_8"];
 $mywariors = array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8);

 $countryID = $b['countryID'];


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Валидность идентификатора цели :::::::::::::::::::::::::::::::::::::::::::::::
 $attackerInfo=CountryInfo($attacker); //В $attacker - ID страны!

 $key=_PREFIKS.':wars'.$attackerInfo['countryID'];
 if (($mem=$memcache->get($key))!==FALSE){
    $tNum=0;
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$countryID){
            $a=$mem[$i];
            $tNum=1;
            break;
        }
    }else{
 $query="select * from `wars` where targetID='".$b["countryID"]."' and countryID='".$attackerInfo["countryID"]."' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $tNum=mysql_num_rows($result);
 }
 if($tNum<=0){
  printrus ("Вы не воюете с гос-вом <u>".$attackerInfo["countryName"]."</u>!<br/>\r\n");
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
 $wariors=$a['wariors'];
 $wariors_2=$a['wariors_2'];
 $wariors_3=$a['wariors_3'];
 $wariors_4=$a['wariors_4'];
 $wariors_5=$a['wariors_5'];
 $wariors_6=$a['wariors_6'];
 $wariors_7=$a['wariors_7'];
 $wariors_8=$a['wariors_8'];

 $time1=$a['time1'];
 $time3=$a['time3'];
 printrus ("Вторжение: <u>".$attackerInfo['countryName']."</u><br/>\r\n");
 printrus ("Находится на вашей территории: ".mkTimeStr(time()-$time1)."<br/>\r\n");
 printrus ("Последний раз было атаковано: ".mkTimeStr(time()-$time3)." назад<br/>\n");

 switch($m):
 default:
  printrus ("Войско:<br/>".print_voisko(array($wariors,$wariors_2,$wariors_3,$wariors_4,$wariors_5,$wariors_6,$wariors_7,$wariors_8))."\r\n");
  if($general=general_info($b['countryID']))
   printrus
("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\">Атаковать</a>
<br/>
");

   printrus
("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=verb\">Завербовать</a>
<br/><br/>
");




 break;
 case('attack'):
  if(!$general=general_info($b['countryID'])){
   printrus ("Вы не можете воевать без генерала!<br/>\r\n");
  }elseif($time3+1800>time()){
   printrus ("Вы можете атаковать противника только через полчаса после последней атаки (неважно, атаковал ли его ваш союзник или вы)!<br/>\r\n");
  }elseif($time1+3600>time()){
   printrus ("Вы можете атаковать противника только через час после вторжения!<br/>\r\n");
  }elseif(($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8)<10){
   printrus ("Сколько воинов вы хотите отправить в атаку? (минимум - 10 в сумме)<br/>\r\n");


                  printrus("<form name=\"\" action=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\" method=\"post\">");
for ($i=0;$i<count($mywariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($mywariors[$i]>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего:<b>".$mywariors[$i]."</b>)<br/>\r\n");
}

printrus("<input type=\"submit\" value=\"Отправить\"/>");
printrus ("</form><br/>");

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
  printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
  }elseif($n=="ch_w_kind" && $ob==TRUE){
   printrus ("Нельзя изменить тип оружия/брони во время обучения солдат!<br/>\r\n");
   printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
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
    printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
   }elseif($iron_to_change_weapon<0){
    printrus ("При переплавке старых оружий в новые вы выручили <b>".(-$iron_to_change_weapon)."</b> железа!<br/>\r\n");
    printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
   }

  }elseif($n=="ch_b_kind" and $b["iron"]<$iron_to_change_bronya){
   printrus ("Недостаточно железа для перехода на другой вид брони! (необходимо <b>$iron_to_change_bronya</b> железа)<br/>\r\n");
  printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
  }elseif($n=="ch_b_kind" && $ob==TRUE){
   printrus ("Нельзя изменить тип оружия/брони во время обучения солдат!<br/>\r\n");
  printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
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
    printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
   }elseif($iron_to_change_bronya<0){
    printrus ("При переплавке старых лат в новые вы выручили <b>".(-$iron_to_change_bronya)."</b> железа!<br/>\r\n");
    printrus("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\"><font color='#EE7621'>Ок</font></a><br/>");
   }
  }

printrus ("---<br />");
$weapon_kind=$b["weapon_kind"];
$bronya_kind=$b["bronya_kind"];

 if($weapon_kind==1){
 printrus ("Тяжелое оружие ");
 printrus("<a href=\"attacks.php?$ses&amp;m=attack&amp;n=ch_w_kind&amp;attacker=$attacker\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_weapon</b> железа)<br/>");
 }elseif($weapon_kind==0){
 printrus ("Легкое оружие ");
 printrus("<a href=\"attacks.php?$ses&amp;m=attack&amp;n=ch_w_kind&amp;attacker=$attacker\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_weapon</b> железа)<br/>");
 }else{
 printrus ("Непонятное инопланетное оружие:)<br/>\r\n");
 }

 if($bronya_kind==1){
 printrus ("Тяжелая броня ");
 printrus("<a href=\"attacks.php?$ses&amp;m=attack&amp;n=ch_b_kind&amp;attacker=$attacker\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_bronya</b> железа)<br/>");
 }elseif($bronya_kind==0){
 printrus ("Легкая броня ");
 printrus("<a href=\"attacks.php?$ses&amp;m=attack&amp;n=ch_b_kind&amp;attacker=$attacker\"><font color='#EE7621'>изменить</font></a> <br />(<b>$iron_to_change_bronya</b> железа)<br/>");
 }else{printrus ("Непонятная инопланетная броня:)<br/>\r\n");}

$neighbourInfo = CountryInfo($attacker);
printrus("<br /><a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\">Обновить</a>
<br/>
");
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
   printrus ("<font color='#FF4040'><br />Воинов</font>");
   printrus (" <font color='#FF4040'>свободно:</font><br/>".print_voisko(array($free,$free_2,$free_3,$free_4,$free_5,$free_6,$free_7,$free_8)));




   $wb_kind=round($neighbourInfo["kind"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $wb_count=round($neighbourInfo["count"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   $wb_protection=round($neighbourInfo["protection"]*(1+(rand(0,100-$spy_lvl)-(100-$spy_lvl)/2)/100));
   printrus ("</div>");



  }elseif($wariorsto>$wariors_free || $wariorsto_2>$wariors_free_2 || $wariorsto_3>$wariors_free_3|| $wariorsto_4>$wariors_free_4|| $wariorsto_5>$wariors_free_5|| $wariorsto_6>$wariors_free_6|| $wariorsto_7>$wariors_free_7|| $wariorsto_8>$wariors_free_8){
   printrus ("У вас нет столько воинов! Всего:<br/>".print_voisko($mywariors)."\r\n");
   printrus ("Сколько воинов вы отправите в атаку? (минимум - 10 в сумме)<br/>\r\n");
    printrus("<form name=\"\" action=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack\" method=\"post\">");
for ($i=0;$i<count($mywariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($mywariors[$i]>0)printrus (get_unit_name($i).":<br/></small><input format='*N' name='$s' /><small>(всего:<b>".$mywariors[$i]."</b>)<br/>\r\n");
}

printrus("<input type=\"submit\" value=\"Отправить\"/>");
printrus ("</form><br/>");
   printrus
("<a href=\"attacks.php?$ses&amp;attacker=$attacker&amp;m=attack&amp;wariorsto=$wariors_free&amp;wariorsto_2=$wariors_free_2&amp;wariorsto_3=$wariors_free_3&amp;wariorsto_4=$wariors_free_4&amp;wariorsto_5=$wariors_free_5&amp;wariorsto_6=$wariors_free_6&amp;wariorsto_7=$wariors_free_7&amp;wariorsto_8=$wariors_free_8\">Отправить всех!</a>
<br/>
");
  }else{

   mysql_query("UPDATE countries SET wariors_free = wariors_free - $wariorsto,
   wariors_free_2 = wariors_free_2 - $wariorsto_2, wariors_free_3 = wariors_free_3 - $wariorsto_3,
   wariors_free_4 = wariors_free_4 - $wariorsto_4, wariors_free_5 = wariors_free_5 - $wariorsto_5,
   wariors_free_6 = wariors_free_6 - $wariorsto_6, wariors_free_7 = wariors_free_7 - $wariorsto_7,
   wariors_free_8 = wariors_free_8 - $wariorsto_8
   WHERE countryID='".$b['countryID']."' LIMIT 1");
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

   battle_people($b['countryID'],$attackerInfo['countryID'],array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8));

   printrus
("
<a href='game.php?$ses'>Ок</a>
<br/>
");

  }
 break;

 case('verb'):

 if(time()<($b['vrbTime']+5400)){
  printrus ("Ваши вербовщики еще не готовы для новой работы! Подождите ".mkTimeStr($b['vrbTime']+5400-time())."<br/>\r\n");
 }else{
 $tm = time();
 $b['vrbTime'] = $tm;
 mysql_query("UPDATE countries SET vrbTime = $tm WHERE countryID = '$countryID'");
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }
 $kk=max(0,$b['verb']-$attackerInfo['spy']);
 $wariors_end = round($wariors*(100-$kk)/100);
 $wariors_end_2 = round($wariors_2*(100-$kk)/100);
 $wariors_end_3 = round($wariors_3*(100-$kk)/100);
 $wariors_end_4 = round($wariors_4*(100-$kk)/100);
 $wariors_end_5 = round($wariors_5*(100-$kk)/100);
 $wariors_end_6 = round($wariors_6*(100-$kk)/100);
 $wariors_end_7 = round($wariors_7*(100-$kk)/100);
 $wariors_end_8 = round($wariors_8*(100-$kk)/100);

 $plus = round($wariors*$kk/100);
 $plus_2 = round($wariors_2*$kk/100);
 $plus_3 = round($wariors_3*$kk/100);
 $plus_4 = round($wariors_4*$kk/100);
 $plus_5 = round($wariors_5*$kk/100);
 $plus_6 = round($wariors_6*$kk/100);
 $plus_7 = round($wariors_7*$kk/100);
 $plus_8 = round($wariors_8*$kk/100);
 mysql_query("UPDATE `wars` SET wariors = $wariors_end, wariors_2 = $wariors_end_2,
 wariors_3 = $wariors_end_3, wariors_4 = $wariors_end_4, wariors_5 = $wariors_end_5,
 wariors_6 = $wariors_end_6, wariors_7 = $wariors_end_7, wariors_8 = $wariors_end_8
 WHERE countryID = '$attacker' and targetID = '$countryID' LIMIT 1");
 $key=_PREFIKS.':wars'.$attackerInfo['countryID'];
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$countryID){
            $mem[$i]['wariors'] = $wariors_end;
            $mem[$i]['wariors_2'] = $wariors_end_2;
            $mem[$i]['wariors_3'] = $wariors_end_3;
            $mem[$i]['wariors_4'] = $wariors_end_4;
            $mem[$i]['wariors_5'] = $wariors_end_5;
            $mem[$i]['wariors_6'] = $wariors_end_6;
            $mem[$i]['wariors_7'] = $wariors_end_7;
            $mem[$i]['wariors_8'] = $wariors_end_8;
            break;
        }
    $memcache->set($key,$mem,false,86400);
    }

 mysql_query("UPDATE `countries` SET wariors_free = wariors_free + $plus, wariors_free_2 = wariors_free_2 + $plus_2,
 wariors_free_3 = wariors_free_3 + $plus_3, wariors_free_4 = wariors_free_4 + $plus_4,
 wariors_free_5 = wariors_free_5 + $plus_5, wariors_free_6 = wariors_free_6 + $plus_6,
 wariors_free_7 = wariors_free_7 + $plus_7, wariors_free_8 = wariors_free_8 + $plus_8
 WHERE countryID = '$countryID' LIMIT 1");

 $b['wariors_free'] = $b['wariors_free'] + $plus;
 $b['wariors_free_2'] = $b['wariors_free_2'] + $plus_2;
 $b['wariors_free_3'] = $b['wariors_free_3'] + $plus_3;
 $b['wariors_free_4'] = $b['wariors_free_4'] + $plus_4;
 $b['wariors_free_5'] = $b['wariors_free_5'] + $plus_5;
 $b['wariors_free_6'] = $b['wariors_free_6'] + $plus_6;
 $b['wariors_free_7'] = $b['wariors_free_7'] + $plus_7;
 $b['wariors_free_8'] = $b['wariors_free_8'] + $plus_8;

 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
 $country=checkCountryID($countryID);
 printrus("Вам удалось завербовать <b>$kk</b>% войска гос-ва ".$attackerInfo['countryName']."!<br/>");
 sendMessage($attacker,"fullMessage","Гос-во <u>$country</u> завербовало ваших войск на его территории:<br/>".print_voisko(array($plus,$plus_2,$plus_3,$plus_4,$plus_5,$plus_6,$plus_7,$plus_8)));

 }

 break;

 endswitch;

//==============================================================================
//Конец скрипту=================================================================
print "------<br/>\r\n";
printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
?>
