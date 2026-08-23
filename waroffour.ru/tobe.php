<?php

//Обработка переменных:
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['clan'])) $clan = $_REQUEST['clan'];

//==============================================================================
//подключаем скрипты, там, и еще всякая фигня:)=================================

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }


//******************************************************************************
//проверка на валидность идентификатора:****************************************

 if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = time();
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600), lastsessid = '$ses' WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u>");

  print "<br/>\r\n";
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='index.php'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 $countryID = $b['countryID'];

 $key=_PREFIKS.':clans'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $clanID = $mem;
    }else{
    $r=mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$countryID'");
    $h=mysql_fetch_array($r);
    if ($h!==FALSE)
    $clanID = $h['clanID'];
    else $clanID=0;
    }


//Обработка отказа/согласия вступления в клан

 $key=_PREFIKS.':messages'.$countryID;
 if(($mem=$memcache->get($key))!==FALSE){
 $num=0;
 for ($i=0;$i<count($mem);$i++) if($mem[$i]['message']==$clan && $mem[$i]['from']=='offerClan'){
  $num=1;
  break;
  }
     }else{
 $r = mysql_query("SELECT * FROM `messages` WHERE countryID='$countryID' and message='$clan' and `from` = 'offerClan' LIMIT 1");
 $num=mysql_num_rows($r);
 }

 if ($num==0){  //Такого предложения не поступало
    printrus("К вам не поступало предложения о вступлении в клан!<br/>\n");
    }else{

 if ($n=='agree'){ //Согласен
 mysql_query("DELETE FROM `messages` WHERE countryID='$countryID' and `from`='offerClan' and message='$clan'");
 $key=_PREFIKS.':messages'.$countryID;
 if(($mem=$memcache->get($key))!==FALSE){
 $newm=array();
 for ($i=0;$i<count($mem);$i++) if($mem[$i]['message']==$clan && $mem[$i]['from']=='offerClan'){
  }else array_push($newm,$mem[$i]);
  $memcache->set($key,$newm,false,86400);
     }
 if ($clanID!=0&&$clanID!=$clan){
    printrus("Вы уже состоите в другом клане, либо сами способны создать клан!<br/>\n");
    }elseif($clanID!=0){
    printrus("Вы уже состоите в этом клане!<br/>\n");
    }else{
    printrus("Вы вступили в клан!<br/>\n");
    //Отправляем сообщение о вступлении в клан предложившему
    $r=mysql_query("SELECT countries.countryID FROM countries,uzers,clans WHERE uzers.clanID='$clan' and uzers.userID=clans.founder and uzers.countryID = countries.countryID LIMIT 1");
    $a=mysql_fetch_array($r);
    $fid=$a[0];
    sendMessage($fid,'fullMessage',"Гос-во <u>".$b['countryName']."</u> согласилось вступить в ваш клан!");

    $clanID = $clan;
    mysql_query("UPDATE `uzers` SET clanID = '$clan' WHERE countryID='$countryID' LIMIT 1");
    $key=_PREFIKS.':clans'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       $mem=$clan;
       $memcache->set($key,$mem,false,86400);
       }

    //Пишем время вступления в клан
    mysql_query("UPDATE `countries` SET lastClan = '".time()."' WHERE countryID='$countryID' LIMIT 1");
    $b['lastClan']=time();
    if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

    }

    }else{  //Отказываемся от вступления
 mysql_query("DELETE FROM `messages` WHERE countryID='$countryID' and `from`='offerClan' and message='$clan'");
 $key=_PREFIKS.':messages'.$countryID;
 if(($mem=$memcache->get($key))!==FALSE){
 $newm=array();
 for ($i=0;$i<count($mem);$i++) if($mem[$i]['message']==$clan && $mem[$i]['from']=='offerClan'){
  }else array_push($newm,$mem[$i]);
  $memcache->set($key,$newm,false,86400);
     }
 printrus("Вы отказались от вступления в клан!<br/>\n");
 //Отправляем сообщение об отказе вступления в клан предложившему
    $r=mysql_query("SELECT countries.countryID FROM countries,uzers WHERE uzers.clanID='$clan' and uzers.countryID = countries.countryID LIMIT 1");
    $a=mysql_fetch_array($r);
    $fid=$a[0];
    sendMessage($fid,'fullMessage',"Гос-во <u>".$b['countryName']."</u> отказалось вступить в ваш клан!");

    }

    }


// printrus ("<a href='game.php?$ses'>&lt;В игру</a><br/>\n");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;Выход</a>");

//футер страницы:
include_once("other_inc/footer.php");

?>
