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
//Приз 2 минус
if (($voting==1 || $voting==2 || $voting==3 || $voting==4 || $voting==5) && time()>($a['reggedTime']+360000)){
   $rnd = rand(500,1500);
   $rnd2 = rand(100,300);
   $rnd3 = rand(5000,20000);
   $rnd4 = rand(100,300);
   $rnd5 = rand(50,150);
   $rnd6 = rand(10,100);
   sendMessage($countryID,"fullMessage","Вам не повезло этот год для вас плохой:( -895 железа, -263 учёных, -1 алмаз, -168 нефти, -10654 денег, -5 научный уровень, -233 пехотинцев, -125 кавалеристов, -675 камня.");
   printrus("В гос-ве ".$a['countryName']." -895 железа, -263 учёных, -1 алмаз, -168 нефти, -10654 денег, -5 научный уровень, -233 пехотинцев, -125 кавалеристов, -675 камня.\n");
   mysql_query("UPDATE countries SET scientists=scientists -263, iron=iron -895, stone=stone -675, oil=oil -168, money=money -10654, science=science-5, wariors_free=wariors_free -233, wariors_free_2=wariors_free_2 -125 WHERE countryID='$countryID' LIMIT 1");
   mysql_query("UPDATE uzers SET credits=credits -1 WHERE countryID='$countryID' LIMIT 1");
   $key=_PREFIKS.':id'.$countryID;
         if (($mem=$memcache->get($key))!==FALSE){
            $mem['credits'] = $mem['credits'] -1;
            $mem['science'] = $mem['science'] -5;
            $mem['iron'] = $mem['iron'] -895;
            $mem['stone'] = $mem['stone'] -675;
            $mem['scientists'] = $mem['scientists'] -263;
            $mem['money'] = $mem['money'] -10654;
            $mem['oil'] = $mem['oil'] -168;
            $mem['wariors_free'] = $mem['wariors_free'] -233;
            $mem['wariors_free_2'] = $mem['wariors_free_2'] -125;
            $memcache->set($key,$mem,false,86400);
            }
   }



}




echo "done!";
include_once("other_inc/footer.php");

?>
