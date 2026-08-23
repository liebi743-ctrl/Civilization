<?php
/*================================================= Алтарь смерти (уникальное здание расы - Демоны) =================================================*/
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['d'])) $d = $_REQUEST['d'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['scientists'])) $scientists = ceil($_REQUEST['scientists']);
if (isset($scientists)&&!is_numeric($scientists)) $scientists=0;
if (isset($scientists)&&$scientists<0) $scientists=0;

if (isset($_REQUEST['wariorsto_0'])) $wariorsto_1 = $_REQUEST['wariorsto_0'];
if (isset($wariorsto_1)&&!is_numeric($wariorsto_1)) $wariorsto_1=0;
if (isset($wariorsto_1)&&$wariorsto_1<0) $wariorsto_1=0;
if (!isset($wariorsto_1)) $wariorsto_1=0;
if (isset($_REQUEST['wariorsto_1'])) $wariorsto_2 = $_REQUEST['wariorsto_1'];
if (isset($wariorsto_2)&&!is_numeric($wariorsto_2)) $wariorsto_2=0;
if (isset($wariorsto_2)&&$wariorsto_2<0) $wariorsto_2=0;
if (!isset($wariorsto_2)) $wariorsto_2=0;
if (isset($_REQUEST['wariorsto_2'])) $wariorsto_3 = $_REQUEST['wariorsto_2'];
if (isset($wariorsto_3)&&!is_numeric($wariorsto_3)) $wariorsto_3=0;
if (isset($wariorsto_3)&&$wariorsto_3<0) $wariorsto_3=0;
if (!isset($wariorsto_3)) $wariorsto_3=0;

if (isset($_REQUEST['w_0'])) $w_1 = $_REQUEST['w_0'];
if (isset($w_1)&&!is_numeric($w_1)) $w_1=0;
if (isset($w_1)&&$w_1<0) $w_1=0;
if (!isset($w_1)) $w_1=0;
if ($w_1>3) $w_1=0;
if (isset($_REQUEST['w_1'])) $w_2 = $_REQUEST['w_1'];
if (isset($w_2)&&!is_numeric($w_2)) $w_2=0;
if (isset($w_2)&&$w_2<0) $w_2=0;
if (!isset($w_2)) $w_2=0;
if ($w_2>3) $w_2=0;
if (isset($_REQUEST['w_2'])) $w_3 = $_REQUEST['w_2'];
if (isset($w_3)&&!is_numeric($w_3)) $w_3=0;
if (isset($w_3)&&$w_3<0) $w_3=0;
if (!isset($w_3)) $w_3=0;
if ($w_3>3) $w_3=0;
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what)&&$what!='offerings_troops'&&$what!='offerings_scientists')exit;

if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;
if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;

if (isset($_REQUEST['pl'])) $pl = ceil($_REQUEST['pl']);
if (isset($pl)&&!is_numeric($pl)) $pl=0;
if (isset($pl)&&$pl<0) $pl=0;
if ($pl>3) $pl=0;
if (isset($_REQUEST['sts'])) $sts = ceil($_REQUEST['sts']);
if (isset($sts)&&!is_numeric($sts)) $sts=0;
if (isset($sts)&&$sts<0) $sts=0;
if ($sts>3) $sts=0;
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
$workers=$b['workers'];
$money=$b['money'];
$iron=$b['iron'];
//******************************************************************************
//проверка на наличие здания:****************************************

build_exists_print($countryID,'altar');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************

is_repairing($countryID,'altar',$m);

if($is_rep==0){

 switch($m):

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим главную здания)::::::::::::::::::::::::::::::

default:
printrus ("<u>Алтарь смерти</u><br/>\r\n");
printrus("<a href=\"guard.php?$ses&amp;bld=altar\">Охрана</a>[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]<br/>");
printrus("<a href=\"altar.php?$ses&amp;m=sacrifice\">Алтарь жертва приношений</a><br/>");
printrus("<a href=\"altar.php?$ses&amp;m=upgraide\">Улучшить алтарь</a><br/>");
if(($time_uz+259200) < time()){printrus("<a href=\"altar.php?$ses&amp;m=citadel\">Активировать Черную цитадель</a><br/>");}
else{printrus("<a href=\"altar.php?$ses&amp;m=citadel\">Черная цитадель</a><br/>");}
if($hits<100){printrus("<a href=\"altar.php?$ses&amp;m=repaire\">Починить</a>(".mkWarning($hits)."%)<br/>");}

break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('repaire'):
repair($countryID,'altar',$m);
break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Алтарь жертва приношений::::::::::::::::::::::::::::::::::::::::::::::::::::::

case('sacrifice'):

printrus ("<u>Алтарь жертва приношений</u><br/>\r\n");
  /********************* Сделать приношение *****************************/
  if($n == 'offering' and ($time_sac+259200) < time() and ($peopleto>0 or $scientiststo>0 or $wariorsto_1>0 or $wariorsto_2>0 or $wariorsto_3>0))
  {
    /*Все проверки по рабочим*/
    if($peopleto > $workers){
    printrus ("У вас нет столько рабочих! (всего: <b>".$workers."</b>)<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($peopleto >= 1 and $peopleto < 100){
    printrus ("Для приношения необходимо минимум 100 рабочих!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($peopleto >= 1 and $pl == 0 and !preg_match('~^[\d]+$~', ($peopleto/100))){
    printrus ("Неверно задано количество рабочих за деньги!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($peopleto >= 1 and $pl == 1 and !preg_match('~^[\d]+$~', ($peopleto/2000))){
    printrus ("Неверно задано количество рабочих за мораль генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($peopleto >= 1 and $pl == 2 and !preg_match('~^[\d]+$~', ($peopleto/2000))){
    printrus ("Неверно задано количество рабочих за удачу генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($peopleto >= 1 and $pl == 3 and !preg_match('~^[\d]+$~', ($peopleto/10000))){
    printrus ("Неверно задано количество рабочих за параметры войск!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }
    /*Все проверки по ученым*/
    elseif($scientiststo > $scientists){
    printrus ("У вас нет столько ученых! (всего: <b>".$b['scientists']."</b>)<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($scientiststo >= 1 and $scientiststo < 100){
    printrus ("Для приношения необходимо минимум 100 ученых!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($scientiststo >= 1 and $b['offerings_scientists'] < 100){
    printrus ("Вам пока недоступно приношение ученых!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($scientiststo >= 1 and $sts == 0 and !preg_match('~^[\d]+$~', ($scientiststo/100))){
    printrus ("Неверно задано количество ученых за деньги!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($scientiststo >= 1 and $sts == 1 and !preg_match('~^[\d]+$~', ($scientiststo/2000))){
    printrus ("Неверно задано количество ученых за мораль генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($scientiststo >= 1 and $sts == 2 and !preg_match('~^[\d]+$~', ($scientiststo/2000))){
    printrus ("Неверно задано количество ученых за удачу генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($scientiststo >= 1 and $sts == 3 and !preg_match('~^[\d]+$~', ($scientiststo/10000))){
    printrus ("Неверно задано количество ученых за параметры войск!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }
    /*Все проверки по пехам*/
    elseif(($wariorsto_1 >= 1 or $wariorsto_2 >= 1 or $wariorsto_3 >= 1) and $b['offerings_troops'] < 100){
    printrus ("Вам пока недоступно приношение войска!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_1 > $b['wariors_free']){
    printrus ("У вас нет столько ".get_unit_name(0)."! (всего: <b>".$b['wariors_free']."</b>)<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_1 >= 1 and $wariorsto_1 < 200){
    printrus ("Для приношения необходимо минимум 200 ".get_unit_name(0)."!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_1 >= 1 and $w_1 == 0 and !preg_match('~^[\d]+$~', ($wariorsto_1/200))){
    printrus ("Неверно задано количество ".get_unit_name(0)." за деньги!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_1 >= 1 and $w_1 == 1 and !preg_match('~^[\d]+$~', ($wariorsto_1/400))){
    printrus ("Неверно задано количество ".get_unit_name(0)." за мораль генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_1 >= 1 and $w_1 == 2 and !preg_match('~^[\d]+$~', ($wariorsto_1/400))){
    printrus ("Неверно задано количество ".get_unit_name(0)." за удачу генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_1 >= 1 and $w_1 == 3 and !preg_match('~^[\d]+$~', ($wariorsto_1/400))){
    printrus ("Неверно задано количество ".get_unit_name(0)." за параметры войск!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }
    /*Все проверки по коням*/
    elseif($wariorsto_2 > $b['wariors_free_2']){
    printrus ("У вас нет столько ".get_unit_name(1)."! (всего: <b>".$b['wariors_free_2']."</b>)<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_2 >= 1 and $wariorsto_2 < 300){
    printrus ("Для приношения необходимо минимум 300 ".get_unit_name(1)."!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_2 >= 1 and $w_2 == 0 and !preg_match('~^[\d]+$~', ($wariorsto_2/300))){
    printrus ("Неверно задано количество ".get_unit_name(1)." за деньги!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_2 >= 1 and $w_2 == 1 and !preg_match('~^[\d]+$~', ($wariorsto_2/800))){
    printrus ("Неверно задано количество ".get_unit_name(1)." за мораль генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_2 >= 1 and $w_2 == 2 and !preg_match('~^[\d]+$~', ($wariorsto_2/800))){
    printrus ("Неверно задано количество ".get_unit_name(1)." за удачу генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_2 >= 1 and $w_2 == 3 and !preg_match('~^[\d]+$~', ($wariorsto_2/900))){
    printrus ("Неверно задано количество ".get_unit_name(1)." за параметры войск!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }
    /*Все проверки по стрелам*/
    elseif($wariorsto_3 > $b['wariors_free_3']){
    printrus ("У вас нет столько ".get_unit_name(2)."! (всего: <b>".$b['wariors_free_3']."</b>)<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_3 >= 1 and $wariorsto_3 < 400){
    printrus ("Для приношения необходимо минимум 400 ".get_unit_name(2)."!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_3 >= 1 and $w_3 == 0 and !preg_match('~^[\d]+$~', ($wariorsto_3/1000))){
    printrus ("Неверно задано количество ".get_unit_name(2)." за деньги!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_3 >= 1 and $w_3 == 1 and !preg_match('~^[\d]+$~', ($wariorsto_3/1000))){
    printrus ("Неверно задано количество ".get_unit_name(2)." за мораль генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_3 >= 1 and $w_3 == 2 and !preg_match('~^[\d]+$~', ($wariorsto_3/1000))){
    printrus ("Неверно задано количество ".get_unit_name(2)." за удачу генералу!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }elseif($wariorsto_3 >= 1 and $w_3 == 3 and !preg_match('~^[\d]+$~', ($wariorsto_3/1000))){
    printrus ("Неверно задано количество ".get_unit_name(2)." за параметры войск!<br/>\r\n");
    printrus("<a href='altar.php?$ses&amp;m=sacrifice'>назад</a><br/>");
    }
    else /*Если всё ништяк, то считаем и выдаём*/
    {
    /*рабочии*/
    if($pl == 0)$res1_peopleto=$peopleto/100*400; /*на деньги*/
    if($pl == 1)$res2_peopleto=$peopleto/2000*1; /*на мораль*/
    if($pl == 2)$res3_peopleto=$peopleto/2000*1; /*на удачу*/
    if($pl == 3)$res4_peopleto=$peopleto/10000*1; /*на войско*/
    /*ученые*/
    if($sts == 0)$res1_scientiststo=$scientiststo/100*600; /*на деньги*/
    if($sts == 1)$res2_scientiststo=$scientiststo/2000*1; /*на мораль*/
    if($sts == 2)$res3_scientiststo=$scientiststo/2000*1; /*на удачу*/
    if($sts == 3)$res4_scientiststo=$scientiststo/10000*1; /*на войско*/
    /*пехи*/
    if($w_1 == 0)$res1_wariorsto_1=$wariorsto_1/200*1500; /*на деньги*/
    if($w_1 == 1)$res2_wariorsto_1=$wariorsto_1/400*1; /*на мораль*/
    if($w_1 == 2)$res3_wariorsto_1=$wariorsto_1/400*1; /*на удачу*/
    if($w_1 == 3)$res4_wariorsto_1=$wariorsto_1/400*1; /*на войско*/
    /*кони*/
    if($w_2 == 0)$res1_wariorsto_2=$wariorsto_2/300*2500; /*на деньги*/
    if($w_2 == 1)$res2_wariorsto_2=$wariorsto_2/800*2; /*на мораль*/
    if($w_2 == 2)$res3_wariorsto_2=$wariorsto_2/800*2; /*на удачу*/
    if($w_2 == 3)$res4_wariorsto_2=$wariorsto_2/900*2; /*на войско*/
    /*стрелы*/
    if($w_3 == 0)$res1_wariorsto_3=$wariorsto_3/400*4500; /*на деньги*/
    if($w_3 == 1)$res2_wariorsto_3=$wariorsto_3/1000*3; /*на мораль*/
    if($w_3 == 2)$res3_wariorsto_3=$wariorsto_3/1000*3; /*на удачу*/
    if($w_3 == 3)$res4_wariorsto_3=$wariorsto_3/1000*3; /*на войско*/
    /*Сколько всего денег получилось*/
    $vs_money=$res1_peopleto+$res1_scientiststo+$res1_wariorsto_1+$res1_wariorsto_2+$res1_wariorsto_3;
    /*Сколько всего морали получилось*/
    $vs_moral=$res2_peopleto+$res2_scientiststo+$res2_wariorsto_1+$res2_wariorsto_2+$res2_wariorsto_3;
    /*Сколько всего удачи получилось*/
    $vs_ud=$res3_peopleto+$res3_scientiststo+$res3_wariorsto_1+$res3_wariorsto_2+$res3_wariorsto_3;
    /*Сколько всего к статам войск получилось*/
    $vs_skill=$res4_peopleto+$res4_scientiststo+$res4_wariorsto_1+$res4_wariorsto_2+$res4_wariorsto_3;

    mysql_query("UPDATE buildings SET time_sac = '".time()."', un_1 = '$vs_moral', un_2 = '$vs_ud', un_3 = '$vs_skill' WHERE countryID = '$countryID' and building = 'altar' LIMIT 1");

    $key=_PREFIKS.':buildings'.$countryID;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='altar'){
        $mem[$i]['time_sac']=time();
        $mem[$i]['un_1'] = $vs_moral;
        $mem[$i]['un_2'] = $vs_ud;
        $mem[$i]['un_3'] = $vs_skill;
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }

     mysql_query("UPDATE countries SET money = money + $vs_money, workers = workers - $peopleto, scientists = scientists - $scientiststo,
     wariors_free = wariors_free - $wariorsto_1, wariors_free_2 = wariors_free_2 - $wariorsto_2, wariors_free_3 = wariors_free_3 - $wariorsto_3
     WHERE countryID = '$countryID' LIMIT 1");

    $b['money'] = $b['money'] + $vs_money;
    $b['workers'] = $b['workers'] - $peopleto;
    $b['scientists'] = $b['scientists'] - $scientiststo;
    $b['wariors_free'] = $b['wariors_free'] - $wariorsto_1;
    $b['wariors_free_2'] = $b['wariors_free_2'] - $wariorsto_2;
    $b['wariors_free_3'] = $b['wariors_free_3'] - $wariorsto_3;

      if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

    //Пишем в лог:
    @$open=fopen("../logs/nz".$countryID,"a+");
    @flock ($open,LOCK_EX);
    @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." сделал приношение ".$print_peopleto."".$print_scientiststo."".print_voisko(array($wariorsto_1,$wariorsto_2,$wariorsto_3))."Получино: ".$print_money."".$print_moral."".$print_ud."".$print_skill."<br />-------------------------\n");
    @fflush($open);
    @flock ($open,LOCK_UN);
    @fclose($open);

    if($peopleto>0){$print_peopleto='рабочих: <b>'.$peopleto.'</b>,<br />';}
    if($scientiststo>0){$print_scientiststo='ученых: <b>'.$scientiststo.'</b>,<br />';}
    if($vs_money>0){$print_money='<b>'.$vs_money.'</b> денег, ';}
    if($vs_moral>0){$print_moral='<b>'.$vs_moral.'</b> морали генералу, ';}
    if($vs_ud>0){$print_ud='<b>'.$vs_ud.'</b> удачи генералу, ';}
    if($vs_skill>0){$print_skill='<b>+'.$vs_skill.'</b> к параметрам всех войск, ';}
    printrus("Вы сделали приношение:<br />".$print_peopleto."".$print_scientiststo."".print_voisko(array($wariorsto_1,$wariorsto_2,$wariorsto_3))."");
    printrus("Получино: ".$print_money."".$print_moral."".$print_ud."".$print_skill."<br />");
    }
  }
  /************** Главная алтаря жертва приношений **********************/
  else
  {
  $wariors_free=$b['wariors_free'];
  $wariors_free_2=$b['wariors_free_2'];
  $wariors_free_3=$b['wariors_free_3'];
    if(($time_sac+259200) > time()){
    printrus("Вы уже делали приношение.<br />Подождите: ".mkTimeStr(($time_sac+259200)-date(U))."<br />");
    printrus("<a href='altar.php?$ses'>назад</a><br/>");
    }else{
    $wariors=array($wariors_free,$wariors_free_2,$wariors_free_3);
    $num = 0;
    printrus ("<form name=\"\" action=\"altar.php?$ses&amp;m=sacrifice&amp;n=offering\" method=\"post\">\r\n");

      if($workers >= 1){
      if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=prin_rab&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
      printrus ("Рабочие: <b>$workers</b><br />
      <input format='*N' name='peopleto'/> за
      <select name=\"pl\">
      <option value=\"0\">деньги</option>
      <option value=\"1\">мораль генерала</option>
      <option value=\"2\">удачу</option>
      <option value=\"3\">войско</option>
      </select><br />"); $num++;}

      if($b['offerings_scientists'] >= 100 and $scientists >= 1){
      if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=prin_uchen&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
      printrus ("Ученые: <b>$scientists</b><br />
      <input format='*N' name='scientiststo'/> за
      <select name=\"sts\">
      <option value=\"0\">деньги</option>
      <option value=\"1\">мораль генерала</option>
      <option value=\"2\">удачу</option>
      <option value=\"3\">войско</option>
      </select><br />"); $num++;}

      for($i=0;$i<=3;$i++)
      {
        if ($b['offerings_troops'] >= 100 and $wariors[$i]>0){
        if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=prin_pexot&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
        printrus("".get_unit_name($i).": <b>".$wariors[$i]."</b>,<br />
        <input format='*N' name='wariorsto_".$i."'/> за
        <select name=\"w_".$i."\">
        <option value=\"0\">деньги</option>
        <option value=\"1\">мораль генерала</option>
        <option value=\"2\">удачу</option>
        <option value=\"3\">войско</option>
        </select><br/>"); $num++;}
      }

    if($num>=1){printrus("<input type=\"submit\" value=\"Сделать приношение\"/></form><br/>");}else{printrus("У вас нет свободных юнитов для приношения.<br/>");}
    }
  }
 {printrus("<a href=\"altar.php?$ses\">Назад</a>");}

 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Улучшить алтарь:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

 case('upgraide'):

printrus ("<u>Улучшение алтаря</u><br/>\r\n");

  if($n == 'troops' or $n == 'scientists')
  {
  if($n == 'troops'){$wn='offerings_troops'; $name_science='приношения войск';}else{$wn='offerings_scientists'; $name_science='приношения ученых';}
  $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
    $num=0;
      for ($i=0;$i<count($mem);$i++){
        if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==''.$wn.''){
        $num=1;
        break;
        }
      }
    }else{
    $query="select * from `works` where countryID='$countryID' and kind='science' and what='$wn' limit 1";
    $result=@MYSQL_QUERY($query);
    $num=@mysql_num_rows($result);
    }

    if($num>0){
    printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
    printrus("<a href='altar.php?$ses'>Отмена</a><br/>");
    }elseif($scientiststo>$scientists){
    printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
    printrus("<a href=\"altar.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a><br/>");
    printrus("<a href='altar.php?$ses'>Отмена</a><br/>");
    }elseif($scientiststo>2500){
    printrus ("Можно использовать максимум 2500 ученых!<br/>\r\n");
    printrus("<a href=\"altar.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=2500\">Использовать 2500 ученых</a><br/>");
    printrus("<a href='altar.php?$ses'>Отмена</a><br/>");
    }elseif($moneyto>$money){
    printrus ("У вас нет столько денег! (всего: <b>".$money."</b>)<br/>\r\n");
    printrus("<a href=\"altar.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$money&amp;scientiststo=$scientiststo\">Использовать все</a><br/>");
    printrus("<a href='altar.php?$ses'>Отмена</a><br/>");
    }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
    printrus ("Ученые: <b>".$b['scientists']."</b><br/>\r\n");
    printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
    printrus ("<form name=\"\" action=\"altar.php?$ses&amp;m=upgraide&amp;n=$n\" method=\"post\">\r\n");
    printrus ("<input format='*N' name='moneyto'/><br/>\r\n");
    printrus ("Ученые:<br/>\r\n");
    printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
    printrus("<input type=\"submit\" value=\"Исследовать\"/></form><br/>");
    }elseif($moneyto<150){
    printrus ("Необходимо выделить мимнимум 150 денег на исследование!<br/>\r\n");
    printrus("<a href=\"altar.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=150&amp;scientiststo=$scientiststo\">Выделить 150 денег</a><br/>");
    printrus("<a href='altar.php?$ses'>Отмена</a><br/>");
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

      $query="insert into `works` values('$countryID','science','$wn',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
      $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
      $key=_PREFIKS.':works'.$countryID;
        if (($mem=$memcache->get($key))!==FALSE){
        $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>$wn, "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
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
      printrus("<a href='altar.php?$ses'>Назад</a><br/>");
      }
      else
      {
      $work_time=round($moneyto/$scientiststo*2000);
      $new_lvl=round($moneyto/150);
      if($new_lvl > 100){$new_lvl=100;}
      printrus ("Уровень <u>$name_science</u> повысится на <b>$new_lvl</b>%,<br/>\r\n");
      printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      printrus("<a href=\"altar.php?$ses&amp;m=upgraide&amp;n=$n&amp;moneyto=$moneyto&amp;scientiststo=$scientiststo&amp;d=yes\">Начать исследование</a><br/>");
      printrus("<a href='altar.php?$ses'>Отмена</a><br/>");
      }
    }
  }
  else
  {
  //Текущие исследования
  $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
    $a=array();
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science' and ($mem[$i]['what']=='offerings_troops' or $mem[$i]['what']=='offerings_scientists'))array_push($a,$mem[$i]);
    }else{
    $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science' and (what = 'offerings_troops' or what = 'offerings_scientists')");
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
          if (count($a)!=0) printrus ("<form name=\"\" action=\"altar.php?$ses&amp;what=$what\" method=\"post\">\r\n");
          switch($what):
          case('offerings_troops'): $name = 'приношения войск';break;
          case('offerings_scientists'): $name = 'приношения ученых';break;
          endswitch;

    printrus("$name($people ученых)[осталось $time]<br/><input format='*N' name='peopleto' /><br/><a href=\"altar.php?$ses&amp;m=breakresearch&amp;what=$what\">прервать</a><br/>");
    printrus("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/><br/>");
    printrus("<input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/></form><br/>");
    }

  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_prin_voisk&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"altar.php?$ses&amp;m=upgraide&amp;n=troops\">Приношения войск</a> [<b>".$b['offerings_troops']."%</b>]<br/>");
  if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq_2.php?m=nauk_prin_uchen&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
  printrus("<a href=\"altar.php?$ses&amp;m=upgraide&amp;n=scientists\">Приношения ученых</a> [<b>".$b['offerings_scientists']."%</b>]<br/>");
  printrus("<a href=\"altar.php?$ses\">Назад</a><br/>");
  }


 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Прекращаем изучения по улучшениям алтаря::::::::::::::::::::::::::::::::::::::

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
 if($what == 'offerings_troops'){$name_science='приношения войск';}else{$name_science='приношения ученых';}
 mysql_query("UPDATE `countries` SET scientists = scientists + $people WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $people;
   if ($id_m==TRUE){
   $memcache->set($key1,$b,false,86400);
   }

 printrus("Исследование <u>$name_science</u> прекращено! Вернулись $people ученых<br/>\n");

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

printrus("<a href='altar.php?$ses&amp;m=upgraide'>Ок</a><br/>");

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

   printrus("Теперь исследованием занимаются ".($people-$peopleto)." ученых. Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

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

printrus("<a href='altar.php?$ses&amp;m=upgraide'>Ок</a><br/>");

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

   printrus("Теперь исследованием занимаются ".($people+$peopleto)." ученых. Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

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

printrus("<a href='altar.php?$ses&amp;m=upgraide'>Ок</a><br/>");

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Активировать Черную цитадель :::::::::::::::::::::::::::::::::::::::::::::::::
case('citadel'):

printrus ("<u>Черная цитадель</u><br/>\r\n");

  if($n == 'activate' and ($time_uz+518400) < time())
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

    mysql_query("UPDATE buildings SET time_uz = '".time()."' WHERE countryID = '$countryID' and building = 'altar' LIMIT 1");
    $key=_PREFIKS.':buildings'.$countryID;
      if (($mem=$memcache->get($key))!==FALSE){
        for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='altar'){
        $mem[$i]['time_uz']=time();
        break;
        }
      $memcache->set($key,$mem,false,86400);
      }
    printrus("Вы активировали черную цитадель.<br />Начало ".date("d.m.y H:i",time())." Москвы до ".date("d.m.y H:i",(time()+259200))." Москвы<br/>");

    //Пишем в лог:
    @$open=fopen("../logs/nz".$countryID,"a+");
    @flock ($open,LOCK_EX);
    @fwrite($open,date_new("H:i j.m:")."".$b['countryName']." активировал черную цитадель. Начало ".date("d.m.y H:i",time())." Москвы до ".date("d.m.y H:i",(time()+259200))." Москвы<br />-------------------------\n");
    @fflush($open);
    @flock ($open,LOCK_UN);
    @fclose($open);
    }
  }
  else
  {
    if(($time_uz+259200) > time()){
    $time_off=$time_uz+259200;/*на 3 суток*/
    printrus("Черная цитадель была активирована в ".date("H:i d.m.y",$time_uz).".<br />Время деактивации: ".date("H:i d.m.y",$time_off)."<br/>Осталось: ".mkTimeStr($time_off-date(U))."<br />");
    }
    else
    {
    printrus("Вы можете активировать черную цитадель раз в 3 игровых года.<br />
    Для активации черной цитадели требуется:<br />
    <b>200000</b> денег и <b>10000</b> железа<br />
    Черная цитадель дает всем параметрам цитадели:<br /><br />
    Шпионаж + 10<br />
    Саботаж +10<br />
    Воровство +10<br />
    Вербовка +10<br />
    Навык генералу +10<br />
    Мораль +10<br />
    Удача +10<br /><br />");
    printrus("<a href='altar.php?$ses&amp;m=citadel&amp;n=activate'>Активировать Черную цитадель</a><br/>");
    }
  }
printrus("<a href='altar.php?$ses'>Назад</a><br/>");


break;
endswitch;

}

//=============================================================================Конец скрипту================================================================
printrus("<br /><a href='../game.php?$ses'>На главную</a><br/>");
//футер страницы:
include_once("../other_inc/footer.php");
?>