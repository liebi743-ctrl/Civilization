<?
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

@include_once("other_inc/header.php");
$inv_id = $_REQUEST["InvId"];
printrus("Вы отказались от оплаты заказа № $inv_id\n");
printrus("<br/><a href=\"bonus.php?$ses\">В игру</a>");

include_once("other_inc/footer.php");
?>


