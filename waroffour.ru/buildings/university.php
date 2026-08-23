<?
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($_REQUEST['what'])) $what = $_REQUEST['what'];
if (isset($what) && ($what!='arbor_making' &&$what!='grain_making' &&$what!='stone_making' &&$what!='iron_making' &&$what!='forest_adding'&& $what!='oil_making' &&$what!='science' &&$what!='plotn_people' &&$what!='plotn_wariors' &&$what!='people_adding' &&$what!='atomic'&&$what!='forest_max'&&$what!='mountains_max' && $what!='scientists' && $what!='wariors'&& $what!='wariors_2'&& $what!='wariors_3'&& $what!='wariors_4'&& $what!='wariors_5'&& $what!='wariors_6'&& $what!='wariors_7'&& $what!='wariors_8')) exit;
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['scientiststo'])) $scientiststo = ceil($_REQUEST['scientiststo']);
if (isset($scientiststo)&&!is_numeric($scientiststo)) $scientiststo=0;
if (isset($scientiststo)&&$scientiststo<0) $scientiststo=0;
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
worksRefresh($_SESSION['countryID']);

//шапка:
@include_once("../other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();

 $countryID = $_SESSION['countryID'];

//******************************************************************************
//проверка на наличие здания:****************************************

 build_exists_print($countryID,'university');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Университет</u><br/>\r\n");

 $noob=$_SESSION['noob'];

 $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];

 if(($scientists<=0 && !isset($m))or ($scientists<=0 && $m!='breakresearch' && $m!='breakteaching' && $m!='minusresearch' && $m!='plusresearch' && $m!='minusteaching' && $m!='plusteaching')){
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
          $time = mkTimeStr($a[$i]['finished']-date(U));
           if (count($a)!=0) printrus ("<form name=\"\" action=\"university.php?$ses&amp;what=$what\" method=\"post\">
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
          endswitch;

printrus
("$name($people ученых)[осталось $time]<br/>
<a href=\"university.php?$ses&amp;m=breakresearch&amp;what=$what\">прервать</a>
<br/>
");
printrus
("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/>
<br/>
");
printrus
("<input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/>
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
          $time = mkTimeStr($a[$i]['finished']-date(U));
          if (count($a)!=0) printrus ("<form name=\"\" action=\"university.php?$ses&amp;what=$what\" method=\"post\">
<input format='*N' name='peopleto' />><br/>\r\n");
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
("Обучаются $wrks крестьян в $name(их учат $people ученых)[осталось $time]<br/>
<a href=\"university.php?$ses&amp;m=breakteaching&amp;what=$what\">прервать</a>
<br/>
");
else
printrus
("Производятся $name(работают $people ученых)[осталось $time]<br/>
<a href=\"university.php?$ses&amp;m=breakteaching&amp;what=$what\">прервать</a>
<br/>
");
printrus
("<input name=\"minusteaching\" type=\"submit\" value=\"отозвать\"/>
<br/>
");
printrus
("<input name=\"plusteaching\" type=\"submit\" value=\"добавить\"/></form>
<br/>
");

          }


  printrus ("-------<br/>\r\n");
  printrus
("
<a href='../game.php?$ses'>&lt;Назад</a>
<br/>
");
//  printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
  //футер страницы:
  include_once("../other_inc/footer.php");

  die("");
 }

is_repairing($countryID,'university',$m);

if($is_rep==0){

 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
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
          $time = mkTimeStr($a[$i]['finished']-date(U));
           if (count($a)!=0) printrus ("<form name=\"\" action=\"university.php?$ses&amp;what=$what\" method=\"post\">
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
          endswitch;
printrus
("$name($people ученых)[осталось $time]<br/>
<a href=\"university.php?$ses&amp;m=breakresearch&amp;what=$what\">прервать</a>
<br/>
");
printrus
("<input name=\"minusresearch\" type=\"submit\" value=\"отозвать\"/>
<br/>
");
printrus
("<input name=\"plusresearch\" type=\"submit\" value=\"добавить\"/>
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
          $time = mkTimeStr($a[$i]['finished']-date(U));
          if (count($a)!=0) printrus ("<form name=\"\" action=\"university.php?$ses&amp;what=$what\" method=\"post\">
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
("Обучаются $wrks крестьян в $name(их учат $people ученых)[осталось $time]<br/>
<a href=\"university.php?$ses&amp;m=breakteaching&amp;what=$what\">прервать</a>
<br/>
");
else
printrus
("Производятся $name(работают $people ученых)[осталось $time]<br/>
<a href=\"university.php?$ses&amp;m=breakteaching&amp;what=$what\">прервать</a>
<br/>
");
printrus
("<input name=\"minusteaching\" type=\"submit\" value=\"отозвать\"/>
<br/>
");
printrus
("<input name=\"plusteaching\" type=\"submit\" value=\"добавить\"/></form>
<br/>
");

          }


  printrus
("<a href=\"guard.php?$ses&amp;bld=university\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_8)."]
<br/>
");
  printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Ученые</a>
[".mkWarning($scientists)."]
<br/>
");
  printrus
("<a href=\"university.php?$ses&amp;m=makings\">Производство</a>
<br/>
");
  if($hits<100){
   printrus
("<a href=\"university.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }elseif(!builds($countryID,"scientificcenter")){
   printrus
("<a href=\"university.php?$ses&amp;m=upgraide\">Строить улучшение (научный центр)</a>
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'university',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//апгрейдим здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('upgraide'):
  build_upgrade($countryID,'scientificcenter','university');
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
("<a href=\"university.php?$ses&amp;m=scientists&amp;n=plus\">Обучить...</a>
<br/>
");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists&amp;n=minus\">Уволить...</a>
<br/>
");
  }elseif($n=="plus" and $num>0){
   printrus ("Подождите пока все рабочие доучатся!<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and ($peopleto<=0 or empty($peopleto) or $scientiststo<=0 or empty($scientiststo))){
   printrus ("Сколько рабочих вы хотите обучить:<br/>\r\n");
   printrus ("<form name=\"\" action=\"university.php?$ses&amp;m=scientists&amp;n=plus\" method=\"post\">
<input format='*N' name='peopleto'/><br/>\r\n");
   printrus ("Ученые:<br/>\r\n");
   printrus ("<input format='*N' name='scientiststo'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Обучить\"/>
</form>
<br/>
");
  }elseif($n=="plus" and $scientiststo>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists&amp;n=plus&amp;peopleto=$peopleto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>$workers){
   printrus ("У вас нет столько свободных рабочих! (всего: <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists&amp;n=plus&amp;peopleto=$workers&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" and $peopleto>($space*$b["plotn_people"])){
   printrus ("Вы можете обучить только <b>".($space*$b["plotn_people"])."</b> рабочих!<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists&amp;n=plus&amp;peopleto=".($space*$b["plotn_people"])."&amp;scientiststo=$scientiststo\">Обучить всех</a>
<br/>
");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus" && ($b["money"]<$peopleto*10 || $b['stone']<$peopleto*5)){

   printrus ("Не хватает ресурсов на обучение! (необходимо <b>".($peopleto*10)."</b> денег и <b>".($peopleto*5)."</b> камня)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="plus"){
   $mmd = $peopleto*10;
   $snd = $peopleto*5;
   mysql_query("UPDATE countries SET workers = ($workers - $peopleto), scientists = ($scientists - $scientiststo), money = money - $mmd, stone = stone - $snd WHERE countryID = '".$b['countryID']."'");
   $b['workers'] = $workers - $peopleto;
   $b['scientists'] = $scientists-$scientiststo;
   $b['money'] = $b['money'] - $mmd;
   $b['stone'] = $b['stone'] - $snd;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   $work_time=round($peopleto/($scientiststo*$b["science"])*10000);

   $query="insert into works values('$countryID','teaching','scientists',$scientiststo,".date(U).",".($work_time+date(U)).", $peopleto, 0)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'teaching', "what"=>'scientists', "peopleatwork"=>$scientiststo, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$peopleto, "var2"=>0);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Обучение займет ".mkTimeStr($work_time).". Это стоило вам <b>".($peopleto*10)." денег</b> и <b>$snd</b> камня<br/>\r\n");

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."обучает в универе $peopleto рабочих в ученых (учат $scientiststo). Время работы ".mkTimeStr($work_time)."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

   printrus
("
<a href='../game.php?$ses'>Ок</a>
<br/>
");
  }elseif($n=="minus" and ($peopleto<=0 or empty($peopleto))){
   printrus ("<form name=\"\" action=\"university.php?$ses&amp;m=scientists&amp;n=minus\" method=\"post\">
<input format='*N' name='peopleto'/><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Уволить\"/>
</form>
<br/>
");
  }elseif($n=="minus" and $peopleto>$scientists){
   printrus ("У вас нет столько ученых! (всего: <b>$scientists</b>)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Отмена</a>
<br/>
");
  }elseif($n=="minus" and $peopleto==$scientists){
   printrus ("Нельзя уволить всех ученых!<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=scientists\">Оk</a>
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

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."увольняет $peopleto ученых\n");
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
//Промышленные исследования:::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('makings'):
  printrus
("<a href=\"university.php?$ses&amp;m=grain_making\">Производство зерна</a>
[<b>".$b["grain_making"]."</b>%]
<br/>
");
  printrus
("<a href=\"university.php?$ses&amp;m=arbor_making\">Производство древесины</a>
[<b>".$b["arbor_making"]."</b>%]
<br/>
");
  printrus
("<a href=\"university.php?$ses&amp;m=iron_making\">Производство железа</a>
[<b>".$b["iron_making"]."</b>%]
<br/>
");
  printrus
("<a href=\"university.php?$ses&amp;m=stone_making\">Производство камня</a>
[<b>".$b["stone_making"]."</b>%]
<br/>
");

printrus("Добыча нефти[<b>".$b['oil_making']."</b>%]<br/>(изучение возможно только в научном центре)<br/>");

  printrus
("
<a href='university.php?$ses'>&lt;&lt;</a>
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
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"university.php?$ses&amp;m=grain_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
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
("<a href=\"university.php?$ses&amp;m=grain_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=grain_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
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
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"university.php?$ses&amp;m=arbor_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
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
("<a href=\"university.php?$ses&amp;m=arbor_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=arbor_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
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
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"university.php?$ses&amp;m=iron_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
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
("<a href=\"university.php?$ses&amp;m=iron_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=iron_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
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
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif(empty($scientiststo) || empty($moneyto) || $scientiststo<=0 || $moneyto<=0){
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=money\">?</a>]
");
   printrus ("Сколько денег вы выделите на исследование:<br/>\r\n");
   printrus ("<form name=\"\" action=\"university.php?$ses&amp;m=stone_making\" method=\"post\">
<input format='*N' name='moneyto'/><br/>\r\n");
   if($noob>=1)
    printrus
("[<a href=\"university.php?$ses&amp;m=help&amp;n=scientists\">?</a>]
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
("<a href=\"university.php?$ses&amp;m=stone_making&amp;moneyto=$moneyto&amp;scientiststo=$scientists\">Использовать всех</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
<br/>
");
  }elseif($moneyto>$b["money"]){
   printrus ("У вас нет столько денег! (всего: <b>".$b["money"]."</b>)<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=stone_making&amp;moneyto=".$b["money"]."&amp;scientiststo=$scientiststo\">Использовать все</a>
<br/>
");
   printrus
("
<a href='university.php?$ses'>Отмена</a>
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
<a href='university.php?$ses'>Ок</a>
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
<a href='university.php?$ses'>Ок</a>
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
<a href='university.php?$ses'>Ок</a>
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
          else $wrks = 0;
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
<a href='university.php?$ses'>Ок</a>
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
 $newfinished=round(time()+($people/($people-$peopleto)*($finished-time()))+1);

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
<a href='university.php?$ses'>Ок</a>
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
<a href='university.php?$ses'>Ок</a>
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
("<a href=\"university.php?$ses&amp;m=makings\">Ok</a>
<br/>
");
  }elseif($n=='scientists'){
   printrus ("Справка: <u>Ученые</u><br/>\r\n");
   printrus ("Чем больше ученых работает над исследованием, тем быстрее они справятся с работой.<br/>\r\n");
   printrus
("<a href=\"university.php?$ses&amp;m=makings\">Ok</a>
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
