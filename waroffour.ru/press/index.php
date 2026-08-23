<?
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("../func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
include_once("../other_inc/header.php");

printrus ("<u>Обмен опытом</u><br/>---<br/>\r\n");

if(!isset($_REQUEST['see'])){printrus
("<a href=\"index.php?$ses&amp;see=belk\">Статья от ( Белка ).</a><br/>
");
printrus
("<a href=\"index.php?$ses&amp;see=belk-3\">Статья от ( Белка №2).</a><br/>
");
printrus
("<a href=\"index.php?$ses&amp;see=liga\">Статья от ( Лига теней ).</a><br/>
");
printrus
("<a href=\"index.php?$ses&amp;see=genius\">Статья от ( Genius ).</a><br/>
");
printrus
("<a href=\"index.php?$ses&amp;see=genius2\">Статья от ( Genius№2 ).</a><br/>
");

}else{	if(!is_readable(_ROOT.'/press/'.$_REQUEST['see'].'.dat'))printrus("Запрашиваемой статьи нет.<br/>");
	else{$logs=file($_REQUEST['see'].".dat");
      for ($i=$pg;$i<count($logs)&&$i<$pg+10;$i++){
          printrus($logs[$i]."<br/>");
          }
      if ($i<count($logs)){
      $npg=$pg+9;
      printrus
("<a href=\"index.php?$ses&amp;see=".$_REQUEST['see']."&amp;pg=$npg\">далее..</a>
<br/>
");
         }

      if ($pg>0){
         $npg = max(0,$pg-9);
         printrus
("<a href=\"index.php?$ses&amp;see=".$_REQUEST['see']."&amp;pg=$npg\">назад..</a>
<br/>
");
 }

}

}
if (!isset($m))printrus ("---<br/><a href=\"../game.php?$ses\">В игру</a><br/>");
else printrus ("---<br/><a href=\"reg.php\">к регистрации</a><br/>");
//printrus ('---<br/><b>©</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("../other_inc/footer.php");

?>
