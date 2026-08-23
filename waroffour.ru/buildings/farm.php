<?php
/*========================================================= Ферма(уникальное здание расы - Люди) =========================================================*/
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['d'])) $d = $_REQUEST['d'];
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what) && ($what!='cow' &&$what!='goats' &&$what!='rams')) exit;
if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;
if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['sum'])) $sum = ceil($_REQUEST['sum']);
if (isset($sum)&&!is_numeric($sum)) $sum=0;
if (isset($sum)&&$sum<0) $sum=0;
if (isset($_REQUEST['summ'])) $summ = $_REQUEST['summ'];
if (isset($summ)&&!is_numeric($summ)) $summ=0;
if (isset($summ)&&$summ<0) $summ=0;
if (isset($_REQUEST['res'])) $res = ceil($_REQUEST['res']);
if (isset($res)&&!is_numeric($res)) $res=1;
if (isset($res)&&$res<0) $res=1;
if (isset($_REQUEST['minusresearch']))$m='minusresearch';
if (isset($_REQUEST['plusresearch']))$m='plusresearch';
//==============================================================================
//подключаем скрипты

$peopleto=round( (int) $peopleto);
$scientiststo=round( (int) $scientiststo);
$moneyto=round( (int) $moneyto);
$sum=round( (int) $sum);
$res=round( (int) $res);

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
$iron=$b['iron'];
$grain=$b['grain'];
//******************************************************************************
//проверка на наличие здания:****************************************

build_exists_print($countryID,'farm');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

is_repairing($countryID,'farm',$m);

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим главную здания)::::::::::::::::::::::::::::::

default:
printrus ("<u>Ферма</u><br/>\r\n");
printrus("<a href=\"guard.php?$ses&amp;bld=farm\">Охрана</a>[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]<br/>");
printrus("<a href=\"farm.php?$ses&amp;m=household\">Хозяйство</a><br/>");
printrus("<a href=\"farm.php?$ses&amp;m=market\">Рынок</a><br/>");
printrus("<a href=\"farm.php?$ses&amp;m=upgraide\">Улучшить ферму</a><br/>");
if(($time_uz+259200) < time()){printrus("<a href=\"farm.php?$ses&amp;m=wall\">Активировать Святую стену</a><br/>");}
else{printrus("<a href=\"farm.php?$ses&amp;m=wall\">Святая стена</a><br/>");}
if($hits<100){printrus("<a href=\"farm.php?$ses&amp;m=repaire\">Починить</a>(".mkWarning($hits)."%)<br/>");}

break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('repaire'):
repair($countryID,'farm',$m);
break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Хозяйство:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('household'):

printrus ("<u>Хозяйство</u><br/>\r\n");
  if(($n == 'cow' or $n == 'rams' or $n == 'goats' or $n == 'pig') and $d == 'buy')
  {
  if($n == 'cow'){$v1="Стоимость одной коровы: <b>15000</b> денег, <b>100000</b> зерна.<br/>Сколько коров купить?<br />"; $v2="коров"; $mon=15000; $grai=100000; $r_voz1=10; $r_voz2=20; $r_ves1=30; $r_ves2=35;}
  if($n == 'rams'){$v1="Стоимость одного барана: <b>2000</b> денег, <b>20000</b> зерна.<br/>Сколько баранов купить?<br />"; $v2="баранов"; $mon=2000; $grai=20000;  $r_voz1=7; $r_voz2=13; $r_ves1=3; $r_ves2=4;}
  if($n == 'goats'){$v1="Стоимость одной козы: <b>4000</b> денег, <b>50000</b> зерна.<br/>Сколько коз купить?<br />"; $v2="коз"; $mon=4000; $grai=50000; $r_voz1=9; $r_voz2=16; $r_ves1=4; $r_ves2=4;}
  if($n == 'pig'){$v1="Стоимость одной свиньи: <b>7000</b> денег, <b>80000</b> зерна.<br/>Сколько свиней купить?<br />"; $v2="свиней"; $mon=7000; $grai=80000; $r_voz1=12; $r_voz2=15; $r_ves1=3; $r_ves2=8;}
    if($sum >= 1)
    {
      if($n == 'cow' and $b['cow'] < 100){
      printrus ("Вам пока недоступна покупка коров!<br/>\r\n");
      printrus("<a href='farm.php?$ses&amp;m=household&amp;n=$n&amp;d=buy'>Назад</a><br/>");
      }elseif($n == 'rams' and $b['rams'] < 100){
      printrus ("Вам пока недоступна покупка баранов!<br/>\r\n");
      printrus("<a href='farm.php?$ses&amp;m=household&amp;n=$n&amp;d=buy'>Назад</a><br/>");
      }elseif($n == 'goats' and $b['goats'] < 100){
      printrus ("Вам пока недоступна покупка коз!<br/>\r\n");
      printrus("<a href='farm.php?$ses&amp;m=household&amp;n=$n&amp;d=buy'>Назад</a><br/>");
      }elseif($money < ($sum*$mon)){
      printrus ("У вас нет столько денег! Необходимо: ".($sum*$mon)." денег. (всего: <b>".$money."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses&amp;m=household&amp;n=$n&amp;d=buy'>Назад</a><br/>");
      }elseif($grain < ($sum*$grai)){
      printrus ("У вас нет столько зерна! Необходимо: ".($sum*$grai)." зерна. (всего: <b>".$grain."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses&amp;m=household&amp;n=$n&amp;d=buy'>Назад</a><br/>");
      }
      else
      {
      $vs_money=$sum*$mon;
      $vs_grain=$sum*$grai;

        for ($i=0;$i<$sum;$i++){
        $rand_ves=rand($r_ves1,$r_ves2);
        $time_kill=time()+rand($r_voz1,$r_voz2)*60*60;
        $query="insert into `farm` values('','$countryID','".FarmName()."','$n','$rand_ves','".time()."','$time_kill')";
        $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
        }

      mysql_query("UPDATE countries SET money = money - $vs_money, grain = grain - $vs_grain WHERE countryID = '$countryID' LIMIT 1");
      $b['money'] = $b['money'] - $vs_money;
      $b['grain'] = $b['grain'] - $vs_grain;

        if ($id_m==TRUE){
        $memcache->set($key1,$b,false,86400);
        }

      //Пишем в лог:
      @$open=fopen("../logs/nz".$countryID,"a+");
      @flock ($open,LOCK_EX);
      @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." купил <b>".$sum."</b> ".$v2."<br />-------------------------\n");
      @fflush($open);
      @flock ($open,LOCK_UN);
      @fclose($open);

      printrus ("Вы купили <b>".$sum."</b> ".$v2."<br/>\r\n");
      printrus("<a href='farm.php?$ses&amp;m=household'>Назад</a><br/>");
      }
    }
    else
    {
    printrus ("".$v1."<form name=\"\" action=\"farm.php?$ses&amp;m=household&amp;n=$n&amp;d=buy\" method=\"post\">\r\n");
    printrus ("<input format='*N' name='sum'/><br/>\r\n");
    printrus("<input type=\"submit\" value=\"Купить\"/></form><br/>");
    printrus("<a href='farm.php?$ses&amp;m=household'>Назад</a><br />");
    }
  }
  elseif($n == 'cow' or $n == 'rams' or $n == 'goats' or $n == 'pig')
  {
  if($n == 'cow'){$v1="корову"; $v2="коровы"; $v3="коров"; $v4="Корова "; $ml1=30; $ml2=70; $ml3=100;}
  if($n == 'rams'){$v1="барана"; $v2="баранов"; $v3="баранов"; $v4="Баран "; $ml1=0.5; $ml2=1; $ml3=1.5;}
  if($n == 'goats'){$v1="козу"; $v2="коз"; $v3="коз"; $v4="Коза "; $ml1=10; $ml2=30; $ml3=50;}
  if($n == 'pig'){$v1="свинью"; $v2="свиньи"; $v3="свиней"; $v4="Свинья ";}

    if($_REQUEST['kill'])
    {
    $id=$_POST['formbox'];
    $c = count($id);
      if(!empty($c)){
      $vs_kill=0; $milk=0; $meat=0;
        for($i=0; $i<$c; $i++)
        {
        $cid=$id[$i];
        $result=mysql_query("SELECT * FROM `farm` WHERE id='$cid' and countryID='$countryID' and who='$n'");
        $res=mysql_fetch_array($result);
          if($res!==FALSE)
          {
          $ves=$res['ves']*floor(1+(time()-$res['time_buy'])/60/60);
          $voz=floor((time()-$res['time_buy'])/60/60);
          $mea=$ves*0.9;
            if($n == 'cow' or $n == 'rams' or $n == 'goats'){
            $mils=0;
              for($j=0;$j<$voz;$j++){
              if($j == 0){$mil=0;}
              if($j >= 1 and $j < 4){$mil=$ml1;}
        	  if($j >= 4 and $j < 7){$mil=$ml2;}
        	  if($j >= 7){$mil=$ml3;}
        	  $mils=$mils+$mil;
              }
            }

          $query="delete from `farm` where id='$cid' and countryID='$countryID' and who='$n' limit 1";
          $resul=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

          $vs_kill++;
          }else{$mea=0;$mils=0;}
        $meat=$meat+$mea;
        $milk=$milk+$mils;
        }

      if($vs_kill == 1){$text=$v1;}elseif($vs_kill >= 2 and $vs_kill < 5){$text=$v2;}else{$text=$v3;}
        if($vs_kill>0){
        if($milk>0 and $n != 'rams'){$text_mil=', <b>'.$milk.'</b> литров молока.';}
        if($milk>0 and $n == 'rams'){$text_mil=', <b>'.$milk.'</b> кг шерсти.';}

        if($n == 'cow'){$un1=0; $un2=$milk; $un3=0; $un4=0; $un5=$meat*1000; $un6=0; $un7=0;}
        if($n == 'rams'){$v1="барана"; $un1=0; $un2=0; $un3=$milk*1000; $un4=$meat*1000; $un5=0; $un6=0; $un7=0;}
        if($n == 'goats'){$v1="козу"; $un1=$milk; $un2=0; $un3=0; $un4=0; $un5=0; $un6=$meat*1000; $un7=0;}
        if($n == 'pig'){$v1="свинью"; $un1=0; $un2=0; $un3=0; $un4=0; $un5=0; $un6=0; $un7=$meat*1000;}

          mysql_query("UPDATE buildings SET un_1 = un_1 + $un1, un_2 = un_2 + $un2, un_3 = un_3 + $un3, un_4 = un_4 + $un4, un_5 = un_5 + $un5,
          un_6 = un_6 + $un6, un_7 = un_7 + $un7 WHERE countryID = '$countryID' and building = 'farm' LIMIT 1");

        $key=_PREFIKS.':buildings'.$countryID;
          if (($mem=$memcache->get($key))!==FALSE){
            for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='farm'){
            $mem[$i]['un_1'] = $mem[$i]['un_1'] + $un1;
            $mem[$i]['un_2'] = $mem[$i]['un_2'] + $un2;
            $mem[$i]['un_3'] = $mem[$i]['un_3'] + $un3;
            $mem[$i]['un_4'] = $mem[$i]['un_4'] + $un4;
            $mem[$i]['un_5'] = $mem[$i]['un_5'] + $un5;
            $mem[$i]['un_6'] = $mem[$i]['un_6'] + $un6;
            $mem[$i]['un_7'] = $mem[$i]['un_7'] + $un7;
            break;
            }
          $memcache->set($key,$mem,false,86400);
          }

        //Пишем в лог:
        @$open=fopen("../logs/nz".$countryID,"a+");
        @flock ($open,LOCK_EX);
        @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." убил <b>".$vs_kill."</b> ".$text."! Получил: <b>".$meat."</b> кг мяса".$text_mil."<br />-------------------------\n");
        @fflush($open);
        @flock ($open,LOCK_UN);
        @fclose($open);

        printrus("Вы убили <b>".$vs_kill."</b> ".$text."! Получили: <b>".$meat."</b> кг мяса".$text_mil."<br/>");
        }
        else
        {
        printrus("У вас нет таких животных либо они уже мертвы!<br/>");
        }
      }
      else
      {
      printrus("Вы не выбрали кого убить!<br/>");
      }
    printrus("<a href='farm.php?$ses&amp;m=household'>Назад</a><br />");
    }
    else
    {
    $farm=mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='$n' ORDER by `id`");
    $vs=mysql_num_rows($farm);
    $num=0;
    printrus ("<form name=\"\" action=\"farm.php?$ses&amp;m=household&amp;n=$n\" method=\"post\">\r\n");
      while($a = mysql_fetch_array($farm))
      {
      $lft = $a['time_kill'] - time();
      $ves=$a['ves']*floor(1+(time()-$a['time_buy'])/60/60);
      $voz=floor((time()-$a['time_buy'])/60/60);
      $meat=$ves*0.9;
      if($voz == 1){$text_voz='год';}elseif($voz >= 2 and $voz < 5){$text_voz='года';}else{$text_voz='лет';}
        if($n == 'cow' or $n == 'rams' or $n == 'goats'){
        $milk=0;
          for($i=0;$i<$voz;$i++){
          if($i == 0){$mil=0;}
          if($i >= 1 and $i < 4){$mil=$ml1;}
          if($i >= 4 and $i < 7){$mil=$ml2;}
          if($i >= 7){$mil=$ml3;}
          $milk=$milk+$mil;
          }
        if($n == 'rams'){$text_mil=', шерсти: <b>'.$milk.'</b> кг';}else{$text_mil=', молока: <b>'.$milk.'</b> литров';}
        }
      printrus ("<input type=\"checkbox\" name=\"formbox[]\" value=\"".$a['id']."\" /> ".$v4."".$a['name']."<br />Возраст: <b>".$voz."</b> ".$text_voz.", вес: <b>".$ves."</b> кг, мяса: <b>".$meat."</b> кг".$text_mil."<br />
      Осталось жить: ".mkTimeStr($lft)."<br/><br />\r\n");
      $num++;
      }
    if($num>0){printrus ("<input type=\"submit\" name=\"kill\" value=\" Убить \"></form><br/>\r\n");}else{printrus ("У вас нет ".$v3."!<br />\r\n");}
    printrus("<a href='farm.php?$ses&amp;m=household'>Назад</a><br/>");
    }
  }
  else
  {
  $vs_cow=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='cow'"));
  $vs_mutton=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='rams'"));
  $vs_goat=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='goats'"));
  $vs_pig=mysql_num_rows(mysql_query("SELECT * FROM `farm` WHERE `countryID`='$countryID' and `who`='pig'"));
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=korova&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='farm.php?$ses&amp;m=household&amp;n=cow'>Коровы</a> (<b>".$vs_cow."</b>) <a href='farm.php?$ses&amp;m=household&amp;n=cow&amp;d=buy'>+</a><br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=baran&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='farm.php?$ses&amp;m=household&amp;n=rams'>Бараны</a> (<b>".$vs_mutton."</b>) <a href='farm.php?$ses&amp;m=household&amp;n=rams&amp;d=buy'>+</a><br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=kozel&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='farm.php?$ses&amp;m=household&amp;n=goats'>Козы</a> (<b>".$vs_goat."</b>) <a href='farm.php?$ses&amp;m=household&amp;n=goats&amp;d=buy'>+</a><br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=svenia&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href='farm.php?$ses&amp;m=household&amp;n=pig'>Свиньи</a> (<b>".$vs_pig."</b>) <a href='farm.php?$ses&amp;m=household&amp;n=pig&amp;d=buy'>+</a><br/>");
  printrus("<a href='farm.php?$ses'>Назад</a><br/>");
  }


 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Рынок:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('market'):

printrus ("<u>Рынок</u><br/>\r\n");
  if($n == 'sell')
  {
  $mf=mysql_fetch_array(mysql_query("SELECT * FROM market_farm WHERE id='1'"));
    if($d == 1)
    {
    printrus ("<form name=\"\" action=\"farm.php?$ses&amp;m=market&amp;n=sell&amp;d=2\" method=\"post\">\r\n");
    printrus ("Сколько продать?<br />
    <input format='*N' name='summ'/><br />
    Что продаём?<br />
    <select name=\"res\">
    <option value=\"1\">козьего молока</option>
    <option value=\"2\">коровьего молока</option>
    <option value=\"3\">бараньей шерсти</option>
    <option value=\"4\">бараньего мяса</option>
    <option value=\"5\">коровьего мяса</option>
    <option value=\"6\">козьего мяса</option>
    <option value=\"7\">свиного мяса</option>
    </select><br />");
    printrus("<input type=\"submit\" value=\"Продать\"/></form><br/>");
    }
    elseif($d == 2 and $summ > 0 and $res > 0 and $res <= 7)
    {
      if($res == 1 and $summ > $un_1){
      printrus ("У вас нет столько козьего молока! (всего <b>".$un_1."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }elseif($res == 2 and $summ > $un_2){
      printrus ("У вас нет столько коровьего молока! (всего <b>".$un_2."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }elseif($res == 3 and $summ > ($un_3/1000)){
      printrus ("У вас нет столько бараньей шерсти! (всего <b>".($un_3/1000)."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }elseif($res == 4 and $summ > ($un_4/1000)){
      printrus ("У вас нет столько бараньего мяса! (всего <b>".($un_4/1000)."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }elseif($res == 5 and $summ > ($un_5/1000)){
      printrus ("У вас нет столько коровьего мяса! (всего <b>".($un_5/1000)."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }elseif($res == 6 and $summ > ($un_6/1000)){
      printrus ("У вас нет столько козьего мяса! (всего <b>".($un_6/1000)."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }elseif($res == 7 and $summ > ($un_7/1000)){
      printrus ("У вас нет столько свиного мяса! (всего <b>".($un_7/1000)."</b>)<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }
      else
      {
      if($res == 1){$name_res='литров козьего молока'; $bd='un_1'; $kol=$summ; $rmoney=$summ*$mf['r1'];}
      if($res == 2){$name_res='литров коровьего молока'; $bd='un_2'; $kol=$summ; $rmoney=$summ*$mf['r2'];}
      if($res == 3){$name_res='кг бараньей шерсти'; $bd='un_3'; $kol=$summ*1000; $rmoney=$summ*$mf['r3'];}
      if($res == 4){$name_res='кг бараньего мяса'; $bd='un_4'; $kol=$summ*1000; $rmoney=$summ*$mf['r4'];}
      if($res == 5){$name_res='кг коровьего мяса'; $bd='un_5'; $kol=$summ*1000; $rmoney=$summ*$mf['r5'];}
      if($res == 6){$name_res='кг козьего мяса'; $bd='un_6'; $kol=$summ*1000; $rmoney=$summ*$mf['r6'];}
      if($res == 7){$name_res='кг свиного мяса'; $bd='un_7'; $kol=$summ*1000; $rmoney=$summ*$mf['r7'];}

      mysql_query("UPDATE buildings SET $bd = $bd - '$kol' WHERE countryID = '$countryID' and building = 'farm' LIMIT 1");

      $key=_PREFIKS.':buildings'.$countryID;
        if (($mem=$memcache->get($key))!==FALSE){
          for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='farm'){
          $mem[$i][$bd] = $mem[$i][$bd] - $kol;
          break;
          }
        $memcache->set($key,$mem,false,86400);
        }

      mysql_query("UPDATE countries SET money = money + $rmoney WHERE countryID = '$countryID' LIMIT 1");

      $b['money'] = $b['money'] + $rmoney;

        if ($id_m==TRUE){
        $memcache->set($key1,$b,false,86400);
        }

      //Пишем в лог:
      @$open=fopen("../logs/nz".$countryID,"a+");
      @flock ($open,LOCK_EX);
      @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." продал <b>".$summ."</b> ".$name_res." за <b>".$rmoney."</b> денег.<br />-------------------------\n");
      @fflush($open);
      @flock ($open,LOCK_UN);
      @fclose($open);

      printrus ("Вы продали <b>".$summ."</b> ".$name_res." за <b>".$rmoney."</b> денег.<br/>\r\n");
      printrus("<a href='farm.php?$ses'>Ок</a><br/>");
      }
    }
    else
    {
    printrus("Цена за 1 литр ".$mf['r1']." денег козьего молока (<b>".$un_1."</b> литров)<br />
    Цена за 1 литр ".$mf['r2']." денег коровьего молока (<b>".$un_2."</b> литров)<br />
    Цена за 1 кг ".$mf['r3']." денег бараньей шерсти (<b>".($un_3/1000)."</b> кг)<br />
    Цена за 1 кг ".$mf['r4']." денег бараньего мяса (<b>".($un_4/1000)."</b> кг)<br />
    Цена за 1 кг ".$mf['r5']." денег коровьего мяса (<b>".($un_5/1000)."</b> кг)<br />
    Цена за 1 кг ".$mf['r6']." денег козьего мяса (<b>".($un_6/1000)."</b> кг)<br />
    Цена за 1 кг ".$mf['r7']." денег свиного мяса (<b>".($un_7/1000)."</b> кг)<br/>\r\n");
    if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=ceni_rin_fer&amp;$ses\"><font color='#EE7621'>Все о ценах рынка</font></a>]</font><br /><br /> ");}
    printrus("<a href=\"farm.php?$ses&amp;m=market&amp;n=sell&amp;d=1\">Продать</a><br/><br/>");
    printrus("<a href='farm.php?$ses&amp;m=market'>Назад</a><br/>");
    }
  }
  else
  {
  printrus("Всего козьего молока (<b>".$un_1."</b> литров)<br/>\r\n");
  printrus("Всего коровьего молока (<b>".$un_2."</b> литров)<br/>\r\n");
  printrus("Всего бараньей шерсти (<b>".($un_3/1000)."</b> кг)<br/>\r\n");
  printrus("Всего бараньего мяса (<b>".($un_4/1000)."</b> кг)<br/>\r\n");
  printrus("Всего коровьего мяса (<b>".($un_5/1000)."</b> кг)<br/>\r\n");
  printrus("Всего козьего мяса (<b>".($un_6/1000)."</b> кг)<br/>\r\n");
  printrus("Всего свиного мяса (<b>".($un_7/1000)."</b> кг)<br/>\r\n");
  printrus("<a href=\"farm.php?$ses&amp;m=market&amp;n=sell\">Продать</a><br/>");
  printrus("<a href='farm.php?$ses'>Назад</a><br/>");
  }


break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Улучшить ферму:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 case('upgraide'):

printrus ("<u>Улучшить ферму</u><br/>\r\n");

  if($n == 'cow' or $n == 'goats' or $n == 'rams')
  {
  if($n == 'cow')$name_science='изучения коров';
  if($n == 'goats')$name_science='изучения коз';
  if($n == 'rams')$name_science='изучения баранов';

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
    printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
    }elseif($scientiststo>$scientists){
    printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
    printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a><br/>");
    printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
    }elseif($scientiststo>2500){
    printrus ("Можно использовать максимум 2500 ученых!<br/>\r\n");
    printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=2500\">Использовать 2500 ученых</a><br/>");
    printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
    }elseif($moneyto>$money){
    printrus ("У вас нет столько денег! (всего: <b>".$money."</b>)<br/>\r\n");
    printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$money&amp;scientiststo=$scientiststo\">Использовать все</a><br/>");
    printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
    }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
    printrus ("Ученые: <b>".$b['scientists']."</b><br/>\r\n");
    printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
    printrus ("<form name=\"\" action=\"farm.php?$ses&amp;m=upgraide&amp;n=$n\" method=\"post\">\r\n");
    printrus ("<input format='*N' name='moneyto'/><br/>\r\n");
    printrus ("Ученые:<br/>\r\n");
    printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
    printrus("<input type=\"submit\" value=\"Исследовать\"/></form><br/>");
    }elseif($moneyto<150){
    printrus ("Необходимо выделить мимнимум 150 денег на исследование!<br/>\r\n");
    printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=150&amp;scientiststo=$scientiststo\">Выделить 150 денег</a><br/>");
    printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
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
      printrus("<a href='farm.php?$ses'>Назад</a><br/>");
      }
      else
      {
      $work_time=round($moneyto/$scientiststo*2000);
      $new_lvl=round($moneyto/150);
      if($new_lvl > 100){$new_lvl=100;}
      printrus ("Уровень <u>$name_science</u> повысится на <b>$new_lvl</b>%,<br/>\r\n");
      printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientiststo&amp;d=yes\">Начать исследование</a><br/>");
      printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
      }
    }
  }
  else
  {
  //Текущие исследования
  $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
    $a=array();
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science' and ($mem[$i]['what']=='cow' or $mem[$i]['what']=='goats' or $mem[$i]['what']=='rams'))array_push($a,$mem[$i]);
    }else{
    $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science' and (what = 'cow' or what = 'goats' or what = 'rams')");
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
    if (count($a)!=0) printrus ("<form name=\"\" action=\"farm.php?$ses&amp;what=$what\" method=\"post\">\r\n");
    switch($what):
    case('cow'): $name = 'изучения коров';break;
    case('goats'): $name = 'изучения коз';break;
    case('rams'): $name = 'изучения баранов';break;
    endswitch;

    printrus("$name($people ученых)[осталось $time]<br/><input format='*N' name='peopleto' /><br/><a href=\"farm.php?$ses&amp;m=breakresearch&amp;what=$what\">прервать</a><br/>");
    printrus("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/><br/>");
    printrus("<input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/></form>-----<br />");
    }

  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_korov&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=cow\">Изучить коров</a> [<b>".$b['cow']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_koz&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=goats\">Изучить коз</a> [<b>".$b['goats']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_baran&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"farm.php?$ses&amp;m=upgraide&amp;n=rams\">Изучить баранов</a> [<b>".$b['rams']."%</b>]<br/>");
  printrus("<a href=\"farm.php?$ses\">Назад</a><br/>");
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
 if($what == 'cow')$name_science='изучения коров';
 if($what == 'goats')$name_science='изучения коз';
 if($what == 'rams')$name_science='изучения баранов';

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

printrus("<a href='farm.php?$ses&amp;m=upgraide'>Ок</a><br/>");

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

printrus("<a href='farm.php?$ses&amp;m=upgraide'>Ок</a><br/>");

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

printrus("<a href='farm.php?$ses&amp;m=upgraide'>Ок</a><br/>");

break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Активировать Святую стену:::::::::::::::::::::::::::::::::::::::::::::::::::::
case('wall'):

printrus ("<u>Святая стена</u><br/>\r\n");
  if($n == 'activate' and ($time_uz+259200) < time())
  {
    if(200000>$money){
    printrus ("У вас нет 200000 денег! (всего: <b>".$money."</b>)<br/>\r\n");
    printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
    }elseif(10000>$iron){
    printrus ("У вас нет 10000 железа! (всего: <b>".$iron."</b>)<br/>\r\n");
    printrus("<a href='farm.php?$ses'>Отмена</a><br/>");
    }
    else
    {
    mysql_query("UPDATE countries SET money = money - 200000, iron = iron - 10000 WHERE countryID='".$b['countryID']."'");
    $b['money'] = $b['money'] - 200000;
    $b['iron'] = $b['iron'] - 10000;
      if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
    mysql_query("UPDATE buildings SET time_uz = '".time()."' WHERE countryID = '$countryID' and building = 'farm' LIMIT 1");

    $key=_PREFIKS.':buildings'.$countryID;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='farm'){
        $mem[$i]['time_uz']=time();
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }

      if(isNewBuildings($countryID,'wall')){
      mysql_query("UPDATE buildings SET hits=hits+'100' WHERE countryID='".$countryID."' and building='wall'");
      $key=_PREFIKS.':buildings'.$countryID;
        if (($mem=$memcache->get($key))!==FALSE){
          for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='wall'){
          $mem[$i]['hits'] = $mem[$i]['hits'] + 100;
          break;
          }
        $memcache->set($key,$mem,false,86400);
        }
      }

    //Пишем в лог:
    @$open=fopen("../logs/nz".$countryID,"a+");
    @flock ($open,LOCK_EX);
    @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." активировал святую стену.<br />Начало ".date("d.m.y H:i",time())." Москвы до ".date("d.m.y H:i",(time()+259200))." Москвы<br />-------------------------\n");
    @fflush($open);
    @flock ($open,LOCK_UN);
    @fclose($open);

    printrus("Вы активировали святую стену.<br />Начало ".date("d.m.y H:i",time())." Москвы до ".date("d.m.y H:i",(time()+259200))." Москвы<br/>");
    }
  }
  else
  {
    if(($time_uz+259200) > time()){
    printrus("Святая стена была активирована в ".date("H:i d.m.y",$time_uz).".<br />Время деактивации: ".date("H:i d.m.y",($time_uz+259200))."<br/>Осталось: ".mkTimeStr(($time_uz+259200)-date(U))."<br />");
    }
    else
    {
    printrus("Вы можете активировать Святую стену раз в 3 игровых года.<br />
    Для активации Святой стены требуется:<br /><br />
    <b>200000</b> денег и <b>10000</b> железа<br />
    Святая стена повышает параметры стены и войск на этой стене:<br /><br />
    Укрепление стены + 100%<br />
    +5 силы и скорости - пехотинцам, кавалеристам, стрелкам, подрывникам, магам. <br /><br />");
    printrus("<a href='farm.php?$ses&amp;m=wall&amp;n=activate'>Активировать Святую стену</a><br/>");
    }
  }
printrus("<a href='farm.php?$ses'>Назад</a><br/>");

break;
endswitch;

}

//============================================================================= Конец скрипту ================================================================
printrus("-----<br /><a href='../game.php?$ses'>На главную</a><br/>");
//футер страницы:
include_once("../other_inc/footer.php");

?>