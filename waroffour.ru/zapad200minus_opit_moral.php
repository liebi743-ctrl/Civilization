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
  $voting1 = $gg['voting'];





$voting1=rand(1,5);
//Приз 2 минус
if (($voting1==1 || $voting1==2 || $voting1==3 || $voting1==4 || $voting1==5) && time()>($a['reggedTime']+720000)){


   sendMessage($countryID,"fullMessage","Вам не повезло вы на западе : ( с вас снимается аренда запада:   -10000 опыта генералу, -4 морали генералу.");
   printrus("В гос-ве ".$a['countryName']." -10000 опыта генералу, -4 морали генералу.\n");


$gen12 = mysql_fetch_array(mysql_query("SELECT * FROM general WHERE countryID='$countryID'"));

$moral1=4;
$expiriense1=10000;

$gen_mor11=$gen12['moral']-$moral1;

$gen_opit11=$gen12['expiriense']-$expiriense1;

if($gen_mor11 > 0){$moral2=$gen_mor11;}else{$moral2=0;}
if($gen_opit11 > 0){$expiriense2=$gen_opit11;}else{$expiriense2=0;}

   mysql_query("UPDATE general SET `moral`='$moral2', `expiriense`='$expiriense2' WHERE countryID='$countryID' LIMIT 1");
   //mysql_query("UPDATE general SET moral=$moral2 WHERE countryID='$countryID' LIMIT 1");
   $key=_PREFIKS.':general'.$countryID;
         if (($gen12=$memcache->get($key))!==FALSE){
            $gen12['moral'] = $moral2;
            $gen12['expiriense'] = $expiriense2;
            $memcache->set($key,$gen12,false,86400);
            }
   }



}




echo "done!";
include_once("other_inc/footer.php");

?>
