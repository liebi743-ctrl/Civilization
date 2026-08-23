<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['bld'])) $bld = $_REQUEST['bld'];
if ($bld!='barracks'&&$bld!='warhouse'&&$bld!='ratusha'&&$bld!='citadel'&&$bld!='keeping'&&$bld!='market'&&$bld!='university'&&$bld!='scientificcenter'&&$bld!='village'&&$bld!='wall'&&$bld!='fabrika'&&$bld!='zavod'&&$bld!='magictower'&&$bld!='gorodmagov'&&$bld!='neftevxwka'&&$bld!='altar'&&$bld!='farm'&&$bld!='necropolis'&&$bld!='dungeon') $bld='ratusha';
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
if(isset($_REQUEST['plus']))$n='plus';
if(isset($_REQUEST['minus']))$n='minus';
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
          printrus("<form name=\"\" action=\"guard.php?$ses&amp;bld=$bld\" method=\"post\">
          <input name=\"bld\" type=\"hidden\" value=\"$bld\"/>");

for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего св.:<b>".$$w_s."</b>)<br/>\r\n");
}
printrus
("<input name=\"plus\" type=\"submit\" value=\"+\"/> /
");

printrus
("<input name=\"minus\" type=\"submit\" value=\"-\"/>
");

printrus ("</form><br/>");

  }elseif(($n=='plus') && ($wariorsto+$guard+$wariorsto_2+$guard_2+$wariorsto_3+$guard_3+$wariorsto_4+$guard_4+$wariorsto_5+$guard_5+$wariorsto_6+$guard_6+$wariorsto_7+$guard_7+$wariorsto_8+$guard_8)>($space*$b["plotn_wariors"])){
   printrus ("В охране может находится только <b>".($space*$b["plotn_wariors"])."</b> военных!<br/>\r\n");
    printrus ("Охрана:<br/>".print_voisko(array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8))."\r\n");
             printrus("<form name=\"\" action=\"guard.php?$ses&amp;bld=$bld\" method=\"post\">
          <input name=\"bld\" type=\"hidden\" value=\"$bld\"/>");
for ($i=0;$i<8;$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';

if ($i!=0)$g_s='guard_'.($i+1);
else $g_s='guard';

if ($i!=0)$w_s='wariors_free_'.($i+1);
else $w_s='wariors_free';

if (($$g_s+$$w_s)>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего св.:<b>".$$w_s."</b>)<br/>\r\n");
}

printrus
("<input name=\"plus\" type=\"submit\" value=\"+\"/> /
");

printrus
("<input name=\"minus\" type=\"submit\" value=\"-\"/>
");

printrus ("</form><br/>");

   printrus
("<a href=\"guard.php?$ses&amp;bld=$bld\">Отмена</a>
<br/>
");
  }elseif($n=='plus' and ($wariorsto>$wariors_free || $wariorsto_2>$wariors_free_2 || $wariorsto_3>$wariors_free_3 || $wariorsto_4>$wariors_free_4 || $wariorsto_5>$wariors_free_5 || $wariorsto_6>$wariors_free_6 || $wariorsto_7>$wariors_free_7 || $wariorsto_8>$wariors_free_8)){
   printrus ("У вас всего:<br/>".print_voisko(array($wariors_free,$wariors_free_2,$wariors_free_3,$wariors_free_4,$wariors_free_5,$wariors_free_6,$wariors_free_7,$wariors_free_8))."\r\n");
   printrus
("<a href=\"guard.php?$ses&amp;bld=$bld&amp;n=plus&amp;wariorsto=$wariors_free&amp;wariorsto_2=$wariors_free_2&amp;wariorsto_3=$wariors_free_3&amp;wariorsto_4=$wariors_free_4&amp;wariorsto_5=$wariors_free_5&amp;wariorsto_6=$wariors_free_6&amp;wariorsto_7=$wariors_free_7&amp;wariorsto_8=$wariors_free_8\">В охрану всех!</a>
<br/>
");
   printrus
("<a href=\"guard.php?$ses&amp;bld=$bld\">Отмена</a>
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
("<a href=\"guard.php?$ses&amp;bld=$bld&amp;n=minus&amp;wariorsto=$guard&amp;wariorsto_2=$guard_2&amp;wariorsto_3=$guard_3&amp;wariorsto_4=$guard_4&amp;wariorsto_5=$guard_5&amp;wariorsto_6=$guard_6&amp;wariorsto_7=$guard_7&amp;wariorsto_8=$guard_8\">Снять всех!</a>
<br/>
");
   printrus
("<a href=\"guard.php?$ses&amp;bld=$bld\">Отмена</a>
<br/>
");
  }elseif($n=='minus' && $wariorsto==$guard && $wariorsto_2==$guard_2 && $wariorsto_3==$guard_3 && $wariorsto_4==$guard_4 && $wariorsto_5==$guard_5 && $wariorsto_6==$guard_6 && $wariorsto_7==$guard_7 && $wariorsto_8==$guard_8 && !isset($sure)){
   printrus ("Вы действительно хотите снять всю охрану со здания?<br/>\r\n");
   printrus
("<a href=\"guard.php?sure&amp;$ses&amp;bld=$bld&amp;n=minus&amp;wariorsto=$guard&amp;wariorsto_2=$guard_2&amp;wariorsto_3=$guard_3&amp;wariorsto_4=$guard_4&amp;wariorsto_5=$guard_5&amp;wariorsto_6=$guard_6&amp;wariorsto_7=$guard_7&amp;wariorsto_8=$guard_8\">Да</a>
<br/>
");
   printrus
("<a href=\"guard.php?$ses&amp;bld=$bld\">Нет</a>
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
