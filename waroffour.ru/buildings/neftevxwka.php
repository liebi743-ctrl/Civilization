<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;

if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;

if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();

//******************************************************************************
//проверка на наличие здания:****************************************

 build_exists_print($countryID,'neftevxwka');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Нефтевышка</u><br/>");

 is_repairing($countryID,'neftevxwka',$m);


if($is_rep==0){

 //Проверка, разрабатывается ли месторождение
 $newplace = FALSE;
 $result = returnProcess($countryID,'newplace');
 if ($result!==FALSE)$newplace=TRUE;

 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:

 if ($var1!=0){
 printrus("Осталось едениц нефти в текущем месторождении: <b>".$var2."</b><br/>\r\n");
 printrus("Последний сбор нефти был произведен: ".mkTimeStr(time()-$var1).' назад<br/>');
 }

  printrus
("<a href=\"guard.php?$ses&amp;bld=neftevxwka\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  if ($var1==0&&$newplace==FALSE){
  printrus
("<a href=\"neftevxwka.php?$ses&amp;m=newplace\">Разработать месторождение</a>
<br/>
");
}elseif($newplace==FALSE){
printrus
("<a href=\"neftevxwka.php?$ses&amp;m=oil\">Добыча нефти</a>
<br/>
");
}else{
printrus("Идет разработка месторождения... Осталось ".mkTimeStr(max(0,$result[0]['finished']-time()))."<br/>\r\n");
printrus
("<a href=\"neftevxwka.php?$ses&amp;m=break\">Прервать</a>
<br/>
");

printrus
("<a href=\"/works.php?$ses&amp;kind=newplace&amp;what=oil\">Добавить/Отозвать рабочих</a>
<br/>
");

}
  if($hits<100){
   printrus
("<a href=\"neftevxwka.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'neftevxwka',$m);
 break;

 //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//прерываем разработку:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('break'):
  if ($newplace==FALSE){
     printrus("Разработки месторождения не проводится!<br/>\r\n");
     }else{
 $people = $result[0]['peopleatwork'];
 mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'newplace'");
 if (($mem=$memcache->get(_PREFIKS.':works'.$countryID))!==FALSE){
 $newworks=array();
 for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='newplace'){
                 }else
            {
            array_push($newworks,$mem[$i]);
                    }
         }
 $memcache->set(_PREFIKS.':works'.$countryID,$newworks,false,86400);
 }
 mysql_query("UPDATE countries SET workers = workers + $people WHERE countryID = '".$b['countryID']."' LIMIT 1");
 $b['workers'] = $b['workers']+$people;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Разработка месторождения прервана! Рабочих вернулось: $people<br/>\r\n");
 }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Разработка месторождения::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('newplace'):
  if ($var1!=0||$newplace!=FALSE){
  printrus("Вы должны доработать текущее месторождение, прежде чем приступать к разработке нового!<br/>\r\n");
  }elseif(!isset($peopleto)||$peopleto<=0||!isset($moneyto)||$moneyto<=0){
   printrus ("Сколько рабочих будут разрабатывать месторождение?<br/>\r\n");
   printrus ("<form name=\"\" action=\"neftevxwka.php?$ses&amp;m=newplace\" method=\"post\">
<input format='*N' name='peopleto' /><br/>");
   printrus ("Сколько денег вы выделите на разработку?<br/>\r\n");
   printrus ("<input format='*N' name='moneyto' /><br/>");
   printrus
("<input type=\"submit\" value=\"Ok\"/>
</form>
<br/>
");
   printrus
("
<a href='neftevxwka.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto<500){
  printrus ("Нельзя выделить меньше <b>500</b> денег!<br/>\n\r");
  printrus ("Сколько денег вы выделите на разработку?<br/>\r\n");
  printrus ("<form name=\"\" action=\"neftevxwka.php?$ses&amp;m=newplace&amp;peopleto=$peopleto\" method=\"post\"/>
<input format='*N' name='moneyto' /><br/>");
  printrus
("<input type=\"submit\" value=\"Ok\"/>
<br/>
</form>
");
  }elseif($b['money']<$moneyto){
  printrus ("У вас всего <b>".$b['money']."</b> денег!<br/>\n\r");
  printrus ("Сколько денег вы выделите на разработку?<br/>\r\n");
 printrus ("<form name=\"\" action=\"neftevxwka.php?$ses&amp;m=newplace&amp;peopleto=$peopleto\" method=\"post\"/>
<input format='*N' name='moneyto' /><br/>");
  printrus
("<input type=\"submit\" value=\"Ok\"/>
<br/>
</form>
");
  }elseif($b['workers']<$peopleto){
  printrus ("У вас всего <b>".$b['workers']."</b> свободных рабочих!<br/>\n\r");
  printrus ("Сколько рабочих будет разрабатывать месторождение?<br/>\r\n");
  printrus ("<form name=\"\" action=\"neftevxwka.php?$ses&amp;m=newplace&amp;moneyto=$moneyto\" method=\"post\"/>
  <input format='*N' name='peopleto' /><br/>");
  printrus
("<input type=\"submit\" value=\"Ok\"/>
<br/>
</form>
");
  }else{
  $res_made = max(1,round($moneyto*sqrt($moneyto)/500));
  $work_time = round((3600*5)*($res_made/5000)*(1000/$peopleto));
  mysql_query("UPDATE countries SET money = money - $moneyto, workers = workers-$peopleto WHERE countryID = '".$b['countryID']."' LIMIT 1");
  $b['money'] = $b['money']-$moneyto;
  $b['workers'] = $b['workers']-$peopleto;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

  $query="insert into `works` values('$countryID','newplace','oil',$peopleto,".date(U).",".($work_time+date(U)).", $res_made, 0)";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
      $neww=array("countryID"=>$countryID, "kind"=>'newplace', "what"=>'oil', "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$res_made, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }
  printrus("Разработка месторождения займёт ".mkTimeStr($work_time).". Ёмкость месторождения будет <b>".$res_made."</b> едениц<br/>\r\n");

  //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."посылает $peopleto рабочих на разработку месторождения ($res_made). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }
  break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добыча нефти::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('oil'):

 if ($newplace==TRUE||$var1==0){
 printrus("Вы должны разработать месторождение, прежде чем собирать нефть!<br/>\r\b");
 }elseif (!isset($sure)){
 printrus("Время, прошедшее с последнего сбора: ".mkTimeStr(time()-$var1)."<br/>\r\n");
 printrus("В скважине осталось: <b>".$var2."</b> нефти<br/>\r\n");
 $can = max(0,min($var2,round(((time()-$var1)/3600)*100)));
 if ((time()-$var1)<300) $oil = round($can*($b['oil_making']/80));
 else $oil = max(1,round($can*($b['oil_making']/80)));
 if($b['improved_mine'] > 99){$oil=$oil+round($oil*20/100);}
 printrus("Вы можете собрать:".$oil." нефти.<br/>\n\r");
 printrus("Вы уверены, что хотите собрать нефть? ");
 printrus
("<a href=\"neftevxwka.php?$ses&amp;m=oil&amp;sure=ok\">Да</a>
 или
");
 printrus("<a href=\"neftevxwka.php?$ses\">нет</a><br/>\r\n");

 }else{
 $can = max(0,min($var2,round(((time()-$var1)/3600)*100)));
 if ((time()-$var1)<300)$oil = round($can*($b['oil_making']/80));
 else $oil = max(1,round($can*($b['oil_making']/80)));
 if($b['improved_mine'] > 99){$oil=$oil+round($oil*20/100);}
 $freeplace=max(0,free_place($countryID));
 if ($oil<=$freeplace){

 mysql_query("UPDATE countries SET oil = oil + $oil WHERE countryID = '".$b['countryID']."' LIMIT 1");
  $b['oil'] = $b['oil']+$oil;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
 printrus("Вы собрали <b>$oil</b> нефти<br/>\r\n");
 if ($can<$var2){  //Еще осталась нефть в месторождении
 mysql_query("UPDATE `buildings` SET var2 = ".($var2-$can).", var1 = ".time()." WHERE countryID = '$countryID' and building = 'neftevxwka' LIMIT 1");
 $key=_PREFIKS.':buildings'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='neftevxwka'){
     $mem[$i]['var1']=time();
     $mem[$i]['var2']=$mem[$i]['var2']-$can;
     break;
     }
 $memcache->set($key,$mem,false,86400);
 }
 printrus("В месторождении осталось <b>".($var2-$can)."</b> едениц.<br/>\r\n");
 }else{  //Месторождение полностью выработано
 mysql_query("UPDATE `buildings` SET var2 = 0, var1 = 0 WHERE countryID = '$countryID' and building = 'neftevxwka' LIMIT 1");
 $key=_PREFIKS.':buildings'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='neftevxwka'){
     $mem[$i]['var1']=0;
     $mem[$i]['var2']=0;
     break;
     }
 $memcache->set($key,$mem,false,86400);
 }
 printrus("Вы полностью выработали месторождение. Разрабатывайте новое.<br/>\r\n");
 }

 }else{
 printrus("Не хватает места на складе! Освободите место.<br/>\r\n");
 }

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
