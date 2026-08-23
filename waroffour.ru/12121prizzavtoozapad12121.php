<?php


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


$query="SELECT * FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE messages.countryID IS NULL";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 while(($a=mysql_fetch_array($result))!==FALSE){
  $countryID=$a[0];
  $kk = mysql_query("SELECT voting FROM `uzers` WHERE countryID = '$countryID' LIMIT 1");
  $gg = mysql_fetch_array($kk);
  $voting = $gg['voting'];




$voting=rand(1,5);
//Приз
if (($voting==1 || $voting==2 || $voting==3 || $voting==4 || $voting==5) && time()>($a['reggedTime']+360000)){
   $rnd = rand(100,350);
   $rnd2 = rand(100,300);
   $rnd3 = rand(2000,4000);
   $rnd4 = rand(100,300);


   sendMessage($countryID,"fullMessage","Получите, запишите ) Будете должны:) +$rnd железа, +$rnd2 учёных, +1 алмаз, +$rnd4 нефти, +$rnd3 денег, +$rnd камня.");
   printrus("В гос-ве ".$a['countryName']." +$rnd железа, +$rnd2 учёных, +1 алмаз, +$rnd4 нефти, +$rnd3 денег, +$rnd камня.\n");
   mysql_query("UPDATE countries SET scientists=scientists+$rnd2, iron=iron+$rnd, stone=stone+$rnd, oil=oil+$rnd4, money=money+$rnd3 WHERE countryID='$countryID' LIMIT 1");
   mysql_query("UPDATE uzers SET credits=credits+1 WHERE countryID='$countryID' LIMIT 1");
   $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['iron'] = $mem['iron'] +$rnd;
            $mem['stone'] = $mem['stone'] +$rnd;
            $mem['scientists'] = $mem['scientists'] +$rnd2;
            $mem['money'] = $mem['money'] +$rnd3;
            $mem['oil'] = $mem['oil'] + $rnd4;


            $memcache->set($key,$mem,false,86400);
            }
   }






}




//echo "done!";
include_once("other_inc/footer.php");

?>
