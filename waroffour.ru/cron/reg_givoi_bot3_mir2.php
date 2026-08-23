<?php
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}


set_time_limit(0);
error_reporting(0);

define('IN_CLV',true);
include_once("../func/functions_clv.php");
mem_connect();

include_once("../other_inc/header.php");

 //все параметры страны ботов, кроме науки - она всегда 100 у обоих ботов.


 //350 часов
 $land[1]=75000; $mountains[1]=20000; $forest[1]=6500; $money[1]=80000; $arbor[1]=80000; $stone[1]=16000; $iron[1]=11500; $grain[1]=300000; $oil[1]=3500; $workers[1]=6500; $scientists[1]=2000;
 $spy[1]=100; $sabotage[1]=10; $grabber[1]=90; $verb[1]=10;
 $weapon_force[1]=1; $weapon_force_2[1]=40; $weapon_force_3[1]=25; $weapon_force_4[1]=17; $weapon_force_5[1]=15; $weapon_force_6[1]=15; $weapon_force_7[1]=15;
 $weapon_speed[1]=1; $weapon_speed_2[1]=40; $weapon_speed_3[1]=25; $weapon_speed_4[1]=17; $weapon_speed_5[1]=15; $weapon_speed_6[1]=15; $weapon_speed_7[1]=15;
 $age[1]=110; $moral[1]=700; $exp[1]=900000; $study[1]=530;
 $wariorsto[1]=0; $wariorsto_2[1]=8500; $wariorsto_3[1]=3500; $wariorsto_4[1]=2000; $wariorsto_5[1]=2000; $wariorsto_6[1]=2000; $wariorsto_7[1]=1500; $wariorsto_8[1]=0;
 $ip[1]='botsysreg12'; $soft[1]='botsysreg12'; $countryName[1]='Енисейские Кыргызы '.rand(0,9999999); $reggedTime[1]=350*60*60;

//400 часов
 $land[2]=80000; $mountains[2]=20000; $forest[2]=6500; $money[2]=80000; $arbor[2]=85000; $stone[2]=16000; $iron[2]=11500; $grain[2]=300000; $oil[2]=3500; $workers[2]=6500; $scientists[2]=2000;
 $spy[2]=101; $sabotage[2]=10; $grabber[2]=90; $verb[2]=10;
 $weapon_force[2]=1; $weapon_force_2[2]=40; $weapon_force_3[2]=25; $weapon_force_4[2]=17; $weapon_force_5[2]=17; $weapon_force_6[2]=17; $weapon_force_7[2]=15;
 $weapon_speed[2]=1; $weapon_speed_2[2]=40; $weapon_speed_3[2]=25; $weapon_speed_4[2]=17; $weapon_speed_5[2]=17; $weapon_speed_6[2]=17; $weapon_speed_7[2]=15;
 $age[2]=130; $moral[2]=200; $exp[2]=110000; $study[2]=140;
 $wariorsto[2]=0; $wariorsto_2[2]=8700; $wariorsto_3[2]=3700; $wariorsto_4[2]=2200; $wariorsto_5[2]=2200; $wariorsto_6[2]=1500; $wariorsto_7[2]=1100; $wariorsto_8[2]=0;
 $ip[2]='botsysreg13'; $soft[2]='botsysreg13'; $countryName[2]='Монахи воины Шаолинь '.rand(0,9999999); $reggedTime[2]=400*60*60;

//450 часов
 $land[3]=80000; $mountains[3]=21500; $forest[3]=6500; $money[3]=90000; $arbor[3]=90000; $stone[3]=17000; $iron[3]=12000; $grain[3]=300000; $oil[3]=4000; $workers[3]=6500; $scientists[3]=2500;
 $spy[3]=101; $sabotage[3]=10; $grabber[3]=90; $verb[3]=10;
 $weapon_force[3]=1; $weapon_force_2[3]=45; $weapon_force_3[3]=25; $weapon_force_4[3]=17; $weapon_force_5[3]=20; $weapon_force_6[3]=17; $weapon_force_7[3]=15;
 $weapon_speed[3]=1; $weapon_speed_2[3]=45; $weapon_speed_3[3]=25; $weapon_speed_4[3]=17; $weapon_speed_5[3]=20; $weapon_speed_6[3]=17; $weapon_speed_7[3]=15;
 $age[3]=130; $moral[3]=700; $exp[3]=920000; $study[3]=900;
 $wariorsto[3]=0; $wariorsto_2[3]=9000; $wariorsto_3[3]=4700; $wariorsto_4[3]=5200; $wariorsto_5[3]=4200; $wariorsto_6[3]=4800; $wariorsto_7[3]=4500; $wariorsto_8[3]=0;
 $ip[3]='botsysreg14'; $soft[3]='botsysreg14'; $countryName[3]='Гунны '.rand(0,9999999); $reggedTime[3]=450*60*60;

//500 часов
 $land[4]=80000; $mountains[4]=21500; $forest[4]=6500; $money[4]=90000; $arbor[4]=95000; $stone[4]=17000; $iron[4]=12000; $grain[4]=350000; $oil[4]=4000; $workers[4]=6800; $scientists[4]=2500;
 $spy[4]=101; $sabotage[4]=10; $grabber[4]=90; $verb[4]=10;
 $weapon_force[4]=1; $weapon_force_2[4]=45; $weapon_force_3[4]=25; $weapon_force_4[4]=17; $weapon_force_5[4]=20; $weapon_force_6[4]=17; $weapon_force_7[4]=15;
 $weapon_speed[4]=1; $weapon_speed_2[4]=45; $weapon_speed_3[4]=25; $weapon_speed_4[4]=17; $weapon_speed_5[4]=20; $weapon_speed_6[4]=17; $weapon_speed_7[4]=15;
 $age[4]=130; $moral[4]=800; $exp[4]=120000; $study[4]=800;
 $wariorsto[4]=0; $wariorsto_2[4]=13000; $wariorsto_3[4]=8000; $wariorsto_4[4]=8200; $wariorsto_5[4]=8200; $wariorsto_6[4]=8000; $wariorsto_7[4]=8700; $wariorsto_8[4]=0;
 $ip[4]='botsysreg15'; $soft[4]='botsysreg15'; $countryName[4]='Русские дружинники '.rand(0,9999999); $reggedTime[4]=500*60*60;

//550 часов
 $land[5]=85000; $mountains[5]=23000; $forest[5]=7000; $money[5]=190000; $arbor[5]=100000; $stone[5]=17000; $iron[5]=12000; $grain[5]=400000; $oil[5]=4000; $workers[5]=7500; $scientists[5]=2500;
 $spy[5]=101; $sabotage[5]=10; $grabber[5]=95; $verb[5]=10;
 $weapon_force[5]=1; $weapon_force_2[5]=50; $weapon_force_3[5]=30; $weapon_force_4[5]=20; $weapon_force_5[5]=20; $weapon_force_6[5]=20; $weapon_force_7[5]=15;
 $weapon_speed[5]=1; $weapon_speed_2[5]=50; $weapon_speed_3[5]=30; $weapon_speed_4[5]=20; $weapon_speed_5[5]=20; $weapon_speed_6[5]=20; $weapon_speed_7[5]=15;
 $age[5]=130; $moral[5]=1000; $exp[5]=120000; $study[5]=1000;
 $wariorsto[5]=0; $wariorsto_2[5]=15500; $wariorsto_3[5]=14000; $wariorsto_4[5]=12200; $wariorsto_5[5]=12200; $wariorsto_6[5]=12200; $wariorsto_7[5]=12000; $wariorsto_8[5]=0;
 $ip[5]='botsysreg16'; $soft[5]='botsysreg16'; $countryName[5]='Рыцари Мальты '.rand(0,9999999); $reggedTime[5]=550*60*60;



 for($i=1;$i<6;$i++)
  {
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'botsysreg'.rand(0,99999999);
 $password1 = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password1,$username,$countryName[$i]);
 $password=md5($password1);

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '".$ip[$i]."', soft = '".$soft[$i]."', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '".$countryName[$i]."',
 reggedTime='".(time()-$reggedTime[$i])."', nalog=1, napr=0, lastNal = '".(time()-$reggedTime[$i])."', lastWar = '".(time()-$reggedTime[$i])."', land='".$land[$i]."', mountains='".$mountains[$i]."',
 forest='".$forest[$i]."', money='".$money[$i]."', arbor='".$arbor[$i]."', stone='".$stone[$i]."', iron='".$iron[$i]."', grain='".$grain[$i]."', oil='".$oil[$i]."',
 workers='".$workers[$i]."', scientists='".$scientists[$i]."', science=100, plotn_people=100, plotn_wariors=100,
 people_adding=100, forest_adding=100, grain_making=100, arbor_making=100, iron_making=100,
 stone_making=100, oil_making=100, forest_max=100, mountains_max=100, spy='".$spy[$i]."', sabotage='".$sabotage[$i]."', grabber='".$grabber[$i]."',
 verb='".$verb[$i]."', spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free = '".$wariorsto[$i]."', wariors_free_2 = '".$wariorsto_2[$i]."', wariors_free_3 = '".$wariorsto_3[$i]."', wariors_free_4 = '".$wariorsto_4[$i]."',
 wariors_free_5 = '".$wariorsto_5[$i]."', wariors_free_6 = '".$wariorsto_6[$i]."', wariors_free_7 = '".$wariorsto_7[$i]."', wariors_free_8 = '".$wariorsto_8[$i]."',
 weapon_force='".$weapon_force[$i]."', weapon_force_2='".$weapon_force_2[$i]."', weapon_force_3='".$weapon_force_3[$i]."', weapon_force_4='".$weapon_force_4[$i]."', weapon_force_5='".$weapon_force_5[$i]."',
 weapon_force_6='".$weapon_force_6[$i]."', weapon_force_7='".$weapon_force_7[$i]."', weapon_force_8=1,
 weapon_speed='".$weapon_speed[$i]."', weapon_speed_2='".$weapon_speed_2[$i]."', weapon_speed_3='".$weapon_speed_3[$i]."', weapon_speed_4='".$weapon_speed_4[$i]."', weapon_speed_5='".$weapon_speed_5[$i]."',
 weapon_speed_6='".$weapon_speed_6[$i]."', weapon_speed_7='".$weapon_speed_7[$i]."', weapon_speed_8=0,
 ip = '".$ip[$i]."', soft = '".$soft[$i]."', count=100000, protection=5, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

//здания
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'citadel', space = 60, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'zavod', space = 500, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'market', space = 35000, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'scientificcenter', space = 30, var2 = 10, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village', space = 5000, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'warhouse', space = 40, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'gorodmagov', space = 600, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'neftevxwka', space = 1000, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall', space = 300, hits = 100");

//генерал
 $query="INSERT INTO `general` VALUES ('$countryID','".$ip[$i]."','".$age[$i]."','".$moral[$i]."','".$exp[$i]."','".$study[$i]."')";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));


//Получаем соседей:
//С востока
 $query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
   and (reggedTime<".(time()-$reggedTime[$i]).") ORDER BY reggedTime DESC
   LIMIT 5";

   $result=@MYSQL_QUERY($query);
   while (($a4=mysql_fetch_array($result))!==FALSE){

    $neigh_=$a4["countryName"];
    $neighbourID=$a4["countryID"];

    setNeighbour($countryID,$neighbourID);
    sendMessage($neighbourID,"newNeighbour",$countryName[$i]);
    sendMessage($countryID,"newNeighbour",$neigh_);
   }

//С запада
 $query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
   and (reggedTime>".(time()-$reggedTime[$i]).") ORDER BY reggedTime ASC
   LIMIT 5";

   $result=@MYSQL_QUERY($query);
   while (($a4=mysql_fetch_array($result))!==FALSE){

    $neigh_=$a4["countryName"];
    $neighbourID=$a4["countryID"];

    setNeighbour($countryID,$neighbourID);
    sendMessage($neighbourID,"newNeighbour",$countryName[$i]);
    sendMessage($countryID,"newNeighbour",$neigh_);
   }

 echo ''.$ip[$i].' - login - '.$username.', pass - '.$password1.'<br />';
 }
include_once("../other_inc/footer.php");
?>