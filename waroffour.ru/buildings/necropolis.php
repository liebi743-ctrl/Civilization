<?php
/*======================================================= Некрополь (уникальное здание расы - Нежити) ========================================================*/
//осталось только подключить к н.г чтоб дохли ожившие и добавить в битвы запись убитых вояк в здание.
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['d'])) $d = $_REQUEST['d'];
if (isset($_REQUEST['wariorsto_1'])) $wariorsto_1 = $_REQUEST['wariorsto_1'];
if (isset($wariorsto_1)&&!is_numeric($wariorsto_1)) $wariorsto_1=0;
if (isset($wariorsto_1)&&$wariorsto_1<0) $wariorsto_1=0;
if (!isset($wariorsto_1)) $wariorsto_1=0;
if (isset($_REQUEST['wariorsto_2'])) $wariorsto_2 = $_REQUEST['wariorsto_2'];
if (isset($wariorsto_2)&&!is_numeric($wariorsto_2)) $wariorsto_2=0;
if (isset($wariorsto_2)&&$wariorsto_2<0) $wariorsto_2=0;
if (!isset($wariorsto_2)) $wariorsto_2=0;
if (isset($_REQUEST['wariorsto_3'])) $wariorsto_3 = $_REQUEST['wariorsto_3'];
if (isset($wariorsto_3)&&!is_numeric($wariorsto_3)) $wariorsto_3=0;
if (isset($wariorsto_3)&&$wariorsto_3<0) $wariorsto_3=0;
if (!isset($wariorsto_3)) $wariorsto_3=0;
if (isset($_REQUEST['wariorsto_4'])) $wariorsto_4 = $_REQUEST['wariorsto_4'];
if (isset($wariorsto_4)&&!is_numeric($wariorsto_4)) $wariorsto_4=0;
if (isset($wariorsto_4)&&$wariorsto_4<0) $wariorsto_4=0;
if (!isset($wariorsto_4)) $wariorsto_4=0;
if (isset($_REQUEST['wariorsto_5'])) $wariorsto_5 = $_REQUEST['wariorsto_5'];
if (isset($wariorsto_5)&&!is_numeric($wariorsto_5)) $wariorsto_5=0;
if (isset($wariorsto_5)&&$wariorsto_5<0) $wariorsto_5=0;
if (!isset($wariorsto_5)) $wariorsto_5=0;
if (isset($_REQUEST['wariorsto_6'])) $wariorsto_6 = $_REQUEST['wariorsto_6'];
if (isset($wariorsto_6)&&!is_numeric($wariorsto_6)) $wariorsto_6=0;
if (isset($wariorsto_6)&&$wariorsto_6<0) $wariorsto_6=0;
if (!isset($wariorsto_6)) $wariorsto_6=0;
if (isset($_REQUEST['wariorsto_7'])) $wariorsto_7 = $_REQUEST['wariorsto_7'];
if (isset($wariorsto_7)&&!is_numeric($wariorsto_7)) $wariorsto_7=0;
if (isset($wariorsto_7)&&$wariorsto_7<0) $wariorsto_7=0;
if (!isset($wariorsto_7)) $wariorsto_7=0;
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what) && ($what!='study_wariors_2' &&$what!='study_wariors_3' &&$what!='study_wariors_4' &&$what!='study_wariors_5' &&$what!='study_wariors_6' &&$what!='study_wariors_7')) exit;
if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;
if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['minusresearch']))$m='minusresearch';
if (isset($_REQUEST['plusresearch']))$m='plusresearch';
//==============================================================================
//подключаем скрипты

$peopleto=round( (int) $peopleto);
$scientiststo=round( (int) $scientiststo);
$moneyto=round( (int) $moneyto);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];
worksRefresh($countryID);
//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();
$us=UzersInfo($countryID);

$scientists=$b['scientists'];
$money=$b['money'];
//******************************************************************************
//проверка на наличие здания:****************************************

build_exists_print($countryID,'necropolis');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

is_repairing($countryID,'necropolis',$m);

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим главную здания)::::::::::::::::::::::::::::::

default:
printrus ("<u>Некрополь</u><br/>\r\n");
printrus("<a href=\"guard.php?$ses&amp;bld=necropolis\">Охрана</a>[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]<br/>");
printrus("<a href=\"necropolis.php?$ses&amp;m=hall\">Зал мертвых</a><br/>");
printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide\">Улучшить зал мертвых</a><br/>");
if($hits<100){printrus("<a href=\"necropolis.php?$ses&amp;m=repaire\">Починить</a>(".mkWarning($hits)."%)<br/>");}

break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('repaire'):
repair($countryID,'necropolis',$m);
break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Зал мертвых:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('hall'):

printrus ("<u>Зал мертвых</u><br/>\r\n");
  if($n == 'dead')
  {
  printrus("Мертвых воинов (<b>".($un_1+$un_2+$un_3+$un_4+$un_5+$un_6+$un_7+$un_8)."</b>)<br/>");
  printrus("Пехотинцев (<b>$un_1</b>)<br/>");
  printrus("Кавалеристов (<b>$un_2</b>)<br/>");
  printrus("Стрелков (<b>$un_3</b>)<br/>");
  printrus("Пушек (<b>$un_4</b>)<br/>");
  printrus("Подрывников (<b>$un_5</b>)<br/>");
  printrus("Самолётов (<b>$un_6</b>)<br/>");
  printrus("Магов (<b>$un_7</b>)<br/>");
  if(($un_1+$un_2+$un_3+$un_4+$un_5+$un_6+$un_7+$un_8)>=1){printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Оживить</a><br/>");}
  }
  elseif($n == 'animate')
  {
    if(($time_sac+259200) > time()){
    printrus ("Оживить можно через: ".mkTimeStr(($time_sac+259200)-date(U))."!<br/>\r\n");
    printrus ("<u>Оживили войск:</u><br/>\r\n");
    printrus ("".print_voisko(array($oun_1,$oun_2,$oun_3,$oun_4,$oun_5,$oun_6,$oun_7))."");
    printrus("<a href='necropolis.php?$ses&amp;m=hall'>Назад</a><br/>");
    }elseif($wariorsto_2 >= 1 and $b['study_wariors_2'] < 100){
    printrus ("Вам пока недоступно оживление ".get_unit_name(1)."!<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_3 >= 1 and $b['study_wariors_3'] < 100){
    printrus ("Вам пока недоступно оживление ".get_unit_name(2)."!<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_4 >= 1 and $b['study_wariors_4'] < 100){
    printrus ("Вам пока недоступно оживление ".get_unit_name(3)."!<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_5 >= 1 and $b['study_wariors_5'] < 100){
    printrus ("Вам пока недоступно оживление ".get_unit_name(4)."!<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_6 >= 1 and $b['study_wariors_6'] < 100){
    printrus ("Вам пока недоступно оживление ".get_unit_name(5)."!<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_7 >= 1 and $b['study_wariors_7'] < 100){
    printrus ("Вам пока недоступно оживление ".get_unit_name(6)."!<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_1 >= 1 and $un_1 < $wariorsto_1){
    printrus ("У вас нет столько мертвых ".get_unit_name(0)."! (всего: <b>$un_1</b>)<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_2 >= 1 and $un_2 < $wariorsto_2){
    printrus ("У вас нет столько мертвых ".get_unit_name(1)."! (всего: <b>$un_2</b>)<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_3 >= 1 and $un_3 < $wariorsto_3){
    printrus ("У вас нет столько мертвых ".get_unit_name(2)."! (всего: <b>$un_3</b>)<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_4 >= 1 and $un_4 < $wariorsto_4){
    printrus ("У вас нет столько мертвых ".get_unit_name(3)."! (всего: <b>$un_4</b>)<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_5 >= 1 and $un_5 < $wariorsto_5){
    printrus ("У вас нет столько мертвых ".get_unit_name(4)."! (всего: <b>$un_5</b>)<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_6 >= 1 and $un_6 < $wariorsto_6){
    printrus ("У вас нет столько мертвых ".get_unit_name(5)."! (всего: <b>$un_6</b>)<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif($wariorsto_7 >= 1 and $un_7 < $wariorsto_7){
    printrus ("У вас нет столько мертвых ".get_unit_name(6)."! (всего: <b>$un_7</b>)<br/>\r\n");
    printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=animate'>Назад</a><br/>");
    }elseif(($wariorsto_1+$wariorsto_2+$wariorsto_3+$wariorsto_4+$wariorsto_5+$wariorsto_6+$wariorsto_7)>=1){

     mysql_query("UPDATE buildings SET time_sac = '".time()."', un_1 = un_1 - $wariorsto_1,
     un_2 = un_2 - $wariorsto_2, un_3 = un_3 - $wariorsto_3, un_4 = un_4 - $wariorsto_4,
     un_5 = un_5 - $wariorsto_5, un_6 = un_6 - $wariorsto_6, un_7 = un_7 - $wariorsto_7,
     oun_1 = oun_1 + $wariorsto_1, oun_2 = oun_2 + $wariorsto_2, oun_3 = oun_3 + $wariorsto_3,
     oun_4 = oun_4 + $wariorsto_4, oun_5 = oun_5 + $wariorsto_5, oun_6 = oun_6 + $wariorsto_6,
     oun_7 = oun_7 + $wariorsto_7 WHERE countryID = '$countryID' and building = 'necropolis' LIMIT 1");

    $key=_PREFIKS.':buildings'.$countryID;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='necropolis'){
        $mem[$i]['time_sac']=time();
        $mem[$i]['un_1'] = $mem[$i]['un_1'] - $wariorsto_1;
        $mem[$i]['un_2'] = $mem[$i]['un_2'] - $wariorsto_2;
        $mem[$i]['un_3'] = $mem[$i]['un_3'] - $wariorsto_3;
        $mem[$i]['un_4'] = $mem[$i]['un_4'] - $wariorsto_4;
        $mem[$i]['un_5'] = $mem[$i]['un_5'] - $wariorsto_5;
        $mem[$i]['un_6'] = $mem[$i]['un_6'] - $wariorsto_6;
        $mem[$i]['un_7'] = $mem[$i]['un_7'] - $wariorsto_7;
        $mem[$i]['oun_1'] = $mem[$i]['oun_1'] + $wariorsto_1;
        $mem[$i]['oun_2'] = $mem[$i]['oun_2'] + $wariorsto_2;
        $mem[$i]['oun_3'] = $mem[$i]['oun_3'] + $wariorsto_3;
        $mem[$i]['oun_4'] = $mem[$i]['oun_4'] + $wariorsto_4;
        $mem[$i]['oun_5'] = $mem[$i]['oun_5'] + $wariorsto_5;
        $mem[$i]['oun_6'] = $mem[$i]['oun_6'] + $wariorsto_6;
        $mem[$i]['oun_7'] = $mem[$i]['oun_7'] + $wariorsto_7;
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }

     mysql_query("UPDATE countries SET wariors_free = wariors_free + $wariorsto_1,
     wariors_free_2 = wariors_free_2 + $wariorsto_2, wariors_free_3 = wariors_free_3 + $wariorsto_3,
     wariors_free_4 = wariors_free_4 + $wariorsto_4, wariors_free_5 = wariors_free_5 + $wariorsto_5,
     wariors_free_6 = wariors_free_6 + $wariorsto_6, wariors_free_7 = wariors_free_7 + $wariorsto_7
     WHERE countryID = '$countryID' LIMIT 1");

    $b['wariors_free'] = $b['wariors_free'] + $wariorsto_1;
    $b['wariors_free_2'] = $b['wariors_free_2'] + $wariorsto_2;
    $b['wariors_free_3'] = $b['wariors_free_3'] + $wariorsto_3;
    $b['wariors_free_4'] = $b['wariors_free_4'] + $wariorsto_4;
    $b['wariors_free_5'] = $b['wariors_free_5'] + $wariorsto_5;
    $b['wariors_free_6'] = $b['wariors_free_6'] + $wariorsto_6;
    $b['wariors_free_7'] = $b['wariors_free_7'] + $wariorsto_7;

      if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

    $atwariors=array($wariorsto_1,$wariorsto_2,$wariorsto_3,$wariorsto_4,$wariorsto_5,$wariorsto_6,$wariorsto_7);
    printrus("Вы оживили:<br />");
      for ($i=0;$i<count($atwariors);$i++){
      if ($atwariors[$i]>0)printrus ("<b>".$atwariors[$i]."</b> ".get_unit_name($i).",<br />\r\n");
      $logs.="<b>".$atwariors[$i]."</b> ".get_unit_name($i).", ";
      }

    //Пишем в лог:
    @$open=fopen("../logs/nz".$countryID,"a+");
    @flock ($open,LOCK_EX);
    @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." оживил: ".$logs."<br />-------------------------\n");
    @fflush($open);
    @flock ($open,LOCK_UN);
    @fclose($open);

    printrus("<a href='necropolis.php?$ses'>Назад</a><br/>");
    }
    else
    {
    printrus ("<form name=\"\" action=\"necropolis.php?$ses&amp;m=hall&amp;n=animate\" method=\"post\">\r\n");
    if($un_1>0)printrus("Пехотинцев (<b>$un_1</b>)<br/><input format='*N' name='wariorsto_1'/><br />");
    if($un_2>0 and $b['study_wariors_2'] >= 100)printrus("Кавалеристов (<b>$un_2</b>)<br/><input format='*N' name='wariorsto_2'/><br />");
    if($un_3>0 and $b['study_wariors_3'] >= 100)printrus("Стрелков (<b>$un_3</b>)<br/><input format='*N' name='wariorsto_3'/><br />");
    if($un_4>0 and $b['study_wariors_4'] >= 100)printrus("Пушек (<b>$un_4</b>)<br/><input format='*N' name='wariorsto_4'/><br />");
    if($un_5>0 and $b['study_wariors_5'] >= 100)printrus("Подрывников (<b>$un_5</b>)<br/><input format='*N' name='wariorsto_5'/><br />");
    if($un_6>0 and $b['study_wariors_6'] >= 100)printrus("Самолётов (<b>$un_6</b>)<br/><input format='*N' name='wariorsto_6'/><br />");
    if($un_7>0 and $b['study_wariors_7'] >= 100)printrus("Магов (<b>$un_7</b>)<br/><input format='*N' name='wariorsto_7'/><br />");
    if(($un_1+$un_2+$un_3+$un_4+$un_5+$un_6+$un_7+$un_8)>=1){printrus("<input type=\"submit\" value=\"Оживить\"/></form><br/>");}else{printrus("У вас нет мертвых юнитов!<br/>");}
    }
  }
  else
  {
  printrus("<a href='necropolis.php?$ses&amp;m=hall&amp;n=dead'>Мертвых воинов</a>(".($un_1+$un_2+$un_3+$un_4+$un_5+$un_6+$un_7+$un_8).")<br/>");
  printrus("<a href='necropolis.php?$ses'>Назад</a><br/>");
  }


 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Улучшить зал мертвых:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 case('upgraide'):

printrus ("<u>Улучшение зала мертвых</u><br/>\r\n");

  if($n == 'study_wariors_2' or $n == 'study_wariors_3' or $n == 'study_wariors_4' or $n == 'study_wariors_5' or $n == 'study_wariors_6' or $n == 'study_wariors_7')
  {
  if($n == 'study_wariors_2')$name_science='изучения кавалеристов';
  if($n == 'study_wariors_3')$name_science='изучения стрелков';
  if($n == 'study_wariors_4')$name_science='изучения пушек';
  if($n == 'study_wariors_5')$name_science='изучения подрывников';
  if($n == 'study_wariors_6')$name_science='изучения самолетов';
  if($n == 'study_wariors_7')$name_science='изучения магов';

  $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
    $num=0;
      for ($i=0;$i<count($mem);$i++){
        if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==''.$n.''){
        $num=1;
        break;
        }
      }
    }else{
    $query="select * from `works` where countryID='$countryID' and kind='science' and what='$n' limit 1";
    $result=@MYSQL_QUERY($query);
    $num=@mysql_num_rows($result);
    }

    if($num>0){
    printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
    printrus("<a href='necropolis.php?$ses'>Отмена</a><br/>");
    }elseif($scientiststo>$scientists){
    printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
    printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a><br/>");
    printrus("<a href='necropolis.php?$ses'>Отмена</a><br/>");
    }elseif($scientiststo>2500){
    printrus ("Можно использовать максимум 2500 ученых!<br/>\r\n");
    printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=2500\">Использовать 2500 ученых</a><br/>");
    printrus("<a href='necropolis.php?$ses'>Отмена</a><br/>");
    }elseif($moneyto>$money){
    printrus ("У вас нет столько денег! (всего: <b>".$money."</b>)<br/>\r\n");
    printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$money&amp;scientiststo=$scientiststo\">Использовать все</a><br/>");
    printrus("<a href='necropolis.php?$ses'>Отмена</a><br/>");
    }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
    printrus ("Ученые: <b>".$b['scientists']."</b><br/>\r\n");
    printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
    printrus ("<form name=\"\" action=\"necropolis.php?$ses&amp;m=upgraide&amp;n=$n\" method=\"post\">\r\n");
    printrus ("<input format='*N' name='moneyto'/><br/>\r\n");
    printrus ("Ученые:<br/>\r\n");
    printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
    printrus("<input type=\"submit\" value=\"Исследовать\"/></form><br/>");
    }elseif($moneyto<150){
    printrus ("Необходимо выделить мимнимум 150 денег на исследование!<br/>\r\n");
    printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=150&amp;scientiststo=$scientiststo\">Выделить 150 денег</a><br/>");
    printrus("<a href='necropolis.php?$ses'>Отмена</a><br/>");
    }
    else
    {
      if($d == 'yes'){
      mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
      $b['money'] = $b['money'] - $moneyto;
      $b['scientists'] = $scientists-$scientiststo;
        if ($id_m==TRUE){
        $memcache->set($key1,$b,false,86400);
        }

      $work_time=round($moneyto/$scientiststo*2000);
      $new_lvl=round($moneyto/150);

      $query="insert into `works` values('$countryID','science','$n',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
      $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
      $key=_PREFIKS.':works'.$countryID;
        if (($mem=$memcache->get($key))!==FALSE){
        $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>$n, "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
        array_push($mem,$neww);
        $memcache->set($key,$mem,false,86400);
        }

      //Пишем в лог:
      @$open=fopen("../logs/nz".$countryID,"a+");
      @flock ($open,LOCK_EX);
      @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." исследует <u>".$name_science."</u> за ".$moneyto." денег, ".$scientiststo." учеными. Исследование займет ".mkTimeStr($work_time)."<br />-------------------------\n");
      @fflush($open);
      @flock ($open,LOCK_UN);
      @fclose($open);

      printrus ("Исследование <u>$name_science</u> займет ".mkTimeStr($work_time)."<br/>\r\n");
      printrus("<a href='necropolis.php?$ses'>Назад</a><br/>");
      }
      else
      {
      $work_time=round($moneyto/$scientiststo*2000);
      $new_lvl=round($moneyto/150);
      if($new_lvl > 100){$new_lvl=100;}
      printrus ("Уровень <u>$name_science</u> повысится на <b>$new_lvl</b>%,<br/>\r\n");
      printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientiststo&amp;d=yes\">Начать исследование</a><br/>");
      printrus("<a href='necropolis.php?$ses'>Отмена</a><br/>");
      }
    }
  }
  else
  {
  //Текущие исследования
  $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
    $a=array();
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science' and ($mem[$i]['what']=='study_wariors_2' or $mem[$i]['what']=='study_wariors_3' or $mem[$i]['what']=='study_wariors_4' or $mem[$i]['what']=='study_wariors_5' or $mem[$i]['what']=='study_wariors_6' or $mem[$i]['what']=='study_wariors_7'))array_push($a,$mem[$i]);
    }else{
    $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science' and (what = 'study_wariors_2' or what = 'study_wariors_3' or what = 'study_wariors_4' or what = 'study_wariors_5' or what = 'study_wariors_6' or what = 'study_wariors_7')");
    $a = array();
      while (($s=mysql_fetch_array($r))!==FALSE){
      array_push($a,$s);
      }
    }
  if (count($a)!=0) printrus("<u>Текущие исследования:</u><br/>\r\n");
    for ($i=0;$i<count($a);$i++){
    $what = $a[$i]['what'];
    $people = $a[$i]['peopleatwork'];
    $time = mkTimeStr($a[$i]['finished']-date_new(U));
    if (count($a)!=0) printrus ("<form name=\"\" action=\"necropolis.php?$ses&amp;what=$what\" method=\"post\">\r\n");
    switch($what):
    case('study_wariors_2'): $name = 'изучения кавалеристов';break;
    case('study_wariors_3'): $name = 'изучения стрелков';break;
    case('study_wariors_4'): $name = 'изучения пушек';break;
    case('study_wariors_5'): $name = 'изучения подрывников';break;
    case('study_wariors_6'): $name = 'изучения самолетов';break;
    case('study_wariors_7'): $name = 'изучения магов';break;
    endswitch;

    printrus("$name($people ученых)[осталось $time]<br/><input format='*N' name='peopleto' /><br/><a href=\"necropolis.php?$ses&amp;m=breakresearch&amp;what=$what\">прервать</a><br/>");
    printrus("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/><br/>");
    printrus("<input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/></form>-----<br />");
    }

  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_zalmert_pex&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=study_wariors_2\">Изучить Кавалеристов</a> [<b>".$b['study_wariors_2']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_zalmert_kav&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=study_wariors_3\">Изучить Стрелков</a> [<b>".$b['study_wariors_3']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_zalmert_str&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=study_wariors_4\">Изучить Пушки</a> [<b>".$b['study_wariors_4']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_zalmert_pux&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=study_wariors_5\">Изучить Подрывников</a> [<b>".$b['study_wariors_5']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_zalmert_pod&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=study_wariors_6\">Изучить Самолетов</a> [<b>".$b['study_wariors_6']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_zalmert_sam&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"necropolis.php?$ses&amp;m=upgraide&amp;n=study_wariors_7\">Изучить Магов</a> [<b>".$b['study_wariors_7']."%</b>]<br/>");

  printrus("<a href=\"necropolis.php?$ses\">Назад</a><br/>");
  }


 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Прекращаем изучения:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 case('breakresearch'):

$key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
   $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
      $num=1;
      $people=$mem[$i]['peopleatwork'];
      break;
      }
   }else{
   $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what' LIMIT 1");
   $num=mysql_num_rows($r);
   $a = mysql_fetch_array($r);
   $people = $a['peopleatwork'];
   }

 if ($num!=0){
 if($what == 'study_wariors_2')$name_science='изучения кавалеристов';
 if($what == 'study_wariors_3')$name_science='изучения стрелков';
 if($what == 'study_wariors_4')$name_science='изучения пушек';
 if($what == 'study_wariors_5')$name_science='изучения подрывников';
 if($what == 'study_wariors_6')$name_science='изучения самолетов';
 if($what == 'study_wariors_7')$name_science='изучения магов';

 mysql_query("UPDATE `countries` SET scientists = scientists + $people WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $people;
   if ($id_m==TRUE){
   $memcache->set($key1,$b,false,86400);
   }

 printrus("Исследование <u>$name_science</u> прекращено!<br />Вернулись $people ученых<br/>\n");

 mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
      }else array_push($neww,$mem[$i]);
   $memcache->set($key,$neww,false,86400);
   }

 //Пишем в лог:
 @$open=fopen("../logs/nz".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." прервал исследование <u>".$name_science."</u>. Вернулись ".$people." ученых<br />-------------------------\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }else{printrus("Вы не ведете данное исследование!<br/>\n");}

printrus("<a href='necropolis.php?$ses&amp;m=upgraide'>Ок</a><br/>");

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Отзываем ученых с исследования::::::::::::::::::::::::::::::::::::::::::::::::
 case('minusresearch'):

$key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
   $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
      $num=1;
      $people=$mem[$i]['peopleatwork'];
      $finished=$mem[$i]['finished'];
      break;
      }
   }else{
   $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what' LIMIT 1");
   $num=mysql_num_rows($r);
   $a = mysql_fetch_array($r);
   $people = $a['peopleatwork'];
   $finished = $a['finished'];
   }

 if ($num!=0){

   if (!isset($peopleto)||$peopleto<=0){
   printrus("Укажите целое положительное число ученых!<br/>\r\n");
   }elseif($peopleto>$people-1){
   printrus("На исследовании находится всего <b>$people</b> ученых! (можно отозвать ".($people-1).")<br/>\r\n");
   }else{
   $newfinished=round(time_new()+($people/($people-$peopleto)*($finished-time_new()))+1);

   mysql_query("UPDATE `countries` SET scientists = scientists + $peopleto WHERE countryID = '$countryID'");
   $b['scientists'] = $b['scientists'] + $peopleto;
     if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

   printrus("Теперь исследованием занимаются ".($people-$peopleto)." ученых.<br />Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

   mysql_query("UPDATE `works` SET finished = '".$newfinished."', peopleatwork='".($people-$peopleto)."' WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");

   $key=_PREFIKS.':works'.$countryID;
     if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
       $mem[$i]['finished']=$newfinished;
       $mem[$i]['peopleatwork']=$people-$peopleto;
       break;
       }
     $memcache->set($key,$mem,false,86400);
     }

   //Пишем в лог:
   @$open=fopen("../logs/nz".$countryID,"a+");
   @flock ($open,LOCK_EX);
   @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." отозвал ".$peopleto." ученых с исследования. Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br />-------------------------\n");
   @fflush($open);
   @flock ($open,LOCK_UN);
   @fclose($open);
   }

 }else{printrus("Вы не ведете данное исследование!<br/>\n");}

printrus("<a href='necropolis.php?$ses&amp;m=upgraide'>Ок</a><br/>");

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добавляем ученых к исследованию:::::::::::::::::::::::::::::::::::::::::::::::
 case('plusresearch'):

$key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
   $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
      $num=1;
      $people=$mem[$i]['peopleatwork'];
      $finished=$mem[$i]['finished'];
      break;
      }
   }else{
   $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what' LIMIT 1");
   $num=mysql_num_rows($r);
   $a = mysql_fetch_array($r);
   $people = $a['peopleatwork'];
   $finished = $a['finished'];
   }

 if ($num!=0){

   if (!isset($peopleto)||$peopleto<=0){
   printrus("Укажите целое положительное число ученых!<br/>\r\n");
   }elseif($peopleto>$b['scientists']){
   printrus("У вас всего <b>".$b['scientists']."</b>свободных ученых!<br/>\r\n");
   }elseif(($people+$peopleto)>2500){
   printrus("Над этим исследованием могут работать максимум 2500 ученых!<br/>\r\n");
   }else{
   $newfinished=round(time_new()+(($people)/($people+$peopleto)*($finished-time_new()))+1);

   mysql_query("UPDATE `countries` SET scientists = scientists - $peopleto WHERE countryID = '$countryID'");
   $b['scientists'] = $b['scientists'] - $peopleto;
     if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

   printrus("Теперь исследованием занимаются ".($people+$peopleto)." ученых.<br />Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

   mysql_query("UPDATE `works` SET finished = '".$newfinished."', peopleatwork='".($people+$peopleto)."' WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");

   $key=_PREFIKS.':works'.$countryID;
     if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
       $mem[$i]['finished']=$newfinished;
       $mem[$i]['peopleatwork']=$people+$peopleto;
       break;
       }
     $memcache->set($key,$mem,false,86400);
     }

   //Пишем в лог:
   @$open=fopen("../logs/nz".$countryID,"a+");
   @flock ($open,LOCK_EX);
   @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." добавил ".$peopleto." ученых на исследование. Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br />-------------------------\n");
   @fflush($open);
   @flock ($open,LOCK_UN);
   @fclose($open);
   }

 }else{printrus("Вы не ведете данное исследование!<br/>\n");}

printrus("<a href='necropolis.php?$ses&amp;m=upgraide'>Ок</a><br/>");

break;
endswitch;

}

//============================================================================= Конец скрипту ================================================================
printrus("-----<br /><a href='../game.php?$ses'>На главную</a><br/>");
//футер страницы:
include_once("../other_inc/footer.php");

?>