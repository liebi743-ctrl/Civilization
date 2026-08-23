<?
define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

@include_once("other_inc/header.php");
/* регистрационная информация (пароль #1) */
$mrh_pass1 = "dJKbyXuxt8B6IDI13Iv7";

/* чтение параметров */
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$crc = $_REQUEST["SignatureValue"];

$crc = strtoupper($crc);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));

/* проверка корректности подписи */
if ($my_crc != $crc)
{
printrus("bad sign<br />");
printrus("<a href=\"bonus.php?$ses\">Назад</a>");
include_once("other_inc/footer.php");
exit();
}


printrus("Оплата счета № ".$inv_id." прошла успешно<br />");
printrus("<br/><a href=\"bonus.php?$ses\">В игру</a>");

include_once("other_inc/footer.php");
?>


