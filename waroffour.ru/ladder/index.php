<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

//sesinit();
//шапка:
@include_once("../other_inc/header.php");


if (!isset($m)){
printrus("Лидеры (обновление статистики - раз в сутки):<br/>");
printrus("Зарегистрировшись в игре, вы сможете посмотреть 5ку лидеров по каждому пункту!<br/>");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/money.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самое богатое гос-во: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> денег)<br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/land.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самое большое гос-во: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> земли)<br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/res.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Больше всего ресурсов: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> едениц)<a href=\"index.php?m=cr\">[?]</a><br/>\r\n");

 $r=mysql_query("SELECT countryName, lastWar FROM `countries` ORDER BY lastWar ASC LIMIT 1");
 $a=mysql_fetch_array($r);
 printrus ("Самая мирная страна: <u>".$a['countryName']."</u>\r\n");
 printrus ("(".mkTimeStr(time()-$a['lastWar'])." без войн)<br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/wariors.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самое сильное войско у гос-ва: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> коэффициент силы)<a href=\"index.php?m=cf\">[?]</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/params.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самая развитая армия: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> коэффициент развитости)<a href=\"index.php?m=cd\">[?]</a><br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/population.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Больше всего населения: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> ученых+рабочих)<br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самый сильный генерал: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> мораль+навык)<br/>\r\n");


 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/battle.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Крупнейшая битва: <u>".$liders[0]."</u> - <u>".$liders[1]."</u>\r\n");
 printrus ("(<b>".$liders[2]."</b> опыта)<a href=\"index.php?m=bat\">[?]</a><br/>\r\n");


 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general_exp.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самый опытный генерал: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> опыт)<br/>\r\n");

 $liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/general_age.dat');
 $liders = split('\*',$liders[0]);
 printrus ("Самый старый генерал: <u>".$liders[0]."</u>\r\n");
 printrus ("(<b>".$liders[1]."</b> лет)<br/>\r\n");

}elseif($m=='cf'){
 printrus("Коэффициент силы считается по следующей формуле:<br/>
 a+2*b+3*c+4*d+3*e+5*f+6*g+10*h, где a-число пехотинцев гос-ва, b-число кавалеристов, c-число стрелков,
 d - число пушек, e - число подрывников, f - число самолетов, g - число магов, h - число генералиссимусов<br/>");
 }elseif($m=='bat'){
 printrus("Считается суммарный опыт, полученный генералами в битве.<br/>");
 }elseif($m=='cd'){
 printrus("Коэффициент развитости считается по следующей формуле:<br/>
 (sa+fa)+2*(sb+fb)+3*(sc+fc)+4*(sd+fd)+3*(se+fe)+5*(sf+ff)+6*(sg+fg)+10*(sh+fh), где sa,fa - скорость/сила пехоты, sb,fb - скорость/
 сила кавалерии, sc,fc - скорость/сила стрелков, sd,fd - скорость/сила пушек, se,fe - скорость/сила
 подрывников, sf,ff - скорость/сила самолетов, sg,fg - скорость/сила магов, sh,fh - скорость/сила
 генералиссимусов.<br/>");
 }elseif($m=='cr'){
 printrus("При подсчете 1 зерно принимается за 0.2 еденицы ресурсов, дерево - 1, камень - 4, железо - 12, нефть - 20.<br/>");
 }
 if (isset($m)) printrus("<a href=\"index.php\">&lt;</a><br/>\n");



printrus ("---<br/><a href='../index.php'>&lt;&lt;Назад</a><br/>\r\n");
//printrus ('<b>&#169;</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("../other_inc/footer.php");

?>
