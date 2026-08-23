<?
set_time_limit(0);
error_reporting(0);
$ip = getenv("REMOTE_ADDR");
echo $ip;

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

//==============================================================================
//Рабочая часть скрипта=========================================================

include_once("other_inc/header.php");

 $w_eat=4;  //Воин жрет в 2 раза больше рабочего!!!!!
 $w_eat_2=15;
 $w_eat_3=30;
 $w_eat_4=0;
 $w_eat_5=30;
 $w_eat_6=0;
 $w_eat_7=50;
 $w_eat_8=1000;
 $p_eat=2;

 $query="SELECT * FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $liders_wariors = array();
 $liders_countries = array();
 $liders_population = array();

 while(($a=mysql_fetch_array($result))!==FALSE){
  $countryID=$a[0];
  $messages.="Новости для Императора:<br/>";
  array_push($liders_countries,$a['countryName']);
  $all_war = 0;
  //worksRefresh($countryID);
  printrus ($a['countryName']."\n");

  $freeland = countFreeLand($countryID);
  //прирост леса
  $forest=$a['forest'];
  $forest_plus=min($freeland,round($forest*$a["forest_adding"]/100));
  if($forest_plus>0){
  	$messages.="<b>+ $forest_plus</b> леса,<br />";
   //sendMessage($countryID,"fullMessage","<b>+ $forest_plus</b> леса!");
  }elseif($freeland<=0){
   $forest_plus=0;
  }else{
   if($a["forest_adding"]>30){
    $forest_plus=round($a["forest_adding"]-$a["forest_adding"]*rand(-10,10)/10);
    $messages.="Искусственным путем выращенно <b>$forest_plus</b> леса,<br />";
    //sendMessage($countryID,"fullMessage","Искусственным путем выращенно <b>$forest_plus</b> леса!");
   }else{
    $messages.="У вас нет леса вообще! Чтобы вырастить его искусственным путем необходимо <u>выращивание лесов</u><b>30 %</b>,<br />";
    //sendMessage($countryID,"fullMessage","У вас нет леса вообще! Чтобы вырастить его искусственным путем необходимо <u>выращивание лесов</u><b>30 %</b>.");
    $forest_plus=0;
   }
  }
  mysql_query("UPDATE countries SET forest=($forest+$forest_plus), land = land - $forest_plus WHERE countryID = '$countryID'");
  $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['forest'] = $forest + $forest_plus;
     $mem['land'] = $mem['land'] - $forest_plus;
     $memcache->set($key,$mem,false,86400);
     }

      $AllLand=$a['land']+$a['mountains']+$a['forest'];
  if ($a["mountains"]>=(3000+sqrt($AllLand)*max(0,($a['mountains_max']-10)))){
          $a["mountains"] = 1000;
          mysql_query("UPDATE `countries` SET mountains = 1000 WHERE countryID = '$countryID'");

  $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['mountains'] = 1000;
     $memcache->set($key,$mem,false,86400);
     }
          $messages.="Землетрясением была разрушена часть гор в вашей стране! Осталось <b>1000</b>,<br />";
          //sendMessage($countryID,"fullMessage","Землетрясением была разрушена часть гор в вашей стране! Осталось <b>1000</b>");
          }
  if ($a["mountains"]<100){
          $m_pl = rand(200,600);
          $a["mountains"] = $a["mountains"] + $m_pl;
          mysql_query("UPDATE `countries` SET mountains = '".$a["mountains"]."' WHERE countryID = '$countryID'");
  $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['mountains'] = $mem['mountains'] + $m_pl;
     $memcache->set($key,$mem,false,86400);
     }
          $messages.="За счет разведок было обнаружено несколько новых мест для шахт в горах! Горы <b>+".$m_pl."</b>,<br />";
          //sendMessage($countryID,"fullMessage","За счет разведок было обнаружено несколько новых мест для шахт в горах! Горы <b>+".$m_pl."</b>");
          }
  //деньги
  $mountains=$a['mountains'];
  $monTime=time_new()-$a['lastWar'];
  $gtr=0.5;
  $money_plus=round($mountains*$gtr)*10;
  if($money_plus>0)
  $new=CountryInfo($countryID);
  if((time_new()-$new['lastWar'])>172800 AND $new['lastWar']!=0)
  $money_plus=max(1,floor($money_plus/(((time_new()-$new['lastWar'])/86400)/2)));
  //if($money_plus>55000)$money_plus=5000;
  if($money_plus<$mountains)$money_plus=$mountains;
   $messages.="Обработка горной породы принесла <b>$money_plus</b> денег,<br />";
   //sendMessage($countryID,"fullMessage","Обработка горной породы принесла <b>$money_plus</b> денег!");
  $newnpr = round($new['napr']*0.75);
  mysql_query("UPDATE countries SET money=money + $money_plus, napr = $newnpr WHERE countryID = '$countryID'");

  $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['money'] = $mem['money'] + $money_plus;
     $mem['napr'] = $newnpr;
     $memcache->set($key,$mem,false,86400);
     }

  //снижение напряжения

  //голод
  $grain=$a['grain'];
  //$wariors_atall=$a['wariors_atall'];
  //$wariors_atall_2=$a['wariors_atall_2'];
  //$wariors_atall_3=$a['wariors_atall_3'];
  $wariors_free=$a['wariors_free'];
  $wariors_free_2=$a['wariors_free_2'];
  $wariors_free_3=$a['wariors_free_3'];
  $wariors_free_4=$a['wariors_free_4'];
  $wariors_free_5=$a['wariors_free_5'];
  $wariors_free_6=$a['wariors_free_6'];
  $wariors_free_7=$a['wariors_free_7'];
  $wariors_free_8=$a['wariors_free_8'];
  $all_war = $wariors_free+$wariors_free_2*2+$wariors_free_3*3+$wariors_free_4*4+$wariors_free_5*3+$wariors_free_6*5+$wariors_free_7*6+$wariors_free_8*10;
  $workers=$a['workers'];
  $scientists=$a['scientists'];
  $grain_=$grain;
  //Считаем действительно всех рабочих, ученых и военных
  $t = mysql_query("SELECT sum(wariors) as w1, sum(wariors_2) as w2, sum(wariors_3) as w3,
  sum(wariors_4) as w4, sum(wariors_5) as w5, sum(wariors_6) as w6, sum(wariors_7) as w7,
  sum(wariors_8) as w8
  FROM `wars` WHERE countryID = '$countryID'");
  $s = mysql_fetch_array($t);
  //$all_w = $wariors_atall+$s['num'];
  $war = $s['w1'];
  $war_2 = $s['w2'];
  $war_3 = $s['w3'];
  $war_4 = $s['w4'];
  $war_5 = $s['w5'];
  $war_6 = $s['w6'];
  $war_7 = $s['w7'];
  $war_8 = $s['w8'];
  $all_war = $all_war + $war+$war_2*2+$war_3*3+$war_4*4+$war_5*3+$war_6*5+$war_7*6+$war_8*10;

  //Считаем действительно всех рабочих, ученых и военных
  $t = mysql_query("SELECT sum(guard) as w1, sum(guard_2) as w2, sum(guard_3) as w3,
  sum(guard_4) as w4, sum(guard_5) as w5, sum(guard_6) as w6, sum(guard_7) as w7,
  sum(guard_8) as w8
  FROM `buildings` WHERE countryID = '$countryID'");
  $s = mysql_fetch_array($t);
  //$all_w = $wariors_atall+$s['num'];
  $build = $s['w1'];
  $build_2 = $s['w2'];
  $build_3 = $s['w3'];
  $build_4 = $s['w4'];
  $build_5 = $s['w5'];
  $build_6 = $s['w6'];
  $build_7 = $s['w7'];
  $build_8 = $s['w8'];
  $all_war = $all_war + $build+$build_2*2+$build_3*3+$build_4*4+$build_5*3+$build_6*5+$build_7*6+$build_8*10;

  array_push($liders_wariors,$all_war);

  $t = mysql_query("SELECT sum(peopleatwork) as num FROM `works` WHERE countryID = '$countryID'");
  $s = mysql_fetch_array($t);
  $all_p = $scientists+$workers+$s['num'];
  array_push($liders_population,$all_p);
  //Посчитаем процент населения, гибнущего с голода:
  $grain_need = ($wariors_free+$war+$build)*$w_eat+($wariors_free_2+$war_2+$build_2)*$w_eat_2+
  ($wariors_free_3+$war_3+$build_3)*$w_eat_3+($wariors_free_5+$war_5+$build_5)*$w_eat_5+
  ($wariors_free_7+$war_7+$build_7)*$w_eat_7+($wariors_free_8+$war_8+$build_8)*$w_eat_8
  +$all_p*$p_eat;
  $proc = round($grain/$grain_need*100);

  if (building_exists($countryID,'citadel')){

  if($proc<20){
  	$messages.="Запасы зерна в стране менее 20% от необходимых! От голода погибло все население,<br />";
  //sendMessage($countryID,"fullMessage","Запасы зерна в стране менее 20% от необходимых! От голода погибло все население!");
  mysql_query("UPDATE countries SET workers=0, scientists=0, wariors_free=0, wariors_free_2=0,
  wariors_free_3=0, wariors_free_5=0, wariors_free_7=0, wariors_free_8=0
  WHERE countryID = '$countryID' LIMIT 1");

  $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['workers'] = $mem['scientists'] = $mem['wariors_free'] = $mem['wariors_free_2'] = $mem['wariors_free_3'] = $mem['wariors_free_5'] = $mem['wariors_free_7'] = $mem['wariors_free_8'] = 0;
     $memcache->set($key,$mem,false,86400);
     }

   looser($countryID);
  }elseif($proc<100){
  //Гибнет 100-$proc % населения страны


  $pl = 100-$proc;
         $free_dead = round($a["wariors_free"]*$pl/100);
         $free_dead_2 = round($a["wariors_free_2"]*$pl/100);
         $free_dead_3 = round($a["wariors_free_3"]*$pl/100);
         $free_dead_5 = round($a["wariors_free_5"]*$pl/100);
         $free_dead_7 = round($a["wariors_free_7"]*$pl/100);
         $free_dead_8 = round($a["wariors_free_8"]*$pl/100);
         $dd = $free_dead;
         $dd_2 = $free_dead_2;
         $dd_3 = $free_dead_3;
         $dd_5 = $free_dead_5;
         $dd_7 = $free_dead_7;
         $dd_8 = $free_dead_8;
         $zz = mysql_query("SELECT * FROM `buildings` WHERE countryID = '$countryID'");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $building = $aa['building'];
                 $grd = $aa['guard'];
                 $grd_2 = $aa['guard_2'];
                 $grd_3 = $aa['guard_3'];
                 $grd_5 = $aa['guard_5'];
                 $grd_7 = $aa['guard_7'];
                 $grd_8 = $aa['guard_8'];
                 printrus ("охрана: $grd,$grd_2,$grd_3,?,$grd_5,?,$grd_7,$grd_8<br/>\n");
                 $grd_dead = round($grd*$pl/100);
                 $grd_dead_2 = round($grd_2*$pl/100);
                 $grd_dead_3 = round($grd_3*$pl/100);
                 $grd_dead_5 = round($grd_5*$pl/100);
                 $grd_dead_7 = round($grd_7*$pl/100);
                 $grd_dead_8 = round($grd_8*$pl/100);
                 printrus ("PL: $pl<br/>\n");
                 $dd = $dd+$grd_dead;
                 $dd_2 = $dd_2+$grd_dead_2;
                 $dd_3 = $dd_3+$grd_dead_3;
                 $dd_5 = $dd_5+$grd_dead_5;
                 $dd_7 = $dd_7+$grd_dead_7;
                 $dd_8 = $dd_8+$grd_dead_8;
                 printrus ("Умерло воинов: $grd_dead,$grd_dead_2,$grd_dead_3,$grd_dead_5,$grd_dead_7,$grd_dead_8<br/>");
                 mysql_query("UPDATE `buildings` SET guard = guard - $grd_dead,
                 guard_2 = guard_2 - $grd_dead_2, guard_3 = guard_3 - $grd_dead_3,
                 guard_5 = guard_5 - $grd_dead_5, guard_7 = guard_7 - $grd_dead_7,
                 guard_8 = guard_8 - $grd_dead_8
                 WHERE countryID = '$countryID' and building='$building' LIMIT 1");
                 echo mysql_error();
                 }
         $key=_PREFIKS.':buildings'.$countryID;
                 if (($mem=$memcache->get($key))!==FALSE){
                    for($i=0;$i<count($mem);$i++){
                    $mem[$i]['guard'] = max(0,round((100-$pl)/100*$mem[$i]['guard']));
                    $mem[$i]['guard_2'] = max(0,round((100-$pl)/100*$mem[$i]['guard_2']));
                    $mem[$i]['guard_3'] = max(0,round((100-$pl)/100*$mem[$i]['guard_3']));
                    $mem[$i]['guard_5'] = max(0,round((100-$pl)/100*$mem[$i]['guard_5']));
                    $mem[$i]['guard_7'] = max(0,round((100-$pl)/100*$mem[$i]['guard_7']));
                    $mem[$i]['guard_8'] = max(0,round((100-$pl)/100*$mem[$i]['guard_8']));
                    }
                    $memcache->set($key,$mem,false,86400);
                    }


         $zz = mysql_query("SELECT * FROM `wars` WHERE countryID = '$countryID'");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $trg = $aa['targetID'];
                 $wrs = $aa['wariors'];
                 $wrs_2 = $aa['wariors_2'];
                 $wrs_3 = $aa['wariors_3'];
                 $wrs_5 = $aa['wariors_5'];
                 $wrs_7 = $aa['wariors_7'];
                 $wrs_8 = $aa['wariors_8'];
                 if ($wrs>1)$wrs_dead = round($wrs*$pl/100);else $wrs_dead=0;
                 if ($wrs_2>=1)$wrs_dead_2 = round($wrs_2*$pl/100);else $wrs_dead_2=0;
                 if ($wrs_3>=1)$wrs_dead_3 = round($wrs_3*$pl/100);else $wrs_dead_3=0;
                 if ($wrs_5>=1)$wrs_dead_5 = round($wrs_5*$pl/100);else $wrs_dead_5=0;
                 if ($wrs_7>=1)$wrs_dead_7 = round($wrs_7*$pl/100);else $wrs_dead_7=0;
                 if ($wrs_8>=1)$wrs_dead_8 = round($wrs_8*$pl/100);else $wrs_dead_8=0;
                 printrus ("Умерло воинов: $wrs_dead,$wrs_dead_2,$wrs_dead_3,$wrs_dead_5,$wrs_dead_7,$wrs_dead_8<br/>");
                 mysql_query("UPDATE `wars` SET wariors = wariors - $wrs_dead,
                 wariors_2 = wariors_2 - $wrs_dead_2, wariors_3 = wariors_3 - $wrs_dead_3,
                 wariors_5 = wariors_5 - $wrs_dead_5, wariors_7 = wariors_7 - $wrs_dead_7,
                 wariors_8 = wariors_8 - $wrs_dead_8
                 WHERE countryID = '$countryID' and targetID='$trg' LIMIT 1");
                 echo mysql_error();
                 }
         $key=_PREFIKS.':wars'.$countryID;
                 if (($mem=$memcache->get($key))!==FALSE){
                    for($i=0;$i<count($mem);$i++){
                    if ($mem[$i]['wariors']>0)$mem[$i]['wariors'] = max(1,round((100-$pl)/100*$mem[$i]['wariors']));
                    if ($mem[$i]['wariors_2']>0)$mem[$i]['wariors_2'] = max(1,round((100-$pl)/100*$mem[$i]['wariors_2']));
                    if ($mem[$i]['wariors_3']>0)$mem[$i]['wariors_3'] = max(1,round((100-$pl)/100*$mem[$i]['wariors_3']));
                    if ($mem[$i]['wariors_5']>0)$mem[$i]['wariors_5'] = max(1,round((100-$pl)/100*$mem[$i]['wariors_5']));
                    if ($mem[$i]['wariors_7']>0)$mem[$i]['wariors_7'] = max(1,round((100-$pl)/100*$mem[$i]['wariors_7']));
                    if ($mem[$i]['wariors_8']>0)$mem[$i]['wariors_8'] = max(0,round((100-$pl)/100*$mem[$i]['wariors_8']));
                    }
                    $memcache->set($key,$mem,false,86400);
                    }

         $scfree_dead = round($a['scientists']*$pl/100);
         $zz = mysql_query("SELECT * FROM `works` WHERE (countryID = '$countryID') and (kind='teaching' or kind='science')");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $kind = $aa['kind'];
                 $what = $aa['what'];
                 $ppl = $aa['peopleatwork'];
                 if ($ppl>1)$ppl_dead = round($ppl*$pl/100);else $ppl_dead=0;
                 printrus ("Умерло ученых: $ppl_dead<br/>");
                 mysql_query("UPDATE `works` SET peopleatwork = peopleatwork - $ppl_dead WHERE countryID = '$countryID' and kind = '$kind' and what='$what'");
                 echo mysql_error();
                 }
         $wfree_dead = round($a['workers']*$pl/100);
         $zz = mysql_query("SELECT * FROM `works` WHERE (countryID = '$countryID') and (kind='building' or kind='working')");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $kind = $aa['kind'];
                 $what = $aa['what'];
                 $ppl = $aa['peopleatwork'];
                 if ($ppl>1)$ppl_dead = round($ppl*$pl/100);else $ppl_dead=0;
                 printrus ("Умерло рабочих: $ppl_dead<br/>");
                 mysql_query("UPDATE `works` SET peopleatwork = peopleatwork - $ppl_dead WHERE countryID = '$countryID' and kind = '$kind' and what='$what'");
                 echo mysql_error();
                 }
         $key=_PREFIKS.':works'.$countryID;
                 if (($mem=$memcache->get($key))!==FALSE){
                    for($i=0;$i<count($mem);$i++) $mem[$i]['peopleatwork'] = max(1,round((100-$pl)/100*$mem[$i]['peopleatwork']));
                    $memcache->set($key,$mem,false,86400);
                    }

         mysql_query("UPDATE `countries` SET workers=workers - $wfree_dead,
         scientists = scientists - $scfree_dead, wariors_free = wariors_free - $free_dead,
         wariors_free_2 = wariors_free_2 - $free_dead_2, wariors_free_3 = wariors_free_3 - $free_dead_3,
         wariors_free_5 = wariors_free_5 - $free_dead_5, wariors_free_7 = wariors_free_7 - $free_dead_7,
         wariors_free_8 = wariors_free_8 - $free_dead_8,
         grain=0 WHERE countryID='$countryID'");
         $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['grain'] = 0;
            $mem['workers'] = $mem['workers'] - $wfree_dead;
            $mem['scientists'] = $mem['scientists'] - $scfree_dead;
            //$mem['wariors_atall'] = $mem['wariors_atall'] - $dd;
            //$mem['wariors_atall_2'] = $mem['wariors_atall_2'] - $dd_2;
            //$mem['wariors_atall_3'] = $mem['wariors_atall_3'] - $dd_3;
            $mem['wariors_free'] = $mem['wariors_free'] - $free_dead;
            $mem['wariors_free_2'] = $mem['wariors_free_2'] - $free_dead_2;
            $mem['wariors_free_3'] = $mem['wariors_free_3'] - $free_dead_3;
            $mem['wariors_free_5'] = $mem['wariors_free_5'] - $free_dead_5;
            $mem['wariors_free_7'] = $mem['wariors_free_7'] - $free_dead_7;
            $mem['wariors_free_8'] = $mem['wariors_free_8'] - $free_dead_8;
            $memcache->set($key,$mem,false,86400);
            }
  $messages.="Запасов зерна не хватило. От голода погибло $pl% населения,<br />";
  //sendMessage($countryID,"fullMessage","Запасов зерна не хватило. От голода погибло $pl% населения!");
  }else{
  $messages.="На еду для населения ушло <b>$grain_need</b> зерна,<br />";
  //sendMessage($countryID,"fullMessage","На еду для населения ушло <b>$grain_need</b> зерна");
  mysql_query("UPDATE `countries` SET grain=grain - $grain_need WHERE countryID='$countryID'");
         $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['grain'] = $mem['grain'] - $grain_need;
            $memcache->set($key,$mem,false,86400);
            }
  }


  }else{ //Если в стране нет цитадели, с голоду она погибнуть не может
  $grain_left = max(0,$grain-$grain_need);
  $messages.="На еду для населения ушло <b>$grain_need</b> зерна,<br />";
  //sendMessage($countryID,"fullMessage","На еду для населения ушло <b>$grain_need</b> зерна");
  mysql_query("UPDATE `countries` SET grain=$grain_left WHERE countryID='$countryID'");
         $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['grain'] = $grain_left;
            $memcache->set($key,$mem,false,86400);
            }
  }

  //прирост населения
  $new=CountryInfo($countryID);
  $workers=$new['workers'];
  $free_w=$workers;
  //Здесь надо прибавить тех, кто работает:
  $z = mysql_query("SELECT sum(peopleatwork) as num FROM `works` WHERE countryID = '$countryID' and (kind='working' or kind='building' or kind='newplace')");
  $q = mysql_fetch_array($z);
  $watwork = $q['num'];
  $workers = $workers + $watwork;
  $KR='';
  $PS='';

  if($workers>0){
   $workers_max=count_workers_max($countryID);
   //$workers_plus=min(max(0,$workers_max-$workers),round($workers*$a["people_adding"]/100));
   $workers_plus=min(max(0,$workers_max-$workers),round($workers*$a["people_adding"]/100/3));
   $workers_d = $workers - $workers_max; //Сколько сдохнут
   if($workers+$workers_plus>$workers_max) $PS="Плотность населения достигла критического уровня!";
   if($workers_d>0){
           $KR = " $workers_d рабочих в негодовании сбежало из страны из-за высокой плотности населения!";
           if ($free_w-$workers_d>0){
           mysql_query("UPDATE countries SET workers = workers-$workers_d WHERE countryID='$countryID'");
   $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['workers'] = $mem['workers'] - $workers_d;
     $memcache->set($key,$mem,false,86400);
     }
           }
            else{
  mysql_query("UPDATE countries SET workers = 0 WHERE countryID='$countryID'");
  $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['workers'] = 0;
     $memcache->set($key,$mem,false,86400);
     }
                 $left = $workers_d-$free; //Осталось снять с работ
                 $req = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and (kind='working' or kind='building' or kind = 'newplace')");
                  while(($zp=mysql_fetch_array($req))!==FALSE && $left>0){
                          $ppl = $zp['peopleatwork'];
                          $kind = $zp['kind'];
                          $what = $zp['what'];
                          if ($ppl-$left>0) {
                             mysql_query("UPDATE `works` SET peopleatwork = peopleatwork - $left WHERE countryID = '$countryID' and kind = '$kind' and what = '$what' LIMIT 1");
  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']==$kind&&$mem[$i]['what']==$what){
            $mem[$i]['peopleatwork'] = $mem[$i]['peopleatwork'] - $left;
            break;
            }
         }
     $memcache->set($key,$mem,false,86400);
     }
                             $left=0;
                             }
                           else{
                                 mysql_query("UPDATE `works` SET peopleatwork = 1 WHERE countryID = '$countryID' and kind = '$kind' and what = '$what' LIMIT 1");
                                 $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']==$kind&&$mem[$i]['what']==$what){
            $mem[$i]['peopleatwork'] = 1;
            break;
            }
         }
     $memcache->set($key,$mem,false,86400);
     }
                                 $left = $left - $ppl + 1;
                                   }
                          }
                    }
           }

   if($workers_plus>0){
   $messages.="Прирост населения: <b>$workers_plus</b> человек! ".$PS.",<br />";
    //sendMessage($countryID,"fullMessage","Прирост населения: <b>$workers_plus</b> человек! ".$PS);
   }else{
   	$messages.="Прирост населения невозможен из-за высокого уровня плотности!".$KR.",<br />";
    //sendMessage($countryID,"fullMessage","Прирост населения невозможен из-за высокого уровня плотности!".$KR);
   }
   mysql_query("UPDATE countries SET workers = workers+$workers_plus WHERE countryID='$countryID'");
   $key=_PREFIKS.':id'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['workers'] = $mem['workers'] + $workers_plus;
     $memcache->set($key,$mem,false,86400);
     }
  }


 //возраст генерала
 $general=general_info($countryID);
 if ($general!==FALSE){
 if($general['age']>(80+7*otkr_exists($countryID,'DOLG')) && round(rand($general['age'],160+14*otkr_exists($countryID,'DOLG')-$general['age']))==(80+7*otkr_exists($countryID,'DOLG'))){
  $messages.="Ваш генерал скоропостижно скончался от старости,<br />";
  //sendMessage($countryID,"fullMessage","Ваш генерал скоропостижно скончался от старости!");
  $query="delete from `general` where countryID='$countryID'";
  $result_=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $key=_PREFIKS.':general'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $memcache->set($key,'',false,86400);
     }

 }else{
  $general['age']++;
  setValue("countryID='$countryID'","general","age",$general['age']);
  $key=_PREFIKS.':general'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $mem['age'] = $mem['age'] + 1;
     $memcache->set($key,$mem,false,86400);
     }

 }

 }
 sendMessage($countryID,"fullMessage",$messages);
 unset($messages);
}

//Составим таблицу лидеров:
$liders_countries_2 = $liders_countries;
array_multisort($liders_wariors,$liders_countries);
array_multisort($liders_population,$liders_countries_2);

$open=fopen(_ROOT."/liders/wariors.dat","w+");
@flock ($open,LOCK_EX);
for ($i=count($liders_wariors)-1;$i>=count($liders_wariors)-10;$i--){
@fwrite($open,$liders_countries[$i].'*'.$liders_wariors[$i]."\n");
}
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$open=fopen(_ROOT."/liders/population.dat","w+");
@flock ($open,LOCK_EX);
for ($i=count($liders_population)-1;$i>=count($liders_population)-10;$i--){
@fwrite($open,$liders_countries_2[$i].'*'.$liders_population[$i]."\n");
}
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query = "SELECT money,countryName FROM `countries` order by money desc LIMIT 10";
$r = mysql_query($query);
$open=fopen(_ROOT."/liders/money.dat","w+");
@flock ($open,LOCK_EX);
while (($a=mysql_fetch_array($r))!==FALSE){
      @fwrite($open,$a['countryName'].'*'.$a['money']."\n");
      }
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query = "SELECT (land+mountains+forest) as fland,countryName FROM `countries` order by (land+mountains+forest) desc LIMIT 10";
$r = mysql_query($query);
$open=fopen(_ROOT."/liders/land.dat","w+");
@flock ($open,LOCK_EX);
while (($a=mysql_fetch_array($r))!==FALSE){
      @fwrite($open,$a['countryName'].'*'.$a['fland']."\n");
      }
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query = "SELECT (weapon_force+weapon_speed+2*weapon_force_2+2*weapon_speed_2+3*weapon_speed_3+
3*weapon_force_3+4*weapon_force_4+4*weapon_speed_4+3*weapon_force_5+3*weapon_speed_5+
5*weapon_force_6+5*weapon_speed_6+6*weapon_force_7+6*weapon_speed_7+10*weapon_force_8+
10*weapon_speed_8) as koef,countryName FROM `countries` order by koef desc LIMIT 10";
$r = mysql_query($query);

$open=fopen(_ROOT."/liders/params.dat","w+");
@flock ($open,LOCK_EX);
while (($a=mysql_fetch_array($r))!==FALSE){
      @fwrite($open,$a['countryName'].'*'.$a['koef']."\n");
      }
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query = "SELECT expiriense,countryName FROM `general`,`countries` WHERE general.countryID = countries.countryID order by expiriense desc LIMIT 10";
$r = mysql_query($query);

$open=fopen(_ROOT."/liders/general_exp.dat","w+");
@flock ($open,LOCK_EX);
while (($a=mysql_fetch_array($r))!==FALSE){
      @fwrite($open,$a['countryName'].'*'.$a['expiriense']."\n");
      }
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query = "SELECT (study+moral) as koef,countryName FROM `general`,`countries` WHERE general.countryID = countries.countryID order by (study+moral) desc LIMIT 10";
$r = mysql_query($query);

$open=fopen(_ROOT."/liders/general.dat","w+");
@flock ($open,LOCK_EX);
while (($a=mysql_fetch_array($r))!==FALSE){
      @fwrite($open,$a['countryName'].'*'.$a['koef']."\n");
      }
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query = "SELECT age as koef,countryName FROM `general`,`countries` WHERE general.countryID = countries.countryID order by age desc LIMIT 10";
$r = mysql_query($query);

$open=fopen(_ROOT."/liders/general_age.dat","w+");
@flock ($open,LOCK_EX);
while (($a=mysql_fetch_array($r))!==FALSE){
      @fwrite($open,$a['countryName'].'*'.$a['koef']."\n");
      }
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

$query = "SELECT (0.2*grain+arbor+4*stone+12*iron+20*oil) as koef,countryName FROM `countries` order by koef desc LIMIT 10";
$r = mysql_query($query);

$open=fopen(_ROOT."/liders/res.dat","w+");
@flock ($open,LOCK_EX);
while (($a=mysql_fetch_array($r))!==FALSE){
      @fwrite($open,$a['countryName'].'*'.$a['koef']."\n");
      }
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

echo "done!";
include_once("other_inc/footer.php");

?>
