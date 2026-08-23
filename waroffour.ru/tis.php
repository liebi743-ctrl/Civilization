<?php
define('IN_CLV',true);
include_once("func/functions_clv.php");
@include_once("arts/art.php");
include_once("other_inc/header.php");
for($i=0;$i<count($arts);$i++){	if($i==0)printrus("<u>Артефакты для параметров юнитов!</u><p></p>\r\n");	if($i==1)printrus("<u>Артефакты для генерала!</u><p></p>\r\n");
for($y=0;$y<count($arts[$i]);$y++){	printrus($arts[$i][$y][1].'<br />');
	printrus('Бонус: <b>'.$arts[$i][$y][0].'</b><br />---<br />');
}
}
include_once("other_inc/footer.php");
?>