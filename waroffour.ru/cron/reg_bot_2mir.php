<?php
define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

//шапка:
@include_once("../other_inc/header.php");

@include_once("../other_inc/startres.php");










                                                        //Пустышки-соседи
 //1-ый

 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'sysreg'.rand(0,99999999999);
 $countryName = 'Затерянный мир '.rand(0,9999999);
 $password = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$countryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, vip =0, phone=0, activ_phone=0, op_activ=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(0,3);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$countryName',
 reggedTime='".(time()+1)."', nalog=1, napr=0, lastNal = '".(time()+1)."', lastWar = '".(time()+1)."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, weapon_force=$force, weapon_force_2=1,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, protection=1, unites=2, mir=2, time_mir=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(5,15);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, space = 100, hits = 100");

 getNeighbours($countryID);


 //1-ый

 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'sysreg'.rand(0,99999999999);
 $countryName = 'Пустыня Затерянный мир '.rand(0,9999999);
 $password = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$countryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, vip =0, phone=0, activ_phone=0, op_activ=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(0,3);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$countryName',
 reggedTime='".(time()+1)."', nalog=1, napr=0, lastNal = '".(time()+1)."', lastWar = '".(time()+1)."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, weapon_force=$force, weapon_force_2=1,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, protection=1, unites=2, mir=2, time_mir=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(5,15);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, space = 100, hits = 100");

 getNeighbours($countryID);




echo "done!";
include_once("../other_inc/footer.php");

?>
