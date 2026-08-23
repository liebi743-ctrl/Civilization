<?php
set_time_limit(0);
error_reporting(0);
define('IN_CLV',true);
//==============================================================================
//подключаем скрипты
include_once("func/functions_clv.php");
mem_connect();

//==============================================================================
//Рабочая часть скрипта=========================================================
include_once("other_inc/header.php");


$y_kogo = mysql_query("SELECT * FROM `market`");
while ($pokup_res = mysql_fetch_array($y_kogo))
{
if ($pokup_res['what'] == "arbor") {$t1='дерева'; $t2='всё дерево'; $colpr=2500;}
if ($pokup_res['what'] == "stone") {$t1='камня'; $t2='весь камень'; $colpr=250;}
if ($pokup_res['what'] == "iron") {$t1='железа'; $t2='всё железо'; $colpr=100;}
if ($pokup_res['what'] == "grain") {$t1='зерна'; $t2='всё зерно'; $colpr=2500;}
if ($pokup_res['what'] == "oil") {$t1='нефти'; $t2='всю нефть'; $colpr=100;}

//покупаем всех продаваемых рес по 10% с каждого игрока по отдельности
//$res_poc=ceil(($pokup_res['count']*10)/100);
//цена за покупаемый рес в евро бгг
//$deneg_d=$pokup_res['price']*$res_poc;

//Высчитываем скока рес покупаем если у юзера меньше
if($pokup_res['count']-$colpr<0){$colpr=$pokup_res['count'];}else{$colpr=$colpr;}

////цена за покупаемый рес в евро бгг
$deneg_d=$pokup_res['price']*$colpr;

//для проверки вывод что и как где считается

printrus ('id игрока: <b>'.$pokup_res['countryID'].'</b><br />
Количество: <b>'.$pokup_res['count'].'</b><br />
Тип: <b>'.$t1.'</b><br />
Цена за ед: <b>'.$pokup_res['price'].'</b><br />
Цена за '.$colpr.' ед: <b>'.$deneg_d.'</b><br />
Скок покупаем: <b>'.$colpr.'</b><br />---<br /><br />');

//высчитываем скока рес осталось
$ost=ceil($pokup_res['count']-$colpr);
/// если ресурса осталось больше 0
if ($ost>0){
//отправляем сообщение о покупке
sendMessage($pokup_res['countryID'],"fullMessage","<u>Бот рынка</u> приобрёл у вас <b>$colpr ед</b> $t1. Вы получили <b>$deneg_d денег</b>.");
///вычитаем рес с рынка если данный ресурс остался
mysql_query("UPDATE market SET `count` = `count` - $colpr WHERE countryID='".$pokup_res['countryID']."' and what = '".$pokup_res['what']."'");
      $key=_PREFIKS.':market'.$pokup_res['countryID'];
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']==$pokup_res['what']){
            $mem[$i]['count'] = $mem[$i]['count'] - $colpr;
            break;
            }
        $memcache->set($key,$mem,false,86400);
        }


//прибавляем бабло игроку
mysql_query("UPDATE countries SET money = money + $deneg_d WHERE countryID = '".$pokup_res['countryID']."' LIMIT 1");
        $key=_PREFIKS.':id'.$pokup_res['countryID'];
        if (($mem=$memcache->get($key))!==FALSE){
        $mem['money'] = $mem['money'] + $deneg_d;
        $memcache->set($key,$mem,false,86400);
        }
        unset($deneg_d);
//если ресурсов неосталось
}else{
//отправляем сообщение о покупке
sendMessage($pokup_res['countryID'],"fullMessage","<u>Бот рынка</u> приобрёл у вас <b>$t2</b>. <b>Вы получили $deneg_d</b>.");
//удаляем с базы тех у кого неосталось ничё на продаже
$query="delete from `market` where what='".$pokup_res['what']."' and countryID='".$pokup_res['countryID']."'";
      $result=@MYSQL_QUERY($query);
      $key=_PREFIKS.':market'.$pokup_res['countryID'];
      if (($mem=$memcache->get($key))!==FALSE){
        $newm=array();
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']!=$pokup_res['what']) array_push($newm,$mem[$i]);
        $memcache->set($key,$newm,false,86400);
        }


//прибавляем бабло игроку за ресы

        mysql_query("UPDATE countries SET money = money + $deneg_d WHERE countryID = '".$pokup_res['countryID']."' LIMIT 1");
        $key=_PREFIKS.':id'.$pokup_res['countryID'];
        if (($mem=$memcache->get($key))!==FALSE){
        $mem['money'] = $mem['money'] + $deneg_d;
        $memcache->set($key,$mem,false,86400);
        }
        unset($deneg_d);

}
}

 include_once("other_inc/footer.php");
?>