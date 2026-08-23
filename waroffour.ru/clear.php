<?php

error_reporting(0);
define('IN_CLV',true);
include_once("func/functions_clv.php");


$tm = date(U);

$last = $tm-86400;
//Удаление из чата старых мессаг
mysql_query("DELETE FROM `guestbook` WHERE id<$last");
mysql_query("DELETE FROM `guestbook2` WHERE id<$last");
echo mysql_error();
echo "test";
//Удаляем из причин старые удаления стран
$last = $tm-86400*2;
mysql_query("DELETE FROM `purposes` WHERE tm<$last");
//Удаляем из блоков старые блоки стран
$last = $tm-86400*2;
mysql_query("DELETE FROM `blocks` WHERE tm<$last");
//CСнимаем игнор со всех стран
mysql_query("UPDATE `uzers` SET inv=0 WHERE inv=1");

//Удаляем старые сообщения
$last = $tm-86400; //1 суток
mysql_query("DELETE FROM `messages` WHERE tm<=$last and `from`!='loose'");

echo "done deleting from messages";
echo mysql_affected_rows();

//Удаляем погибшие страны
$last = $tm-86400*2; //2 суток
$r = mysql_query("SELECT * FROM `messages` WHERE tm<=$last and `from` = 'loose'");
while (($a=mysql_fetch_array($r))!==FALSE){
        $countryID = $a['countryID']; //ID проигравшей страны
 echo $a['countryName'];
 echo "\n\r";
 //mysql_query("delete FROM attacks WHERE attackerID = '$countryID' or countryID = '$countryID'");
 mysql_query("delete FROM buildings WHERE countryID = '$countryID'");
 mysql_query("delete FROM countries WHERE countryID = '$countryID'");

 mysql_query("delete FROM general WHERE countryID = '$countryID'");
 mysql_query("delete FROM market WHERE countryID = '$countryID'");
 mysql_query("delete FROM messages WHERE countryID = '$countryID'");
 //mysql_query("delete FROM nalog");
 mysql_query("delete FROM neighbours WHERE countryID = '$countryID' or neighbourID='$countryID'");
 mysql_query("delete FROM otkrytiya WHERE countryID = '$countryID'");
 //mysql_query("delete FROM resources");
 //mysql_query("delete FROM science");
 mysql_query("delete FROM unite WHERE countryID = '$countryID'");
 //mysql_query("delete FROM units");
 //mysql_query("delete FROM uzers");
 //mysql_query("delete FROM wallboom");
 //mysql_query("delete FROM warment");
 mysql_query("delete FROM wars WHERE countryID = '$countryID' or targetID = '$countryID'");
 mysql_query("delete FROM works WHERE countryID = '$countryID'");
        }



?>
