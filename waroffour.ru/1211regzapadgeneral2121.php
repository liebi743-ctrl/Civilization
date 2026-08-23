<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");

@include_once("other_inc/startres.php");




                                                                          //5-й //  300 час


 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General120'.rand(100000,999999);
 $acountryName = 'General 120 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'gena120 '.rand(100000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(5,10);
 $speed = rand(6,10);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 120, expiriense = 1000, study = 100";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));



 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-1080000)."', nalog=1, napr=0, lastNal = '".(time()-1080000)."', lastWar = '".(time()-1080000)."', land = 80000, mountains=10000,
 forest=$forest, money=80000, arbor=10000, stone=8000, iron=3000, grain=50000, oil=1000,
 workers=1000, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=85, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=2000,wariors_free_3=2500,  weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(200,2500);
 $guard_2 = rand(250,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,4000);
 $guard_2 = rand(400,5000);
 $guard_3 = rand(500,7000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(100,2000);
 $guard_4 = rand(200,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,900);
 $guard_4 = rand(600,800);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);

//конец пятого




                                                                     //  250 час



 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General100'.rand(100000,99999999999);
 $acountryName = 'General 100 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena100 '.rand(100000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(4,6);
 $speed = rand(5,7);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-900000)."', nalog=1, napr=0, lastNal = '".(time()-900000)."', lastWar = '".(time()-900000)."', land = 80000, mountains=8000,
 forest=$forest, money=100000, arbor=$arbor, stone=5000, iron=3000, grain=70000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=75, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=2000,wariors_free_3=2500, weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 100, expiriense = 1000, study = 100";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(500,1000);
 $guard_2 = rand(700,1000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,2000);
 $guard_2 = rand(800,1500);
 $guard_3 = rand(500,1200);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1300);
 $guard_3 = rand(500,2000);
 $guard_4 = rand(400,1000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,500);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,2000);
 $guard_4 = rand(600,1500);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);











                                     //  200 час
  //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General70'.rand(100000,99999999999);
 $acountryName = 'General 70 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena70'.rand(100000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password = md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(4,6);
 $speed = rand(5,7);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-720000)."', nalog=1, napr=0, lastNal = '".(time()-720000)."', lastWar = '".(time()-720000)."', land = 80000, mountains=8000,
 forest=$forest, money=70000, arbor=$arbor, stone=5000, iron=3000, grain=70000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=75, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=1000,wariors_free_3=1500, weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 70, expiriense = 1000, study = 100";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(500,1000);
 $guard_2 = rand(700,1000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,2000);
 $guard_2 = rand(800,1500);
 $guard_3 = rand(500,1200);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1300);
 $guard_3 = rand(500,2000);
 $guard_4 = rand(400,1000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,500);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,2000);
 $guard_4 = rand(600,1500);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);






                            //   150 час

  //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General50'.rand(100000,99999999999);
 $acountryName = 'General 50 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena50 '.rand(100000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(4,6);
 $speed = rand(5,7);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-540000)."', nalog=1, napr=0, lastNal = '".(time()-540000)."', lastWar = '".(time()-540000)."', land = 80000, mountains=8000,
 forest=$forest, money=60000, arbor=$arbor, stone=5000, iron=3000, grain=70000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=75, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=1000,wariors_free_3=1500,weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 50, expiriense = 1000, study = 51";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(500,1000);
 $guard_2 = rand(700,1000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,2000);
 $guard_2 = rand(800,1500);
 $guard_3 = rand(500,1200);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1300);
 $guard_3 = rand(500,2000);
 $guard_4 = rand(400,1000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,500);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,2000);
 $guard_4 = rand(600,1500);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);















                                              //1-й //  300 часов  GeneralRandom


 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom300'.rand(100000,999999);
 $acountryName = 'GeneralRandom300 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom300 '.rand(100000,9999999);
 $study = rand(80,200);
 $moral = rand(80,180);
 $spy = rand(70,95);
 $expiriense = rand(60000,150000);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(7,15);
 $speed = rand(4,10);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = $moral, expiriense = $expiriense, study = $study";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));



 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-1080000)."', nalog=1, napr=0, lastNal = '".(time()-1080000)."', lastWar = '".(time()-1080000)."', land = 180000, mountains=10000,
 forest=$forest, money=80000, arbor=10000, stone=8000, iron=5000, grain=50000, oil=3000,
 workers=1000, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=$spy, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=2000,wariors_free_3=2500,  weapon_force=$force, weapon_force_2=$force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(200,2500);
 $guard_2 = rand(250,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,4000);
 $guard_2 = rand(400,5000);
 $guard_3 = rand(500,7000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(100,2000);
 $guard_4 = rand(200,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,900);
 $guard_4 = rand(600,800);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);

//конец 1-го





                                                     //2-й //  250 часов GeneralRandom



 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom250'.rand(100000,999999);
 $acountryName = 'GeneralRandom250 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom250 '.rand(100000,9999999);
 $study = rand(50,150);
 $moral = rand(50,100);
 $spy = rand(60,85);
 $expiriense = rand(40000,100000);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(7,15);
 $speed = rand(4,10);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = $moral, expiriense = $expiriense, study = $study";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));



 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-900000)."', nalog=1, napr=0, lastNal = '".(time()-900000)."', lastWar = '".(time()-900000)."', land = 80000, mountains=10000,
 forest=$forest, money=80000, arbor=10000, stone=8000, iron=3000, grain=50000, oil=2000,
 workers=1000, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=$spy, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=2000,wariors_free_3=2500,  weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(200,2500);
 $guard_2 = rand(250,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,4000);
 $guard_2 = rand(400,5000);
 $guard_3 = rand(500,7000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(100,2000);
 $guard_4 = rand(200,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,900);
 $guard_4 = rand(600,800);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);

//конец 2-го





                                               //3-й //  200 часов GeneralRandom




 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom200'.rand(100000,999999);
 $acountryName = 'GeneralRandom200 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom200 '.rand(100000,9999999);
 $study = rand(50,100);
 $moral = rand(50,80);
 $spy = rand(60,75);
 $expiriense = rand(30000,80000);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(7,15);
 $speed = rand(4,10);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = $moral, expiriense = $expiriense, study = $study";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));


 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-720000)."',nalog=1, napr=0, lastNal = '".(time()-720000)."', lastWar = '".(time()-720000)."', land = 80000, mountains=10000,
 forest=$forest, money=80000, arbor=10000, stone=8000, iron=3000, grain=50000, oil=1000,
 workers=1000, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=$spy, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=2000,wariors_free_3=2500,  weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(200,2500);
 $guard_2 = rand(250,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,4000);
 $guard_2 = rand(400,5000);
 $guard_3 = rand(500,7000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(100,2000);
 $guard_4 = rand(200,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,900);
 $guard_4 = rand(600,800);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);

//конец 3-го





                                              //4-й // 150 часов GeneralRandom



 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom150'.rand(100000,999999);
 $acountryName = 'GeneralRandom150 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom150 '.rand(100000,9999999);
 $study = rand(50,80);
 $moral = rand(50,70);
 $spy = rand(60,70);
 $expiriense = rand(20000,60000);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(5,10);
 $speed = rand(4,10);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = $moral, expiriense = $expiriense, study = $study";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));





 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-540000)."', nalog=1, napr=0, lastNal = '".(time()-540000)."', lastWar = '".(time()-540000)."', land = 70000, mountains=10000,
 forest=$forest, money=80000, arbor=10000, stone=8000, iron=3000, grain=50000, oil=1000,
 workers=1000, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=$spy, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=2000,wariors_free_3=2500,  weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(200,2500);
 $guard_2 = rand(250,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(300,4000);
 $guard_2 = rand(400,5000);
 $guard_3 = rand(500,7000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(2500,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(100,2000);
 $guard_4 = rand(200,3000);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(100,5000);
 $guard_2 = rand(500,1000);
 $guard_3 = rand(700,900);
 $guard_4 = rand(600,800);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);

//конец 4-го









//ботинки:
include_once("other_inc/footer.php");


?>