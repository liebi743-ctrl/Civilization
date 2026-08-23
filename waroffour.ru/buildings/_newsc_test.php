<?
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = $_REQUEST['peopleto'];
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
//if (isset($_REQUEST['building'])) $building = $_REQUEST['building'];
if (isset($_REQUEST['scientiststo'])) $scientiststo = $_REQUEST['scientiststo'];
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what) && ($what!='arbor_making' &&$what!='demontaj' &&$what!='grain_making' &&$what!='stone_making' &&$what!='iron_making' &&$what!='oil_making' &&$what!='forest_adding' &&$what!='science' &&$what!='plotn_people' &&$what!='plotn_wariors' &&$what!='people_adding' &&$what!='atomic' &&$what!='forest_max'&&$what!='mountains_max' && $what!='scientists' && $what!='wariors'&& $what!='wariors_2'&& $what!='wariors_3'&& $what!='wariors_4'&& $what!='wariors_5'&& $what!='wariors_6'&& $what!='wariors_7'&& $what!='wariors_8')) exit;
if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;

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
worksRefresh($_SESSION['countryID']);
$countryID=$_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();

 $countryID = $_SESSION['countryID'];


//******************************************************************************
//проверка на наличие здания:****************************************

 #build_exists_print($countryID,'scientificcenter');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Научный центр</u><br/>\r\n");

 $noob=$_SESSION['noob'];

 is_repairing($countryID,'scientificcenter',$m);

 $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];
  $var2=10;
 if(($scientists<=0 && !isset($m))or ($scientists<=0 && $m!='breakresearch' && $m!='breakteaching' && $m!='minusresearch' && $m!='plusresearch' && $m!='minusteaching' && $m!='plusteaching')){
  printrus ("Уровень: <b>$var2</b><br/>");
  printrus ("У вас нет свободных ученых!<br/>\r\n");

  //Текущие исследования
  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $a=array();
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science')array_push($a,$mem[$i]);
     }else{
  $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science'");
  $a = array();
  while (($s=mysql_fetch_array($r))!==FALSE){
        array_push($a,$s);
        }

        }

  if (count($a)!=0) printrus("<u>Текущие исследования:</u><br/>Ученые:<br/>\r\n");
  if (count($a)!=0) printrus ("</small><input format='*N' name='peopleto' /><small><br/>\r\n");
  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $time = mkTimeStr($a[$i]['finished']-date(U));
          switch($what):
          case('arbor_making'): $name = 'производство древесины';break;
          case('grain_making'): $name = 'производство зерна';break;
          case('stone_making'): $name = 'производство камня';break;
          case('iron_making'): $name = 'производство железа';break;
          case('oil_making'): $name = 'добыча нефти';break;
          case('forest_adding'): $name = 'выращивание лесов';break;
          case('science'): $name = 'научный уровень';break;
          case('plotn_people'): $name = 'плотность населения';break;
          case('plotn_wariors'): $name = 'плотность войска';break;
          case('people_adding'): $name = 'прирост населения';break;
          case('atomic'): $name = 'атомная бомба';break;
          case('mountains_max'): $name = 'прочность шахт';break;
          case('forest_max'): $name = 'сохранение лесов';break;
          case('demontaj'): $name = 'демонтаж зданий';break;
          endswitch;

printrus
("$name($people ученых)[осталось $time]<br/><anchor>
прервать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='breakresearch'/>
<postfield name='what' value='$what'/>
</go>
</anchor>
<br/>
");
printrus
("<anchor>
отозвать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='minusresearch'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");
printrus
("<anchor>
добавить
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plusresearch'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");

          }


   //Текущие обучения
   $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $a=array();
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching')array_push($a,$mem[$i]);
     }else{
  $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'teaching'");
  $a = array();
  while (($s=mysql_fetch_array($r))!==FALSE){
        array_push($a,$s);
        }

  }

  if (count($a)!=0) printrus("<u>Текущие обучения:</u><br/>Ученые:<br/>\r\n");
  if (count($a)!=0) printrus ("</small><input format='*N' name='peopleto' /><small><br/>\r\n");
  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $wrks = $a[$i]['var1'];
          $time = mkTimeStr($a[$i]['finished']-date(U));
          switch($what):
          case('scientists'): $name = 'ученых';break;
          case('wariors'): $name = get_unit_name(0);break;
          case('wariors_2'): $name = get_unit_name(1);break;
          case('wariors_3'): $name = get_unit_name(2);break;
          case('wariors_4'): $name = get_unit_name(3);break;
          case('wariors_5'): $name = get_unit_name(4);break;
          case('wariors_6'): $name = get_unit_name(5);break;
          case('wariors_7'): $name = get_unit_name(6);break;
          case('wariors_8'): $name = get_unit_name(7);break;
          endswitch;

if($what!='wariors_4'&&$what!='wariors_6')
printrus
("Обучаются $wrks крестьян в $name(их учат $people ученых)[осталось $time]<br/><anchor>
прервать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='breakteaching'/>
<postfield name='what' value='$what'/>
</go>
</anchor>
<br/>
");
else
printrus
("Производятся $name(работают $people ученых)[осталось $time]<br/><anchor>
прервать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='breakteaching'/>
<postfield name='what' value='$what'/>
</go>
</anchor>
<br/>
");
printrus
("<anchor>
отозвать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='minusteaching'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");
printrus
("<anchor>
добавить
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plusteaching'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");

          }


  printrus ("-------<br/>\r\n");
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

if($is_rep==0){

 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
   printrus ("Уровень: <b>$var2</b><br/>");

   //Текущие исследования
  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $a=array();
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science')array_push($a,$mem[$i]);
     }else{
  $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science'");
  $a = array();
  while (($s=mysql_fetch_array($r))!==FALSE){
        array_push($a,$s);
        }

  }

  if (count($a)!=0) printrus("<u>Текущие исследования:</u><br/>Ученые:<br/>\r\n");
  if (count($a)!=0) printrus ("</small><input format='*N' name='peopleto' /><small><br/>\r\n");
  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $time = mkTimeStr($a[$i]['finished']-time());
          switch($what):
          case('arbor_making'): $name = 'производство древесины';break;
          case('grain_making'): $name = 'производство зерна';break;
          case('stone_making'): $name = 'производство камня';break;
          case('iron_making'): $name = 'производство железа';break;
          case('oil_making'): $name = 'добыча нефти';break;
          case('forest_adding'): $name = 'выращивание лесов';break;
          case('science'): $name = 'научный уровень';break;
          case('plotn_people'): $name = 'плотность населения';break;
          case('plotn_wariors'): $name = 'плотность войска';break;
          case('people_adding'): $name = 'прирост населения';break;
          case('atomic'): $name = 'атомная бомба';break;
          case('mountains_max'): $name = 'прочность шахт';break;
          case('forest_max'): $name = 'сохранение лесов';break;
          case('demontaj'): $name = 'демонтаж зданий';break;
          endswitch;

printrus
("$name($people ученых)[осталось $time]<br/><anchor>
прервать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='breakresearch'/>
<postfield name='what' value='$what'/>
</go>
</anchor>
<br/>
");
printrus
("<anchor>
отозвать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='minusresearch'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");
printrus
("<anchor>
добавить
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plusresearch'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");

          }


   //Текущие обучения

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $a=array();
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching')array_push($a,$mem[$i]);
     }else{
  $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'teaching'");
  $a = array();
  while (($s=mysql_fetch_array($r))!==FALSE){
        array_push($a,$s);
        }

  }


  if (count($a)!=0) printrus("<u>Текущие обучения:</u><br/>Ученые:<br/>\r\n");
  if (count($a)!=0) printrus ("</small><input format='*N' name='peopleto' /><small><br/>\r\n");
  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $wrks = $a[$i]['var1'];
          $time = mkTimeStr($a[$i]['finished']-time());
          switch($what):
          case('scientists'): $name = 'ученых';break;
          case('wariors'): $name = get_unit_name(0);break;
          case('wariors_2'): $name = get_unit_name(1);break;
          case('wariors_3'): $name = get_unit_name(2);break;
          case('wariors_4'): $name = get_unit_name_im(3);break;
          case('wariors_5'): $name = get_unit_name(4);break;
          case('wariors_6'): $name = get_unit_name_im(5);break;
          case('wariors_7'): $name = get_unit_name(6);break;
          case('wariors_8'): $name = get_unit_name(7);break;
          endswitch;

if($what!='wariors_4'&&$what!='wariors_6')
printrus
("Обучаются $wrks крестьян в $name(их учат $people ученых)[осталось $time]<br/><anchor>
прервать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='breakteaching'/>
<postfield name='what' value='$what'/>
</go>
</anchor>
<br/>
");
else
printrus
("Производятся $name(работают $people ученых)[осталось $time]<br/><anchor>
прервать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='breakteaching'/>
<postfield name='what' value='$what'/>
</go>
</anchor>
<br/>
");

printrus
("<anchor>
отозвать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='minusteaching'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");
printrus
("<anchor>
добавить
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plusteaching'/>
<postfield name='what' value='$what'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");

          }


  printrus
("<anchor>
Охрана
<go href='guard.php?$ses' method='post'>
<postfield name='bld' value='scientificcenter'/>
</go>
</anchor>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  printrus
("<anchor>
Ученые
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
[".mkWarning($scientists)."]
<br/>
");
  printrus
("<anchor>
Производство
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='makings'/>
</go>
</anchor>
<br/>
");
  if($var2>=1){
   printrus
("<anchor>
Дополнительно
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='addings'/>
</go>
</anchor>
<br/>
");
  }else{
   printrus ("<u>Дополнительно</u> (открывается с 1 уровня научного центра)<br/>\r\n");
  }

  if($hits<100){
   printrus
("<anchor>
Починить
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='repaire'/>
</go>
</anchor>
(".mkWarning($hits)."%)
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'scientificcenter',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//учим ученых:):::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('scientists'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='teaching'&&$mem[$i]['what']=='scientists'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='teaching' and what='scientists' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");
  if(empty($n)){
   printrus
("<anchor>
Обучить...
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
<postfield name='n' value='plus'/>
</go>
</anchor>
<br/>
");
   printrus
("<anchor>
Уволить...
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
<postfield name='n' value='minus'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="plus" and $num>0){
   printrus ("Подождите пока все крестьяне доучатся!<br/>\r\n");
   printrus
("<anchor>
Отмена
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="plus" and ($peopleto<=0 or empty($peopleto) or $scientiststo<=0 or empty($scientiststo))){
   printrus ("Сколько рабочих вы хотите обучить:<br/>\r\n");
   printrus ("</small><input format='*N' name='peopleto'/><small><br/>\r\n");
   printrus ("Учителя:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Обучить
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
<postfield name='n' value='plus'/>
<postfield name='peopleto' value='$(peopleto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="plus" and $scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
<postfield name='n' value='plus'/>
<postfield name='peopleto' value='$peopleto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("<anchor>
Отмена
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="plus" and $peopleto>$workers){
   printrus ("У вас нет столько свободных рабочих! (всего: <b>$workers</b>)<br/>\r\n");
   printrus
("<anchor>
Обучить всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
<postfield name='n' value='plus'/>
<postfield name='peopleto' value='$workers'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("<anchor>
Отмена
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="plus" and $peopleto>($space*$b["plotn_people"])){
   printrus ("Вы можете обучить только <b>".($space*$b["plotn_people"])."</b> крестьян!<br/>\r\n");
   printrus
("<anchor>
Обучить всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
<postfield name='n' value='plus'/>
<postfield name='peopleto' value='".($space*$b["plotn_people"])."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("<anchor>
Отмена
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="plus" and ($b["money"]<$peopleto*50 || $b['stone']<$peopleto*5)){

   printrus ("Не хватает ресурсов на обучение! (необходимо <b>".($peopleto*50)."</b> денег и <b>".($peopleto*5)."</b> камня)<br/>\r\n");
   printrus
("<anchor>
Отмена
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="plus"){
   $mmd = $peopleto*50;
   $snd = $peopleto*5;
   mysql_query("UPDATE countries SET workers = ($workers - $peopleto), scientists = ($scientists - $scientiststo), money = money - $mmd, stone = stone - $snd WHERE countryID = '".$b['countryID']."'");
   $b['workers'] = $workers - $peopleto;
   $b['scientists'] = $scientists-$scientiststo;
   $b['money'] = $b['money'] - $mmd;
   $b['stone'] = $b['stone'] - $snd;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($peopleto/($scientiststo*$b["science"])*10000)*10;

   $query="insert into works values('$countryID','teaching','scientists',$scientiststo,".date(U).",".($work_time+date(U)).", $peopleto, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'teaching', "what"=>'scientists', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$peopleto, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Обучение займет ".mkTimeStr($work_time).". Это стоило вам <b>".$mmd." денег</b> и <b>$snd</b> камня<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."обучает в центре $peopleto рабочих в ученых (учат $scientiststo). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="minus" and ($peopleto<=0 or empty($peopleto))){
   print "</small><input format='*N' name='peopleto'/><small><br/>\r\n";
   printrus
("<anchor>
Уволить
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
<postfield name='n' value='minus'/>
<postfield name='peopleto' value='$(peopleto)'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="minus" and $peopleto>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Отмена
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="minus" and $peopleto==$scientists){
   printrus ("Нельзя уволить всех ученых!<br/>\r\n");
   printrus
("<anchor>
Отмена
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='scientists'/>
</go>
</anchor>
<br/>
");
  }elseif($n=="minus"){
   mysql_query("UPDATE countries SET workers = ($workers+$peopleto), scientists = ($scientists-$peopleto) WHERE countryID = '".$b['countryID']."'");
   $b['workers'] = $workers+$peopleto;
   $b['scientists'] = $scientists-$peopleto;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("Вы только что уволили <b>$peopleto</b> ученых<br/>\r\n");
   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Промышленные исследования:::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('makings'):
  printrus
("<anchor>
Производство зерна
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='grain_making'/>
</go>
</anchor>
[<b>".$b["grain_making"]."</b>%]
<br/>
");
  printrus
("<anchor>
Производство древесины
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='arbor_making'/>
</go>
</anchor>
[<b>".$b["arbor_making"]."</b>%]
<br/>
");
  printrus
("<anchor>
Производство железа
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='iron_making'/>
</go>
</anchor>
[<b>".$b["iron_making"]."</b>%]
<br/>
");
  printrus
("<anchor>
Производство камня
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='stone_making'/>
</go>
</anchor>
[<b>".$b["stone_making"]."</b>%]
<br/>
");
  printrus
("<anchor>
Добыча нефти
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='oil_making'/>
</go>
</anchor>
[<b>".$b["oil_making"]."</b>%]
<br/>
");
  printrus
("
<a href='newsc.php?$ses'>&lt;&lt;</a>
<br/>
");
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Дополнительные исследования:::::::::::::::::::::::::::::::::::::::::::::::::::
 case('addings'):
  if($var2<1){
   printrus ("Дополнительные исследования недоступны!<br/>\r\n");
  }else{
   if($var2>=1){
    printrus
("<anchor>
Выращивание лесов
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_adding'/>
</go>
</anchor>
[<b>".$b["forest_adding"]."</b>%]
<br/>
");
   }
   if($var2>=3){   	printrus
("<anchor>
Демонтаж зданий
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='demontaj'/>
</go>
</anchor>
[<b>".$b["demontaj"]."</b>%]
<br/>
");
    printrus
("<anchor>
Научный уровень
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='science'/>
</go>
</anchor>
[<b>".$b["science"]."</b>%]
<br/>
");
   }
   if($var2>=5){
    printrus
("<anchor>
Макс. плотность населения
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_people'/>
</go>
</anchor>
[<b>".$b["plotn_people"]."</b>]
<br/>
");
   }
   if($var2>=7){
    printrus
("<anchor>
Макс. плотность войска
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_wariors'/>
</go>
</anchor>
[<b>".$b["plotn_wariors"]."</b>]
<br/>
");
   }
   if($var2>=9){
    printrus
("<anchor>
Прирост населения
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='people_adding'/>
</go>
</anchor>
[<b>".$b["people_adding"]."</b>%]
<br/>
");


printrus
("<anchor>
Атомная бомба
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='atomic'/>
</go>
</anchor>
<br/>
");

if (building_exists($countryID,'zavod'))
printrus
("<anchor>
Прочность шахт
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='mountains_max'/>
</go>
</anchor>
[<b>".$b["mountains_max"]."</b>%]
<br/>
");

if (building_exists($countryID,'gorodmagov'))
printrus
("<anchor>
Сохранение лесов
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_max'/>
</go>
</anchor>
[<b>".$b["forest_max"]."</b>%]
<br/>
");

   }

$key=_PREFIKS.':otkrytiya'.$countryID;
if (($mem=$memcache->get($key))!==FALSE){
   $ot=$mem;
   }else{
   $r=mysql_query("SELECT * FROM `otkrytiya` WHERE countryID = '$countryID'");
   $ot=array();
   while(($a=mysql_fetch_array($r))!==FALSE){
   array_push($ot,$a);
   }

   }
if (count($ot)>0){  //Есть дополнительные открытия
   printrus("Дополнительно исследованы: ");
   for ($i=0;$i<count($ot);$i++){
       if ($ot[$i]['otkr']=='STLI') {
          printrus("<u>стальная арматура</u>");
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='STLI'/>
</go>
</anchor>],
");
          }
       if ($ot[$i]['otkr']=='PERJ') {
          printrus("<u>переплавка железа</u>");
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='PERJ'/>
</go>
</anchor>],
");
          }
       if ($ot[$i]['otkr']=='DOLG') {
          printrus("<u>элексир долголетия</u>");
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='DOLG'/>
</go>
</anchor>],
");
          }
       if ($ot[$i]['otkr']=='BERS') {
          printrus("<u>берсерк</u>");
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='BERS'/>
</go>
</anchor>],
");
          }




       }
   printrus("<br/>\n");
   }

  }
  printrus
("
<a href='newsc.php?$ses'>&lt;&lt;</a>
<br/>
");
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Производство зерна::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('grain_making'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='grain_making'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='grain_making' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='grain_making'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='grain_making'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='grain_making'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*60000);
   $new_lvl=round(($moneyto*$b["science"]/10000)*100/2);

   $query="insert into works values('$countryID','science','grain_making',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'grain_making', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует произв.зерна до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Производство дерева:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('arbor_making'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='arbor_making'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='arbor_making' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='arbor_making'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='arbor_making'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='arbor_making'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*60000);
   $new_lvl=round(($moneyto*$b["science"]/10000)*100/2);

   $query="insert into works values('$countryID','science','arbor_making',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'arbor_making', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует произв.дерева до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Производство железа:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('iron_making'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='iron_making'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='iron_making' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='iron_making'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='iron_making'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='iron_making'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*80000);
   $new_lvl=round(($moneyto*$b["science"]/10000)*100/2);

   $query="insert into works values('$countryID','science','iron_making',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'iron_making', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует произв.железа до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Производство камня :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('stone_making'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='stone_making'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='stone_making' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='stone_making'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='stone_making'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='stone_making'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*60000);
   $new_lvl=round(($moneyto*$b["science"]/10000)*100/2);

   $query="insert into works values('$countryID','science','stone_making',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'stone_making', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует произв.камня до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Добыча нефти::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('oil_making'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='oil_making'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='oil_making' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='oil_making'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='oil_making'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='oil_making'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."' LIMIT 1");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*100000);
   $new_lvl=round(($moneyto*$b["science"]/10000)*100/2);

   $query="insert into works values('$countryID','science','oil_making',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'oil_making', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует произв.нефти до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Научный уровень:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('science'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='science'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='science' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($var2<3){
   printrus ("Это исследование пока недоступно! (требуется уровень выше третьего)<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='science'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='science'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='science'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round(120*(1+round($moneyto/200))/($scientiststo*10)*80000);
   $new_lvl=round(($moneyto*10/20000)*100);

   $query="insert into `works` values('$countryID','science','science',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'science', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует науч.уровень до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Плотность населения:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('plotn_people'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='plotn_people'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='plotn_people' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($var2<5){
   printrus ("Это исследование пока недоступно! (требуется уровень выше пятого)<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_people'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_people'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_people'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*100000);
   $new_lvl=round(($moneyto*$b["science"]/20000)*100);

   $query="insert into `works` values('$countryID','science','plotn_people',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'plotn_people', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует плотн.населения до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;









//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Демонтаж зданий:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('demontaj'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='demontaj'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='demontaj' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($var2<5){
   printrus ("Это исследование пока недоступно! (требуется уровень выше пятого)<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='demontaj'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='demontaj'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='demontaj'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*100000);
   $new_lvl=round(($moneyto*$b["science"]/20000)*100);

   $query="insert into `works` values('$countryID','science','demontaj',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'demontaj', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует Демонтаж зданий до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;

#######################
#############################
###################################

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Плотность войска::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('plotn_wariors'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='plotn_wariors'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='plotn_wariors' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($var2<7){
   printrus ("Это исследование пока недоступно! (требуется уровень выше седьмого)<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_wariors'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_wariors'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='plotn_wariors'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*100000);
   $new_lvl=round(($moneyto*$b["science"]/20000)*100);

   $query="insert into `works` values('$countryID','science','plotn_wariors',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'plotn_wariors', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует плотн.войска до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//АТОМНАЯ БОМБА:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('atomic'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='atomic'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='atomic' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($b['atomic']!=0){
  printrus ("У вас уже есть атомная бомба! Невозможно произвести еще одну!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($var2<=9){
   printrus ("Это исследование пока недоступно! (требуется уровень выше девятого)<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){

   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");

   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='atomic'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='atomic'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='atomic'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto<35000){
   printrus ("На это исследование надо выделить минимум <b>35000</b>!<br/>\r\n");
   printrus
("<anchor>
Выделить 35000
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='atomic'/>
<postfield name='moneyto' value='35000'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=max(3600*24*2,round(3600*24*2/$scientiststo*300));
   $new_lvl=10;

   $query="insert into `works` values('$countryID','science','atomic',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'atomic', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует атомн.бомбу до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Прирост населения:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('people_adding'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='people_adding'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='people_adding' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($var2<9){
   printrus ("Это исследование пока недоступно! (требуется уровень выше девятого)<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='people_adding'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='people_adding'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='people_adding'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*100000);
   $new_lvl=round(($moneyto*$b["science"]/20000)*100);

   $query="insert into `works` values('$countryID','science','people_adding',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'people_adding', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует прирост насел. до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Выращивание лесов:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('forest_adding'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='forest_adding'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='forest_adding' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($var2<1){
   printrus ("Это исследование пока недоступно! (требуется уровень выше первого)<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_adding'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_adding'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_adding'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($moneyto/($scientiststo*$b["science"])*100000);
   $new_lvl=round(($moneyto*$b["science"]/10000)*100);

   $query="insert into `works` values('$countryID','science','forest_adding',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'forest_adding', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует выращ.лесов до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Прочность шахт::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('mountains_max'):
 if (!building_exists($countryID,'zavod')){
 printrus("Для этого исследования необходима постройка завода!<br/>\n");
 }else{

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='mountains_max'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='mountains_max' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='mountains_max'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='mountains_max'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='mountains_max'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."' LIMIT 1");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round(120*(1+round($moneyto/200))/($scientiststo*$b['science'])*80000);
   $new_lvl=round(($moneyto*10/20000)*100);

   $query="insert into `works` values('$countryID','science','mountains_max',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'mountains_max', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует прочн.шахт до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }

  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Сохранение лесов::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('forest_max'):
 if (!building_exists($countryID,'gorodmagov')){
 printrus("Для этого исследования необходима постройка Города магов!<br/>\n");
 }else{

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='forest_max'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='forest_max' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='money'/>
</go>
</anchor>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("</small><input format='*N' name='moneyto'/><small><br/>\r\n");
   if($noob>=1)
    printrus
("[<anchor>
?
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='help'/>
<postfield name='n' value='scientists'/>
</go>
</anchor>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("</small><input format='*N' name='scientiststo'/><small><br/>\r\n");
   printrus
("<anchor>
Исследовать
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_max'/>
<postfield name='moneyto' value='$(moneyto)'/>
<postfield name='scientiststo' value='$(scientiststo)'/>
</go>
</anchor>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать всех
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_max'/>
<postfield name='moneyto' value='$moneyto'/>
<postfield name='scientiststo' value='$scientists'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<anchor>
Использовать все
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='forest_max'/>
<postfield name='moneyto' value='".$b["money"]."'/>
<postfield name='scientiststo' value='$scientiststo'/>
</go>
</anchor>
<br/>
");
   printrus
("
<a href='newsc.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."' LIMIT 1");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round(120*(1+round($moneyto/200))/($scientiststo*$b['science'])*80000);
   $new_lvl=round(($moneyto*10/20000)*100);

   $query="insert into `works` values('$countryID','science','forest_max',$scientiststo,".date(U).",".($work_time+date(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'forest_max', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."исследует сохран.лесов до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }

  }
 break;


////////////////////////////////////////////////////////////////////////////////
//Прекращаем исследование///////////////////////////////////////////////////////
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
 mysql_query("UPDATE `countries` SET scientists = scientists + $people WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $people;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Исследование прекращено! Из лаборатории вернулись $people ученых<br/>\n");

 mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
          }else array_push($neww,$mem[$i]);
      $memcache->set($key,$neww,false,86400);
      }

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."прекращает исслед. $what. Вернулось $people ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }else{
       printrus("Вы не ведете данное исследование!<br/>\n");
         }
 printrus
("
<a href='newsc.php?$ses'>Ок</a>
<br/>
");

 break;

 ////////////////////////////////////////////////////////////////////////////////
//Отзываем $peopleto ученых с исследования///////////////////////////////////////
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
 $newfinished=round(time()+($people/($people-$peopleto)*($finished-time()))+1);

 mysql_query("UPDATE `countries` SET scientists = scientists + $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь исследованием занимаются ".($people-$peopleto)." ученых. Исследование будет завершено через ".mkTimeStr($newfinished-time())."<br/>\n");

 mysql_query("UPDATE `works` SET finished = '".$newfinished."', peopleatwork='".($people-$peopleto)."' WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 //mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
          $mem[$i]['finished']=$newfinished;
          $mem[$i]['peopleatwork']=$people-$peopleto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."отзывает от исследования $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }

 }else{
       printrus("Вы не ведете данное исследование!<br/>\n");
         }
 printrus
("
<a href='newsc.php?$ses'>Ок</a>
<br/>
");

 break;

 ////////////////////////////////////////////////////////////////////////////////
//Добавляем $peopleto ученых к исследованию//////////////////////////////////////
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
 }else{
 if ($what!='atomic')$newfinished=round(time()+(($people)/($people+$peopleto)*($finished-time()))+1);
 else $newfinished=$finished;

 mysql_query("UPDATE `countries` SET scientists = scientists - $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] - $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь исследованием занимаются ".($people+$peopleto)." ученых. Исследование будет завершено через ".mkTimeStr($newfinished-time())."<br/>\n");

 mysql_query("UPDATE `works` SET finished = '".$newfinished."', peopleatwork='".($people+$peopleto)."' WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 //mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science'&&$mem[$i]['what']==$what){
          $mem[$i]['finished']=$newfinished;
          $mem[$i]['peopleatwork']=$people+$peopleto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."добавляет к исследованию $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }

 }else{
       printrus("Вы не ведете данное исследование!<br/>\n");
         }
 printrus
("
<a href='newsc.php?$ses'>Ок</a>
<br/>
");

 break;

 ////////////////////////////////////////////////////////////////////////////////
//Прекращаем обучение////////////////////////////////////////////////////////////
 case('breakteaching'):
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching'&&$mem[$i]['what']==$what){
          $num=1;
          $people=$mem[$i]['peopleatwork'];
          if ($what!='wariors_4'&&$what!='wariors_6')$wrks = $mem[$i]['var1'];
          else $wrks=0;
          break;
          }
      }else{
 $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'teaching' and what = '$what' LIMIT 1");
 $num=mysql_num_rows($r);
 $a = mysql_fetch_array($r);
 $people = $a['peopleatwork'];  //Сколько ученых ведут обучение
 if ($what!='wariors_4'&&$what!='wariors_6')$wrks = $a['var1']; //Сколько народа они обучают
 else $wrks=0;
 }

 if ($num!=0){
 mysql_query("UPDATE `countries` SET scientists = scientists + $people, workers = workers + $wrks WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $people;
 $b['workers'] = $b['workers'] + $wrks;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Обучение прекращено! Из лаборатории вернулись $people ученых и $wrks рабочих<br/>\n");

 mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'teaching' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww=array();
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching'&&$mem[$i]['what']==$what){
          }else array_push($neww,$mem[$i]);
      $memcache->set($key,$neww,false,86400);
      }

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."прекращает обучение $what. Вернулось $people ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }else{
       printrus("Вы не ведете данное обучение!<br/>\n");
         }
 printrus
("
<a href='newsc.php?$ses'>Ок</a>
<br/>
");

 break;

 ////////////////////////////////////////////////////////////////////////////////
//Отзываем $peopleto ученых с обучения///////////////////////////////////////////
 case('minusteaching'):

 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching'&&$mem[$i]['what']==$what){
          $num=1;
          $people=$mem[$i]['peopleatwork'];
          $finished=$mem[$i]['finished'];
          break;
          }
      }else{
 $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'teaching' and what = '$what' LIMIT 1");
 $num=mysql_num_rows($r);
 $a = mysql_fetch_array($r);
 $people = $a['peopleatwork'];
 $finished = $a['finished'];
 }

 if ($num!=0){

 if (!isset($peopleto)||$peopleto<=0){
 printrus("Укажите целое положительное число ученых!<br/>\r\n");
 }elseif($peopleto>$people-1){
 printrus("На обучении находится всего <b>$people</b> ученых! (можно отозвать ".($people-1).")<br/>\r\n");
 }else{
 if ($what!='atomic')$newfinished=round(time()+($people/($people-$peopleto)*($finished-time()))+1);
 else $newfinished=min(100*3600,round(time()+($people/($people-$peopleto)*($finished-time()))+1));

 mysql_query("UPDATE `countries` SET scientists = scientists + $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь обучением занимаются ".($people-$peopleto)." ученых. Обучение будет завершено через ".mkTimeStr($newfinished-time())."<br/>\n");

 mysql_query("UPDATE `works` SET finished = '".$newfinished."', peopleatwork='".($people-$peopleto)."' WHERE countryID = '$countryID' and kind = 'teaching' and what = '$what'");
 //mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching'&&$mem[$i]['what']==$what){
          $mem[$i]['finished']=$newfinished;
          $mem[$i]['peopleatwork']=$people-$peopleto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."отзывает с обучения $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }

 }else{
       printrus("Вы не ведете данное обучение!<br/>\n");
         }
 printrus
("
<a href='newsc.php?$ses'>Ок</a>
<br/>
");

 break;

 ////////////////////////////////////////////////////////////////////////////////
//Добавляем $peopleto ученых к обучению....//////////////////////////////////////
 case('plusteaching'):

 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $num=0;
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching'&&$mem[$i]['what']==$what){
          $num=1;
          $people=$mem[$i]['peopleatwork'];
          $finished=$mem[$i]['finished'];
          break;
          }
      }else{
 $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID' and kind = 'teaching' and what = '$what' LIMIT 1");
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
 }else{
 $newfinished=round(time()+(($people)/($people+$peopleto)*($finished-time()))+1);

 mysql_query("UPDATE `countries` SET scientists = scientists - $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] - $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь обучением занимаются ".($people+$peopleto)." ученых. Обучение будет завершено через ".mkTimeStr($newfinished-time())."<br/>\n");

 mysql_query("UPDATE `works` SET finished = '".$newfinished."', peopleatwork='".($people+$peopleto)."' WHERE countryID = '$countryID' and kind = 'teaching' and what = '$what'");
 //mysql_query("DELETE FROM `works` WHERE countryID = '$countryID' and kind = 'science' and what = '$what'");
 $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='teaching'&&$mem[$i]['what']==$what){
          $mem[$i]['finished']=$newfinished;
          $mem[$i]['peopleatwork']=$people+$peopleto;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."добавляет к обучению $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }

 }else{
       printrus("Вы не ведете данное обучение!<br/>\n");
         }
 printrus
("
<a href='newsc.php?$ses'>Ок</a>
<br/>
");

 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//В помощ нубам !!!:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('help'):

  if(empty($n)){

  }elseif($n=='money'){
   printrus ("Справка: <u>Вложения в исследования</u><br/>\r\n");
   printrus ("Чем больше денег вы вложите в исследование, тем больших высот достигнут ваши ученые. НО время работы будет увеличено!<br/>\r\n");
   printrus
("<anchor>
OK
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='makings'/>
</go>
</anchor>
<br/>
");
  }elseif($n=='scientists'){
   printrus ("Справка: <u>Ученые</u><br/>\r\n");
   printrus ("Чем больше ученых работает над исследованием, тем быстрее они справятся с работой.<br/>\r\n");
   printrus
("<anchor>
OK
<go href='newsc.php?$ses' method='post'>
<postfield name='m' value='makings'/>
</go>
</anchor>
<br/>
");
  }elseif($n=='scientists'){
   printrus ("Справка: <u>Уровень</u><br/>\r\n");
   printrus ("Уровень научного центра растет при работе над исследованиями. По мере его роста вам открываются дополнительные исследования.<br/>\r\n");
   printrus
("
<a href='newsc.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='STLI'){
  printrus ("Справка: <u>Стальныя арматура</u><br/>\r\n");
  printrus ("Стальная арматура позволит вам укрепить вашу стену. Теперь при нападении стена дольше способна сопротивляться атакам, дыра появляется только при разламывании до 10%. Также стальная арматура позволит вам избежать крушения стены атомной бомбой, если уровень укрепления не меньше 10.<br/>\r\n");
  printrus
("
<a href='newsc.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='PERJ'){
  printrus ("Справка: <u>Переплавка железа</u><br/>\r\n");
  printrus ("Переплавка железа позволит вашим рабочим добывать из шахт на 20% больше железа!<br/>\r\n");
  printrus
("
<a href='newsc.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='DOLG'){
  printrus ("Справка: <u>Элексир долголетия</u><br/>\r\n");
  printrus ("Элексир долголетия продлевает жизнь вашему генералу. Теперь он будет гибнуть в возрасте от 90 до 100 лет!<br/>\r\n");
  printrus
("
<a href='newsc.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='BERS'){
  printrus ("Справка: <u>Берсерк</u><br/>\r\n");
  printrus ("Берсерк позволяет с 50% вероятностью атаковать противника с увеличенной в полтора раза силой на вашей территории. Появляется только у слаборазвитых стран.<br/>\r\n");
  printrus
("
<a href='newsc.php?$ses'>OK</a>
<br/>
");
  }

 break;
 endswitch;

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
