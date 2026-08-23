<?
// подключаемся
define('IN_CLV',true);
require ('../func/functions_clv.php');
mem_connect();
echo mysql_error();

// Если это форма предварительного запроса, то идем дальше...
if($_POST['LMI_PREREQUEST']==1) {
  // 1) Проверяем, есть ли товар с таким id в базе данных.
  // Если такой товар не обнаружен, то выводим ошибку и прерываем работу скрипта.
  $q="SELECT `id`, `cost` FROM `goods` WHERE id=".$_POST['id']."";
  $res=mysql_fetch_row(mysql_query($q));
  if(!$res[0] or $res[0]=="") {
    echo "ERR: НЕТ ТАКОГО ТОВАРА";
    exit;
  }
  // 2) Проверяем, не произошла ли подмена суммы.
  // Cравниваем стоимость товара в базе данных с той суммой, что передана нам Мерчантом.
  // Если сумма не совпадает, то выводим ошибку и прерываем работу скрипта.
  if(trim($res[1])!=trim($_POST['LMI_PAYMENT_AMOUNT'])) {
    echo "ERR: НЕВЕРНАЯ СУММА ".$_POST['LMI_PAYMENT_AMOUNT'];
    exit;
  }
  // 3) Проверяем, не произошла ли подмена кошелька.
  // Cравниваем наш настоящий кошелек с тем кошельком, который передан нам Мерчантом.
  // Если кошельки не совпадают, то выводим ошибку и прерываем работу скрипта.
  if(trim($_POST['LMI_PAYEE_PURSE'])!="R171446592363") {
    echo "ERR: НЕВЕРНЫЙ КОШЕЛЕК ПОЛУЧАТЕЛЯ ".$_POST['LMI_PAYEE_PURSE'];
    exit;}
  // 4) Проверяем, указал ли пользователь свой email.
  // Если параметр $email пустой, то выводим ошибку и прерываем работу скрипта.
  /*if(!trim($_POST['email']) or trim($_POST['email'])=="") {
    echo "ERR: НЕ УКАЗАН EMAIL";
    exit;
  }*/
  // Если ошибок не возникло и мы дошли до этого места, то выводим YES
  echo "YES";
}
// ЕСЛИ НЕТ LMI_PREREQUEST, СЛЕДОВАТЕЛЬНО ЭТО ФОРМА ОПОВЕЩЕНИЯ О ПЛАТЕЖЕ...
ELSE {

  // Задаем значение $secret_key.
  // Оно должно совпадать с Secret Key, указанным нами в настройках кошелька.
  $secret_key="gv5Gf3Wsq1St7J8";
  // Склеиваем строку параметров
  $common_string = $_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].
     $_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].
     $_POST['LMI_SYS_TRANS_DATE'].$secret_key.$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'];
  // Шифруем полученную строку в MD5 и переводим ее в верхний регистр
  $hash = strtoupper(md5($common_string));
  // Прерываем работу скрипта, если контрольные суммы не совпадают
  if($hash!=$_POST['LMI_HASH']) exit;
  //mail($_POST['email'], convert_cyr_string("Ваш товар",w,k), convert_cyr_string($text,w,k),

$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".$_POST['name']."' LIMIT 1");
$a = mysql_fetch_array($r);
$sum = $a['credits']; //Число кредитов
$partner = $a['partner']; //от партнера
	if ($a!=false){ 

    $qw="SELECT `id`, `cost` FROM `goods` WHERE id=".$_POST['id']."";
    $res=mysql_fetch_row(mysql_query($qw));

 if(trim($_POST['LMI_PAYEE_PURSE'])=="R171446592363" && $res[1]=="1") //1
                {$sum=$sum+1;}
 if(trim($_POST['LMI_PAYEE_PURSE'])=="R171446592363" && $res[1]=="5") //5
                {$sum=$sum+6;}
  if(trim($_POST['LMI_PAYEE_PURSE'])=="R171446592363" && $res[1]=="25") //25
                {$sum=$sum+28;}
  if(trim($_POST['LMI_PAYEE_PURSE'])=="R171446592363" && $res[1]=="100") //100
                {$sum=$sum+115;}
  if(trim($_POST['LMI_PAYEE_PURSE'])=="R171446592363" && $res[1]=="500") //500
                {$sum=$sum+650;}
                 
mysql_query("UPDATE `uzers` SET credits='".$sum."' WHERE userID = '".$_POST['name']."' LIMIT 1");
	
 // для партнеров
                $time=date('H:i:s');
                $dta=date('d.m.y');               
 if($udat[85]!='')
                {   
                $partners=''.$_POST['name'].'||'.$sum.'||'.$sum.'||'.$dta.'/'.$time.'||wm_auto||'.$udat[85].'||';
               $fp=fopen("../gros/partner/system/".$udat[85].".dat","a+");
				flock($fp,LOCK_EX);
				fputs($fp,"$partners\r\n");
				fflush($fp);
				flock($fp,LOCK_UN);
				fclose($fp);
				chmod ("../gros/partner/system/".$udat[85].".dat", 0666);
                }
                // для партнеров
}}
?>