<?
 foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
include_once("other_inc/header1.php");



//printrus ("<div class=\"block small event\">");
  printrus(' 
  	<img src="/img/ico/cr.png" alt="." />'.$b["money"].' денег,<br>
  	<img src="/img/ico/forest.png" alt="." /> '.$b["arbor"].' дерева, <br> 
  	<img src="/img/ico/stone.png" alt="." /> '.$b["stone"].' камня, <br> 
  	<img src="/img/ico/iron.png" alt="." /> '.$b['iron'].' железа, <br> 
  	<img src="/img/ico/oil.png" alt="." /> '.$b["oil"].' нефти, <br> 
  	<img src="/img/ico/grain.png" alt="." /> '.$b["grain"].' зерна<br/> ');

  //Генерал
printrus('<div class="event">');
printrus ("<hr/>");
printrus ("<center>");
printrus ('<h1>Генерал:</h1> '.$fa["name"].'<br>');
  printrus('
  	Возраст: '.$fa["age"].' лет. 
  	Мораль: '.$fa["moral"].'  
  	Опыт: '.$fa['expiriense'].'  
  	Навык: '.$fa["study"].' ');
  printrus ("</center>");
  printrus ("<hr/>");
  printrus('</div>');

/*printrus("Сейчас на карте мира:<br/>\n");
$r = mysql_query("SELECT * FROM uzers WHERE countryID = '".$_SESSION['countryID']."'");
$a = mysql_fetch_array($r);
printrus("<b>".$a['money']."</b> Таргет id<br/>\n");
printrus("<b>".$a['stone']."</b> пехотинец<br/>\n");*/


if (!isset($m))printrus ("---<br/><a href=\"game.php?$ses\">В игру</a><br/>");
else printrus ("---<br/><a href=\"reg.php\">к регистрации</a><br/>");
//printrus ('---<br/><b>©</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
