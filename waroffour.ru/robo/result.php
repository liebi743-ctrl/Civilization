<?
define('IN_CLV',true);
@include_once("../func/functions_clv.php");
mem_connect();

@include_once("../other_inc/header.php");

/* регистрационная информация (пароль #2)*/
$mrh_pass2 = "aS68ok4wF7nARNrihwT2";

/* чтение параметров */
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$crc = $_REQUEST["SignatureValue"];

$crc = strtoupper($crc);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));

/* проверка корректности подписи */
if ($my_crc !=$crc)
{
printrus("bad sign\n");
  exit();
}

/* признак успешно проведенной операции */
printrus("OK$inv_id\n");

$zakaz=mysql_fetch_array(mysql_query("SELECT * FROM zakaz WHERE id='$inv_id'"));
$out_summ=$out_summ*10;
if($out_summ >= 1){$sum=round($out_summ);}
if($out_summ >= 100 and $out_summ < 300){$sum=round($out_summ+($out_summ*10/100));}
if($out_summ >= 300 and $out_summ < 900){$sum=round($out_summ+($out_summ*15/100));}
if($out_summ >= 900){$sum=round($out_summ+($out_summ*30/100));}


mysql_query("UPDATE zakaz SET otvet='1' WHERE id='$inv_id'");
mysql_query("UPDATE `uzers` SET `credits`=`credits`+".$sum." WHERE `userID` = '$zakaz[userID]' LIMIT 1");
include_once("../other_inc/footer.php");
?>


