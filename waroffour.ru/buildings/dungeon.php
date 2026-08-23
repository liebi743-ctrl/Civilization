<?php
/*======================================================= Подземелье (уникальное здание расы - Гномы) ========================================================*/
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
if (isset($what) && ($what!='hammer' &&$what!='cuirass' &&$what!='pouch' &&$what!='pono' &&$what!='improved_mine' &&$what!='diamond_wall')) exit;
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

build_exists_print($countryID,'dungeon');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

is_repairing($countryID,'dungeon',$m);

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим главную здания)::::::::::::::::::::::::::::::

default:
printrus ("<u>Подземелье</u><br/>\r\n");
printrus("<a href=\"guard.php?$ses&amp;bld=dungeon\">Охрана</a>[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]<br/>");
printrus("<a href=\"dungeon.php?$ses&amp;m=workshop\">Мастерская гномов</a><br/>");
printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide\">Улучшение, мастерская гномов</a><br/>");
if($hits<100){printrus("<a href=\"dungeon.php?$ses&amp;m=repaire\">Починить</a>(".mkWarning($hits)."%)<br/>");}

break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('repaire'):
repair($countryID,'dungeon',$m);
break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Мастерская гномов:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('workshop'):

printrus ("<u>Мастерская гномов</u><br/>\r\n");
  if($n == 'hammer' or $n == 'cuirass' or $n == 'pouch' or $n == 'pono')
  {
  if($n == 'hammer'){$time_art=$un_1; $tb='un_1'; $name_art='Гномий кузнечный молот';}
  if($n == 'cuirass'){$time_art=$un_2; $tb='un_2'; $name_art='Кираса Короля Гномов';}
  if($n == 'pouch'){$time_art=$un_3; $tb='un_3'; $name_art='Мешочек с деньгами';}
  if($n == 'pono'){$time_art=$un_4; $tb='un_4'; $name_art='Поножи Короля Гномов';}
    if($d == 'yes')
    {
      if(($time_art+259200) > time()){
      printrus ("Повторно активировать артефакт можно только через: ".mkTimeStr(($time_art+259200)-date(U))."!<br/>\r\n");
      printrus("<a href='dungeon.php?$ses&amp;m=workshop'>Назад</a><br/>");
      }elseif($b[$n] < 100){
      printrus ("Нельзя активировать неизученный артефакт!<br/>\r\n");
      printrus("<a href='dungeon.php?$ses&amp;m=workshop&amp;n=animate'>Назад</a><br/>");
      }
      else
      {
      mysql_query("UPDATE buildings SET $tb = '".time()."' WHERE countryID = '$countryID' and building = 'dungeon' LIMIT 1");

      $key=_PREFIKS.':buildings'.$countryID;
        if (($mem=$memcache->get($key))!==FALSE){
          for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='dungeon'){
          $mem[$i][$tb]=time();
          break;
          }
        $memcache->set($key,$mem,false,86400);
        }

      mysql_query("UPDATE countries SET $n = 0 WHERE countryID = '$countryID' LIMIT 1");
      $b[$n] = 0;

        if ($id_m==TRUE){
        $memcache->set($key1,$b,false,86400);
        }

      //Пишем в лог:
      @$open=fopen("../logs/nz".$countryID,"a+");
      @flock ($open,LOCK_EX);
      @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." активировал артефакт ".$name_art."<br />-------------------------\n");
      @fflush($open);
      @flock ($open,LOCK_UN);
      @fclose($open);

      printrus("Вы активировали артефакт $name_art<br />");
      printrus("<a href='dungeon.php?$ses'>Назад</a><br/>");
      }
    }
    else
    {
    printrus("$name_art<br/>");
      if(($time_art+259200) > time()){
      printrus("Дата активации ".date("H:i d.m.y",$time_art)." мс , окончание ".date("H:i d.m.y",($time_art+259200))." мс<br/>");
      }else{
      printrus("Артефакт после активирования действует 3 игровых года, после удалиться, надо заново изучать <br/>");
      printrus("<a href='dungeon.php?$ses&amp;m=workshop&amp;n=$n&amp;d=yes'>Активировать</a><br/>");
      }
    printrus("<a href='dungeon.php?$ses'>Назад</a><br/>");
    }
  }
  else
  {
  $num = 0;
  if($b['hammer']>99 or ($un_1+259200)>time()){if($us['noob']>=1)
  {printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=kuzn_mol&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='dungeon.php?$ses&amp;m=workshop&amp;n=hammer'>Гномий кузнечный молот</a><br/>"); $num++;}
  if($b['cuirass']>99 or ($un_2+259200)>time()){if($us['noob']>=1)
  {printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=kiras_kor_gnm&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='dungeon.php?$ses&amp;m=workshop&amp;n=cuirass'>Кираса Короля Гномов</a><br/>"); $num++;}
  if($b['pouch']>99 or ($un_3+259200)>time()){if($us['noob']>=1)
  {printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=meshek_den&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='dungeon.php?$ses&amp;m=workshop&amp;n=pouch'>Мешочек с деньгами</a><br/>"); $num++;}
  if($b['pono']>99 or ($un_4+259200)>time()){if($us['noob']>=1)
  {printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=pon_kor_gnm&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='dungeon.php?$ses&amp;m=workshop&amp;n=pono'>Поножи Короля Гномов</a><br/>"); $num++;}
  if($num == 0){printrus("У вас нет изученных артефактов. Изучите.<br/>");}
  printrus("<a href='dungeon.php?$ses'>Назад</a><br/>");
  }


 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Улучшение, мастерская гномов::::::::::::::::::::::::::::::::::::::::::::::::::

 case('upgraide'):

printrus ("<u>Улучшение, мастерская гномов</u><br/>\r\n");

  if($n == 'hammer' or $n == 'cuirass' or $n == 'pouch' or $n == 'pono' or $n == 'improved_mine' or $n == 'diamond_wall')
  {
  if($n == 'hammer'){$name_science='гномий кузнечный молот'; $time_art=$un_1;}
  if($n == 'cuirass'){$name_science='кираса короля гномов'; $time_art=$un_2;}
  if($n == 'pouch'){$name_science='мешочек с деньгами'; $time_art=$un_3;}
  if($n == 'pono'){$name_science='поножи короля гномов'; $time_art=$un_4;}
  if($n == 'improved_mine'){$name_science='улучшенные шахты'; $time_art=0;}
  if($n == 'diamond_wall'){$name_science='алмазная стена'; $time_art=0;}

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
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
    }elseif($scientiststo>$scientists){
    printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
    printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a><br/>");
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
    }elseif(($time_art+259200)>time()){
    printrus ("Повторно изучить артефакт <u>$name_science</u> можно только после его удаления!<br/>\r\n");
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
    }elseif(($n == 'hammer' or $n == 'cuirass' or $n == 'pouch' or $n == 'pono') and $scientiststo>2500){
    printrus ("Можно использовать максимум 2500 ученых!<br/>\r\n");
    printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=2500\">Использовать 2500 ученых</a><br/>");
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
    }elseif($n == 'improved_mine' and $scientiststo>3000){
    printrus ("Можно использовать максимум 3000 ученых!<br/>\r\n");
    printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=3000\">Использовать 3000 ученых</a><br/>");
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
    }elseif($n == 'diamond_wall' and $scientiststo>3500){
    printrus ("Можно использовать максимум 3500 ученых!<br/>\r\n");
    printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=3500\">Использовать 3500 ученых</a><br/>");
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
    }elseif($moneyto>$money){
    printrus ("У вас нет столько денег! (всего: <b>".$money."</b>)<br/>\r\n");
    printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$money&amp;scientiststo=$scientiststo\">Использовать все</a><br/>");
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
    }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
    printrus ("Ученые: <b>".$b['scientists']."</b><br/>\r\n");
    printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
    printrus ("<form name=\"\" action=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n\" method=\"post\">\r\n");
    printrus ("<input format='*N' name='moneyto'/><br/>\r\n");
    printrus ("Ученые:<br/>\r\n");
    printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
    printrus("<input type=\"submit\" value=\"Исследовать\"/></form><br/>");
    }elseif($moneyto<150){
    printrus ("Необходимо выделить мимнимум 150 денег на исследование!<br/>\r\n");
    printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=150&amp;scientiststo=$scientiststo\">Выделить 150 денег</a><br/>");
    printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
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

        if($n == 'hammer' or $n == 'cuirass' or $n == 'pouch' or $n == 'pono'){
        $work_time=round($moneyto/$scientiststo*1200);
        $new_lvl=round($moneyto/250);
        }elseif($n == 'improved_mine'){
        $work_time=round($moneyto/$scientiststo*3000);
        $new_lvl=round($moneyto/300);
        }elseif($n == 'diamond_wall'){
        $work_time=round($moneyto/$scientiststo*1050);
        $new_lvl=round($moneyto/1000);
        }

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
      printrus("<a href='dungeon.php?$ses'>Назад</a><br/>");
      }
      else
      {
        if($n == 'hammer' or $n == 'cuirass' or $n == 'pouch' or $n == 'pono'){
        $work_time=round($moneyto/$scientiststo*1200);
        $new_lvl=round($moneyto/250);
        }elseif($n == 'improved_mine'){
        $work_time=round($moneyto/$scientiststo*3000);
        $new_lvl=round($moneyto/300);
        }elseif($n == 'diamond_wall'){
        $work_time=round($moneyto/$scientiststo*1050);
        $new_lvl=round($moneyto/1000);
        }
      if($new_lvl > 100){$new_lvl=100;}
      printrus ("Уровень <u>$name_science</u> повысится на <b>$new_lvl</b>%,<br/>\r\n");
      printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientiststo&amp;d=yes\">Начать исследование</a><br/>");
      printrus("<a href='dungeon.php?$ses'>Отмена</a><br/>");
      }
    }
  }
  else
  {
  //Текущие исследования
  $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
    $a=array();
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science' and ($mem[$i]['what']=='hammer' or $mem[$i]['what']=='cuirass' or $mem[$i]['what']=='pouch' or $mem[$i]['what']=='pono' or $mem[$i]['what']=='improved_mine' or $mem[$i]['what']=='diamond_wall'))array_push($a,$mem[$i]);
    }else{
    $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science' and (what = 'hammer' or what = 'cuirass' or what = 'pouch' or what = 'pono' or what = 'improved_mine' or what = 'diamond_wall')");
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
    if (count($a)!=0) printrus ("<form name=\"\" action=\"dungeon.php?$ses&amp;what=$what\" method=\"post\">\r\n");
    switch($what):
    case('hammer'): $name = 'гномий кузнечный молот';break;
    case('cuirass'): $name = 'кираса короля гномов';break;
    case('pouch'): $name = 'мешочек с деньгами';break;
    case('pono'): $name = 'поножи короля гномов';break;
    case('improved_mine'): $name = 'улучшенные шахты';break;
    case('diamond_wall'): $name = 'алмазная стена';break;
    endswitch;

    printrus("$name($people ученых)[осталось $time]<br/><input format='*N' name='peopleto' /><br/><a href=\"dungeon.php?$ses&amp;m=breakresearch&amp;what=$what\">прервать</a><br/>");
    printrus("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/><br/>");
    printrus("<input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/></form>-----<br />");
    }

  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_kuzn_mol&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=hammer\">Изучить Гномий кузнечный молот</a> [<b>".$b['hammer']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_kiras_kor_gnm&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=cuirass\">Изучить Кираса Короля Гномов</a> [<b>".$b['cuirass']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_meshek_den&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=pouch\">Изучить Мешочек с деньгами</a> [<b>".$b['pouch']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_pon_kor_gnm&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=pono\">Изучить Поножи Короля Гномов</a> [<b>".$b['pono']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_dob_res&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=improved_mine\">Изучить улучшенные шахты +20% добычи железа, камня, нефти</a> [<b>".$b['improved_mine']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_almaz_sten&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"dungeon.php?$ses&amp;m=upgraide&amp;n=diamond_wall\">Изучить алмазную стену +200 к прочности стены</a> [<b>".$b['diamond_wall']."%</b>]<br/>");

  printrus("<a href=\"dungeon.php?$ses\">Назад</a><br/>");
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
 if($what == 'hammer')$name_science='гномий кузнечный молот';
 if($what == 'cuirass')$name_science='кираса короля гномов';
 if($what == 'pouch')$name_science='мешочек с деньгами';
 if($what == 'pono')$name_science='поножи короля гномов';
 if($what == 'improved_mine')$name_science='улучшенные шахты';
 if($what == 'diamond_wall')$name_science='алмазная стена';

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

printrus("<a href='dungeon.php?$ses&amp;m=upgraide'>Ок</a><br/>");

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

printrus("<a href='dungeon.php?$ses&amp;m=upgraide'>Ок</a><br/>");

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
   printrus("У вас всего <b>".$b['scientists']."</b> свободных ученых!<br/>\r\n");
   }elseif(($what == 'hammer'  or $what == 'cuirass' or $what == 'pouch' or $what == 'pono') and ($people+$peopleto)>2500){
   printrus("Над этим исследованием могут работать максимум 2500 ученых!<br/>\r\n");
   }elseif($what == 'improved_mine' and ($people+$peopleto)>3000){
   printrus("Над этим исследованием могут работать максимум 3000 ученых!<br/>\r\n");
   }elseif($what == 'diamond_wall' and ($people+$peopleto)>3500){
   printrus("Над этим исследованием могут работать максимум 3500 ученых!<br/>\r\n");
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

printrus("<a href='dungeon.php?$ses&amp;m=upgraide'>Ок</a><br/>");

break;
endswitch;

}

//============================================================================= Конец скрипту ================================================================
printrus("-----<br /><a href='../game.php?$ses'>На главную</a><br/>");
//футер страницы:
include_once("../other_inc/footer.php");

?>