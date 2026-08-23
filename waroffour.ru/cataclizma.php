<?php

if ($_GET['pas'] != 't67gh52cZv')
	die('403.');

set_time_limit(0);
error_reporting(0);
define('IN_CLV',true);
//==============================================================================
//подключаем скрипты
include_once("func/functions_clv.php");
mem_connect();

//==============================================================================
//Рабочая часть скрипта=========================================================
include_once("other_inc/header.php");


//Обнуление потраченного за сутки золота
mysql_query("UPDATE `uzers` SET spent=0");


$query="SELECT * FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE ip!='sysreg' and ip!='botsysreg1' and ip!='botsysreg2' and ip!='botsysreg3' and ip!='botsysreg4' and ip!='botsysreg5' and ip!='botsysreg6' and ip!='botsysreg7' and ip!='botsysreg8' and ip!='botsysreg9' and ip!='botsysreg10' and ip!='botsysreg11' and ip!='botsysreg12' and ip!='botsysreg13' and ip!='botsysreg14' and ip!='botsysreg15' and ip!='botsysreg16' and ip!='botsysreg17' and ip!='botsysreg18' and ip!='botsysreg19' and ip!='botsysreg20' and messages.countryID IS NULL";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 while(($a=mysql_fetch_array($result))!==FALSE){
  $countryID=$a[0];
  $kk = mysql_query("SELECT voting FROM `uzers` WHERE countryID = '$countryID' LIMIT 1");
  $gg = mysql_fetch_array($kk);
  $voting = $gg['voting'];

//ЧУМА!!!!
 $plague = FALSE;
 //Войны
 $t = mysql_query("SELECT sum(wariors+wariors_2+wariors_3+wariors_4+wariors_5+wariors_6+wariors_7+wariors_8) as num FROM `wars` WHERE countryID = '$countryID'");
 $s = @mysql_fetch_array($t);
 if ($s===false) $s['num']=0;
 $all = $a['wariors_free']+$a['wariors_free_2']+$a['wariors_free_3']+$a['wariors_free_4']+$a['wariors_free_5']+$a['wariors_free_6']+$a['wariors_free_7']+$a['wariors_free_8']+$s["num"];//Общее число военных

 //Замок
 $t = mysql_query("SELECT sum(wariors+wariors_2+wariors_3+wariors_4+wariors_5+wariors_6+wariors_7+wariors_8) as num FROM `zamok_defence` WHERE countryID = '$countryID'");
 $s = @mysql_fetch_array($t);
 if ($s===false) $s['num']=0;
 $all += $s['num'];
 $t = mysql_query("SELECT sum(wariors+wariors_2+wariors_3+wariors_4+wariors_5+wariors_6+wariors_7+wariors_8) as num FROM `zamok_attack` WHERE countryID = '$countryID'");
 $s = @mysql_fetch_array($t);
 if ($s===false) $s['num']=0;
 $all += $s['num'];

 //Здания
 $t = mysql_query("SELECT sum(guard+guard_2+guard_3+guard_4+guard_5+guard_6+guard_7+guard_8) as num FROM `buildings` WHERE countryID = '$countryID'");
 $s = @mysql_fetch_array($t);
 if ($s===false) $s['num']=0;
 $all = $all+$s["num"];//Общее число военных

 //Работы
 $t = mysql_query("SELECT sum(peopleatwork) as num FROM `works` WHERE countryID = '$countryID'");
 $s = @mysql_fetch_array($t);
 if ($s===false) $s['num']=0;

 if($att_nz=isNewBuildings($countryID,'farm')){
  $vs_cow=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='cow'"));
  $vs_mutton=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='rams'"));
  $vs_goat=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='goats'"));
  $vs_pig=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='pig'"));
  $all_farm=$vs_cow+$vs_mutton+$vs_goat+$vs_pig;
 }else{$all_farm=0;}

 $all = $all+$a['scientists']+$a['workers']+$s['num']+$all_farm;
 if ($all>20000){
         printrus("Государство ".$a['countryName'].": $all<br/>\n");
         $pl = rand(20000,30000);
         if ($all>$pl) $plague = TRUE;
         }
 if ($plague==TRUE){
         $pl = rand(20,70);

       if($att_nz=isNewBuildings($countryID,'farm')){
       $vs_cow=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='cow'"));
       $vs_mutton=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='rams'"));
       $vs_goat=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='goats'"));
       $vs_pig=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='pig'"));
       $cow_dead = round($vs_cow*$pl/100);
       $rams_dead = round($vs_mutton*$pl/100);
       $goats_dead = round($vs_goat*$pl/100);
       $pig_dead = round($vs_pig*$pl/100);
         for($i=0;$i<4;$i++){
         if($i == 0){$vid='cow'; $vz=$cow_dead;}
         if($i == 1){$vid='rams'; $vz=$rams_dead;}
         if($i == 2){$vid='goats'; $vz=$goats_dead;}
         if($i == 3){$vid='pig'; $vz=$pig_dead;}
           for($f=0;$f<$vz;$f++){
           $query="delete from `farm` where countryID='$countryID' and who='$vid' limit 1";
           $resul=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
           }
         }
       }

         $free_dead = round($a["wariors_free"]*$pl/100);
         $free_dead_2 = round($a["wariors_free_2"]*$pl/100);
         $free_dead_3 = round($a["wariors_free_3"]*$pl/100);
         $free_dead_4 = round($a["wariors_free_4"]*$pl/100);
         $free_dead_5 = round($a["wariors_free_5"]*$pl/100);
         $free_dead_6 = round($a["wariors_free_6"]*$pl/100);
         $free_dead_7 = round($a["wariors_free_7"]*$pl/100);
         $free_dead_8 = round($a["wariors_free_8"]*$pl/100);
         //$dd = $free_dead;
         //$dd_2 = $free_dead_2;
         //$dd_3 = $free_dead_3;
         $zz = mysql_query("SELECT * FROM `buildings` WHERE countryID = '$countryID'");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $building = $aa['building'];
                 $grd = $aa['guard'];
                 $grd_2 = $aa['guard_2'];
                 $grd_3 = $aa['guard_3'];
                 $grd_4 = $aa['guard_4'];
                 $grd_5 = $aa['guard_5'];
                 $grd_6 = $aa['guard_6'];
                 $grd_7 = $aa['guard_7'];
                 $grd_8 = $aa['guard_8'];
                 printrus ("Охрана: $grd,$grd_2,$grd_3,$grd_4,$grd_5,$grd_6,$grd_7,$grd_8<br/>\n");
                 $grd_dead = round($grd*$pl/100);
                 $grd_dead_2 = round($grd_2*$pl/100);
                 $grd_dead_3 = round($grd_3*$pl/100);
                 $grd_dead_4 = round($grd_4*$pl/100);
                 $grd_dead_5 = round($grd_5*$pl/100);
                 $grd_dead_6 = round($grd_6*$pl/100);
                 $grd_dead_7 = round($grd_7*$pl/100);
                 $grd_dead_8 = round($grd_8*$pl/100);
                 printrus ("PL: $pl<br/>\n");
                 //$dd = $dd+$grd_dead;
                 //$dd_2 = $dd_2+$grd_dead_2;
                 //$dd_3 = $dd_3+$grd_dead_3;
                 printrus ("Умерло воинов: $grd_dead,$grd_dead_2,$grd_dead_3,$grd_dead_4,$grd_dead_5,$grd_dead_6,$grd_dead_7,$grd_dead_8<br/>");
                 mysql_query("UPDATE `buildings` SET guard = guard - $grd_dead,
                 guard_2 = guard_2 - $grd_dead_2, guard_3 = guard_3 - $grd_dead_3,
                 guard_4 = guard_4 - $grd_dead_4, guard_5 = guard_5 - $grd_dead_5,
                 guard_6 = guard_6 - $grd_dead_6, guard_7 = guard_7 - $grd_dead_7,
                 guard_8 = guard_8 - $grd_dead_8
                 WHERE countryID = '$countryID' and building='$building' LIMIT 1");

                 if(isNewBuildings($countryID,'necropolis')){
			     mysql_query("UPDATE buildings SET un_1 = un_1 + $grd_dead,
			     un_2 = un_2 + $grd_dead_2, un_3 = un_3 + $grd_dead_3, un_4 = un_4 + $grd_dead_4,
			     un_5 = un_5 + $grd_dead_5, un_6 = un_6 + $grd_dead_6, un_7 = un_7 + $grd_dead_7
			     WHERE countryID = '$countryID' and building = 'necropolis' LIMIT 1");

			     $key=_PREFIKS.':buildings'.$countryID;
			      if (($mem=$memcache->get($key))!==FALSE){
			        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
			        $mem[$i]['un_1'] = $mem[$i]['un_1'] + $grd_dead;
			        $mem[$i]['un_2'] = $mem[$i]['un_2'] + $grd_dead_2;
			        $mem[$i]['un_3'] = $mem[$i]['un_3'] + $grd_dead_3;
			        $mem[$i]['un_4'] = $mem[$i]['un_4'] + $grd_dead_4;
			        $mem[$i]['un_5'] = $mem[$i]['un_5'] + $grd_dead_5;
			        $mem[$i]['un_6'] = $mem[$i]['un_6'] + $grd_dead_6;
			        $mem[$i]['un_7'] = $mem[$i]['un_7'] + $grd_dead_7;
			        break;
			        }
			      $memcache->set($key,$mem,false,86400);
			      }
			     }


                 echo mysql_error();
                 }
         $key=_PREFIKS.':buildings'.$countryID;
                 if (($mem=$memcache->get($key))!==FALSE){
                    for($i=0;$i<count($mem);$i++){
                    $mem[$i]['guard'] = max(0,round((100-$pl)/100*$mem[$i]['guard']));
                    $mem[$i]['guard_2'] = max(0,round((100-$pl)/100*$mem[$i]['guard_2']));
                    $mem[$i]['guard_3'] = max(0,round((100-$pl)/100*$mem[$i]['guard_3']));
                    $mem[$i]['guard_4'] = max(0,round((100-$pl)/100*$mem[$i]['guard_4']));
                    $mem[$i]['guard_5'] = max(0,round((100-$pl)/100*$mem[$i]['guard_5']));
                    $mem[$i]['guard_6'] = max(0,round((100-$pl)/100*$mem[$i]['guard_6']));
                    $mem[$i]['guard_7'] = max(0,round((100-$pl)/100*$mem[$i]['guard_7']));
                    $mem[$i]['guard_8'] = max(0,round((100-$pl)/100*$mem[$i]['guard_8']));
                    }
                    $memcache->set($key,$mem,false,86400);
                    }
          /*
         //Замок
         $zz = mysql_query("SELECT * FROM `zamok_attack` WHERE countryID = '$countryID'");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $zid = $aa['zid'];
                 $wrs = $aa['wariors'];
                 $wrs_2 = $aa['wariors_2'];
                 $wrs_3 = $aa['wariors_3'];
                 $wrs_4 = $aa['wariors_4'];
                 $wrs_5 = $aa['wariors_5'];
                 $wrs_6 = $aa['wariors_6'];
                 $wrs_7 = $aa['wariors_7'];
                 $wrs_8 = $aa['wariors_8'];
                 if ($wrs>1)$wrs_dead = round($wrs*$pl/100);else $wrs_dead=0;
                 if ($wrs_2>1)$wrs_dead_2 = round($wrs_2*$pl/100);else $wrs_dead_2=0;
                 if ($wrs_3>1)$wrs_dead_3 = round($wrs_3*$pl/100);else $wrs_dead_3=0;
                 if ($wrs_4>1)$wrs_dead_4 = round($wrs_4*$pl/100);else $wrs_dead_4=0;
                 if ($wrs_5>1)$wrs_dead_5 = round($wrs_5*$pl/100);else $wrs_dead_5=0;
                 if ($wrs_6>1)$wrs_dead_6 = round($wrs_6*$pl/100);else $wrs_dead_6=0;
                 if ($wrs_7>1)$wrs_dead_7 = round($wrs_7*$pl/100);else $wrs_dead_7=0;
                 if ($wrs_8>1)$wrs_dead_8 = round($wrs_8*$pl/100);else $wrs_dead_8=0;
                 printrus ("Умерло воиновв ат.замк.: $wrs_dead,$wrs_dead_2,$wrs_dead_3,$wrs_dead_4,$wrs_dead_5,$wrs_dead_6,$wrs_dead_7,$wrs_dead_8<br/>");
                 mysql_query("UPDATE `zamok_attack` SET wariors = wariors - $wrs_dead,
                 wariors_2 = wariors_2 - $wrs_dead_2, wariors_3 = wariors_3 - $wrs_dead_3,
                 wariors_4 = wariors_4 - $wrs_dead_4, wariors_5 = wariors_5 - $wrs_dead_5,
                 wariors_6 = wariors_6 - $wrs_dead_6, wariors_7 = wariors_7 - $wrs_dead_7,
                 wariors_8 = wariors_8 - $wrs_dead_8
                 WHERE countryID = '$countryID' and zid = '$zid' LIMIT 1");
                 echo mysql_error();
                 }
         $zz = mysql_query("SELECT * FROM `zamok_defence` WHERE countryID = '$countryID'");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $zid = $aa['zid'];
                 $wrs = $aa['wariors'];
                 $wrs_2 = $aa['wariors_2'];
                 $wrs_3 = $aa['wariors_3'];
                 $wrs_4 = $aa['wariors_4'];
                 $wrs_5 = $aa['wariors_5'];
                 $wrs_6 = $aa['wariors_6'];
                 $wrs_7 = $aa['wariors_7'];
                 $wrs_8 = $aa['wariors_8'];
                 if ($wrs>1)$wrs_dead = round($wrs*$pl/100);else $wrs_dead=0;
                 if ($wrs_2>1)$wrs_dead_2 = round($wrs_2*$pl/100);else $wrs_dead_2=0;
                 if ($wrs_3>1)$wrs_dead_3 = round($wrs_3*$pl/100);else $wrs_dead_3=0;
                 if ($wrs_4>1)$wrs_dead_4 = round($wrs_4*$pl/100);else $wrs_dead_4=0;
                 if ($wrs_5>1)$wrs_dead_5 = round($wrs_5*$pl/100);else $wrs_dead_5=0;
                 if ($wrs_6>1)$wrs_dead_6 = round($wrs_6*$pl/100);else $wrs_dead_6=0;
                 if ($wrs_7>1)$wrs_dead_7 = round($wrs_7*$pl/100);else $wrs_dead_7=0;
                 if ($wrs_8>1)$wrs_dead_8 = round($wrs_8*$pl/100);else $wrs_dead_8=0;
                 printrus ("Умерло воинов защ.замк.: $wrs_dead,$wrs_dead_2,$wrs_dead_3,$wrs_dead_4,$wrs_dead_5,$wrs_dead_6,$wrs_dead_7,$wrs_dead_8<br/>");
                 mysql_query("UPDATE `zamok_defence` SET wariors = wariors - $wrs_dead,
                 wariors_2 = wariors_2 - $wrs_dead_2, wariors_3 = wariors_3 - $wrs_dead_3,
                 wariors_4 = wariors_4 - $wrs_dead_4, wariors_5 = wariors_5 - $wrs_dead_5,
                 wariors_6 = wariors_6 - $wrs_dead_6, wariors_7 = wariors_7 - $wrs_dead_7,
                 wariors_8 = wariors_8 - $wrs_dead_8
                 WHERE countryID = '$countryID' and zid = '$zid' LIMIT 1");
                 echo mysql_error();
                 }

         */
         $zz = mysql_query("SELECT * FROM `wars` WHERE countryID = '$countryID'");
         while (($aa=mysql_fetch_array($zz))!==FALSE){
                 $trg = $aa['targetID'];
                 $wrs = $aa['wariors'];
                 $wrs_2 = $aa['wariors_2'];
                 $wrs_3 = $aa['wariors_3'];
                 $wrs_4 = $aa['wariors_4'];
                 $wrs_5 = $aa['wariors_5'];
                 $wrs_6 = $aa['wariors_6'];
                 $wrs_7 = $aa['wariors_7'];
                 $wrs_8 = $aa['wariors_8'];
                 if ($wrs>1)$wrs_dead = round($wrs*$pl/100);else $wrs_dead=0;
                 if ($wrs_2>1)$wrs_dead_2 = round($wrs_2*$pl/100);else $wrs_dead_2=0;
                 if ($wrs_3>1)$wrs_dead_3 = round($wrs_3*$pl/100);else $wrs_dead_3=0;
                 if ($wrs_4>1)$wrs_dead_4 = round($wrs_4*$pl/100);else $wrs_dead_4=0;
                 if ($wrs_5>1)$wrs_dead_5 = round($wrs_5*$pl/100);else $wrs_dead_5=0;
                 if ($wrs_6>1)$wrs_dead_6 = round($wrs_6*$pl/100);else $wrs_dead_6=0;
                 if ($wrs_7>1)$wrs_dead_7 = round($wrs_7*$pl/100);else $wrs_dead_7=0;
                 if ($wrs_8>1)$wrs_dead_8 = round($wrs_8*$pl/100);else $wrs_dead_8=0;
                 printrus ("Умерло воинов: $wrs_dead,$wrs_dead_2,$wrs_dead_3,$wrs_dead_4,$wrs_dead_5,$wrs_dead_6,$wrs_dead_7,$wrs_dead_8<br/>");
                 mysql_query("UPDATE `wars` SET wariors = wariors - $wrs_dead,
                 wariors_2 = wariors_2 - $wrs_dead_2, wariors_3 = wariors_3 - $wrs_dead_3,
                 wariors_4 = wariors_4 - $wrs_dead_4, wariors_5 = wariors_5 - $wrs_dead_5,
                 wariors_6 = wariors_6 - $wrs_dead_6, wariors_7 = wariors_7 - $wrs_dead_7,
                 wariors_8 = wariors_8 - $wrs_dead_8
                 WHERE countryID = '$countryID' and targetID='$trg' LIMIT 1");

                 if(isNewBuildings($countryID,'necropolis')){
			     mysql_query("UPDATE buildings SET un_1 = un_1 + $wrs_dead,
			     un_2 = un_2 + $wrs_dead_2, un_3 = un_3 + $wrs_dead_3, un_4 = un_4 + $wrs_dead_4,
			     un_5 = un_5 + $wrs_dead_5, un_6 = un_6 + $wrs_dead_6, un_7 = un_7 + $wrs_dead_7
			     WHERE countryID = '$countryID' and building = 'necropolis' LIMIT 1");

			     $key=_PREFIKS.':buildings'.$countryID;
			      if (($mem=$memcache->get($key))!==FALSE){
			        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
			        $mem[$i]['un_1'] = $mem[$i]['un_1'] + $wrs_dead;
			        $mem[$i]['un_2'] = $mem[$i]['un_2'] + $wrs_dead_2;
			        $mem[$i]['un_3'] = $mem[$i]['un_3'] + $wrs_dead_3;
			        $mem[$i]['un_4'] = $mem[$i]['un_4'] + $wrs_dead_4;
			        $mem[$i]['un_5'] = $mem[$i]['un_5'] + $wrs_dead_5;
			        $mem[$i]['un_6'] = $mem[$i]['un_6'] + $wrs_dead_6;
			        $mem[$i]['un_7'] = $mem[$i]['un_7'] + $wrs_dead_7;
			        break;
			        }
			      $memcache->set($key,$mem,false,86400);
			      }
			     }

                 echo mysql_error();
                 }
         $key=_PREFIKS.':wars'.$countryID;
                 if (($mem=$memcache->get($key))!==FALSE){
                    for($i=0;$i<count($mem);$i++){
                    $mem[$i]['wariors'] = ceil((100-$pl)/100*$mem[$i]['wariors']);
                    $mem[$i]['wariors_2'] = ceil((100-$pl)/100*$mem[$i]['wariors_2']);
                    $mem[$i]['wariors_3'] = ceil((100-$pl)/100*$mem[$i]['wariors_3']);
                    $mem[$i]['wariors_4'] = ceil((100-$pl)/100*$mem[$i]['wariors_4']);
                    $mem[$i]['wariors_5'] = ceil((100-$pl)/100*$mem[$i]['wariors_5']);
                    $mem[$i]['wariors_6'] = ceil((100-$pl)/100*$mem[$i]['wariors_6']);
                    $mem[$i]['wariors_7'] = ceil((100-$pl)/100*$mem[$i]['wariors_7']);
                    $mem[$i]['wariors_8'] = ceil((100-$pl)/100*$mem[$i]['wariors_8']);
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
         wariors_free_4 = wariors_free_4 - $free_dead_4, wariors_free_5 = wariors_free_5 - $free_dead_5,
         wariors_free_6 = wariors_free_6 - $free_dead_6, wariors_free_7 = wariors_free_7 - $free_dead_7,
         wariors_free_8 = wariors_free_8 - $free_dead_8
         WHERE countryID='$countryID' LIMIT 1");
         $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['workers'] = $mem['workers'] - $wfree_dead;
            $mem['scientists'] = $mem['scientists'] - $scfree_dead;
            $mem['wariors_free'] = $mem['wariors_free'] - $free_dead;
            $mem['wariors_free_2'] = $mem['wariors_free_2'] - $free_dead_2;
            $mem['wariors_free_3'] = $mem['wariors_free_3'] - $free_dead_3;
            $mem['wariors_free_4'] = $mem['wariors_free_4'] - $free_dead_4;
            $mem['wariors_free_5'] = $mem['wariors_free_5'] - $free_dead_5;
            $mem['wariors_free_6'] = $mem['wariors_free_6'] - $free_dead_6;
            $mem['wariors_free_7'] = $mem['wariors_free_7'] - $free_dead_7;
            $mem['wariors_free_8'] = $mem['wariors_free_8'] - $free_dead_8;
            $memcache->set($key,$mem,false,86400);
            }

                 if(isNewBuildings($countryID,'necropolis')){
			     mysql_query("UPDATE buildings SET un_1 = un_1 + $free_dead,
			     un_2 = un_2 + $free_dead_2, un_3 = un_3 + $free_dead_3, un_4 = un_4 + $free_dead_4,
			     un_5 = un_5 + $free_dead_5, un_6 = un_6 + $free_dead_6, un_7 = un_7 + $free_dead_7
			     WHERE countryID = '$countryID' and building = 'necropolis' LIMIT 1");

			     $key=_PREFIKS.':buildings'.$countryID;
			      if (($mem=$memcache->get($key))!==FALSE){
			        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
			        $mem[$i]['un_1'] = $mem[$i]['un_1'] + $free_dead;
			        $mem[$i]['un_2'] = $mem[$i]['un_2'] + $free_dead_2;
			        $mem[$i]['un_3'] = $mem[$i]['un_3'] + $free_dead_3;
			        $mem[$i]['un_4'] = $mem[$i]['un_4'] + $free_dead_4;
			        $mem[$i]['un_5'] = $mem[$i]['un_5'] + $free_dead_5;
			        $mem[$i]['un_6'] = $mem[$i]['un_6'] + $free_dead_6;
			        $mem[$i]['un_7'] = $mem[$i]['un_7'] + $free_dead_7;
			        break;
			        }
			      $memcache->set($key,$mem,false,86400);
			      }
			     }

         echo mysql_error();
         sendMessage($countryID,"fullMessage","В вашем государстве разразилась чума!!! Она унесла <b>$pl</b>% населения!");

         printrus ("В государстве ".$a['countryName']." была чума, унесшая ".$pl."% воинов!");
         }

//Пожары
$pojar=FALSE;
$fm = ($a['forest_max']-10)*37;
if ($a['forest']>(700+$fm)){
        printrus("Государство ".$a['countryName'].":".$a['forest']." леса");
        $poj = rand(700+$fm,3000+$fm);
        if ($a['forest']>$poj)$pojar=TRUE;
        }
if ($pojar==TRUE){
        $pj = rand(20,70);
        $f_dead = round($a['forest']*$pj/100);
        mysql_query("UPDATE countries SET forest=forest-$f_dead WHERE countryID='$countryID'");
        $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['forest'] = $mem['forest'] - $f_dead;
            $memcache->set($key,$mem,false,86400);
            }

        sendMessage($countryID,"fullMessage","В вашем государстве ,бушевали пожары!!! Они уничтожили <b>$pj</b>% леса!");

        printrus("В гос-ве ".$a['countryName']." были пожары, унесшие $pj% леса!");
        }
$voting=rand(1,6);
//Приз
if (($voting==2 || $voting==3) && ($a['reggedTime']+60*60*50)>time()){
   $rnd = rand(1000,2000);
   $rnd2 = rand(200,500);
   sendMessage($countryID,"fullMessage","Получите распишитесь:): +$rnd железа, +$rnd2 учёных.");
   printrus("В гос-ве ".$a['countryName']." +$rnd железа, +$rnd2 учёных.\n");
   mysql_query("UPDATE countries SET scientists=scientists+$rnd2, iron=iron+$rnd WHERE countryID='$countryID' LIMIT 1");
   $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['scientists'] = $mem['scientists'] + $rnd2;
            $mem['iron'] = $mem['iron'] + $rnd;
            $memcache->set($key,$mem,false,86400);
            }
   }

//Случайные открытия
$all = countAllLand($countryID,TRUE);

$rnd = rand(1,100);   //Стальная арматура
if ($rnd==25 && !otkr_exists($countryID,'STLI')&& $all<=15000){
   sendMessage($countryID,"fullMessage","Ваши ученые, проторчав в секретных лабораториях целый год наконец-то сделали новое открытие - <u>стальная арматура</u>!!!");
   printrus("В гос-ве ".$a['countryName']." изобрели стальную арматуру!\n");
   mysql_query("INSERT INTO `otkrytiya` SET countryID='$countryID', otkr='STLI'");
   $key=_PREFIKS.':otkrytiya'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newo = array("countryID"=>$countryID, "otkr"=>'STLI');
      array_push($mem,$newo);
      $memcache->set($key,$mem,false,86400);
      }

   }

$rnd = rand(1,100);  //Переплавка железа
if ($rnd==25 && !otkr_exists($countryID,'PERJ')&& $all<=10000){
   sendMessage($countryID,"fullMessage","Ваши ученые, проторчав в секретных лабораториях целый год наконец-то сделали новое открытие - <u>переплавка железа</u>!!!");
   printrus("В гос-ве ".$a['countryName']." изобрели переплавку железа!\n");
   mysql_query("INSERT INTO `otkrytiya` SET countryID='$countryID', otkr='PERJ'");
   $key=_PREFIKS.':otkrytiya'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newo = array("countryID"=>$countryID, "otkr"=>'PERJ');
      array_push($mem,$newo);
      $memcache->set($key,$mem,false,86400);
      }

   }

$rnd = rand(1,100);  //Элексир долголетия
if ($rnd==25 && !otkr_exists($countryID,'DOLG')&& $all<=10000){
   sendMessage($countryID,"fullMessage","Ваши ученые, проторчав в секретных лабораториях целый год наконец-то сделали новое открытие - <u>элексир долголетия</u>!!!");
   printrus("В гос-ве ".$a['countryName']." изобрели элексир долголетия!\n");
   mysql_query("INSERT INTO `otkrytiya` SET countryID='$countryID', otkr='DOLG'");
   $key=_PREFIKS.':otkrytiya'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newo = array("countryID"=>$countryID, "otkr"=>'DOLG');
      array_push($mem,$newo);
      $memcache->set($key,$mem,false,86400);
      }

   }

$rnd = rand(1,100);  //Берсерк
if ($rnd==25 && !otkr_exists($countryID,'BERS') && $all<=10000){
   sendMessage($countryID,"fullMessage","Ваши ученые, проторчав в секретных лабораториях целый год наконец-то сделали новое открытие - <u>БЕРСЕРК</u>!!!");
   printrus("В гос-ве ".$a['countryName']." изобрели берсерк!\n");
   mysql_query("INSERT INTO `otkrytiya` SET countryID='$countryID', otkr='BERS'");
   $key=_PREFIKS.':otkrytiya'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newo = array("countryID"=>$countryID, "otkr"=>'BERS');
      array_push($mem,$newo);
      $memcache->set($key,$mem,false,86400);
      }

   }


}

 //меняем цены на рынке фермы
 mysql_query("UPDATE market_farm SET r1 = '".rand(12,30)."', r2 = '".rand(8,18)."', r3 = '".rand(500,1000)."', r4 = '".rand(110,160)."',
 r5 = '".rand(70,120)."', r6 = '".rand(250,350)."', r7 = '".rand(200,300)."' WHERE id = '1' LIMIT 1");

//Высчитывание средних рыночных цен
$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'stone'");
$a = mysql_fetch_array($r);
$avg_stone = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'iron'");
$a = mysql_fetch_array($r);
$avg_iron = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'arbor'");
$a = mysql_fetch_array($r);
$avg_arbor = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'grain'");
$a = mysql_fetch_array($r);
$avg_grain = $a['num'];

$r = mysql_query("SELECT AVG(price) as num FROM `market` WHERE what = 'oil'");
$a = mysql_fetch_array($r);
$avg_oil = $a['num'];

//Пишем в лог работ:
$open=fopen(_ROOT."/liders/market.dat","w+");
@flock ($open,LOCK_EX);
@fwrite($open,round($avg_stone,2)."\n".round($avg_iron,2)."\n".round($avg_arbor,2)."\n".round($avg_grain,2)."\n".round($avg_oil,2));
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);


echo "done!";
include_once("other_inc/footer.php");

?>
