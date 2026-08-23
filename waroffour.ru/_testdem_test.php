<?php
$building=$_GET['u'];
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("other_inc/header.php");

$countryID = $_SESSION['countryID'];

 $b=CountryInfo($countryID);
 isAuthed();
 $ac=array();
 for($i=0;$i<count($b);$i++){
 echo $b[$i];
}

print($ac[napr]);
print "---<br/>\r\n";
printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");

?>