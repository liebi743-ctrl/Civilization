<?
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
//if (isset($_REQUEST['building'])) $building = $_REQUEST['building'];
if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what) && ($what!='arbor_making' &&$what!='demontaj' &&$what!='grain_making' &&$what!='stone_making' &&$what!='iron_making' &&$what!='oil_making' &&$what!='forest_adding' &&$what!='science' &&$what!='plotn_people' &&$what!='plotn_wariors' &&$what!='people_adding' &&$what!='atomic' &&$what!='forest_max'&&$what!='mountains_max' && $what!='scientists' && $what!='wariors'&& $what!='wariors_2'&& $what!='wariors_3'&& $what!='wariors_4'&& $what!='wariors_5'&& $what!='wariors_6'&& $what!='wariors_7'&& $what!='wariors_8' && $what!='artefakt' && $what!='art')) exit;
if (isset($_REQUEST['moneyto'])) $moneyto = $_REQUEST['moneyto'];
if (isset($moneyto)&&!is_numeric($moneyto)) $moneyto=0;
if (isset($moneyto)&&$moneyto<0) $moneyto=0;
if (isset($_REQUEST['minusresearch']))$m='minusresearch';
if (isset($_REQUEST['plusresearch']))$m='plusresearch';
if (isset($_REQUEST['minusteaching']))$m='minusteaching';
if (isset($_REQUEST['plusteaching']))$m='plusteaching';
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

 build_exists_print($countryID,'scientificcenter');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Научный центр</u><br/>\r\n");

 $noob=$_SESSION['noob'];

 is_repairing($countryID,'scientificcenter',$m);

 $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];
  #$var2=10;
 if(($scientists<=0 && !isset($m))or ($scientists<=0 && $m!='breakresearch' && $m!='breakteaching' && $m!='minusresearch' && $m!='plusresearch' && $m!='minusteaching' && $m!='plusteaching')){
  printrus ("Уровень: <b>$var2</b><br/>");
  printrus ("У вас нет свободных ученых!<br/>\r\n");

  //Текущие исследования
  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $a=array();
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science' and $mem[$i]['what']!='offerings_troops' and $mem[$i]['what']!='offerings_scientists' and $mem[$i]['what']!='cow' and $mem[$i]['what']!='goats' and $mem[$i]['what']!='rams' and $mem[$i]['what']!='study_wariors_2' and $mem[$i]['what']!='study_wariors_3' and $mem[$i]['what']!='study_wariors_4' and $mem[$i]['what']!='study_wariors_5' and $mem[$i]['what']!='study_wariors_6' and $mem[$i]['what']!='study_wariors_7' and $mem[$i]['what']!='hammer' and $mem[$i]['what']!='cuirass' and $mem[$i]['what']!='pouch' and $mem[$i]['what']!='pono' and $mem[$i]['what']!='improved_mine' and $mem[$i]['what']!='diamond_wall')array_push($a,$mem[$i]);
     }else{
  $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science' and what != 'offerings_troops' and what != 'offerings_scientists' and what!='cow' and what!='goats' and what!='rams' and what!='study_wariors_2' and what!='study_wariors_3' and what!='study_wariors_4' and what!='study_wariors_5' and what!='study_wariors_6' and what!='study_wariors_7' and what!='hammer' and what!='cuirass' and what!='pouch' and what!='pono' and what!='improved_mine' and what!='diamond_wall'");
  $a = array();
  while (($s=mysql_fetch_array($r))!==FALSE){
        array_push($a,$s);
        }

        }

  if (count($a)!=0) printrus("<u>Текущие исследования:</u><br/>Ученые:<br/>\r\n");

  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $time = mkTimeStr($a[$i]['finished']-date_new(U));
          if (count($a)!=0) printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;what=$what\" method=\"post\">
<input format='*N' name='peopleto' /><br/>\r\n");
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
		  case('artefakt'): $name = 'археология';break;
		  case('art'): $name = 'исследование артефакта';break;
          endswitch;


printrus
("$name($people ученых)<br />осталось <font color='#FF4040'>$time</font><br/>
 <input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/>

");
printrus

("<a href=\"scientificcenter.php?$ses&amp;m=breakresearch&amp;what=$what\"><font color='#EE7621'>прервать</font></a>

");
printrus
("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/>

</form>
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

  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $wrks = $a[$i]['var1'];
          $time = mkTimeStr($a[$i]['finished']-date_new(U));
            if (count($a)!=0) printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;what=$what\" method=\"post\">
<input format='*N' name='peopleto' /><br/>\r\n");
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
("Обучаются $wrks крестьян в $name(их учат $people ученых)<br />осталось <font color='#FF4040'>$time</font><br/>
<a href=\"scientificcenter.php?$ses&amp;m=breakteaching&amp;what=$what\"><font color='#EE7621'>прервать</font></a>

");
else
printrus
("Производятся $name(работают $people ученых)<br />осталось <font color='#FF4040'>$time</font><br/>
<a href=\"scientificcenter.php?$ses&amp;m=breakteaching&amp;what=$what\"><font color='#EE7621'>прервать</font></a>

");
printrus
("<input name=\"plusteaching\" type=\"submit\" value=\"добавить\"/>

");
printrus
("<input name=\"minusteaching\" type=\"submit\" value=\"отозвать\"/>

</form>
<br/>
");

          }


  printrus ("-------<br/>\r\n");
  printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//  printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
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
     for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='science' and $mem[$i]['what']!='offerings_troops' and $mem[$i]['what']!='offerings_scientists' and $mem[$i]['what']!='cow' and $mem[$i]['what']!='goats' and $mem[$i]['what']!='rams' and $mem[$i]['what']!='study_wariors_2' and $mem[$i]['what']!='study_wariors_3' and $mem[$i]['what']!='study_wariors_4' and $mem[$i]['what']!='study_wariors_5' and $mem[$i]['what']!='study_wariors_6' and $mem[$i]['what']!='study_wariors_7' and $mem[$i]['what']!='hammer' and $mem[$i]['what']!='cuirass' and $mem[$i]['what']!='pouch' and $mem[$i]['what']!='pono' and $mem[$i]['what']!='improved_mine' and $mem[$i]['what']!='diamond_wall')array_push($a,$mem[$i]);
     }else{
  $r = mysql_query("SELECT * FROM `works` WHERE countryID='$countryID' and kind = 'science' and what != 'offerings_troops' and what != 'offerings_scientists' and what!='cow' and what!='goats' and what!='rams' and what!='study_wariors_2' and what!='study_wariors_3' and what!='study_wariors_4' and what!='study_wariors_5' and what!='study_wariors_6' and what!='study_wariors_7' and what!='hammer' and what!='cuirass' and what!='pouch' and what!='pono' and what!='improved_mine' and what!='diamond_wall'");
  $a = array();
  while (($s=mysql_fetch_array($r))!==FALSE){
        array_push($a,$s);
        }

  }

  if (count($a)!=0) printrus("<u>Текущие исследования:</u><br/>Ученые:<br/>\r\n");
  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $time = mkTimeStr($a[$i]['finished']-time_new());
          if (count($a)!=0) printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;what=$what\" method=\"post\">
<input format='*N' name='peopleto' /><br/>\r\n");
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
("$name($people ученых)<br />осталось <font color='#FF4040'>$time</font><br/>
<input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/>

");
printrus

("<a href=\"scientificcenter.php?$ses&amp;m=breakresearch&amp;what=$what\"><font color='#EE7621'>прервать</font></a>

");
printrus
("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/>

</form>
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

  for ($i=0;$i<count($a);$i++){
          $what = $a[$i]['what'];
          $people = $a[$i]['peopleatwork'];
          $wrks = $a[$i]['var1'];
          $time = mkTimeStr($a[$i]['finished']-time_new());
            if (count($a)!=0) printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;what=$what\" method=\"post\">
<input format='*N' name='peopleto' /><br/>\r\n");
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
("Обучаются $wrks крестьян в $name(их учат $people ученых)<br />осталось <font color='#FF4040'>$time</font><br/>
<a href=\"scientificcenter.php?$ses&amp;m=breakteaching&amp;what=$what\"><font color='#EE7621'>прервать</font></a>

");
else
printrus
("Производятся $name(работают $people ученых)<br />осталось<font color='#FF4040'> $time</font><br/>
<a href=\"scientificcenter.php?$ses&amp;m=breakteaching&amp;what=$what\"><font color='#EE7621'>прервать</a>

");

printrus
("<input name=\"plusteaching\" type=\"submit\" value=\"добавить\"/>


");
printrus
("<input name=\"minusteaching\" type=\"submit\" value=\"отозвать\"/>
</form>
<br/>
");

          }


  printrus
("<a href=\"guard.php?$ses&amp;bld=scientificcenter\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Ученые</a>
[".mkWarning($scientists)."]
<br/>
");
  printrus
("<a href=\"scientificcenter.php?$ses&amp;m=makings\">Производство</a>
<br/>
");
  if($var2>=1){
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=addings\">Дополнительно</a>
<br/>
");
  }else{
   printrus ("<u>Дополнительно</u> (открывается с 1 уровня научного центра)<br/>\r\n");
  }

  if($hits<100){
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=repaire\">Починить</a>
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
("<a href=\"scientificcenter.php?$ses&amp;m=scientists&amp;n=plus\">Обучить...</a>
<br/>
");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists&amp;n=minus\">Уволить...</a>
<br/>
");
  }elseif($n=="plus" and $num>0){
   printrus ("Подождите пока все крестьяне доучатся!<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and ($peopleto<=0 or empty($peopleto) or $scientiststo<=0 or empty($scientiststo))){
   printrus ("Сколько рабочих вы хотите обучить:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=scientists&amp;n=plus\" method=\"post\">
<input format='*N' name='peopleto'/><br/>\r\n");
   printrus ("Учителя:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Обучить\"/>
</form>
<br/>
");
  }elseif($n=="plus" and $scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists&amp;n=plus&amp;peopleto=$peopleto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>$workers){
   printrus ("У вас нет столько свободных рабочих! (всего: <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists&amp;n=plus&amp;peopleto=$workers&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>($space*$b["plotn_people"])){
   printrus ("Вы можете обучить только <b>".($space*$b["plotn_people"])."</b> крестьян!<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists&amp;n=plus&amp;peopleto=".($space*$b["plotn_people"])."&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and ($b["money"]<$peopleto*50 || $b['stone']<$peopleto*5)){

   printrus ("Не хватает ресурсов на обучение! (необходимо <b>".($peopleto*50)."</b> денег и <b>".($peopleto*5)."</b> камня)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Отмена</a>
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

   $query="insert into works values('$countryID','teaching','scientists',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $peopleto, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'teaching', "what"=>'scientists', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$peopleto, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Обучение займет ".mkTimeStr($work_time).". Это стоило вам <b>".$mmd." денег</b> и <b>$snd</b> камня<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."обучает в центре $peopleto рабочих в ученых (учат $scientiststo). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="minus" and ($peopleto<=0 or empty($peopleto))){
   print "<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=scientists&amp;n=minus\" method=\"post\">
<input format='*N' name='peopleto'/><br/>\r\n";
   printrus
("<input type=\"submit\" value=\"Уволить\"/>
</form>
<br/>
");
  }elseif($n=="minus" and $peopleto>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="minus" and $peopleto==$scientists){
   printrus ("Нельзя уволить всех ученых!<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=scientists\">Отмена</a>
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
("<a href=\"scientificcenter.php?$ses&amp;m=grain_making\">Производство зерна</a>
[<b>".$b["grain_making"]."</b>%]
<br/>
");
  printrus
("<a href=\"scientificcenter.php?$ses&amp;m=arbor_making\">Производство древесины</a>
[<b>".$b["arbor_making"]."</b>%]
<br/>
");
  printrus
("<a href=\"scientificcenter.php?$ses&amp;m=iron_making\">Производство железа</a>
[<b>".$b["iron_making"]."</b>%]
<br/>
");
  printrus
("<a href=\"scientificcenter.php?$ses&amp;m=stone_making\">Производство камня</a>
[<b>".$b["stone_making"]."</b>%]
<br/>
");
  printrus
("<a href=\"scientificcenter.php?$ses&amp;m=oil_making\">Добыча нефти</a>
[<b>".$b["oil_making"]."</b>%]
<br/>
");
  printrus
("
<a href='scientificcenter.php?$ses'>&lt;&lt;</a>
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
("<a href=\"scientificcenter.php?$ses&amp;m=forest_adding\">Выращивание лесов</a>
[<b>".$b["forest_adding"]."</b>%]
<br/>
");
   }
   if($var2>=3){
   	printrus
("<a href=\"scientificcenter.php?$ses&amp;m=demontaj\">Демонтаж зданий</a>
[<b>".$b["demontaj"]."</b>%]
<br/>
");

	 printrus
("<a href=\"scientificcenter.php?$ses&amp;m=artefakt\">Археология</a>
[<b>".$b["artefakt"]."</b>%]
<br/>
");

    printrus
("<a href=\"scientificcenter.php?$ses&amp;m=science\">Научный уровень</a>
[<b>".$b["science"]."</b>%]
<br/>
");
   }
   if($var2>=5){
    printrus
("<a href=\"scientificcenter.php?$ses&amp;m=plotn_people\">Макс. плотность населения</a>
[<b>".$b["plotn_people"]."</b>]
<br/>
");
   }
   if($var2>=7){
    printrus
("<a href=\"scientificcenter.php?$ses&amp;m=plotn_wariors\">Макс. плотность войска</a>
[<b>".$b["plotn_wariors"]."</b>]
<br/>
");
   }
   if($var2>=9){
    printrus
("<a href=\"scientificcenter.php?$ses&amp;m=people_adding\">Прирост населения</a>
[<b>".$b["people_adding"]."</b>%]
<br/>
");


printrus
("<a href=\"scientificcenter.php?$ses&amp;m=atomic\">Атомная бомба</a>
<br/>
");

if (building_exists($countryID,'zavod'))
printrus
("<a href=\"scientificcenter.php?$ses&amp;m=mountains_max\">Прочность шахт</a>
[<b>".$b["mountains_max"]."</b>%]
<br/>
");

if (building_exists($countryID,'gorodmagov'))
printrus
("<a href=\"scientificcenter.php?$ses&amp;m=forest_max\">Сохранение лесов</a>
[<b>".$b["forest_max"]."</b>%]
<br/>
");

	 printrus
("<a href=\"/artefacts.php?$ses&amp;m=art\">Артефакты</a>
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
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=STLI\">?</a>],
");
          }
       if ($ot[$i]['otkr']=='PERJ') {
          printrus("<u>переплавка железа</u>");
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=PERJ\">?</a>],
");
          }
       if ($ot[$i]['otkr']=='DOLG') {
          printrus("<u>элексир долголетия</u>");
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=DOLG\">?</a>],
");
          }
       if ($ot[$i]['otkr']=='BERS') {
          printrus("<u>берсерк</u>");
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=BERS\">?</a>],
");
          }




       }
   printrus("<br/>\n");
   }

  }
  printrus
("
<a href='scientificcenter.php?$ses'>&lt;&lt;</a>
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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=grain_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=grain_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=grain_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into works values('$countryID','science','grain_making',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'grain_making', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
         /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует произв.зерна до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=arbor_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=arbor_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=arbor_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into works values('$countryID','science','arbor_making',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'arbor_making', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
     /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует произв.дерева до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=iron_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=iron_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=iron_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into works values('$countryID','science','iron_making',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'iron_making', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
            /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует произв.железа до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=stone_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
  printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=stone_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=stone_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into works values('$countryID','science','stone_making',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'stone_making', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
           /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует произв.камня до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);*/

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
  printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=oil_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=oil_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=oil_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into works values('$countryID','science','oil_making',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'oil_making', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
          /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует произв.нефти до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
  printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=science\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=science&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=science&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','science',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'science', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует науч.уровень до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);*/

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=plotn_people\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
  printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=plotn_people&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=plotn_people&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','plotn_people',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'plotn_people', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
       /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует плотн.населения до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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

  if($var2<3){
   printrus ("Это исследование пока недоступно! (требуется уровень выше второго)<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
    printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=demontaj\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=demontaj&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=demontaj&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','demontaj',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'demontaj', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует Демонтаж зданий до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
//Археология:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('artefakt'):

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $num=0;
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='artefakt'){
            $num=1;
            break;
            }
         }
     }else{
  $query="select * from `works` where countryID='$countryID' and kind='science' and what='artefakt' limit 1";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  }

  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

  if($var2<3){
   printrus ("Это исследование пока недоступно! (требуется уровень выше второго)<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
    printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=artefakt\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=artefakt&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=artefakt&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','artefakt',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'artefakt', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует Архиологию до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=plotn_wariors\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=plotn_wariors&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=plotn_wariors&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','plotn_wariors',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'plotn_wariors', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует плотн.войска до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($var2<=9){
   printrus ("Это исследование пока недоступно! (требуется уровень выше девятого)<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){

   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
  printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=atomic\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");

   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
    printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=atomic&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=atomic&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto<35000){
   printrus ("На это исследование надо выделить минимум <b>35000</b>!<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=atomic&amp;moneyto=35000&amp;scientiststo=$scientiststo\">Выделить 35000</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }else{
   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
   $b['money'] = $b['money'] - $moneyto;
   $b['scientists'] = $scientists-$scientiststo;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=max(360*24*2,round(3600*24*2/$scientiststo*300));
   $new_lvl=10;

   $query="insert into `works` values('$countryID','science','atomic',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'atomic', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует атомн.бомбу до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
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
//Исследование артефакта:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('art'):



  $aid=intval($_GET['aid']);
  $cc=mysql_fetch_array(mysql_query("SELECT COUNT(id) AS cc FROM artefacts WHERE countryID='$b[countryID]' AND id=$aid"));
  if ($cc[0] == 0){
  printrus("У вас нет такого артефакта.<br/>\r\n");
  }
  else{



			  $key=_PREFIKS.':works'.$countryID;
			  if (($mem=$memcache->get($key))!==FALSE){
				 $num=0;
				 for ($i=0;$i<count($mem);$i++){
					 if ($mem[$i]['kind']=='science'&&$mem[$i]['what']=='art'){
						$num=1;
						break;
						}
					 }
				 }else{
			  $query="select * from `works` where countryID='$countryID' and kind='science' and what='art' limit 1";
			  $result=@MYSQL_QUERY($query);
			  $num=@mysql_num_rows($result);
			  }

			  printrus ("Ученые: <b>$scientists</b><br/>\r\n");

			  if($b['art']!=0){
			  printrus ("У вас уже есть атомная бомба! Невозможно произвести еще одну!<br/>\r\n");
			   printrus
			("
			<a href='scientificcenter.php?$ses'>Отмена</a>
			<br/>
			");
			  }elseif($var2<=9){
			   printrus ("Это исследование пока недоступно! (требуется уровень выше девятого)<br/>\r\n");
			   printrus
			("
			<a href='scientificcenter.php?$ses'>Отмена</a>
			<br/>
			");
			  }elseif($num>0){
			   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
			   printrus
			("
			<a href='scientificcenter.php?$ses'>Отмена</a>
			<br/>
			");
			  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){

			   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
			  printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=art&amp;aid=$aid\" method=\"post\">
			<input format='*N' name='moneyto'/><br/>\r\n");

			   printrus ("Ученые:<br/>\r\n");
			   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
				printrus
			("<input type=\"submit\" value=\"Исследовать\"/>
			</form>
			<br/>
			");
			  }elseif($scientiststo>$scientists){
			   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
			   printrus
			("<a href=\"scientificcenter.php?$ses&amp;m=art&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
			<br/>
			");
			   printrus
			("
			<a href='scientificcenter.php?$ses'>Отмена</a>
			<br/>
			");
			  }elseif($moneyto>$b["money"]){
			   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
			   printrus
			("<a href=\"scientificcenter.php?$ses&amp;m=art&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
			<br/>
			");
			   printrus
			("
			<a href='scientificcenter.php?$ses'>Отмена</a>
			<br/>
			");
			  }elseif($moneyto<20000){
			   printrus ("На это исследование надо выделить минимум <b>20000</b>!<br/>\r\n");
			   printrus
			("<a href=\"scientificcenter.php?$ses&amp;m=art&amp;moneyto=20000&amp;scientiststo=$scientiststo&amp;aid=$aid\">Выделить 20000</a>
			<br/>
			");
			   printrus
			("
			<a href='scientificcenter.php?$ses'>Отмена</a>
			<br/>
			");
			  }else{
			   mysql_query("UPDATE countries SET money = money - $moneyto, scientists = ($scientists-$scientiststo) WHERE countryID='".$b['countryID']."'");
			   $b['money'] = $b['money'] - $moneyto;
			   $b['scientists'] = $scientists-$scientiststo;
			   if ($id_m==TRUE){
				  $memcache->set($key1,$b,false,86400);
				  }

			   $work_time=max(360*24*2,round(3600*24*2/$scientiststo*300));
			   $new_lvl=10;

			   $query="insert into `works` values('$countryID','science','art',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, $aid)";
			   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
			   $key=_PREFIKS.':works'.$countryID;
			   if (($mem=$memcache->get($key))!==FALSE){
				  $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'art', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>$aid);
				  array_push($mem,$neww);
				  $memcache->set($key,$mem,false,86400);
				  }

			   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");

			   //Пишем в лог работ:
			 @$open=fopen("../logs/works".$countryID,"a+");
			 @flock ($open,LOCK_EX);
			 @fwrite($open,date_new("H:i j.m:")."исследует артефакт до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=people_adding\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
  printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=people_adding&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=people_adding&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','people_adding',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'people_adding', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует прирост насел. до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);*/

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($num>0){
   printrus ("Подождите, пока закончится текущее исследование!<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=forest_adding\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=forest_adding&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=forest_adding&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','forest_adding',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'forest_adding', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
        /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует выращ.лесов до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
  printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=mountains_max\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=mountains_max&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=mountains_max&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','mountains_max',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'mountains_max', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
        /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует прочн.шахт до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"scientificcenter.php?$ses&amp;m=forest_max\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"scientificcenter.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Исследовать\"/>
</form>
<br/>
");
  }elseif($scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=forest_max&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=forest_max&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='scientificcenter.php?$ses'>Отмена</a>
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

   $query="insert into `works` values('$countryID','science','forest_max',$scientiststo,".date_new(U).",".($work_time+date_new(U)).", $new_lvl, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'science', "what"=>'forest_max', "peopleatwork"=>$scientiststo, "started"=>time_new(), "finished"=>($work_time+time_new()), "var1"=>$new_lvl, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }


   printrus ("Исследование займет ".mkTimeStr($work_time)."<br/>\r\n");
      /*
   //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."исследует сохран.лесов до $new_lvl $scientiststo учеными. Время исследования ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

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
      /*
 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."прекращает исслед. $what. Вернулось $people ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open); */

 }else{
       printrus("Вы не ведете данное исследование!<br/>\n");
         }
 printrus
("
<a href='scientificcenter.php?$ses'>Ок</a>
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
 $newfinished=round(time_new()+($people/($people-$peopleto)*($finished-time_new()))+1);

 mysql_query("UPDATE `countries` SET scientists = scientists + $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь исследованием занимаются ".($people-$peopleto)." ученых. Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

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
    /*
 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."отзывает от исследования $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
   */
 }

 }else{
       printrus("Вы не ведете данное исследование!<br/>\n");
         }
 printrus
("
<a href='scientificcenter.php?$ses'>Ок</a>
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
 if ($what!='atomic')$newfinished=round(time_new()+(($people)/($people+$peopleto)*($finished-time_new()))+1);
 else $newfinished=$finished;

 mysql_query("UPDATE `countries` SET scientists = scientists - $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] - $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь исследованием занимаются ".($people+$peopleto)." ученых. Исследование будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

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
    /*
 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."добавляет к исследованию $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
   */
 }

 }else{
       printrus("Вы не ведете данное исследование!<br/>\n");
         }
 printrus
("
<a href='scientificcenter.php?$ses'>Ок</a>
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
 @fwrite($open,date_new("H:i j.m:")."прекращает обучение $what. Вернулось $people ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }else{
       printrus("Вы не ведете данное обучение!<br/>\n");
         }
 printrus
("
<a href='scientificcenter.php?$ses'>Ок</a>
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
 if ($what!='atomic')$newfinished=round(time_new()+($people/($people-$peopleto)*($finished-time_new()))+1);
 else $newfinished=min(100*3600,round(time_new()+($people/($people-$peopleto)*($finished-time_new()))+1));

 mysql_query("UPDATE `countries` SET scientists = scientists + $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] + $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь обучением занимаются ".($people-$peopleto)." ученых. Обучение будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

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
 @fwrite($open,date_new("H:i j.m:")."отзывает с обучения $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }

 }else{
       printrus("Вы не ведете данное обучение!<br/>\n");
         }
 printrus
("
<a href='scientificcenter.php?$ses'>Ок</a>
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
 $newfinished=round(time_new()+(($people)/($people+$peopleto)*($finished-time_new()))+1);

 mysql_query("UPDATE `countries` SET scientists = scientists - $peopleto WHERE countryID = '$countryID'");
 $b['scientists'] = $b['scientists'] - $peopleto;
 if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

 printrus("Теперь обучением занимаются ".($people+$peopleto)." ученых. Обучение будет завершено через ".mkTimeStr($newfinished-time_new())."<br/>\n");

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
 @fwrite($open,date_new("H:i j.m:")."добавляет к обучению $what $peopleto ученых.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }

 }else{
       printrus("Вы не ведете данное обучение!<br/>\n");
         }
 printrus
("
<a href='scientificcenter.php?$ses'>Ок</a>
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
("<a href=\"scientificcenter.php?$ses&amp;m=makings\">Ok</a>
<br/>
");
  }elseif($n=='scientists'){
   printrus ("Справка: <u>Ученые</u><br/>\r\n");
   printrus ("Чем больше ученых работает над исследованием, тем быстрее они справятся с работой.<br/>\r\n");
   printrus
("<a href=\"scientificcenter.php?$ses&amp;m=makings\">Ok</a>
<br/>
");
  }elseif($n=='scientists'){
   printrus ("Справка: <u>Уровень</u><br/>\r\n");
   printrus ("Уровень научного центра растет при работе над исследованиями. По мере его роста вам открываются дополнительные исследования.<br/>\r\n");
   printrus
("
<a href='scientificcenter.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='STLI'){
  printrus ("Справка: <u>Стальныя арматура</u><br/>\r\n");
  printrus ("Стальная арматура позволит вам укрепить вашу стену. Теперь при нападении стена дольше способна сопротивляться атакам, дыра появляется только при разламывании до 10%. Также стальная арматура позволит вам избежать крушения стены атомной бомбой, если уровень укрепления не меньше 10.<br/>\r\n");
  printrus
("
<a href='scientificcenter.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='PERJ'){
  printrus ("Справка: <u>Переплавка железа</u><br/>\r\n");
  printrus ("Переплавка железа позволит вашим рабочим добывать из шахт на 20% больше железа!<br/>\r\n");
  printrus
("
<a href='scientificcenter.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='DOLG'){
  printrus ("Справка: <u>Элексир долголетия</u><br/>\r\n");
  printrus ("Элексир долголетия продлевает жизнь вашему генералу. Теперь он будет гибнуть в возрасте от 90 до 100 лет!<br/>\r\n");
  printrus
("
<a href='scientificcenter.php?$ses'>OK</a>
<br/>
");
  }elseif($n=='BERS'){
  printrus ("Справка: <u>Берсерк</u><br/>\r\n");
  printrus ("Берсерк позволяет с 50% вероятностью атаковать противника с увеличенной в полтора раза силой на вашей территории. Появляется только у слаборазвитых стран.<br/>\r\n");
  printrus
("
<a href='scientificcenter.php?$ses'>OK</a>
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
