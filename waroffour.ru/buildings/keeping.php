<?
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['n'])) $n = $_REQUEST['n'];
if (isset($_REQUEST['peopleto'])) $peopleto = $_REQUEST['peopleto'];
if (isset($peopleto)&&!is_numeric($peopleto)) $peopleto=0;
if (isset($peopleto)&&$peopleto<0) $peopleto=0;
if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);
 $scientiststo=round( (int) $scientiststo);
 $moneyto=round( (int) $moneyto);

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

sesinit();
//worksRefresh($_SESSION['countryID']);

//шапка:
@include_once("../other_inc/header.php");
$countryID=$_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();

$countryID = $_SESSION['countryID'];


//******************************************************************************
//проверка на наличие здания:****************************************

 build_exists_print($countryID,'keeping');

//******************************************************************************
//Рисуем всякие цыферки-ссылочки разные*****************************************
 printrus ("<u>Хранилище</u><br/>\r\n");

 $scientists=$b['scientists'];
 $workers=$b['workers'];
 $money=$b['money'];

 is_repairing($countryID,'keeping',$m);

if($is_rep==0){


 switch($m):
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если не указано действие(смотрим в первый раз)::::::::::::::::::::::::::::::::
 default:
  printrus
("<a href=\"guard.php?$ses&amp;bld=keeping\">Охрана</a>
[".mkWarning($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)."]
<br/>
");
  $freeplace=free_place($countryID);
  printrus ("Свободное место: <b>$freeplace</b><br/>\r\n");
  $iron=$b['iron'];
  $arbor=$b['arbor'];
  $grain=$b['grain'];
  $stone=$b['stone'];
  $oil=$b['oil'];
  printrus ("Железо: <b>$iron</b><br/>\r\n");
  printrus ("Древесина: <b>$arbor</b><br/>\r\n");
  printrus ("Зерно: <b>$grain</b><br/>\r\n");
  printrus ("Камень: <b>$stone</b><br/>\r\n");
  printrus ("Нефть: <b>$oil</b><br/>\r\n");
  if($hits<100){
   printrus
("<a href=\"keeping.php?$ses&amp;m=repaire\">Починить</a>
(".mkWarning($hits)."%)
<br/>
");
  }elseif(!builds($countryID,"market")){
   printrus
("<a href=\"keeping.php?$ses&amp;m=upgraide\">Строить улучшение (рынок)</a>
<br/>
");
  }
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//чиним здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('repaire'):
  repair($countryID,'keeping',$m);
 break;


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//апгрейдим здание::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 case('upgraide'):
  build_upgrade($countryID,'market','keeping');
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
