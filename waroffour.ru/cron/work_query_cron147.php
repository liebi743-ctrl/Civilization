<?php
if ($_GET['pas'] != 't67gh52cZv')
	die('403.');

set_time_limit(0);
error_reporting(0);
define('IN_CLV',true);
//==============================================================================
//подключаем скрипты
include_once("../func/functions_clv.php");
mem_connect();
VIP_settings();
//==============================================================================
//Рабочая часть скрипта=========================================================
include_once("../other_inc/header.php");

$q="SELECT * FROM `work_query` ORDER BY `kol`";
$r=mysql_query($q);

if(!isset($_SESSION['op']) || $_SESSION['op']<time()){
$_SESSION['op']=(time()+5);

 while(($a=mysql_fetch_array($r))!==FALSE){
 $countryID=$a['countryID'];
 worksRefresh($countryID);

 $space_free=countFreeLand($countryID);
 $b=CountryInfo($countryID);
 $workers=$b['workers'];
 $money=$b["money"];
 $peopleto=$a['workers'];
 $moneyto=$a['money'];
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='working'&&$mem[$i]['what']=='grain'){
     $work = $mem[$i]['what'];
     $timeleft=$mem[$i]['finished']-time();
     $num++;
     break;
     }
   }else{
   $query="select * from `works` where countryID='$countryID' and kind='working' and what='grain' limit 1";
   $result=@MYSQL_QUERY($query);
   $work=@mysql_result($result,0,'what');
   $timeleft=@mysql_result($result,0,'finished')-date(U);
   $num++;
   }


   if($work != 'grain'){
   	 if($a['kol'] == 0){
   	 mysql_query("DELETE FROM `work_query` WHERE `countryID` = '$countryID'");
   	 }
   	 elseif($a['ost'] > 10){
   	 mysql_query("DELETE FROM `work_query` WHERE `countryID` = '$countryID'");
   	 sendMessage($countryID, "fullMessage", "Превышено допустимое кол-во остановок! Очередь на добычу зерна удалена!");
   	 }
   	 else
   	 {
   	   if($space_free<=0){
   	   mysql_query("UPDATE `work_query` SET `ost`=`ost`+'1' WHERE `countryID`='$countryID' LIMIT 1");
   	   sendMessage($countryID, "fullMessage", "В вашей стране нет свободных полей! Невозможно начать добычу зерна! Освободите землю.");
   	   }
   	   elseif($peopleto>$workers)
   	   {
   	   mysql_query("UPDATE `work_query` SET `ost`=`ost`+'1' WHERE `countryID`='$countryID' LIMIT 1");
   	   sendMessage($countryID, "fullMessage", "У вас нет заявленых $peopleto рабочих! Невозможно начать добычу зерна!");
   	   }
       elseif($moneyto>$money)
       {
       mysql_query("UPDATE `work_query` SET `ost`=`ost`+'1' WHERE `countryID`='$countryID' LIMIT 1");
   	   sendMessage($countryID, "fullMessage", "У вас нет заявленых $moneyto денег! Невозможно начать добычу зерна!");
       }
       else
       {
       //просчитываем,скока понадобится времени для работы:
       $land_taken=max(1,min($space_free,(round($moneyto/5)+1)*$peopleto));
       $grain_made=round(min(10000,$land_taken)*$b["grain_making"]/100*0.5);
       $work_time=workTime($grain_made,0,0,$grain_made,$peopleto/$vip_mining*100);

       mysql_query("UPDATE countries SET money = ($money - $moneyto), workers = ($workers-$peopleto), land = land-$land_taken WHERE countryID = '".$b['countryID']."'");

       $key1=_PREFIKS.':id'.$countryID;
         if(($b=$memcache->get($key1))!==FALSE){
         $b['money'] = $money-$moneyto;
         $b['workers'] = $workers-$peopleto;
         $b['land'] = $b['land']-$land_taken;
         $memcache->set($key1,$b,false,86400);
         }

       $quer="insert into `works` values('$countryID','working','grain',$peopleto,".date(U).",".($work_time+date(U)).", $grain_made, $land_taken)";
       $resul=@MYSQL_QUERY($quer) or (mySQLqueryERROR($quer) and die(""));
       $key2=_PREFIKS.':works'.$countryID;
         if (($mem=$memcache->get($key2))!==FALSE){
         $neww=array("countryID"=>$countryID, "kind"=>'working', "what"=>'grain', "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$grain_made, "var2"=>$land_taken);
         array_push($mem,$neww);
         $memcache->set($key2,$mem,false,86400);
         }

       mysql_query("UPDATE `work_query` SET `kol`=`kol`-'1', `ost`='0' WHERE `countryID`='$countryID' LIMIT 1");
       }
   	 }
   }
 unset($countryID);
 unset($work);
 }

}

echo "ok!";
include_once("../other_inc/footer.php");
?>