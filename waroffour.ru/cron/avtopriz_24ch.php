<?php

set_time_limit(0);
error_reporting(0);
define('IN_CLV',true);
//==============================================================================
//подключаем скрипты
include_once("../func/functions_clv.php");
mem_connect();

//==============================================================================
//Рабочая часть скрипта=========================================================
include_once("../other_inc/header.php");


$query="SELECT * FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE ip!='' and ip!='sysreg' and messages.countryID IS NULL";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 while(($a=mysql_fetch_array($result))!==FALSE){
  $countryID=$a[0];

//Приз
   if (($a['reggedTime']+60*60*24) > time()){
   $rnd = rand(500,600);
   $rnd2 = rand(100,110);
   $rnd3 = rand(8000,10000);
   $rnd4 = rand(100,110);
   sendMessage($countryID,"fullMessage","Здравствуй уважаемый игрок,  онлайн игра Великая Империя рада видеть вас у нас в игре и дарит вам подарок :) +$rnd железа, +$rnd2 учёных,  +$rnd4 нефти, +$rnd3 денег,  +$rnd камня.");
   printrus("В гос-ве ".$a['countryName']." +$rnd железа, +$rnd2 учёных,  +$rnd4 нефти, +$rnd3 денег,  +$rnd камня.<br /><br />");
   mysql_query("UPDATE countries SET scientists=scientists+$rnd2, iron=iron+$rnd, stone=stone+$rnd, oil=oil+$rnd4, money=money+$rnd3 WHERE countryID='$countryID' LIMIT 1");

   $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['iron'] = $mem['iron'] + $rnd;
            $mem['stone'] = $mem['stone'] + $rnd;
            $mem['scientists'] = $mem['scientists'] + $rnd2;
            $mem['money'] = $mem['money'] + $rnd3;
            $mem['oil'] = $mem['oil'] + $rnd4;
            $memcache->set($key,$mem,false,86400);
            }
   }


}



//echo "done!";
include_once("../other_inc/footer.php");

?>

