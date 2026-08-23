<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");

@include_once("other_inc/startres.php");
//5-й
 //Определяем будущий ID
 /*$query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'sysreg'.rand(0,99999999999);
 $acountryName = 'Санта  Дед мороз '.rand(0,9999999);
 $password = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:
$partner=str_replace('.', '', $_SESSION['site']);
 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, partner='".$partner."'";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(0,3);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()+2)."', nalog=1, napr=0, lastNal = '".(time()+2)."', lastWar = '".(time()+2)."', land = 10000, mountains=10000,
 forest=$forest, money=50000, arbor=10000, stone=8000, iron=3000, grain=50000, oil=100,
 workers=1000, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=50, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=1000,wariors_free_3=1500,  weapon_force=$force, weapon_force_2=$force,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed,weapon_force_2 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(200,250);
 $guard_2 = rand(250,300);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,400);
 $guard_2 = rand(400,500);
 $guard_3 = rand(500,700);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(500,2500);
 $guard_2 = rand(100,500);
 $guard_3 = rand(100,200);
 $guard_4 = rand(200,300);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(100,500);
 $guard_2 = rand(100,500);
 $guard_3 = rand(700,900);
 $guard_4 = rand(600,800);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 getNeighbours($countryID);

//конец пятого



//ботинки:
include_once("other_inc/footer.php");


?>