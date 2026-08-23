<?php
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}

if (isset($_REQUEST['bot'])) $bot = ceil($_REQUEST['bot']);
if (isset($bot)&&!is_numeric($bot)) $bot=0;
if (isset($bot)&&$bot<1) $bot=0;
if (!isset($bot)) $bot=0;

//по умолчанию 4 группы ботов. если надо будет больше, то меняем "$bot > 4" на нужное нам число + добавляем в условия нападения строку с новыми параметрами.
if($bot == 0 or $bot > 4) exit();

set_time_limit(0);
error_reporting(0);

define('IN_CLV',true);
include_once("../func/functions_clv.php");
mem_connect();

include_once("../other_inc/header.php");

/*--------- условия нападения ------------*/

//$bot=1 25ч
$moral[1]=array(11,15); $nasel[1]=1500; $opt[1]=1; $koff[1]=0; $spy[1]=50; $ip[1]='botsysreg1';
//$bot=2 50ч
$moral[2]=array(30,50); $nasel[2]=1500; $opt[2]=1; $koff[2]=0; $spy[2]=55; $ip[2]='botsysreg2';
//$bot=3 75ч
$moral[3]=array(50,65); $nasel[3]=4000; $opt[3]=1; $koff[3]=0; $spy[3]=65; $ip[3]='botsysreg3';
//$bot=4 100ч
$moral[4]=array(75,95); $nasel[4]=4500; $opt[4]=1000; $koff[4]=100; $spy[4]=80; $ip[4]='botsysreg4';
//$bot=5 125ч
$moral[5]=array(90,115); $nasel[5]=6000; $opt[5]=1000; $koff[5]=100; $spy[5]=85; $ip[5]='botsysreg5';
//$bot=6 150ч
$moral[6]=array(110,140); $nasel[6]=7000; $opt[6]=5000; $koff[6]=100; $spy[6]=85; $ip[6]='botsysreg6';
//$bot=7 175ч
$moral[7]=array(120,160); $nasel[7]=7500; $opt[7]=5000; $koff[7]=100; $spy[7]=90; $ip[7]='botsysreg7';
//$bot=8 200ч
$moral[8]=array(140,175); $nasel[8]=9000; $opt[8]=10000; $koff[8]=150; $spy[8]=100; $ip[8]='botsysreg8';
//$bot=9 225ч
$moral[9]=array(160,185); $nasel[9]=9000; $opt[9]=10000; $koff[9]=150; $spy[9]=100; $ip[9]='botsysreg9';
//$bot=10 250ч
$moral[10]=array(160,195); $nasel[10]=9000; $opt[10]=10000; $koff[10]=150; $spy[10]=100; $ip[10]='botsysreg10';
//$bot=11 300ч
$moral[11]=array(180,205); $nasel[11]=10000; $opt[11]=20000; $koff[11]=200; $spy[11]=100; $ip[11]='botsysreg11';
//$bot=12 350ч
$moral[12]=array(180,3007); $nasel[12]=1000; $opt[12]=20000; $koff[12]=200; $spy[12]=100; $ip[12]='botsysreg12';
//$bot=13 400ч
$moral[13]=array(180,3009); $nasel[13]=1000; $opt[13]=30000; $koff[13]=250; $spy[13]=101; $ip[13]='botsysreg13';
//$bot=14 450ч
$moral[14]=array(180,3015); $nasel[14]=1000; $opt[14]=30000; $koff[14]=250; $spy[14]=101; $ip[14]='botsysreg14';
//$bot=15 500ч
$moral[15]=array(190,3000); $nasel[15]=1000; $opt[15]=30000; $koff[15]=290; $spy[15]=101; $ip[15]='botsysreg15';
//$bot=16 550ч
$moral[16]=array(200,3000); $nasel[16]=1000; $opt[16]=40000; $koff[16]=340; $spy[16]=101; $ip[16]='botsysreg16';

if($bot == 1){$grup1=1; $grup2=2; $grup3=3; $grup4=4;}
if($bot == 2){$grup1=5; $grup2=6; $grup3=7; $grup4=8;}
if($bot == 3){$grup1=9; $grup2=10; $grup3=11; $grup4=12;}
if($bot == 4){$grup1=13; $grup2=14; $grup3=15; $grup4=16;}

$wr=1;
$query1="SELECT * FROM `countries` WHERE ip='".$ip[$grup1]."' or ip='".$ip[$grup2]."' or ip='".$ip[$grup3]."' or ip='".$ip[$grup4]."'";
$result1=@MYSQL_QUERY($query1) or (mySQLqueryERROR($query1) and die(""));
$sssCount=@mysql_num_rows($result1);
 while(($a=mysql_fetch_array($result1))!==FALSE){
 $countryID=$a[0];
 $query="select * from `messages` where `countryID`='$countryID' and `from`='loose' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $counts=@mysql_num_rows($result);
  if($counts == 0){
  $country=$a["countryName"];
  printrus ("".$country." (".$countryID.")<br />");
  $br=rand(0,1); $wr=rand(0,1);

  $sus1=CountryInfo($countryID);

  mysql_query("UPDATE countries SET bronya_kind = '$br', weapon_kind = '$wr' WHERE countryID = '$countryID' LIMIT 1");

  $sus2=CountryInfo($countryID);
  printrus ("было ".$sus1['bronya_kind']."/".$sus1['weapon_kind'].", стало ".$sus2['bronya_kind']."/".$sus2['weapon_kind']."<br />");
  // проверяем наличие соседей, сколько их всего, и.т.д
  $nids = array();
  $r = mysql_query("SELECT countryID FROM `neighbours` WHERE neighbourID = '$countryID'");
   while (($a=mysql_fetch_array($r))!==FALSE){
   array_push($neighbours,checkCountryID($a[0]));
   array_push($nids,$a[0]);
   }

 //если соседей меньше 10, то делаем шир на восток до талого, чтоб стало 10 соседей
   if($nids < 10){
   $nvs=10-$nids;
   $query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
   and (reggedTime>".$b['reggedTime'].") ORDER BY reggedTime ASC
   LIMIT ".$nvs."";
   $result=@MYSQL_QUERY($query);
     while (($a=mysql_fetch_array($result))!==FALSE){
     $neigh_=$a["countryName"];
     $neighbourID=$a["countryID"];
     setNeighbour($countryID,$neighbourID);
     sendMessage($neighbourID,"newNeighbour","$country");
     sendMessage($countryID,"newNeighbour",$neigh_);
     }
   }

   if(building_exists($countryID,'citadel')){
   printrus ("есть цита<br />");

    //воруем
    $neighbours = array();
    $nids = array();
    $key=_PREFIKS.':neighs'.$countryID;
       if (($mem=$memcache->get($key))!==FALSE){
         for ($i=0;$i<count($mem);$i++){
         array_push($nids,$mem[$i]);
         array_push($neighbours,checkCountryID($mem[$i]));
         }
       }else{
       $r = mysql_query("SELECT countryID FROM `neighbours` WHERE neighbourID = '$countryID'");
          while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($neighbours,checkCountryID($a[0]));
          array_push($nids,$a[0]);
          }
       }

    $vss=count($neighbours);
     for($f=0;$f<20;$f++){
     $ns=rand(0,$vss);
     $vvdr=UzersInfo($nids[$ns]);
     printrus ("".$f." - ".$nids[$ns]."<br />");

     $bs=CountryInfo($nids[$ns]);
     $gens=general_info($nids[$ns]);
     $querys = "SELECT (weapon_force+weapon_speed+2*weapon_force_2+2*weapon_speed_2+3*weapon_speed_3+3*weapon_force_3+4*weapon_force_4+4*weapon_speed_4+3*weapon_force_5+3*weapon_speed_5+
5*weapon_force_6+5*weapon_speed_6+6*weapon_force_7+6*weapon_speed_7+10*weapon_force_8+10*weapon_speed_8) as koef FROM `countries` WHERE countryID = '".$nids[$ns]."' LIMIT 1";
     $rs=@MYSQL_QUERY($querys) or (mySQLqueryERROR($querys) and die(""));
     $as=mysql_fetch_array($rs);
     if($gens!==FALSE and $gens['moral'] >= $moral[$bot][0] and $gens['moral'] <= $moral[$bot][1] and ($bs['workers']+$bs['scientists']) >= $nasel[$bot] and $gens['expiriense'] >= $opt[$bot] and $as['koef'] >= $koff[$bot] and $bs['spy'] >= $spy[$bot] and $vvdr['ip'] != 'botsysreg' and $vvdr['ip'] != 'sysreg'){grab($countryID,$nids[$ns]); $f=20;}
     }

   }
 //война
 $query="select targetID from `wars` where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $warCount=@mysql_num_rows($result);
 $a=array();
  while (($s=mysql_fetch_array($result))!==FALSE){
  array_push($a,$s);
  }
 $tim=10800;
 //если есть война, то пытаемся ломать здания, захватить
   if($warCount>0){
     for ($i=0;$i<count($a);$i++){
     $targetID=$a[$i]["targetID"];
     $targetNAME=checkCountryID($targetID);

     $key = _PREFIKS.':wars'.$countryID;
       if (($mem=$memcache->get($key))!==FALSE){
       $tNum=0;
            for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetID) {
            $wariors=$mem[$i]['wariors'];
            $wariors_2=$mem[$i]['wariors_2'];
            $wariors_3=$mem[$i]['wariors_3'];
            $wariors_4=$mem[$i]['wariors_4'];
            $wariors_5=$mem[$i]['wariors_5'];
            $wariors_6=$mem[$i]['wariors_6'];
            $wariors_7=$mem[$i]['wariors_7'];
            $wariors_8=$mem[$i]['wariors_8'];
            $time1=$mem[$i]['time1'];
            $time2=$mem[$i]['time2'];
            $tNum=1;
            break;
            }
       }else{
       $query="select * from `wars` where countryID='$countryID' and targetID='$targetID' LIMIT 1";
       $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
       $tNum=@mysql_num_rows($result);
       $wariors=@mysql_result($result,0,'wariors');
       $wariors_2=@mysql_result($result,0,'wariors_2');
       $wariors_3=@mysql_result($result,0,'wariors_3');
       $wariors_4=@mysql_result($result,0,'wariors_4');
       $wariors_5=@mysql_result($result,0,'wariors_5');
       $wariors_6=@mysql_result($result,0,'wariors_6');
       $wariors_7=@mysql_result($result,0,'wariors_7');
       $wariors_8=@mysql_result($result,0,'wariors_8');
       $time1=@mysql_result($result,0,'time1');
       $time2=@mysql_result($result,0,'time2');
       }

     //ломаем здания
       if(date(U)>($time1+$tim) and date(U)>($time2+2400))
       {
       //есть ли вообще здания у жертвы?
       $result=returnBuildings($targetID);
       $buildings=count($result);
         //если есть - ломаем
         if($buildings>0){
         $building=$result[0]["building"];
         mysql_query("UPDATE `wars` SET wariors = wariors - $wariorsto, wariors_2 = wariors_2 - $wariorsto_2,
         wariors_3 = wariors_3 - $wariorsto_3, wariors_4 = wariors_4 - $wariorsto_4,
         wariors_5 = wariors_5 - $wariorsto_5, wariors_6 = wariors_6 - $wariorsto_6,
         wariors_7 = wariors_7 - $wariorsto_7, wariors_8 = wariors_8 - $wariorsto_8
         WHERE countryID = '".$countryID."' and targetID = '".$targetID."' LIMIT 1");
         $key=_PREFIKS.':wars'.$countryID;
          if (($mem=$memcache->get($key))!==FALSE){
            for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetID){
            $mem[$i]['wariors'] = $mem[$i]['wariors'] - $wariorsto;
            $mem[$i]['wariors_2'] = $mem[$i]['wariors_2'] - $wariorsto_2;
            $mem[$i]['wariors_3'] = $mem[$i]['wariors_3'] - $wariorsto_3;
            $mem[$i]['wariors_4'] = $mem[$i]['wariors_4'] - $wariorsto_4;
            $mem[$i]['wariors_5'] = $mem[$i]['wariors_5'] - $wariorsto_5;
            $mem[$i]['wariors_6'] = $mem[$i]['wariors_6'] - $wariorsto_6;
            $mem[$i]['wariors_7'] = $mem[$i]['wariors_7'] - $wariorsto_7;
            $mem[$i]['wariors_8'] = $mem[$i]['wariors_8'] - $wariorsto_8;
            }
          $memcache->set($key,$mem,false,86400);
          }
         $att_wariors = array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8);
         battle_bld($countryID,$targetID,$att_wariors,$building,true);
         //Пишем в лог о битве:
		 $open=fopen("../logs/war".$countryID,"a+");
		 @flock ($open,LOCK_EX);
		 @fwrite($open,date("H:i j.m:").$a['countryName']." атаков. ".$targetNAME.", здание $bld войском $wariorsto:$wariorsto_2:$wariorsto_3:$wariorsto_4:$wariorsto_5:$wariorsto_6:$wariorsto_7:$wariorsto_8\n");
		 @fflush($open);
		 @flock ($open,LOCK_UN);
		 @fclose($open);
		 //Пишем в лог о битве жертве:
		 $open=fopen("../logs/war".$targetID,"a+");
		 @flock ($open,LOCK_EX);
		 @fwrite($open,date("H:i j.m:").$a['countryName']." атаков. ваше здание $building войском $wariorsto:$wariorsto_2:$wariorsto_3:$wariorsto_4:$wariorsto_5:$wariorsto_6:$wariorsto_7:$wariorsto_8\n");
		 @fflush($open);
		 @flock ($open,LOCK_UN);
		 @fclose($open);
		 }
       }
     //захватываем
     $tim=43200;
       if(date(U)>($time1+$tim)){
       takecountry($countryID,$targetID,array($wariors,$wariors_2,$wariors_3,$wariors_4,$wariors_5,$wariors_6,$wariors_7,$wariors_8));
       }
     }

   }
   else /*если войны нету, то нападаем на соседа, при условии что нет вторжения*/
   {
   printrus ("нету войн<br />");
   //есть ли у нас вторжения?
   $query="select countryID from `wars` where targetID='".$countryID."'";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $attCount=@mysql_num_rows($result);
   //если нет вторжений - нападаем на живого соседа (не сусрег)
     if($attCount==0){
     printrus ("вторжений у нас нет<br />");
     $neighbours = array();
     $nids = array();
     $key=_PREFIKS.':neighs'.$countryID;
       if (($mem=$memcache->get($key))!==FALSE){
         for ($i=0;$i<count($mem);$i++){
         array_push($nids,$mem[$i]);
         array_push($neighbours,checkCountryID($mem[$i]));
         }
       }else{
       $r = mysql_query("SELECT countryID FROM `neighbours` WHERE neighbourID = '$countryID'");
          while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($neighbours,checkCountryID($a[0]));
          array_push($nids,$a[0]);
          }
       }

       for($i=0;$i<count($neighbours);$i++){
       $key=_PREFIKS.':wars'.$countryID;
		 if (($mem=$memcache->get($key))!==FALSE){
		 $warCount=count($mem);
		 }else{
		 $query="select targetID from `wars` where countryID='$countryID'";
		 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
		 $warCount=@mysql_num_rows($result);
		 }

		 if($warCount==0){
         $countryName = $neighbours[$i];
         $nbr= $nids[$i];
         $us=UzersInfo($nbr);
           if($us['ip'] != 'sysreg' and $us['ip'] != 'botsysreg1' and $us['ip'] != 'botsysreg2' and $us['ip'] != 'botsysreg3' and $us['ip'] != 'botsysreg4' and $us['ip'] != 'botsysreg5' and $us['ip'] != 'botsysreg6' and $us['ip'] != 'botsysreg7' and $us['ip'] != 'botsysreg8' and $us['ip'] != 'botsysreg9' and $us['ip'] != 'botsysreg10' and $us['ip'] != 'botsysreg11' and $us['ip'] != 'botsysreg12' and $us['ip'] != 'botsysreg13' and $us['ip'] != 'botsysreg14' and $us['ip'] != 'botsysreg15' and $us['ip'] != 'botsysreg16')
           {
           printrus ("жертва не бот<br />");
           $sus=CountryInfo($countryID);
           $b=CountryInfo($nbr);
           $gen=general_info($nbr);
           $query = "SELECT (weapon_force+weapon_speed+2*weapon_force_2+2*weapon_speed_2+3*weapon_speed_3+3*weapon_force_3+4*weapon_force_4+4*weapon_speed_4+3*weapon_force_5+3*weapon_speed_5+
5*weapon_force_6+5*weapon_speed_6+6*weapon_force_7+6*weapon_speed_7+10*weapon_force_8+10*weapon_speed_8) as koef FROM `countries` WHERE countryID = '$nbr' LIMIT 1";
           $r=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
           $a=mysql_fetch_array($r);

           if($sus['ip'] == 'botsysreg'.$grup1.''){$bot2=$grup1;}
           if($sus['ip'] == 'botsysreg'.$grup2.''){$bot2=$grup2;}
           if($sus['ip'] == 'botsysreg'.$grup3.''){$bot2=$grup3;}
           if($sus['ip'] == 'botsysreg'.$grup4.''){$bot2=$grup4;}

             if($gen!==FALSE and $gen['moral'] >= $moral[$bot2][0] and $gen['moral'] <= $moral[$bot2][1] and ($b['workers']+$b['scientists']) >= $nasel[$bot2] and $gen['expiriense'] >= $opt[$bot2] and $a['koef'] >= $koff[$bot2] and $b['spy'] >= $spy[$bot2])
             {
             printrus ("подходит под условия<br />");
               if(maratory($nbr)==FALSE)
               {
               $rs = mysql_query("SELECT count(*) as num FROM `wars` WHERE targetID = '$nbr'");
               $as = mysql_fetch_array($rs);
               $defCount = $as['num'];
               printrus ("<u>кол-во вторжний: ".$defCount."</u><br />");
                 if($defCount < 3){
                 $wariorsto=$sus["wariors_free"];
			     $wariorsto_2=$sus["wariors_free_2"];
			     $wariorsto_3=$sus["wariors_free_3"];
			     $wariorsto_4=$sus["wariors_free_4"];
			     $wariorsto_5=$sus["wariors_free_5"];
			     $wariorsto_6=$sus["wariors_free_6"];
			     $wariorsto_7=$sus["wariors_free_7"];
			     $wariorsto_8=$sus["wariors_free_8"];
                   if(($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8) >= 1){
			        mysql_query("UPDATE countries SET wariors_free = wariors_free - $wariorsto,
		            wariors_free_2 = wariors_free_2 - $wariorsto_2, wariors_free_3 = wariors_free_3 - $wariorsto_3,
		            wariors_free_4 = wariors_free_4 - $wariorsto_4, wariors_free_5 = wariors_free_5 - $wariorsto_5,
		            wariors_free_6 = wariors_free_6 - $wariorsto_6, wariors_free_7 = wariors_free_7 - $wariorsto_7,
		            wariors_free_8 = wariors_free_8 - $wariorsto_8
		            WHERE countryID='$countryID' LIMIT 1");

		           $sus['wariors_free'] = $sus['wariors_free'] - $wariorsto;
		           $sus['wariors_free_2'] = $sus['wariors_free_2'] - $wariorsto_2;
		           $sus['wariors_free_3'] = $sus['wariors_free_3'] - $wariorsto_3;
		           $sus['wariors_free_4'] = $sus['wariors_free_4'] - $wariorsto_4;
		           $sus['wariors_free_5'] = $sus['wariors_free_5'] - $wariorsto_5;
		           $sus['wariors_free_6'] = $sus['wariors_free_6'] - $wariorsto_6;
		           $sus['wariors_free_7'] = $sus['wariors_free_7'] - $wariorsto_7;
		           $sus['wariors_free_8'] = $sus['wariors_free_8'] - $wariorsto_8;

			        if ($id_m==TRUE){
			        $memcache->set($key1,$sus,false,86400);
			        }
                   //Пишем в лог о битве:
			       $open=fopen("../logs/war".$countryID,"a+");
			       @flock ($open,LOCK_EX);
			       @fwrite($open,date("H:i j.m:").$sus['countryName']."(ID=".$countryID.") напала на ".$countryName." войском ".print_voisko(array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8))."\n\r");
			       @fflush($open);
			       @flock ($open,LOCK_UN);
			       @fclose($open);

                   start_war($countryID,$nbr,array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8));
                   }
                 }
               }
             }
           }
         }
       }
     }
     else /*если есть вторжение - пытаемся выбить*/
     {
     printrus ("у нас вторжение есть<br />");
     $tim_att=3600;
       while (($a=mysql_fetch_array($result))!==FALSE){
       $attackerID=$a["countryID"];
       $attackerInfo=CountryInfo($attackerID);

       $key=_PREFIKS.':wars'.$attackerInfo['countryID'];
         if (($mem=$memcache->get($key))!==FALSE){
         $tNum=0;
            for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$countryID){
            $a=$mem[$i];
            $tNum=1;
            }
         }else{
         $query="select * from `wars` where targetID='$countryID' and countryID='".$attackerInfo["countryID"]."' limit 1";
         $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
         $a = mysql_fetch_array($result);
         $tNum=mysql_num_rows($result);
         }
       $time1=$a['time1']; $time3=$a['time3'];
       //если есть вторжение и подошло время бить
         if($tNum>0 and ($time3+1800) < time() and ($time1+$tim_att) < time())
         {
         $sus=CountryInfo($countryID);
         $wariorsto=$sus["wariors_free"];
		 $wariorsto_2=$sus["wariors_free_2"];
		 $wariorsto_3=$sus["wariors_free_3"];
		 $wariorsto_4=$sus["wariors_free_4"];
		 $wariorsto_5=$sus["wariors_free_5"];
		 $wariorsto_6=$sus["wariors_free_6"];
		 $wariorsto_7=$sus["wariors_free_7"];
		 $wariorsto_8=$sus["wariors_free_8"];
         //а есть ли у нас свободная армия? если нету - игнорируем вторжение
           if(($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8) > 10)
           {
           mysql_query("UPDATE countries SET wariors_free = wariors_free - $wariorsto,
		   wariors_free_2 = wariors_free_2 - $wariorsto_2, wariors_free_3 = wariors_free_3 - $wariorsto_3,
		   wariors_free_4 = wariors_free_4 - $wariorsto_4, wariors_free_5 = wariors_free_5 - $wariorsto_5,
		   wariors_free_6 = wariors_free_6 - $wariorsto_6, wariors_free_7 = wariors_free_7 - $wariorsto_7,
		   wariors_free_8 = wariors_free_8 - $wariorsto_8
		   WHERE countryID='$countryID' LIMIT 1");
		   $sus['wariors_free'] = $sus['wariors_free'] - $wariorsto;
		   $sus['wariors_free_2'] = $sus['wariors_free_2'] - $wariorsto_2;
		   $sus['wariors_free_3'] = $sus['wariors_free_3'] - $wariorsto_3;
		   $sus['wariors_free_4'] = $sus['wariors_free_4'] - $wariorsto_4;
		   $sus['wariors_free_5'] = $sus['wariors_free_5'] - $wariorsto_5;
		   $sus['wariors_free_6'] = $sus['wariors_free_6'] - $wariorsto_6;
		   $sus['wariors_free_7'] = $sus['wariors_free_7'] - $wariorsto_7;
		   $sus['wariors_free_8'] = $sus['wariors_free_8'] - $wariorsto_8;

		     if ($id_m==TRUE){
		      $memcache->set($key1,$sus,false,86400);
		      }

		   battle_people($sus['countryID'],$attackerInfo['countryID'],array($wariorsto,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7,$wariorsto_8));
           }
         }
       }
     }
   }
 printrus ("-------------------//---------------------<br />");
  }
 }

include_once("../other_inc/footer.php");
?>