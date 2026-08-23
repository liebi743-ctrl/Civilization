<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['seller'])) $seller = $_REQUEST['seller'];
if (isset($_REQUEST['count'])) $count = $_REQUEST['count'];
if (isset($count)&&!is_numeric($count)) $count=0;
if (isset($count)&&$count<0) $count=0;
if (isset($_REQUEST['price'])) $price = $_REQUEST['price'];
if (isset($price)&&!is_numeric($price)) $price=0;
if (isset($price)&&$price<0) $price=0;
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg)) $pg=0;
if (!isset($pg))$pg=0;
if (isset($_REQUEST['spaceto'])) $spaceto = $_REQUEST['spaceto'];
if (isset($spaceto)&&!is_numeric($spaceto)) $spaceto=0;
if (isset($spaceto)&&$spaceto<0) $spaceto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['peopleto'])) $peopleto = $_REQUEST['peopleto'];
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;

//Максимальные и минимальные цены на ресурсы на рынке:
//(впоследствии, возможно, сделать высчитывая из средней цены на рынке)
$prices = file("../liders/market.dat");

$min_iron_price = max(6,$prices[1]-5);
$max_iron_price = max(11,$prices[1]+5);
if($max_iron_price>30)$max_iron_price=30;
//$min_stone_price = max(0.01,$prices[0]-5);
//$max_stone_price = $prices[0]+5;
$min_stone_price = max(1.8,$prices[0]-5);
$max_stone_price = max(6.8,$prices[0]+5);
if($max_stone_price>10)$max_stone_price=10;

$min_arbor_price = max(0.01,$prices[2]-5);
$max_arbor_price = $prices[2]+5;
if($max_arbor_price>0.4)$max_arbor_price=0.4;

$min_grain_price = max(0.01,$prices[3]-5);
$max_grain_price = $prices[3]+5;
if($max_grain_price>0.2)$max_grain_price=0.2;

$min_oil_price = max(12,$prices[4]-5);
$max_oil_price =  max(17,$prices[4]+5);
if($max_oil_price>60)$max_oil_price=60;

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);
 $spaceto=round( (int) $spaceto);
 //$moneyto=round( (int) $moneyto);
 $price=round( $price , 2);
 $count=round( (int) $count);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();
//worksRefresh($_SESSION['countryID']);

//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();

$sellerID=$seller;
$countryID = $_SESSION['countryID'];

//******************************************************************************
//проверка на наличие здания:****************************************

 //build_exists_print($countryID,'market');

//Считаем, а может ли страна выходить на мировой рынок:
 if (is_developed($countryID)) $whole=1;
 else $whole = 0;

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 if ($whole==0)printrus ("<u>Рынок</u><br/>\r\n");
 else printrus ("<u>Мировой рынок</u><br/>\r\n");


 $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];

 is_repairing($countryID,'market',$m);

if($is_rep==0){


 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
  printrus
("<a href=\"guard.php?$ses&amp;bld=market\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  $freeplace=free_place($countryID);
  //$r = mysql_query("SELECT space FROM `buildings` WHERE countryID = '$countryID' and building='market'");
  //$a = mysql_fetch_array($r);
  //$space = $a['space'];
  printrus ("Свободное место: <b>$freeplace</b><br/>\r\n");
  printrus
("<a href=\"test_market_.php?$ses&amp;m=space\">Территория</a>
[$space]
<br/>
");
  $iron=$b['iron'];
  $arbor=$b['arbor'];
  $grain=$b['grain'];
  $stone=$b['stone'];
  $oil=$b['oil'];
  printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=iron\">Железо</a>
[$iron]
<br/>
");
  printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=arbor\">Древесина</a>
[$arbor]
<br/>
");
  printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=grain\">Зерно</a>
[$grain]
<br/>
");
  printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=stone\">Камень</a>
[$stone]
<br/>
");
  printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=oil\">Нефть</a>
[$oil]
<br/>
");
  if($hits<100){
   printrus
("<a href=\"test_market_.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Рынок:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('market'):

 printrus ("Рынок ".get_res_name_rod($n).":<br/>\r\n");

 $key=_PREFIKS.':market'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++)if ($mem[$i]['what']==$n){
             $num=1;
             $count=$mem[$i]['count'];
             $price=$mem[$i]['price'];
             $isw=$mem[$i]['whole'];
             if ($isw!=$whole) {$mem[$i]['whole']=$whole;$memcache->set($key,$mem,false,86400);}
             break;
             }
      }else{
   $query="select * from `market` where what='$n' and countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query);
   $num=@mysql_num_rows($result);
   $count=mysql_result($result,0,'count');
   $price=mysql_result($result,0,'price');
   $isw=mysql_result($result,0,'whole');
   }

   if($num>0){
    if ($isw!=$whole)mysql_query("UPDATE `market` SET whole = '$whole' WHERE what = '$n' and countryID = '$countryID' LIMIT 1");
    printrus ("Вы продаете <b>$count</b> ".get_res_name_rod($n)." по цене: <b>$price</b> за ед.<br/>\r\n");
    printrus ("Количество:<br/>
    <form name=\"\" action=\"test_market_.php?$ses&amp;n=$n&amp;m=takeoffpart\" method=\"post\">
<input format='*N' name='count' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Снять часть\"/></form>
<br/>
");
   printrus
("<a href=\"test_market_.php?$ses&amp;m=add&amp;n=$n\">Еще на продажу</a>
<br/>
");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=takeoff&amp;n=$n\">Снять с продажи</a>
<br/>
");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=chprice&amp;n=$n\">Изменить цену</a>
<br/>
");
   }else{
    printrus
("<a href=\"test_market_.php?$ses&amp;m=sell&amp;n=$n\">Продать...</a>
<br/>
");
   }

$a=market();
$l=market2($a['price']);
/*$tst=mysql_query("select sum(count) as cnt, sum(price) as prc from market where countryID!='".$b['countryID']."' and what = '$n' and price<=".$a['price']."");
//$num=mysql_num_rows($result);
$s=mysql_fetch_array($tst);
$query="select * from market where countryID!='".$countryID."' and what='$n' and price<=".$a['price']."";
$result=MYSQL_QUERY($query);
$num=mysql_num_rows($result);*/
printrus("<i>Мин. цена на ".get_res_name_vin($n).":</i> <b>".$l['cnt']."</b> <i>ед.</i><br />
<i>Средняя цена </i> <b>".$l['price']."</b> <i>денег.</i><br />
<a href=\"test_market_.php?$ses&amp;m=buy&amp;n=$n&amp;micro\">Купить</a><br />");

//$b=market(1);
printrus("<i>Общий рынок ".get_res_name_rod($n).":</i> <b>".$a['cnt']."</b> <i>ед.</i><br />
<i>Средняя цена </i> <b>".($a['price'])."</b> <i>денег.</i><br />
<a href=\"test_market_.php?$ses&amp;m=buy&amp;n=$n\">Купить</a><br />");
 /*  if ($whole==0)$query="SELECT * FROM `market` WHERE (what='$n')and(countryID!='".$countryID."')and(countryID IN (SELECT neighbourID FROM `neighbours` WHERE countryID = '$countryID')) LIMIT $pg,10";
   else $query="SELECT * FROM `market` WHERE (what='$n')and(countryID!='".$countryID."')and (whole=1 or countryID IN (SELECT neighbourID FROM `neighbours` WHERE countryID = '$countryID')) LIMIT $pg,10";
   $result=MYSQL_QUERY($query);
   $num=mysql_num_rows($result);

$i=0;
while (($a=mysql_fetch_array($result))!==FALSE){
$i++;
$sellerID=$a['countryID'];
$seller=checkCountryID($sellerID);
$count=$a['count'];
$price=$a['price'];
if($seller){
print "-----<br/>\r\n";
printrus ("<u>$seller:</u> количество: <b>$count</b> цена: <b>$price</b> за ед.<br/>\r\n");
printrus
("<a href=\"test_market_.php?$ses&amp;m=buy&amp;n=$n&amp;seller=$sellerID\">Купить</a>
<br/>
");
   }
}


if ($i>=10){
$npg = $pg+9;
printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=$n&amp;seller=$sellerID&amp;pg=$npg\">далее...</a>
<br/>
");
}

if ($pg>0){
$npg = max(0,$pg-9);
printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=$n&amp;seller=$sellerID&amp;pg=$npg\">назад...</a>
<br/>
");
} */
break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Продажа:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('sell'):

 $r = mysql_query("SELECT count(*) as num FROM `wars` WHERE targetID = '$countryID'");
 $a = mysql_fetch_array($r);
 if ($a['num']>0) $SELL = FALSE;
 else $SELL = TRUE;
if ($SELL == FALSE){
printrus("Вы не можете ничего продавать, пока вражеские войска стоят на Вашей территории!<br/>\n");
printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=$n\">Ok</a>
<br/>
");
printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");
die("");
}


printrus ("Рынок ".get_res_name_rod($n).":<br/>\r\n");

   $key=_PREFIKS.':market'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++)if ($mem[$i]['what']==$n){
             $num=1;
             $count=$mem[$i]['count'];
             $price=$mem[$i]['price'];
             $isw=$mem[$i]['whole'];
             break;
             }
      }else{
   $query="select * from `market` where what='$n' and countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query);
   $num=@mysql_num_rows($result);
   $count=mysql_result($result,0,'count');
   $price=mysql_result($result,0,'price');
   }

   $s = 'min_'.$n.'_price';
   $min_price = $$s;
   $s = 'max_'.$n.'_price';
   $max_price = $$s;

   if($num>0){
    printrus ("Вы уже продаете <b>$count</b> ".get_res_name_rod($n)." по цене: <b>$price</b> за ед.<br/>\r\n");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=add&amp;n=$n\">Еще на продажу</a>
<br/>
");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=takeoff&amp;n=$n\">Снять с продажи</a>
<br/>
");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=chprice&amp;n=$n\">Изменить цену</a>
<br/>
");
   }elseif(empty($count) || $count<=0 || empty($price) || $price<$min_price || $price>$max_price){
    printrus ("Сколько ".get_res_name_rod($n)." вы хотите продать?<br/>\r\n");
    printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=sell&amp;n=$n\" method=\"post\">
<input format='*N' name='count' /><br/>\r\n");
    printrus("Возможная цена от <b>$min_price</b> до <b>$max_price</b> за ед.!<br/>\r\n");
    printrus ("По какой цене? (за единицу)<br/>\r\n");
    printrus ("<input name='price' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Продать\"/></form>
<br/>
");
   }elseif($b["$n"]<$count){
    printrus ("У вас только <b>".$b["$n"]."</b> ".get_res_name_rod($n)."!<br/>\r\n");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=sell&amp;n=$n&amp;count=".($b["$n"])."&amp;price=$price\">Продать все</a>
<br/>
");
   }elseif($n=='grain'&&($b["$n"]-$count<10000)){
   printrus ("В запасах должно оставаться минимум <b>10000</b> зерна!<br/>\r\n");
   printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=sell&amp;n=$n&amp;price=$price\" method=\"post\">
<input format='*N' name='count' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Продать\"/>
</form>
<br/>
");
   }else{
    mysql_query("UPDATE countries SET $n = $n - $count WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b["$n"] = $b["$n"] - $count;
    if ($id_m==TRUE){
       $memcache->set($key1,$b,false,86400);
       }

    $query="insert into `market` values('$countryID','$n',$count,$price,$whole)";
    $result=@MYSQL_QUERY($query);
    $key=_PREFIKS.':market'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       $newm = array("countryID"=>$countryID, "what"=>$n, "count"=>$count, "price"=>$price, "whole"=>$whole);
       array_push($mem,$newm);
       $memcache->set($key,$mem,false,86400);
       }

    printrus ("Теперь вы продаете <b>$count</b> ".get_res_name_rod($n)." по цене: <b>$price</b> за ед.<br/>\r\n");
   }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добавление::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('add'):

 $r = mysql_query("SELECT count(*) as num FROM `wars` WHERE targetID = '$countryID'");
 $a = mysql_fetch_array($r);
 if ($a['num']>0) $SELL = FALSE;
 else $SELL = TRUE;
 if ($SELL == FALSE){
    printrus("Вы не можете ничего добавлять, пока вражеские войска стоят на Вашей территории!<br/>\n");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=market\">Ok</a>
<br/>
");
die("");
}

printrus ("Рынок ".get_res_name_rod($n).":<br/>\r\n");

   $key=_PREFIKS.':market'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++)if ($mem[$i]['what']==$n){
             $num=1;
             $a['count']=$mem[$i]['count'];
             //$price=$mem[$i]['price'];
             //$isw=$mem[$i]['whole'];
             break;
             }
      }else{
   $query="select * from `market` where what='$n' and countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query);
   $num=@mysql_num_rows($result);
   $a = mysql_fetch_array($result);
   }

   if($num<=0){
    printrus ("Вы не продаете ".get_res_name_vin($n)."!<br/>\r\n");
   }elseif(empty($count) || $count<=0){
    printrus ("Сколько ".get_res_name_rod($n)." вы хотите еще продать?<br/>\r\n");
    printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=add&amp;n=$n\" method=\"post\">
<input format='*N' name='count' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Продать\"/>
</form>
<br/>
");
   }elseif($b["$n"]<$count){
    printrus ("У вас только <b>".$b["$n"]."</b> ".get_res_name_rod($n)."!<br/>\r\n");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=add&amp;n=$n&amp;count=".($b["$n"])."\">Продать все</a>
<br/>
");

   }elseif($n=='grain'&&($b["$n"]-$count<10000)){
   printrus ("В запасах должно оставаться минимум <b>10000</b> зерна!<br/>\r\n");
   printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=add&amp;n=$n\" method=\"post\">
<input format='*N' name='count' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Продать\"/>
</form>
<br/>
");
   }else{
    mysql_query("UPDATE countries SET $n = $n - $count WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b["$n"] = $b["$n"] - $count;
    if ($id_m==TRUE){
       $memcache->set($key1,$b,false,86400);
       }

    mysql_query("UPDATE market SET `count` = `count` + $count WHERE countryID = '".$b['countryID']."' and what = '$n'");
    $key=_PREFIKS.':market'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']==$n){
           $mem[$i]['count'] = $mem[$i]['count'] + $count;
           break;
           }
       $memcache->set($key,$mem,false,86400);
       }

    printrus ("Теперь вы продаете <b>".($a['count']+$count)."</b> ".get_res_name_rod($n).".<br/>\r\n");
   }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Меняем цену:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('chprice'):

 $r = mysql_query("SELECT count(*) as num FROM `wars` WHERE targetID = '$countryID'");
 $a = mysql_fetch_array($r);
 if ($a['num']>0) $SELL = FALSE;
 else $SELL = TRUE;
 if ($SELL == FALSE){
 printrus("Вы не можете менять цену, пока вражеские войска стоят на Вашей территории!<br/>\n");
 printrus
("<a href=\"test_market_.php?$ses&amp;m=market\">Ok</a>
<br/>
");
die("");
}

printrus ("Рынок ".get_res_name_rod($n).":<br/>\r\n");

   $key=_PREFIKS.':market'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++)if ($mem[$i]['what']==$n){
             $num=1;
             $a['price']=$mem[$i]['price'];
             //$price=$mem[$i]['price'];
             //$isw=$mem[$i]['whole'];
             break;
             }
      }else{
   $query="select * from `market` where what='$n' and countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query);
   $num=@mysql_num_rows($result);
   $a = mysql_fetch_array($result);
   }
   $s = 'min_'.$n.'_price';
   $min_price = $$s;
   $s = 'max_'.$n.'_price';
   $max_price = $$s;

   if($num<=0){
    printrus ("Вы не продаете ".get_res_name_vin($n)."!<br/>\r\n");
   }elseif(empty($price) || $price<$min_price || $price>$max_price){
    printrus("Возможная цена от <b>$min_price</b> до <b>$max_price</b> за ед.!<br/>\r\n");
    printrus ("По какой цене вы хотите продавать ".get_res_name_vin($n)." (за единицу)?<br/>\r\n");
    printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=chprice&amp;n=$n\" method=\"post\">
<input name='price' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   }else{
    mysql_query("UPDATE market SET price = $price WHERE countryID='".$b['countryID']."' and what = '$n'");
    $key=_PREFIKS.':market'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']==$n){
           $mem[$i]['price'] = $price;
           break;
           }
       $memcache->set($key,$mem,false,86400);
       }

    printrus ("Теперь вы продаете ".get_res_name_vin($n)." по цене: <b>$price</b> за ед.<br/>\r\n");
   }

 break;


 //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Убираем с продажи часть::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('takeoffpart'):

 printrus ("Рынок ".get_res_name_rod($n).":<br/>\r\n");

   $key=_PREFIKS.':market'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++)if ($mem[$i]['what']==$n){
             $num=1;
             $a['count']=$mem[$i]['count'];
             //$price=$mem[$i]['price'];
             //$isw=$mem[$i]['whole'];
             break;
             }
      }else{
   $query="select * from `market` where what='$n' and countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query);
   $num=@mysql_num_rows($result);
   $a = mysql_fetch_array($result);
   }

   if($num<=0){
    printrus ("Вы не продаете ".get_res_name_vin($n)."!<br/>\r\n");
   }elseif(!isset($count)||$count<=0){
    printrus ("Укажите целое положительное число ресурса<br/>\r\n");
   }elseif($count>=$a['count']){
   printrus("Вы можете снять с продажи только ".($count-1)." едениц ресурса!<br/>");
   }else{
    $cnt = $a['count'];
    mysql_query("UPDATE countries SET $n = $n + $count WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b["$n"] = $b["$n"] + $count;
    if ($id_m==TRUE){
       $memcache->set($key1,$b,false,86400);
       }

    $query="UPDATE `market` SET `count`=`count`-$count where what='$n' and countryID='$countryID'";
    $result=@MYSQL_QUERY($query);
    $key=_PREFIKS.':market'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']==$n){
       $mem[$i]['count'] = $mem[$i]['count'] - $count;
       break;
       }
       $memcache->set($key,$mem,false,86400);
       }

    printrus ("Теперь вы продаете ".($a['count']-$count)." ".get_res_name_rod($n).".<br/>\r\n");
   }

 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Убираем с продажи:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('takeoff'):

 printrus ("Рынок ".get_res_name_rod($n).":<br/>\r\n");

   $key=_PREFIKS.':market'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++)if ($mem[$i]['what']==$n){
             $num=1;
             $a['count']=$mem[$i]['count'];
             //$price=$mem[$i]['price'];
             //$isw=$mem[$i]['whole'];
             break;
             }
      }else{
   $query="select * from `market` where what='$n' and countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query);
   $num=@mysql_num_rows($result);
   $a = mysql_fetch_array($result);
   }

   if($num<=0){
    printrus ("Вы не продаете ".get_res_name_vin($n)."!<br/>\r\n");
   }elseif(empty($sure)){
    printrus ("Вы уверены что хотите полностью снять с продажи ".get_res_name_vin($n)."?<br/>\r\n");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=takeoff&amp;n=$n&amp;sure=sure\">Да</a>
<br/>
");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=market&amp;n=$n\">Отмена</a>
<br/>
");
   }else{
    $cnt = $a['count'];
    mysql_query("UPDATE countries SET $n = $n + $cnt WHERE countryID = '".$b['countryID']."'");
    $b["$n"] = $b["$n"] + $cnt;
    if ($id_m==TRUE){
       $memcache->set($key1,$b,false,86400);
       }

    $query="delete from `market` where what='$n' and countryID='$countryID'";
    $result=@MYSQL_QUERY($query);
    $key=_PREFIKS.':market'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       $newm=array();
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']!=$n) array_push($newm,$mem[$i]);
       $memcache->set($key,$newm,false,86400);
       }

    printrus ("Вы полностью сняли с продажи ".get_res_name_vin($n).".<br/>\r\n");
   }

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Покупаем::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('buy'):
  $frpl = free_place($countryID);

   //$j=market();
  printrus ("Рынок ".get_res_name_rod($n).":<br/>\r\n");
   //$seller=checkCountryID($sellerID);
   //ВПОСЛЕДСТВИИ МОЖЕТ НА МЕМКЕШ ПЕРЕДЕЛАТЬ????
   $a=market();
   $sss=$a['price'];
   if(isset($_REQUEST['micro'])){ $a=market2($a['price']);}
   /*if ($whole==0)$r2 = mysql_query("SELECT * FROM market WHERE countryID = '".$sellerID."' and what = '$n' and countryID IN (SELECT neighbourID FROM `neighbours` WHERE countryID = '$countryID')");
   else $r2 = mysql_query("SELECT * FROM market WHERE countryID = '".$sellerID."' and what = '$n' and (whole=1 or countryID IN (SELECT neighbourID FROM `neighbours` WHERE countryID = '$countryID')) LIMIT 1");
   $a2 = mysql_fetch_array($r2); */

   $cnt = $a['cnt'];
   $prc = $a['price'];
   if(isset($_REQUEST['micro'])){$sql="and price<='".$sss."'"; $url="&amp;micro";}
   if(empty($count) || $count<=0){
    printrus ("Сколько ".get_res_name_rod($n)." вы хотите купить?<br/>\r\n");
    printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=buy&amp;n=$n&amp;seller=$sellerID$url\" method=\"post\">
<input format='*N' name='count' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Купить\"/>
</form>
<br/>
");
   }elseif($cnt<$count){
    printrus ("На рынке продается только <b>".$cnt."</b> ".get_res_name_rod($n)."!<br/>\r\n");
    printrus
("<a href=\"test_market_.php?$ses&amp;m=buy&amp;n=$n&amp;seller=$sellerID&amp;count=".$cnt."$url\">Купить все</a>
<br/>
");

   }elseif($b["money"]<($prc*$count)){
    printrus ("У вас не хватает денег!<br/>\r\n");
    printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=buy&amp;n=$n&amp;seller=$sellerID$url\" method=\"post\">
<input format='*N' name='count' /><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Купить\"/>
</form>
<br/>
");
   }else if($frpl-$count<0){
   printrus ("У вас не хватает места на складе! (влезет только ".$frpl." ".get_res_name_rod($n).")<br/>\r\n");
    $vl = $frpl;
    printrus
("<a href=\"test_market_.php?$ses&amp;m=buy&amp;n=$n&amp;seller=$sellerID&amp;count=".$vl."$url\">Купить сколько влезет</a>
<br/>
");

   }else{
    $mmd = $prc*$count;
   mysql_query("UPDATE countries SET $n = $n + $count, money = money - $mmd WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b['money'] = $b['money'] - $mmd;
    $b["$n"] = $b["$n"] + $count;
    if ($id_m==TRUE){
       $memcache->set($key1,$b,false,86400);
       }


      $tt=floor($count/$a['prd']);
      $bay=$count-$tt*$a['prd']; //остаток
      //printrus("потратил: $mmd, купил: $count, продавцов: ".$a['prd'].", покупка по: $tt, остаток: $bay<br />");
      printrus("Вы купили $count ".get_res_name_rod($n)."! Потратили $mmd денег.<br />");
      $ss=mysql_query("select * from market where countryID!='".$b['countryID']."' and what = '$n' $sql order by count asc");
      $k=0;
      /*printrus("
      <table border=2 align=center >
      <tr>
		    <td>Номер продавца</td>
		    <td>Ск. продает</td>
		    <td>Ск. купил у него</td>
		    <td>Цена</td>
		    <td>ID продавца</td>
		  </tr>");*/
	  $nums=mysql_num_rows($ss);
      WHILE(($kh=mysql_fetch_array($ss))!==FALSE):



      if($bay>0)
      $v=$tt+1;
      else $v=$tt;
      if($kh['count']<=$v){
      	$v=$kh['count'];
        sendMessage($kh['countryID'],"fullMessage","Гос-во <u>".$b['countryName']."</u> приобрело у вас все/всю ".get_res_name_vin($n)."!");
	     $query="delete from `market` where what='$n' and countryID='".$kh['countryID']."'";
	     $result=@MYSQL_QUERY($query);
	     $key=_PREFIKS.':market'.$kh['countryID'];
	     if (($mem=$memcache->get($key))!==FALSE){
	       $newm=array();
	       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']!=$n) array_push($newm,$mem[$i]);
	       $memcache->set($key,$newm,false,86400);
	       }


           $mmd=$v*$prc;
	       mysql_query("UPDATE countries SET money = money + $mmd WHERE countryID = '".$kh['countryID']."' LIMIT 1");
	       $key=_PREFIKS.':id'.$kh['countryID'];
	       if (($mem=$memcache->get($key))!==FALSE){
	       $mem['money'] = $mem['money'] + $mmd;
	       $memcache->set($key,$mem,false,86400);
	       }
	       unset($mmd);


      	$tt=floor(($count-$k-$v)/($nums-1));
        $bay=(($count-$k-$v)-$tt*($nums-1))+1;

      }else{
      	if($v!=0){
      	sendMessage($kh['countryID'],"fullMessage","Гос-во <u>".$b['countryName']."</u> приобрело у вас <b>$v</b> ".get_res_name_rod($n).".");
	     mysql_query("UPDATE market SET `count` = `count` - $v WHERE countryID='".$kh['countryID']."' and what = '$n'");
	     $key=_PREFIKS.':market'.$kh['countryID'];
	     if (($mem=$memcache->get($key))!==FALSE){
	       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']==$n){
	           $mem[$i]['count'] = $mem[$i]['count'] - $v;
	           break;
	           }
	       $memcache->set($key,$mem,false,86400);
	       }
	       $mmd=$v*$prc;
	       mysql_query("UPDATE countries SET money = money + $mmd WHERE countryID = '".$kh['countryID']."' LIMIT 1");
	       $key=_PREFIKS.':id'.$kh['countryID'];
	       if (($mem=$memcache->get($key))!==FALSE){
	       $mem['money'] = $mem['money'] + $mmd;
	       $memcache->set($key,$mem,false,86400);
	       }
	       unset($mmd);



	        }
      }



     /* printrus("
		  <tr>
		    <td>$nums</td>
		    <td>".$kh['count']."</td>
		    <td>".($v)."</td>
		    <td>".$kh['price']."</td>
		    <td>".$kh['countryID']."</td>
		  </tr>"); */



      $k+=$v;
      $nums--;
      $bay--;
      endwhile;
     /* printrus("</table>
      Всего купили: ".$k);*/


    /*mysql_query("UPDATE countries SET money = money + $mmd WHERE countryID = '".$sellerID."' LIMIT 1");
    $key=_PREFIKS.':id'.$sellerID;
    if (($mem=$memcache->get($key))!==FALSE){
       $mem['money'] = $mem['money'] + $mmd;
       $memcache->set($key,$mem,false,86400);
       } */

   /* if(($cnt-$count)<=0){
     sendMessage($sellerID,"fullMessage","Гос-во <u>".$b['countryName']."</u> приобрело у вас все/всю ".get_res_name_vin($n)."!");
     $query="delete from `market` where what='$n' and countryID='$sellerID'";
     $result=@MYSQL_QUERY($query);
    $key=_PREFIKS.':market'.$sellerID;
    if (($mem=$memcache->get($key))!==FALSE){
       $newm=array();
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']!=$n) array_push($newm,$mem[$i]);
       $memcache->set($key,$newm,false,86400);
       }

    }else{
     sendMessage($sellerID,"fullMessage","Гос-во <u>".$b['countryName']."</u> приобрело у вас <b>$count</b> ".get_res_name_rod($n).".");
     mysql_query("UPDATE market SET `count` = `count` - $count WHERE countryID='".$sellerID."' and what = '$n'");
    $key=_PREFIKS.':market'.$sellerID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['what']==$n){
           $mem[$i]['count'] = $mem[$i]['count'] - $count;
           break;
           }
       $memcache->set($key,$mem,false,86400);
       }

     }  */
        @$open=fopen("../logs/".$countryID,"a+");
         @flock ($open,LOCK_EX);
         @fwrite($open,date("H:i j.m:").$b['countryName']." куп. $count ".get_res_name_rod($n)." по $prc\n");
         @fflush($open);
         @flock ($open,LOCK_UN);
         @fclose($open);
     /*
       @$open=fopen("../logs/".$countryID,"a+");
         @flock ($open,LOCK_EX);
         @fwrite($open,date("H:i j.m:").$b['countryName']." куп. $count ".get_res_name_rod($n)." по $prc у $seller\n");
         @fflush($open);
         @flock ($open,LOCK_UN);
         @fclose($open);
         @$open=fopen("../logs/".$sellerID,"a+");
         @flock ($open,LOCK_EX);
         @fwrite($open,date("H:i j.m:").$b['countryName']." куп. у вас $count ".get_res_name_rod($n)." по $prc\n");
         @fflush($open);
         @flock ($open,LOCK_UN);
         @fclose($open);
    printrus ("Вы купили <b>$count</b> ".get_res_name_rod($n).".<br/>\r\n");
   }
     */
     }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'market',$m);
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Изменение территории::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('space'):
  $space_free=countFreeLand($countryID);
  $place_free=free_place($countryID);

  if(empty($n)){
   printrus ("Вы хотите\r\n");
   printrus
("<a href=\"test_market_.php?$ses&amp;m=space&amp;n=plus\">увеличить</a>
");
   printrus ("или\r\n");
   printrus
("<a href=\"test_market_.php?$ses&amp;m=space&amp;n=minus\">уменьшить</a>
");
   printrus ("территорию рынка?<br/>\r\n");
   printrus
("
<a href='test_market_.php?$ses'>Отмена</a>
<br/>
");
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//прибавляем территорию^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  }elseif($n=="plus" && $space_free<=0){
   printrus ("Нет свободной земли!<br/>\r\n");
   printrus
("
<a href='test_market_.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="plus" && (empty($spaceto) or $spaceto<=0)){
   printrus ("На сколько вы хотите увеличить территорию рынка?<br/>\r\n");
   printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=space&amp;n=plus\" method=\"post\">
<input format='*N' name='spaceto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='test_market_.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=="plus" && $spaceto>$space_free){
   printrus ("У вас нет столько свободной земли! (всего <b>$space_free</b>)<br/>\r\n");
   printrus
("<a href=\"test_market_.php?$ses&amp;m=space&amp;n=plus&amp;spaceto=$space_free\">Использовать всю землю</a>
<br/>
");
   printrus
("
<a href='test_market_.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=="plus"){
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE `buildings` SET space = space + $spaceto WHERE countryID='$countryID' and building='market'");
   $key=_PREFIKS.':buildings'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='market'){
          $mem[$i]['space'] = $mem[$i]['space'] + $spaceto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Территория рынка увеличена на $spaceto!<br/>\r\n");
   printrus
("
<a href='test_market_.php?$ses'>Ок</a>
<br/>
");
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//уменьшаем территорию^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
  }elseif($n=="minus" && (empty($spaceto) or $spaceto<=0)){
   printrus ("На сколько вы хотите уменьшить территорию рынка?<br/>\r\n");
   printrus ("<form name=\"\" action=\"test_market_.php?$ses&amp;m=space&amp;n=minus\" method=\"post\">
<input format='*N' name='spaceto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='test_market_.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=="minus" && ($spaceto*100)>$place_free){
   printrus ("Вы можете уменьшить территорию только на <b>".(round($place_free/100)-1)."</b>!<br/>\r\n");
   printrus
("<a href=\"test_market_.php?$ses&amp;m=space&amp;n=minus&amp;spaceto=".(round($place_free/100)-1)."\">Уменьшить</a>
<br/>
");
   printrus
("<a href=\"test_market_.php?$ses&amp;m=space&amp;n=minus\">Отмена</a>
<br/>
");
  }elseif($n=="minus"){
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE `buildings` SET space = space - $spaceto WHERE countryID = '$countryID' and building='market'");
   $key=_PREFIKS.':buildings'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='market'){
          $mem[$i]['space'] = $mem[$i]['space'] - $spaceto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Территория рынка уменьшена на $spaceto!<br/>\r\n");

   printrus
("
<a href='test_market_.php?$ses'>Ок</a>
<br/>
");
  }

 break;

 endswitch;

}

//=============================================================================//Конец скрипту================================================================print "---<br/>\r\n";
printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");
?>
