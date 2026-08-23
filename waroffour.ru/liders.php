<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
include_once("other_inc/header.php");

$countryID = $_SESSION['countryID'];
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 $b=CountryInfo($countryID);
 isAuthed();

 if (!isset($m)){
 printrus("ЛИДЕРЫ (обновление  статистики - раз в сутки):<br/>\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/money.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самое богатое гос-во: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> денег)<a href=\"liders.php?m=money&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/land.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самое большое гос-во: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> земли)<a href=\"liders.php?m=land&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/res.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Больше всего ресурсов: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> едениц)<a href=\"liders.php?m=cr&amp;$ses\">[?]</a>,<a href=\"liders.php?m=res&amp;$ses\">10ка</a><br/>\r\n");
 $qq="SELECT countryName, lastWar FROM `countries` where countryID not in (select countryID from uzers where useit='1' and countryID=countries.countryID) ORDER BY lastWar ASC LIMIT 1";
 //$r=mysql_query("SELECT countryName, lastWar FROM `countries` ORDER BY lastWar ASC LIMIT 1");
 $r=mysql_query($qq);
 $a=mysql_fetch_array($r);
 printrus ("Самая мирная страна: <u>".$a['countryName']."</u>\r\n");
 printrus ("(<b>".mkTimeStr(time()-$a['lastWar'])."</b> без войн)<a href=\"liders.php?m=mir&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/wariors.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самое сильное войско у гос-ва: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> коэффициент силы)<a href=\"liders.php?m=cf&amp;$ses\">[?]</a>,<a href=\"liders.php?m=koef_silx&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/params.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самая развитая армия: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> коэффициент развитости)<a href=\"liders.php?m=cd&amp;$ses\">[?]</a>,<a href=\"liders.php?m=koef_razv&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/population.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Больше всего населения: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> ученых+рабочих)<a href=\"liders.php?m=pop&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/battle.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Крупнейшая битва: <u>".$liders[0]."</u> - <u>".$liders[1]."</u>\r\n");
 printrus ("(<b>".$liders[2]."</b> опыта)<a href=\"liders.php?m=bat&amp;$ses\">[?]</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general_exp.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самый опытный генерал: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> опыта)<a href=\"liders.php?m=expiriense&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самый сильный генерал: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> мораль+навык)<a href=\"liders.php?m=study&amp;$ses\">10ка</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general_age.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самый старый генерал: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> лет)<br/>\r\n");

 }elseif($m=='cr'){
 printrus("При подсчете 1 зерно принимается за 0.2 еденицы ресурсов, дерево - 1, камень - 4, железо - 12, нефть - 20.<br/>");
 }elseif($m=='bat'){
 printrus("Считается суммарный опыт, полученный генералами в битве.<br/>");
 }elseif($m=='cf'){
 printrus("Коэффициент силы считается по следующей формуле:<br/>
 a+2*b+3*c+4*d+3*e+5*f+6*g+10*h, где a-число пехотинцев гос-ва, b-число кавалеристов, c-число стрелков,
 d - число пушек, e - число подрывников, f - число самолетов, g - число магов, h - число генералиссимусов<br/>");
 }elseif($m=='cd'){
 printrus("Коэффициент развитости считается по следующей формуле:<br/>
 (sa+fa)+2*(sb+fb)+3*(sc+fc)+4*(sd+fd)+3*(se+fe)+5*(sf+ff)+6*(sg+fg)+10*(sh+fh), где sa,fa - скорость/сила пехоты, sb,fb - скорость/
 сила кавалерии, sc,fc - скорость/сила стрелков, sd,fd - скорость/сила пушек, se,fe - скорость/сила
 подрывников, sf,ff - скорость/сила самолетов, sg,fg - скорость/сила магов, sh,fh - скорость/сила
 генералиссимусов.<br/>");
 }elseif($m=='money'){
 printrus("Десятка самых богатых стран:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/money.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> денег<br/>');
 }
 }elseif($m=='land'){
 printrus("Десятка самых крупных стран:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/land.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> земли<br/>');
 }
 }elseif($m=='res'){
 printrus("Десятка самых богатых ресурсами стран:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/res.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> едениц<br/>');
 }
 }elseif($m=='mir'){
 printrus("Десятка самых мирных стран:<br/>");
 $qq="SELECT countryName, lastWar FROM `countries` where ip!='' and countryID not in (select countryID from uzers where useit='1' and countryID=countries.countryID) ORDER BY lastWar ASC LIMIT 10";
 //$r=mysql_query("SELECT countryName, lastWar FROM `countries` ORDER BY lastWar ASC LIMIT 10");
  $r=mysql_query($qq);
 $i=1;
 while(($a=mysql_fetch_array($r))!==FALSE){
 printrus ($i.".<u>".$a['countryName']."</u> - ");
 printrus (mkTimeStr(time()-$a['lastWar'])." без войн<br/>\r\n");
 $i++;
 }
 }elseif($m=='koef_silx'){
 printrus("Десятка стран, имеющих самую сильную армию:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/wariors.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> коэф. силы<br/>');
 }
 }elseif($m=='koef_razv'){
 printrus("Десятка стран, имеющих самую развитую армию:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/params.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> коэф. развитости<br/>');
 }
 }elseif($m=='pop'){
 printrus("Десятка самых густонаселенных стран:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/population.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> ученых+рабочих<br/>');
 }
 }elseif($m=='expiriense'){
 printrus("Десятка самых опытных генералов:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general_exp.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> опыта<br/>');
 }
 }elseif($m=='study'){
 printrus("Десятка самых сильных генералов:<br/>");
 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general.dat');
 for ($i=0;$i<10;$i++){
 $par = split('\*',$liders[$i]);
 printrus(($i+1).'.<u>'.$par[0].'</u> - <b>'.$par[1].'</b> мораль+навык<br/>');
 }
 }
 if (isset($m)) printrus("<a href=\"liders.php?$ses\">назад</a><br/>\n");

//printrus ("---<br/><a href='game.php?$ses'>&lt;&lt;В игру</a><br/>\r\n");
//printrus ('<b>&#169;</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
