<?php
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

//шапка:
@include_once("other_inc/header.php");

@include_once("other_inc/startres.php");











                                                             //  130 час



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
 reggedTime='".(time()-468000)."', nalog=1, napr=0, lastNal = '".(time()-468000)."', lastWar = '".(time()-468000)."', land = 80000, mountains=8000,
 forest=$forest, money=50000, arbor=$arbor, stone=5000, iron=3000, grain=70000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=75, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=1000,wariors_free_3=1500, weapon_force=$force, weapon_force_2 = $force,
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





                //  100 час
  //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General30'.rand(100000,99999999999);
 $acountryName = 'General 30 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena30 '.rand(100000,9999999);

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
 reggedTime='".(time()-360000)."', nalog=1, napr=0, lastNal = '".(time()-360000)."', lastWar = '".(time()-360000)."', land = 40000, mountains=4000,
 forest=$forest, money=50000, arbor=$arbor, stone=$stone, iron=3000, grain=70000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=70, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=1000,wariors_free_3=1500, weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 30, expiriense = 1000, study = 51";
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




                                    //   80 час


  //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General20'.rand(100000,99999999999);
 $acountryName = 'General 20 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena20'.rand(100000,9999999);

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
 reggedTime='".(time()-288000)."',  nalog=1, napr=0, lastNal = '".(time()-288000)."', lastWar = '".(time()-288000)."',  land = 30000, mountains=3000,
 forest=$forest, money=50000, arbor=$arbor, stone=3000, iron=3000, grain=50000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=65, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=1000,wariors_free_3=1500, weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 20, expiriense = 1000, study = 51";
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





                                                                      //   50 часов



  //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General10'.rand(100000,99999999999);
 $acountryName = 'General 10 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena10 '.rand(100000,9999999);

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
 reggedTime= '".(time()-180000)."', nalog=1, napr=0, lastNal = '".(time()-180000)."', lastWar = '".(time()-180000)."', land = 25000, mountains=3500,
 forest=$forest, money=50000, arbor=$arbor, stone=4000, iron=3000, grain=50000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=55, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=1000,wariors_free_3=1500, weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 10, expiriense = 1000, study = 51";
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




                           //   30 часов



  //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General9'.rand(100000,99999999999);
 $acountryName = 'General 9 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena9 '.rand(100000,9999999);

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

 $force = rand(2,4);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime= '".(time()-108000)."', nalog=1, napr=0, lastNal = '".(time()-108000)."', lastWar = '".(time()-108000)."', land = 25000, mountains=3500,
 forest=$forest, money=50000, arbor=$arbor, stone=4000, iron=3000, grain=50000, oil=1000,
 workers=1000, scientists=1000, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=55, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=1000,wariors_free_3=1500, weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 9, expiriense = 1000, study = 51";
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



                                                       //   10 часов



  //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'General5'.rand(100000,99999999999);
 $acountryName = 'General 5 '.rand(100000,9999999);
 $password = rand(1000000,9999999);
 $name = 'gena5 '.rand(100000,9999999);

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

 $force = rand(1,2);
 $speed = rand(1,2);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime= '".(time()-36000)."', nalog=1, napr=0, lastNal = '".(time()-36000)."', lastWar = '".(time()-36000)."', land = 25000, mountains=3500,
 forest=$forest, money=50000, arbor=$arbor, stone=4000, iron=3000, grain=50000, oil=100,
 workers=500, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=40, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0,wariors_free=500, wariors_free_2=1000,wariors_free_3=1500, weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = 5, expiriense = 1000, study = 51";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(5,10);
 $guard_2 = rand(7,10);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(3,20);
 $guard_2 = rand(8,15);
 $guard_3 = rand(5,12);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(25,50);
 $guard_2 = rand(5,13);
 $guard_3 = rand(5,20);
 $guard_4 = rand(4,10);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(10,50);
 $guard_2 = rand(5,10);
 $guard_3 = rand(7,20);
 $guard_4 = rand(6,15);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);










                                               //5-й //  130 часов GeneralRandom


 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom130'.rand(100000,999999);
 $acountryName = 'GeneralRandom130 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom130 '.rand(100000,9999999);
 $study = rand(50,70);
 $moral = rand(50,60);
 $spy = rand(60,65);
 $expiriense = rand(15000,50000);

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
 reggedTime='".(time()-468000)."', nalog=1, napr=0, lastNal = '".(time()-468000)."', lastWar = '".(time()-468000)."', land = 60000, mountains=8000,
 forest=$forest, money=80000, arbor=10000, stone=5000, iron=3000, grain=50000, oil=1000,
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

//конец 5-го





                                                                 //6-й // 100 часов  GeneralRandom
 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom100'.rand(100000,999999);
 $acountryName = 'GeneralRandom100 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom100 '.rand(100000,9999999);
 $study = rand(50,60);
 $moral = rand(40,50);
 $spy = rand(50,60);
 $expiriense = rand(15000,40000);

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
 reggedTime='".(time()-360000)."', nalog=1, napr=0, lastNal = '".(time()-360000)."', lastWar = '".(time()-360000)."', land = 50000, mountains=7000,
 forest=$forest, money=70000, arbor=10000, stone=5000, iron=3000, grain=50000, oil=1000,
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

//конец 6-го





                                                         //7-й // 80 часов  GeneralRandom
 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom80'.rand(100000,999999);
 $acountryName = 'GeneralRandom80 '.rand(100000,999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom80 '.rand(100000,9999999);
 $study = rand(50,55);
 $moral = rand(35,45);
 $spy = rand(50,55);
 $expiriense = rand(15000,30000);

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
 reggedTime='".(time()-288000)."',  nalog=1, napr=0, lastNal = '".(time()-288000)."',  lastWar = '".(time()-288000)."',  land = 40000, mountains=6000,
 forest=$forest, money=60000, arbor=10000, stone=4000, iron=3000, grain=50000, oil=1000,
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

//конец 7-го





                                                    //8-й // 50 часов  GeneralRandom



 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom50'.rand(1000000,99999999);
 $acountryName = 'GeneralRandom50 '.rand(1000000,99999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom50 '.rand(1000000,999999999);
 $study = rand(40,50);
 $moral = rand(30,40);
 $spy = rand(45,50);
 $expiriense = rand(15000,20000);

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

 $force = rand(4,7);
 $speed = rand(4,7);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = $moral, expiriense = $expiriense, study = $study";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));



 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()-180000)."',  nalog=1, napr=0, lastNal = '".(time()-180000)."',  lastWar = '".(time()-180000)."',  land = 30000, mountains=5000,
 forest=$forest, money=50000, arbor=10000, stone=3000, iron=3000, grain=50000, oil=1000,
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

//конец 8-го




                                                                         //9-й // 30 часов  GeneralRandom



 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom30'.rand(1000000,99999999);
 $acountryName = 'GeneralRandom30 '.rand(1000000,99999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom30 '.rand(1000000,999999999);
 $study = rand(30,40);
 $moral = rand(20,30);
 $spy = rand(35,40);
 $expiriense = rand(10000,15000);

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

 $force = rand(2,5);
 $speed = rand(2,5);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = $moral, expiriense = $expiriense, study = $study";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));



 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime= '".(time()-108000)."',  nalog=1, napr=0, lastNal = '".(time()-108000)."',  lastWar = '".(time()-108000)."',  land = 20000, mountains=4000,
 forest=$forest, money=40000, arbor=10000, stone=3000, iron=3000, grain=50000, oil=500,
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

//конец 9-го


                                                          //10-й // 10 часов  GeneralRandom



 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'GeneralRandom10'.rand(1000000,99999999);
 $acountryName = 'GeneralRandom10 '.rand(1000000,99999999);
 $password = rand(1000000,9999999);
 $name = 'GeneralRandom10 '.rand(1000000,999999999);
 $study = rand(10,30);
 $moral = rand(10,20);
 $spy = rand(35,40);
 $expiriense = rand(5000,10000);

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

 $force = rand(2,5);
 $speed = rand(2,5);
 $query="INSERT INTO `general` SET countryID = '$countryID', name = '$name',
 age=20, moral = $moral, expiriense = $expiriense, study = $study";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));



 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime= '".(time()-36000)."',  nalog=1, napr=0, lastNal = '".(time()-36000)."',  lastWar = '".(time()-36000)."',  land = 10000, mountains=4000,
 forest=$forest, money=40000, arbor=10000, stone=3000, iron=3000, grain=50000, oil=300,
 workers=1000, scientists=500, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=$spy, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free=500, wariors_free_2=2000,wariors_free_3=2500,  weapon_force=$force, weapon_force_2 = $force,
 weapon_force_3 = $force, weapon_force_4=$force, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, weapon_speed_2 = $speed, weapon_speed_3 = $speed, weapon_speed_4 = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(20,25);
 $guard_2 = rand(25,30);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 $guard = rand(30,40);
 $guard_2 = rand(40,50);
 $guard_3 = rand(50,70);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'ratusha',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, space = 100, hits = 100");
 $guard = rand(25,50);
 $guard_2 = rand(10,50);
 $guard_3 = rand(10,20);
 $guard_4 = rand(20,30);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'keeping',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 $guard = rand(10,50);
 $guard_2 = rand(10,50);
 $guard_3 = rand(70,90);
 $guard_4 = rand(60,80);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall',
 guard = $guard, guard_2 = $guard_2, guard_3 = $guard_3, guard_4 = $guard_4, space = 100, hits = 100");
 getNeighbours($countryID);

//конец 10-го






//ботинки:
include_once("other_inc/footer.php");


?>