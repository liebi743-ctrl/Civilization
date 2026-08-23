<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['bld'])) $bld = $_REQUEST['bld'];
if ($bld!='barracks'&&$bld!='warhouse'&&$bld!='ratusha'&&$bld!='citadel'&&$bld!='keeping'&&$bld!='market'&&$bld!='university'&&$bld!='scientificcenter'&&$bld!='village'&&$bld!='wall'&&$bld!='fabrika'&&$bld!='zavod'&&$bld!='magictower'&&$bld!='gorodmagov'&&$bld!='neftevxwka') $bld='ratusha';
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['wariorsto'])) $wariorsto = ceil($_REQUEST['wariorsto']);
if (isset($wariorsto)&&$wariorsto<0) $wariorsto=0;
if (isset($wariorsto)&&!is_numeric($wariorsto)) $wariorsto=0;
if (!isset($wariorsto))$wariorsto=0;
if (isset($_REQUEST['wariorsto_2'])) $wariorsto_2 = ceil($_REQUEST['wariorsto_2']);
if (isset($wariorsto_2)&&$wariorsto_2<0) $wariorsto_2=0;
if (isset($wariorsto_2)&&!is_numeric($wariorsto_2)) $wariorsto_2=0;
if (!isset($wariorsto_2))$wariorsto_2=0;
if (isset($_REQUEST['wariorsto_3'])) $wariorsto_3 = ceil($_REQUEST['wariorsto_3']);
if (isset($wariorsto_3)&&$wariorsto_3<0) $wariorsto_3=0;
if (isset($wariorsto_3)&&!is_numeric($wariorsto_3)) $wariorsto_3=0;
if (!isset($wariorsto_3))$wariorsto_3=0;
if (isset($_REQUEST['wariorsto_4'])) $wariorsto_4 = ceil($_REQUEST['wariorsto_4']);
if (isset($wariorsto_4)&&$wariorsto_4<0) $wariorsto_4=0;
if (isset($wariorsto_4)&&!is_numeric($wariorsto_4)) $wariorsto_4=0;
if (!isset($wariorsto_4))$wariorsto_4=0;
if (isset($_REQUEST['wariorsto_5'])) $wariorsto_5 = ceil($_REQUEST['wariorsto_5']);
if (isset($wariorsto_5)&&$wariorsto_5<0) $wariorsto_5=0;
if (isset($wariorsto_5)&&!is_numeric($wariorsto_5)) $wariorsto_5=0;
if (!isset($wariorsto_5))$wariorsto_5=0;
if (isset($_REQUEST['wariorsto_6'])) $wariorsto_6 = ceil($_REQUEST['wariorsto_6']);
if (isset($wariorsto_6)&&$wariorsto_6<0) $wariorsto_6=0;
if (isset($wariorsto_6)&&!is_numeric($wariorsto_6)) $wariorsto_6=0;
if (!isset($wariorsto_6))$wariorsto_6=0;
if (isset($_REQUEST['wariorsto_7'])) $wariorsto_7 = ceil($_REQUEST['wariorsto_7']);
if (isset($wariorsto_7)&&$wariorsto_7<0) $wariorsto_7=0;
if (isset($wariorsto_7)&&!is_numeric($wariorsto_7)) $wariorsto_7=0;
if (!isset($wariorsto_7))$wariorsto_7=0;
if (isset($_REQUEST['wariorsto_8'])) $wariorsto_8 = ceil($_REQUEST['wariorsto_8']);
if (isset($wariorsto_8)&&$wariorsto_8<0) $wariorsto_8=0;
if (isset($wariorsto_8)&&!is_numeric($wariorsto_8)) $wariorsto_8=0;
if (!isset($wariorsto_8))$wariorsto_8=0;

if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];

//==============================================================================
//подключаем скрипты

 $wariorsto=round( (int) $wariorsto);
 $wariorsto_2=round( (int) $wariorsto_2);
 $wariorsto_3=round( (int) $wariorsto_3);
 $wariorsto_4=round( (int) $wariorsto_4);
 $wariorsto_5=round( (int) $wariorsto_5);
 $wariorsto_6=round( (int) $wariorsto_6);
 $wariorsto_7=round( (int) $wariorsto_7);
 $wariorsto_8=round( (int) $wariorsto_8);

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

//******************************************************************************
//проверка на наличие здания:****************************************

 build_exists_print($countryID,$bld);


//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>".printBuilding($bld)."</u><br/>\r\n");

 $wariors_free=$b["wariors_free"];
 $wariors_free_2=$b["wariors_free_2"];
 $wariors_free_3=$b["wariors_free_3"];
 $wariors_free_4=$b["wariors_free_4"];
 $wariors_free_5=$b["wariors_free_5"];
 $wariors_free_6=$b["wariors_free_6"];
 $wariors_free_7=$b["wariors_free_7"];
 $wariors_free_8=$b["wariors_free_8"];

 is_repairing($countryID,$bld,$m);

if($is_rep==1){

 printrus("Идет ремонт здания!<br/>\n");

}else{

        if(empty($n) || ($wariorsto+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7+$wariorsto_8)<=0){
   printrus ("Охрана:<br/>".print_voisko(array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8))."\r\n");

for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0)printrus (get_unit_name($i).":<br/></small><input format='*N' name='$s' /><small>(всего св.:<b>".$$w_s."</b>)<br/>\r\n");
}

printrus
("<anchor>
+
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
<postfield name='n' value='plus'/>
");
for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0) printrus("<postfield name='$s' value='$($s)'/>");
}
printrus ("</go></anchor>/");

printrus
("<anchor>
-
<go href='guard.php?sure&amp;$ses' method='post'>
<postfield name='bld' value='$bld'/>
<postfield name='n' value='minus'/>
");
for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0) printrus("<postfield name='$s' value='$($s)'/>");
}
printrus ("</go></anchor><br/>");

  }elseif(($n=='plus') && ($wariorsto+$guard+$wariorsto_2+$guard_2+$wariorsto_3+$guard_3+$wariorsto_4+$guard_4+$wariorsto_5+$guard_5+$wariorsto_6+$guard_6+$wariorsto_7+$guard_7+$wariorsto_8+$guard_8)>($space*$b["plotn_wariors"])){
   printrus ("В охране может находится только <b>".($space*$b["plotn_wariors"])."</b> военных!<br/>\r\n");
    printrus ("Охрана:<br/>".print_voisko(array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8))."\r\n");

for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0)printrus (get_unit_name($i).":<br/></small><input format='*N' name='$s' /><small>(всего св.:<b>".$$w_s."</b>)<br/>\r\n");
}

printrus
("<anchor>
+
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
<postfield name='n' value='plus'/>
");
for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0) printrus("<postfield name='$s' value='$($s)'/>");
}
printrus ("</go></anchor>/");

printrus
("<anchor>
-
<go href='guard.php?sure&amp;$ses' method='post'>
<postfield name='bld' value='$bld'/>
<postfield name='n' value='minus'/>
");
for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0) printrus("<postfield name='$s' value='$($s)'/>");
}
printrus ("</go></anchor><br/>");

   printrus
("<anchor>
Отмена
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
</go>
</anchor>
<br/>
");
  }elseif($n=='plus' and ($wariorsto>$wariors_free || $wariorsto_2>$wariors_free_2 || $wariorsto_3>$wariors_free_3 || $wariorsto_4>$wariors_free_4 || $wariorsto_5>$wariors_free_5 || $wariorsto_6>$wariors_free_6 || $wariorsto_7>$wariors_free_7 || $wariorsto_8>$wariors_free_8)){
   printrus ("У вас всего:<br/>".print_voisko(array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8))."\r\n");
   printrus
("<anchor>
В охрану всех!
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
<postfield name='n' value='plus'/>
<postfield name='wariorsto' value='$wariors_free'/>
<postfield name='wariorsto_2' value='$wariors_free_2'/>
<postfield name='wariorsto_3' value='$wariors_free_3'/>
<postfield name='wariorsto_4' value='$wariors_free_4'/>
<postfield name='wariorsto_5' value='$wariors_free_5'/>
<postfield name='wariorsto_6' value='$wariors_free_6'/>
<postfield name='wariorsto_7' value='$wariors_free_7'/>
<postfield name='wariorsto_8' value='$wariors_free_8'/>
</go>
</anchor>
<br/>
");
   printrus
("<anchor>
Отмена
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
</go>
</anchor>
<br/>
");
  }elseif($n=='plus'){

   mysql_query("UPDATE countries SET wariors_free = ($wariors_free-$wariorsto), wariors_free_2 = ($wariors_free_2-$wariorsto_2), wariors_free_3 = ($wariors_free_3-$wariorsto_3), wariors_free_4 = ($wariors_free_4-$wariorsto_4), wariors_free_5 = ($wariors_free_5-$wariorsto_5), wariors_free_6 = ($wariors_free_6-$wariorsto_6), wariors_free_7 = ($wariors_free_7-$wariorsto_7), wariors_free_8 = ($wariors_free_8-$wariorsto_8) WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['wariors_free'] = $wariors_free - $wariorsto;
   $b['wariors_free_2'] = $wariors_free_2 - $wariorsto_2;
   $b['wariors_free_3'] = $wariors_free_3 - $wariorsto_3;
   $b['wariors_free_4'] = $wariors_free_4 - $wariorsto_4;
   $b['wariors_free_5'] = $wariors_free_5 - $wariorsto_5;
   $b['wariors_free_6'] = $wariors_free_6 - $wariorsto_6;
   $b['wariors_free_7'] = $wariors_free_7 - $wariorsto_7;
   $b['wariors_free_8'] = $wariors_free_8 - $wariorsto_8;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   mysql_query("UPDATE buildings SET guard = ($guard+$wariorsto), guard_2 = ($guard_2+$wariorsto_2), guard_3 = ($guard_3+$wariorsto_3), guard_4 = ($guard_4+$wariorsto_4), guard_5 = ($guard_5+$wariorsto_5), guard_6 = ($guard_6+$wariorsto_6), guard_7 = ($guard_7+$wariorsto_7), guard_8 = ($guard_8+$wariorsto_8) WHERE countryID = '".$b['countryID']."' and building = '$bld' LIMIT 1");
   $key=_PREFIKS.':buildings'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
          $mem[$i]['guard']=$guard+$wariorsto;
          $mem[$i]['guard_2']=$guard_2+$wariorsto_2;
          $mem[$i]['guard_3']=$guard_3+$wariorsto_3;
          $mem[$i]['guard_4']=$guard_4+$wariorsto_4;
          $mem[$i]['guard_5']=$guard_5+$wariorsto_5;
          $mem[$i]['guard_6']=$guard_6+$wariorsto_6;
          $mem[$i]['guard_7']=$guard_7+$wariorsto_7;
          $mem[$i]['guard_8']=$guard_8+$wariorsto_8;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   $str2 = build_print_vin($bld);

   printrus ("Теперь $str2 охраняют:<br/>".print_voisko(array($guard+$wariorsto,$guard_2+$wariorsto_2,$guard_3+$wariorsto_3,$guard_4+$wariorsto_4,$guard_5+$wariorsto_5,$guard_6+$wariorsto_6,$guard_7+$wariorsto_7,$guard_8+$wariorsto_8))."\r\n");

  }elseif($n=='minus' && ($wariorsto>$guard || $wariorsto_2>$guard_2 || $wariorsto_3>$guard_3 || $wariorsto_4>$guard_4 || $wariorsto_5>$guard_5 || $wariorsto_6>$guard_6 || $wariorsto_7>$guard_7 || $wariorsto_8>$guard_8)){
   printrus ("В охране здания всего:<br/>".print_voisko(array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8))."\r\n");
   printrus
("<anchor>
Снять всех!
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
<postfield name='n' value='minus'/>
<postfield name='wariorsto' value='$guard'/>
<postfield name='wariorsto_2' value='$guard_2'/>
<postfield name='wariorsto_3' value='$guard_3'/>
<postfield name='wariorsto_4' value='$guard_4'/>
<postfield name='wariorsto_5' value='$guard_5'/>
<postfield name='wariorsto_6' value='$guard_6'/>
<postfield name='wariorsto_7' value='$guard_7'/>
<postfield name='wariorsto_8' value='$guard_8'/>
</go>
</anchor>
<br/>
");
   printrus
("<anchor>
Отмена
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
</go>
</anchor>
<br/>
");
  }elseif($n=='minus' && $wariorsto==$guard && $wariorsto_2==$guard_2 && $wariorsto_3==$guard_3 && $wariorsto_4==$guard_4 && $wariorsto_5==$guard_5 && $wariorsto_6==$guard_6 && $wariorsto_7==$guard_7 && $wariorsto_8==$guard_8 && !isset($sure)){
   printrus ("Вы действительно хотите снять всю охрану со здания?<br/>\r\n");
   printrus
("<anchor>
Да
<go href='guard.php?sure&amp;$ses' method='post'>
<postfield name='bld' value='$bld'/>
<postfield name='n' value='minus'/>
<postfield name='wariorsto' value='$guard'/>
<postfield name='wariorsto_2' value='$guard_2'/>
<postfield name='wariorsto_3' value='$guard_3'/>
<postfield name='wariorsto_4' value='$guard_4'/>
<postfield name='wariorsto_5' value='$guard_5'/>
<postfield name='wariorsto_6' value='$guard_6'/>
<postfield name='wariorsto_7' value='$guard_7'/>
<postfield name='wariorsto_8' value='$guard_8'/>
</go>
</anchor>
<br/>
");
   printrus
("<anchor>
Нет
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='$bld'/>
</go>
</anchor>
<br/>
");
  }elseif($n=='minus'){

   mysql_query("UPDATE countries SET wariors_free = ($wariors_free+$wariorsto),
   wariors_free_2 = ($wariors_free_2+$wariorsto_2), wariors_free_3 = ($wariors_free_3+$wariorsto_3),
   wariors_free_4 = ($wariors_free_4+$wariorsto_4), wariors_free_5 = ($wariors_free_5+$wariorsto_5),
   wariors_free_6 = ($wariors_free_6+$wariorsto_6), wariors_free_7 = ($wariors_free_7+$wariorsto_7),
   wariors_free_8 = ($wariors_free_8+$wariorsto_8)
   WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['wariors_free'] = $wariors_free + $wariorsto;
   $b['wariors_free_2'] = $wariors_free_2 + $wariorsto_2;
   $b['wariors_free_3'] = $wariors_free_3 + $wariorsto_3;
   $b['wariors_free_4'] = $wariors_free_4 + $wariorsto_4;
   $b['wariors_free_5'] = $wariors_free_5 + $wariorsto_5;
   $b['wariors_free_6'] = $wariors_free_6 + $wariorsto_6;
   $b['wariors_free_7'] = $wariors_free_7 + $wariorsto_7;
   $b['wariors_free_8'] = $wariors_free_8 + $wariorsto_8;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
   mysql_query("UPDATE `buildings` SET guard = ($guard-$wariorsto),
   guard_2 = ($guard_2-$wariorsto_2), guard_3 = ($guard_3-$wariorsto_3),
   guard_4 = ($guard_4-$wariorsto_4), guard_5 = ($guard_5-$wariorsto_5),
   guard_6 = ($guard_6-$wariorsto_6), guard_7 = ($guard_7-$wariorsto_7),
   guard_8 = ($guard_8-$wariorsto_8)
   WHERE countryID = '".$b['countryID']."' and building = '$bld' LIMIT 1");
   $key=_PREFIKS.':buildings'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
          $mem[$i]['guard']=$guard-$wariorsto;
          $mem[$i]['guard_2']=$guard_2-$wariorsto_2;
          $mem[$i]['guard_3']=$guard_3-$wariorsto_3;
          $mem[$i]['guard_4']=$guard_4-$wariorsto_4;
          $mem[$i]['guard_5']=$guard_5-$wariorsto_5;
          $mem[$i]['guard_6']=$guard_6-$wariorsto_6;
          $mem[$i]['guard_7']=$guard_7-$wariorsto_7;
          $mem[$i]['guard_8']=$guard_8-$wariorsto_8;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }
   $str = build_print_rod($bld);
   $str2 = build_print_vin($bld);

   if(($guard-$wariorsto+$guard_2-$wariorsto_2+$guard_3-$wariorsto_3+$guard_4-$wariorsto_4+$guard_5-$wariorsto_5+$guard_6-$wariorsto_6+$guard_7-$wariorsto_7+$guard_8-$wariorsto_8)<=0){
    printrus ("Теперь в охране $str нет военных!<br/>\r\n");
   }else{
    printrus ("Теперь $str2 охраняют:<br/>".print_voisko(array($guard-$wariorsto,$guard_2-$wariorsto_2,$guard_3-$wariorsto_3,$guard_4-$wariorsto_4,$guard_5-$wariorsto_5,$guard_6-$wariorsto_6,$guard_7-$wariorsto_7,$guard_8-$wariorsto_8))."\r\n");
   }
  }

}

//==============================================================================
//Конец скрипту=================================================================
print "---<br/>\r\n";
printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("../other_inc/footer.php");

?>