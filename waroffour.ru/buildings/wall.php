<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = ceil($_REQUEST['peopleto']);
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
//if (isset($_REQUEST['building'])) $building = $_REQUEST['building'];

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);

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

 build_exists_print($countryID,'wall');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Стена</u><br/>");

 is_repairing($countryID,'wall',$m);

 if($var1==0){
  printrus ("Укрепление: дерево<br/>\r\n");
 }else{
  printrus ("Укрепление: камень<br/>\r\n");
 }


if($is_rep==0){

 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
  printrus
("<a href=\"guard.php?$ses&amp;bld=wall\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  printrus
("<a href=\"wall.php?$ses&amp;m=forcing\">Укрепление</a>
[$var2]
<br/>
");
  if($hits<100){
   printrus
("<a href=\"wall.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }
 break;

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'wall',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Укрепление::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('forcing'):
  //$arbor=round((30*(1-$var1))*($var2+1)*($var2+1))+$var1*($var2-9)*400;
  //$stone=round(25*$var1*($var2+1)*($var2+1));
  $arbor=round(40+($var2)*80);
  $newVAR2=$var2-9;
  if($newVAR2<0)
  $newVAR2=0;
  $stone=round($var1*($newVAR2)*200);

  if($n!="up"){
   printrus ("Уровень укрепления: <b>$var2</b><br/>\r\n");

   printrus ("Для поднятия уровня требуется<br/>\r\n");
   if($arbor>0){
    printrus ("Дерево: <b>$arbor</b><br/>\r\n");
   }
   if($stone>0){
    printrus ("Камень: <b>$stone</b><br/>\r\n");
   }

   printrus
("<a href=\"wall.php?$ses&amp;m=forcing&amp;n=up\">Поднять уровень</a>
<br/>
");
    printrus
("
<a href='wall.php?$ses'>Отмена</a>
<br/>
");
  }elseif($n=="up" and ($b['arbor']<$arbor || $b['stone']<$stone)){
   printrus ("Не хватает материалов для увеличения уровня укрепления!<br/>\r\n");
   printrus
("
<a href='wall.php?$ses'>Ок</a>
<br/>
");
  }else{
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET arbor = arbor - $arbor, stone = stone - $stone WHERE countryID = '".$b['countryID']."'");
   $b['arbor'] = $b['arbor'] - $arbor;
   $b['stone'] = $b['stone'] - $stone;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   mysql_query("UPDATE buildings SET var2 = ($var2+1) WHERE countryID = '".$b['countryID']."' and building = 'wall' LIMIT 1");
   $var2=$var2+1;

   $key=_PREFIKS.':buildings'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='wall'){
          $mem[$i]['var2'] = $mem[$i]['var2'] + 1;
          if ($mem[$i]['var2']>9 && $mem[$i]['var1']==0) $mem[$i]['var1']=1;
          break;
          }
      $memcache->set($key,$mem,false,86400);
      }

   if($var2>9 and $var1==0){
    mysql_query("UPDATE buildings SET var1 = 1 WHERE countryID = '".$b['countryID']."' and building = 'wall'");

    printrus ("Укрепление стены улучшено! Теперь стена сложена из камня!<br/>\r\n");
   }else{
    printrus ("Укрепление стены улучшено!<br/>\r\n");
   }

   printrus
("
<a href='wall.php?$ses'>Ок</a>
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