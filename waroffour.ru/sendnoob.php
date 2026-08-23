<?php
@include_once("func/functions_clv.php");
$now = time();
 $query="SELECT * FROM uzers WHERE onlineFlag>$now";
 $r = mysql_query($query);
 while(($a = mysql_fetch_array($r))!==false){


 	if ($a['noob']==2){
          $z = mysql_query("SELECT count(*) as num FROM `tips`");
          $az = mysql_fetch_array($z);
          $num = rand(1,$az['num']);
          $z = mysql_query("SELECT tip FROM `tips` WHERE id='$num'");
          $az = mysql_fetch_array($z);
          sendMessage($a['countryID'],'fullMessage','<u>«наете ли вы, что:</u><br/>'.$az['tip']);
  }






 }
?>