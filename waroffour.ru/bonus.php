<?


define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];
include_once("bonus_1.php");
//printrus ("Магазин временно недоступен");
include_once("other_inc/footer.php");
?>